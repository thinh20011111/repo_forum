<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Comment;
use App\Models\Notification_admin;
use App\Models\Post;
use App\Models\Report;
use Illuminate\Http\Request;

class ReportController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $report = Report::find($id);
        $notification = Notification_admin::where('report_id', $report->id)->first();
        $notification->status = 'read';
        $notification->save();

        $noti_small = Notification_admin::orderBy('created_at', 'desc')
            ->limit(5)
            ->get();
        $notification_count = Notification_admin::where('status', 'new')->count();
        return view('admin.details_report_post', compact('report', 'noti_small', 'notification_count'));
    }
    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function delete($id)
    {
        $report = Report::find($id);

        $report->delete();

        return redirect('admin/manage_reports/posts');
    }

    public function delete_post($id)
    {
        $post = Post::find($id);


        // Kiểm tra nếu có đường dẫn file, thực hiện xóa file
        if ($post->file_path) {
            $file_path = $post->file_path;
            $full_path = 'front/files/' . $file_path;
            if (file_exists($full_path)) {
                unlink($full_path);
            }
        }

        // Kiểm tra nếu có đường dẫn hình ảnh, thực hiện xóa hình ảnh
        if ($post->image) {
            $image_path = $post->image;
            $image_full_path = 'front/img/stories/' . $image_path;
            if (file_exists($image_full_path)) {
                unlink($image_full_path);
            }
        }

        // Xóa comment và bài viết
        $post->likes()->delete();
        $post->comments()->delete();
        $post->delete();

        return redirect('/admin/manage_reports/posts')->with('success', 'Xóa bài viết thành công');
    }


    public function delete_comment($id)
    {
        $report = Report::find($id);

        $comment_id = $report->comment_id;
        $post_id = $report->post_id;

        $comment = Comment::where('id',  $comment_id)
            ->where('post_id',  $post_id)
            ->first();

        if ($comment) {
            if ($comment->reply_id == 0) {
                // Xóa comment cha và các comment con
                Comment::where('post_id', $post_id)
                    ->where(function ($query) use ($comment_id) {
                        $query->where('id', $comment_id)
                            ->orWhere('reply_id', $comment_id);
                    })
                    ->delete();
            } else {
                if ($comment) {
                    $comment->delete();
                }
            }

            $comment_count = Comment::where('post_id', $post_id)->count();
            $post = Post::find($post_id);
            $post->comment_count = $comment_count;
            $post->save();
        }

        return redirect('/admin/manage_reports/comments')->with('success', 'Xóa comment thành công');
    }
}
