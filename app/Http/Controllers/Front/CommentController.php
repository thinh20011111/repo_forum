<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Models\Comment;
use App\Models\Notification;
use App\Models\Post;
use App\Services\Comment\CommentServiceInterface;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use Pusher\Pusher;

class CommentController extends Controller
{
    private $commentService;

    public function __construct(
        CommentServiceInterface $commentService,

    ) {
        $this->commentService =  $commentService;
    }

    public function getCommentCount($postId)
    {
        $count = Comment::where('post_id', $postId)->count();
        return response()->json(['count' => $count]);
    }

    public function comment(Request $request, $id, Post $post)
    {
        $userId = Auth::user()->id;
        $post = Post::find($id);
        $postId = $id;

        $messages = [
            'content.required' => 'Bạn chưa nhập nội dung bình luận.',
        ];

        $validator = Validator::make($request->all(), [
            'content' => 'required',
        ], $messages);

        if ($post->comment_mode == 1) {
            return response()->json([
                'error' => 'Bài viết đã khóa bình luận.',
                'comment_mode' => $post->comment_mode,
            ]);
        }

        if ($validator->passes()) {
            $data = [
                'user_id' => $userId,
                'post_id' => $postId,
                'content' => $request->content,
                'reply_id' => $request->reply_id ? $request->reply_id : 0
            ];

            if ($comment = $this->commentService->create($data)) {
                $comments = Comment::where('post_id', $postId)->orderBy('id', 'DESC')->get();

                $comment_count = Comment::where('post_id', $postId)->count();
                $post = Post::find($postId);
                $post->comment_count = $comment_count;
                $post->save();

                // Gửi sự kiện cho chủ bài viết bằng Pusher's client events
                $pusher = new Pusher(env('PUSHER_APP_KEY'), env('PUSHER_APP_SECRET'), env('PUSHER_APP_ID'), [
                    'cluster' => env('PUSHER_APP_CLUSTER'),
                    'useTLS' => true
                ]);

                // Gửi thông báo đến chủ bài viết nếu comment là comment cha
                if ($request->reply_id == 0) {
                    $notification = new Notification();
                    $notification->owner_id = $post->user_id; // id của người đăng bài viết
                    $notification->user_id = Auth::user()->id;
                    $notification->post_id = $postId;
                    $notification->content = 'Đã bình luận bài viết của bạn.';
                    $notification->status = 'new';
                    $notification->type = 'comment';
                    $notification->interact_id = $comment->id;
                    $notification->save();

                    $notificationsCount = Notification::where('user_id', '!=', $post->user_id)->where('owner_id', $post->user_id)->where('status', 'new')->count();
                } else { // Gửi thông báo đến người đã comment trong comment cha nếu comment là comment reply
                    $parentComment = Comment::find($request->reply_id);
                    $notification = new Notification();
                    $notification->owner_id = $parentComment->user_id;
                    $notification->user_id = Auth::user()->id;
                    $notification->post_id = $postId;
                    $notification->content = 'Đã trả lời bình luận của bạn trong bài viết.';
                    $notification->status = 'new';
                    $notification->type = 'reply-comment';
                    $notification->interact_id = $comment->id;
                    $notification->save();

                    $notificationsCount = Notification::where('user_id', '!=', $parentComment->user_id)->where('owner_id', $parentComment->user_id)->where('status', 'new')->count();
                }

                $pusher->trigger('post-channel', 'comment-event', [
                    'postId' => $postId,
                    'ownerId' => $notification->owner_id,
                    'userId' => $userId,
                    'userName' => $comment->user->name,
                    'notification_id' => $notification->id,
                    'avatar' => $comment->user->avatar,
                    'time' => formatTime($notification->created_at),
                    'notifications_count' => $notificationsCount,
                ]);

                return view('front.what_news.list-comment', compact('comments'));
            }
        }


        return response()->json(['error' => $validator->errors()->first()]);
    }

    public function destroy($post_id, $comment_id, Post $post)
    {
        $comment = Comment::where('id', $comment_id)
            ->where('post_id', $post_id)
            ->first();

        if ($comment) {
            $pusher = new Pusher(env('PUSHER_APP_KEY'), env('PUSHER_APP_SECRET'), env('PUSHER_APP_ID'), [
                'cluster' => env('PUSHER_APP_CLUSTER'),
                'useTLS' => true
            ]);

            if ($comment->reply_id == 0) {
                // Xóa comment cha và các comment con
                Comment::where('post_id', $post_id)
                    ->where(function ($query) use ($comment_id) {
                        $query->where('id', $comment_id)
                            ->orWhere('reply_id', $comment_id);
                    })
                    ->delete();

                $notification = Notification::where('owner_id', $comment->post->user_id)
                    ->whereIn('type', ['comment', 'reply-comment'])
                    ->where('interact_id', $comment->id)
                    ->first();

                if ($notification) {
                    $notification->delete();
                }

                //Cập nhật lại số lượng
                $notificationsCount = Notification::where('user_id', '!=', $comment->post->user_id)->where('owner_id', $comment->post->user_id)->where('status', 'new')->count();

                $pusher->trigger('post-channel', 'delete-comment-event', [
                    'ownerId' => $notification ? $notification->owner_id : null,
                    'userId' => Auth::user()->id,
                    'notification_id' => $notification ? $notification->id : null,
                    'notifications_count' => $notificationsCount
                ]);
            } else {
                $notification = Notification::where('owner_id', $comment->post->user_id)
                    ->whereIn('type', 'reply-comment')
                    ->where('interact_id', $comment->id)
                    ->first();

                if ($notification) {
                    $notification->delete();
                }

                $notificationsCount = Notification::where('user_id', '!=', $comment->post->user_id)->where('owner_id', $comment->post->user_id)->where('status', 'new')->count();

                $pusher->trigger('post-channel', 'delete-comment-event', [
                    'ownerId' => $notification ? $notification->owner_id : null,
                    'userId' => Auth::user()->id,
                    'notification_id' => $notification ? $notification->id : null,
                    'notifications_count' => $notificationsCount
                ]);

                // Xóa comment con
                if ($comment) {
                    $comment->delete();
                }
            }

            $comment_count = Comment::where('post_id', $post_id)->count();
            $post = Post::find($post_id);
            $post->comment_count = $comment_count;
            $post->save();

            return response()->json(['success' => true]);
        }

        return response()->json(['errors' => false, 'message' => 'Không tìm thấy bình luận']);
    }

    public function update(Request $request)
    {
        $commentText = $request->input('content');
        // dd($commentText);
        $comment = Comment::find($request->commentId);
        // dd($comment);

        if (!$comment) {
            return redirect()->back()->with('error', 'Không tìm thấy bình luận này.');
        }

        $comment->update(['content' => $commentText]);

        return redirect()->back()->with('success', 'Bình luận đã được cập nhật.');
    }
}
