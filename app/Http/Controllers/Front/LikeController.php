<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Models\Like;
use App\Models\Notification;
use App\Models\Post;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Pusher\Pusher;

class LikeController extends Controller
{
    public function like(Request $request, $id)
    {
        $postId = $id;
        $userId = $request->input('user_id');
        $userName = User::find($userId)->name ?? null;
        $userAvt =  User::find($userId)->avatar ?? null;
        $post = Post::find($postId);

        // Gửi sự kiện cho chủ bài viết bằng Pusher's client events
        $pusher = new Pusher(env('PUSHER_APP_KEY'), env('PUSHER_APP_SECRET'), env('PUSHER_APP_ID'), [
            'cluster' => env('PUSHER_APP_CLUSTER'),
            'useTLS' => true
        ]);

        $like = Like::where('post_id', $postId)
            ->where('user_id', $userId)
            ->first();

        if ($like) {
            $like->delete();
            $liked = false;
        } else {
            $like = new Like();
            $like->post_id = $postId;
            $like->user_id = $userId;
            $like->save();
            $liked = true;

            // Tạo thông báo
            $notification = new Notification();
            $notification->owner_id = $post->user_id; // id của người đăng bài viết
            $notification->user_id = Auth::user()->id;
            $notification->post_id = $postId;
            $notification->content = 'Đã thích bài viết của bạn.';
            $notification->status = 'new';
            $notification->type = 'like';
            $notification->interact_id = $like->id;
            $notification->save();

            $notification_id =  $notification->id;

            //Lấy số lượng thông báo
            $notificationsCount = Notification::where('user_id', '!=', $post->user_id )->where('owner_id', $post->user_id)->where('status', 'new')->count();

            $pusher->trigger('post-channel', 'like-event', [
                'postId' => $postId,
                'ownerId' => $notification->owner_id,
                'userId' => $userId,
                'userName' => $userName,
                'notification_id' => $notification_id,
                'avatar' => $userAvt,
                'time' => formatTime($notification->created_at),
                'notifications_count' => $notificationsCount
            ]);
        }

        $likesCount = Like::where('post_id', $postId)->count();
        $post = Post::find($postId);
        $post->like_count = $likesCount;
        $post->save();

        // Xóa thông báo nếu người dùng bỏ thích
        if (!$liked) {
            $notification = Notification::where('owner_id', $post->user_id)->where('type', 'like')
                ->where('interact_id', $like->id)
                ->first();

            $notification->delete();

            //Cập nhật lại số lượng
            $notificationsCount = Notification::where('user_id', '!=', $post->user_id )->where('owner_id', $post->user_id)->where('status', 'new')->count();

            if ($notification) {
                $pusher->trigger('post-channel', 'unlike-event', [
                    'ownerId' => $notification->owner_id,
                    'userId' => $notification->user_id,
                    'notification_id' => $notification->id,
                    'notifications_count' => $notificationsCount
                ]);
            }
        }

        return response()->json([
            'liked' => $liked,
            'likesCount' => $likesCount,
        ]);
    }
}
