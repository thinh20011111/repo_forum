<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Comment;
use App\Models\Notification_admin;
use App\Models\Post;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Storage;

class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
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

    public function show($id)
    {
        $post = Post::find($id);
        $noti_small = Notification_admin::orderBy('created_at', 'desc')
            ->limit(5)
            ->get();
        $notification_count = Notification_admin::where('status', 'new')->count();
        return view('admin.post_details', compact('post', 'noti_small', 'notification_count'));
    }

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
    public function delete_post($postId)
    {
        $post = Post::find($postId);

        // Lấy đường dẫn file và hình ảnh từ bài viết
        $file_path = $post->file_path;
        $image_path = $post->image;

        // Kiểm tra nếu có đường dẫn file, thực hiện xóa file
        if ($file_path) {
            $full_path = 'front/files/' . $file_path;
            if (file_exists($full_path)) {
                unlink($full_path);
            }
        }

        // Kiểm tra nếu có đường dẫn hình ảnh, thực hiện xóa hình ảnh
        if ($image_path) {
            $image_full_path = 'front/img/stories/' . $image_path;
            if (file_exists($image_full_path)) {
                unlink($image_full_path);
            }
        }

        // Xóa comment và bài viết
        $post->likes()->delete();
        $post->comments()->delete();
        $post->delete();

        return redirect('/admin/manage_posts')->with('success', 'Xóa bài viết thành công');
    }

    public function create_event()
    {
        $noti_small = Notification_admin::orderBy('created_at', 'desc')
            ->limit(5)
            ->get();
        $notification_count = Notification_admin::where('status', 'new')->count();
        return view('admin.create_event', compact('noti_small', 'notification_count'));
    }

    public function store_event(Request $request)
    {
        // Validate dữ liệu đầu vào
        $validator = Validator::make($request->all(), [
            'image' => 'required|image',
            'end_time' => 'required|date|after_or_equal:today',
            'title' => 'required',
            'content' => 'required',
        ], [
            'image.required' => 'Hình ảnh không được để trống.',
            'image.image' => 'Vui lòng chỉ chọn file hình ảnh.',
            'end_time.required' => 'Thời gian kết thúc sự kiện không được để trống.',
            'end_time.date' => 'Thời gian kết thúc sự kiện phải là ngày.',
            'end_time.after_or_equal' => 'Thời gian kết thúc sự kiện không được chọn trong quá khứ.',
            'title.required' => 'Tiêu đề không được để trống.',
            'content.required' => 'Nội dung không được để trống.',
        ]);

        // Kiểm tra và xử lý lỗi validation
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $imageName = time() . '_' . $image->getClientOriginalName();
            $image->move(public_path('front/img/event_post'), $imageName);
        }

        // Lưu bài viết vào cơ sở dữ liệu
        $post = new Post();
        $post->user_id = Auth::user()->id;
        $post->end_time_event = $request->input('end_time');
        $post->event_post = 1;
        $post->title = $request->input('title');
        $post->content = $request->input('content');
        $post->image = $imageName;

        $post->save();

        // Trả về kết quả và thông báo thành công
        return redirect('admin/manage_event')->with('success', 'Đăng bài viết thành công!');
    }

    public function show_event($id)
    {
        $post = Post::find($id);
        $noti_small = Notification_admin::orderBy('created_at', 'desc')
            ->limit(5)
            ->get();
        $notification_count = Notification_admin::where('status', 'new')->count();
        return view('admin.event_details', compact('post', 'noti_small', 'notification_count'));
    }

    public function delete_event($postId)
    {
        $post = Post::find($postId);

        $image_path = $post->image;

        // Kiểm tra nếu có đường dẫn hình ảnh, thực hiện xóa hình ảnh
        if ($image_path) {
            $image_full_path = 'front/img/event_post/' . $image_path;
            if (file_exists($image_full_path)) {
                unlink($image_full_path);
            }
        }

        // Xóa comment và bài viết
        $post->likes()->delete();
        $post->comments()->delete();
        $post->delete();

        return redirect('/admin/manage_event')->with('success', 'Xóa bài viết thành công');
    }

    public function search_event(Request $request)
    {
        $searchTerm = $request->input('searchTerm');
        $events = Post::where('event_post', '1')
            ->where('title', 'like', "%$searchTerm%")
            ->select('id', 'title', 'content')
            ->get();

        return response()->json($events);
    }

    public function search_event_by_date(Request $request)
    {
        $noti_small = Notification_admin::orderBy('created_at', 'desc')
            ->limit(5)
            ->get();
        $notification_count = Notification_admin::where('status', 'new')->count();
        $startDate = $request->input('start_date');
        $endDate = $request->input('end_date');

        $posts = Post::where('event_post', '1')
            ->whereDate('created_at', '>=', $startDate)
            ->whereDate('end_time_event', '<=', $endDate)
            ->paginate(10);

        return view('admin.manage_event', compact('posts', 'noti_small', 'notification_count'));
    }

    public function edit_event($id)
    {
        $post = Post::find($id);
        $noti_small = Notification_admin::orderBy('created_at', 'desc')
            ->limit(5)
            ->get();
        $notification_count = Notification_admin::where('status', 'new')->count();
        return view('admin.edit_event', compact('post', 'noti_small', 'notification_count'));
    }

    public function save_event(Request $request, $id)
    {
        // Kiểm tra các trường bắt buộc
        $validatedData = $request->validate([
            'title' => 'required',
            'content' => 'required',
            'image' => 'image|mimes:jpeg,png,jpg,gif|max:2048', // Thay đổi các yêu cầu kỹ thuật cho hình ảnh tùy theo nhu cầu
            'end_time' => 'required|date|after:start_time', // Ngày kết thúc phải sau ngày bắt đầu
        ], [
            'end_time.after' => 'Ngày kết thúc phải sau ngày bắt đầu.',
        ]);

        // Tìm sự kiện cần chỉnh sửa
        $event = Post::findOrFail($id);

        // Kiểm tra xem ngày kết thúc có lớn hơn ngày bắt đầu không
        $startTime = Carbon::parse($event->start_time);
        $endTime = Carbon::parse($validatedData['end_time']);
        if ($endTime->lessThan($startTime)) {
            return redirect()->back()->withErrors(['end_time' => 'Ngày kết thúc phải sau ngày bắt đầu.'])->withInput();
        }

        $oldImg = $event->image;
        // Kiểm tra xem người dùng đã tải lên tệp tin ảnh đại diện hay chưa
        if ($request->hasFile('image')) {
            $path_document = 'front/img/event_post';
            $get_file = $request->file('image');
            $get_name_file = $get_file->getClientOriginalName();

            $name_file =  current(explode('.', $get_name_file));
            $new_name_file = $name_file . rand(0, 99) . '.' . $get_file->getClientOriginalExtension();
            $get_file->move($path_document, $new_name_file);

            // Xóa tệp tin cũ
            if (!empty($oldImg) && file_exists($path_document . '/' . $oldImg)) {
                unlink($path_document . '/' . $oldImg);
            }

            $event->image = $new_name_file;
        } else {
            // Giữ nguyên file cũ nếu không có file mới
            $event->image = $oldImg;
        }

        // Cập nhật thông tin sự kiện
        $event->title = $validatedData['title'];
        $event->content = $validatedData['content'];
        $event->end_time_event = $endTime;
        // Lưu và thực hiện các thao tác khác cần thiết
        $event->save();

        // Điều hướng người dùng đến trang hiển thị sự kiện hoặc trang thành công khác
        return redirect('/admin/manage_event/event_'.$event->id);
    }
}
