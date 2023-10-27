<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Models\Comment;
use App\Models\Notification_admin;
use App\Models\Post;
use App\Models\Report;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Pusher\Pusher;

class ReportController extends Controller
{
    public function report_post(Request $request, $id)
    {
        $messages = [
            'content.required' => 'Bạn chưa nhập nội dung báo cáo.',
        ];

        $validator = Validator::make($request->all(), [
            'content' => 'required',
        ], $messages);

        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()->first()]);
        }

        $post = Post::find($id);

        $report = new Report();
        $report->owner_id = Auth::id();
        $report->user_id = $post->user_id;
        $report->content = $request->content;
        $report->post_id = $id;
        $report->comment_id = null;
        $report->type = 'post';
        $report->save();

        // Gửi sự kiện cho chủ bài viết bằng Pusher's client events
        $pusher = new Pusher(env('PUSHER_APP_KEY'), env('PUSHER_APP_SECRET'), env('PUSHER_APP_ID'), [
            'cluster' => env('PUSHER_APP_CLUSTER'),
            'useTLS' => true
        ]);

        // Tạo thông báo
        $notification = new Notification_admin();
        $notification->report_id = $report->id;
        $notification->owner_id = $report->owner_id; // id của người đăng bài viết
        $notification->user_id = $report->user_id;
        $notification->post_id = $report->post_id;
        $notification->content = 'Đã báo cáo 1 bài viết.';
        $notification->status = 'new';
        $notification->save();

        //Lấy số lượng thông báo
        $notificationsCount = Notification_admin::where('status', 'new')->count();

        $pusher->trigger('report-channel', 'send-report-event', [
            'report_id' => $report->id,
            'owner_id' => $notification->owner_id,
            'post_id' => $notification->post_id,
            'user_report' => $report->owner->name,
            'content' => $notification->content,
            'avatar' => $report->owner->avatar,
            'time' => formatTime($notification->created_at),
            'notifications_count' => $notificationsCount
        ]);

        return response()->json(['message' => 'Báo cáo thành công!']);
    }

    public function report_comment(Request $request, $id, $comment_id)
    {
        $messages = [
            'content.required' => 'Bạn chưa nhập nội dung báo cáo.',
        ];

        $validator = Validator::make($request->all(), [
            'content' => 'required',
        ], $messages);

        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()->first()]);
        }

        $comment = Comment::find($comment_id);

        $report = new Report();
        $report->owner_id = Auth::id();
        $report->user_id = $comment->user_id;
        $report->content = $request->content;
        $report->post_id = $request->post_id;
        $report->comment_id = $comment_id;
        $report->type = 'comment';
        $report->save();

        // Gửi sự kiện cho chủ bài viết bằng Pusher's client events
        $pusher = new Pusher(env('PUSHER_APP_KEY'), env('PUSHER_APP_SECRET'), env('PUSHER_APP_ID'), [
            'cluster' => env('PUSHER_APP_CLUSTER'),
            'useTLS' => true
        ]);

        // Tạo thông báo
        $notification = new Notification_admin();
        $notification->report_id = $report->id;
        $notification->owner_id = $report->owner_id; // id của người đăng bài viết
        $notification->user_id = $report->user_id;
        $notification->comment_id = $report->comment_id;
        $notification->content = 'Đã báo cáo 1 bình luận.';
        $notification->status = 'new';
        $notification->save();

        //Lấy số lượng thông báo
        $notificationsCount = Notification_admin::where('status', 'new')->count();


        $pusher->trigger('report-channel', 'send-report-event', [
            'report_id' =>  $report->id,
            'owner_id' => $notification->owner_id,
            'comment_id' => $notification->comment_id,
            'user_report' => $report->owner->name,
            'content' => $notification->content,
            'avatar' => $report->owner->avatar,
            'time' => formatTime($notification->created_at),
            'notifications_count' => $notificationsCount
        ]);

        return response()->json(['message' => 'Báo cáo thành công!']);
    }
}
