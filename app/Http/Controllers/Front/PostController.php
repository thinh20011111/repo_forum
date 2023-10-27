<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Models\Comment;
use App\Models\Notification;
use App\Models\Post;
use App\Models\Subject;
use App\Models\Tag;
use App\Models\User;
use App\Services\Notification\NotificationServiceInterface;
use App\Services\PostCategories\PostCategoriesServiceInterface;
use App\Services\Posts\PostsServiceInterface;
use App\Services\School_year\School_yearServiceInterface;
use App\Services\Specialized\SpecializedServiceInterface;
use App\Services\Subject\SubjectServiceInterface;
use App\Services\Type\TypeServiceInterface;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Pusher\Pusher;

class PostController extends Controller
{
    private $shcool_yearService;
    private $typeService;
    private $specializedService;
    private $subjecService;
    private $categoriesService;
    private $postsService;
    private $notificationsService;

    public function __construct(
        School_yearServiceInterface $shcool_yearService,
        SpecializedServiceInterface $specializedService,
        SubjectServiceInterface $subjecService,
        TypeServiceInterface $typeService,
        PostCategoriesServiceInterface $categoriesService,
        PostsServiceInterface $postsService,
        NotificationServiceInterface $notificationsService
    ) {
        $this->typeService =  $typeService;
        $this->subjecService = $subjecService;
        $this->shcool_yearService = $shcool_yearService;
        $this->specializedService = $specializedService;
        $this->categoriesService = $categoriesService;
        $this->postsService = $postsService;
        $this->notificationsService = $notificationsService;
    }

    public function index()
    {
        $types = $this->typeService->all();
        $subjects = $this->subjecService->all();
        $school_years = $this->shcool_yearService->all();
        $specialized = $this->specializedService->all();
        $categories = $this->categoriesService->all();
        $posts = $this->postsService->all();
        $notifications = Notification::getNotificationsForCurrentUser();
        $notificationsCount = $notifications->where('status', 'new')->count();

        return view('front.create_post.index', compact('types', 'subjects', 'school_years', 'specialized', 'categories', 'posts', 'notifications', 'notificationsCount'));
    }

    public function create()
    {
        $types = $this->typeService->all();
        $subjects = $this->subjecService->all();
        $school_years = $this->shcool_yearService->all();
        $specialized = $this->specializedService->all();
        $categories = $this->categoriesService->all();
        $posts = $this->postsService->all();
        $notifications = Notification::getNotificationsForCurrentUser();
        $notificationsCount = $notifications->where('status', 'new')->count();

        return view('front.create_post.index', compact('types', 'subjects', 'school_years', 'specialized', 'categories', 'posts', 'notifications', 'notificationsCount'));
    }

    public function store(Request $request)
    {
        $messages = [
            'type.required' => 'Trường này không được để trống.',
            'category.required' => 'Trường này không được để trống.',
            'title.required' => 'Trường này không được để trống.',
            'content.required' => 'Trường này không được để trống.',
        ];

        $validator = Validator::make($request->all(), [
            'type' => 'required',
            'category' => 'required',
            'title' => 'required',
            'content' => 'required',
        ], $messages);

        if ($validator->fails()) {
            return redirect('/create_post')
                ->withErrors($validator)
                ->withInput();
        }

        $path_document = 'front/files';
        $get_file = $request->file('file_path');

        $tags = $request->input('tags');

        if ($get_file) {
            $get_name_file = $get_file->getClientOriginalName();
            $name_file = current(explode('.', $get_name_file));
            $new_name_file = $name_file . rand(0, 99) . '.' . $get_file->getClientOriginalExtension();
            $get_file->move($path_document, $new_name_file);
        }

        $user_id = Auth::user()->id;

        $post = $this->postsService->create([
            'subject' => $request->input('subject'),
            'school_year' => $request->input('school_year'),
            'topic' => $request->input('topic'),
            'specialized' => $request->input('specialized'),
            'type' => $request->input('type'),
            'category' => $request->input('category'),
            'title' => $request->input('title'),
            'content' => $request->input('content'),
            'file_path' => isset($new_name_file) ? $new_name_file : null,
            'user_id' => $user_id,
        ]);


        //gửi thông báo đến người đã follow
        $pusher = new Pusher(env('PUSHER_APP_KEY'), env('PUSHER_APP_SECRET'), env('PUSHER_APP_ID'), [
            'cluster' => env('PUSHER_APP_CLUSTER'),
            'useTLS' => true
        ]);

        $followers = Auth::user()->followers;

        foreach ($followers as $follower) {
            // Tạo thông báo
            $notification = new Notification();
            $notification->owner_id = $follower->id; // id của người đăng bài viết
            $notification->user_id = Auth::user()->id;
            $notification->post_id = $post->id;
            $notification->content = 'Đã đăng một bài viết mới.';
            $notification->status = 'new';
            $notification->type = 'create';
            $notification->save();

            $notification_id = $notification->id;

            // Lấy số lượng thông báo
            $notificationsCount = Notification::where('owner_id', $follower->id)
                ->where('status', 'new')
                ->count();

            $pusher->trigger('post-channel', 'create-event', [
                'post_id' => $notification->post_id,
                'ownerId' => $notification->owner_id,
                'userId' => $notification->user_id,
                'userName' => Auth::user()->name,
                'notification_id' => $notification_id,
                'avatar' => Auth::user()->avatar,
                'time' => formatTime($post->created_at),
                'notifications_count' => $notificationsCount
            ]);
        }

        // Lưu các tags vào bảng "tag"
        if ($tags) {
            if (is_array($tags)) {
                $tagIds = [];
                foreach ($tags as $tag) {
                    $tagName = is_array($tag) ? $tag['name'] : $tag;
                    // Kiểm tra xem tag đã tồn tại trong bảng "tag" chưa
                    $existingTag = Tag::where('name', $tagName)->first();

                    if ($existingTag) {
                        $tagIds[] = $existingTag->id;
                    } else {
                        // Tạo tag mới trong bảng "tag"
                        $newTag = Tag::create([
                            'name' => $tagName
                        ]);

                        $tagIds[] = $newTag->id;
                    }
                }
                // Thêm các tag vào bài viết trong bảng "post_tag"
                $post->tags()->syncWithoutDetaching($tagIds);
            } else {
                // Kiểm tra xem tag đã tồn tại trong bảng "tag" chưa
                $existingTag = Tag::where('name', $tags)->first();

                if ($existingTag) {
                    // Thêm tag vào bài viết trong bảng "post_tag"
                    $post->tags()->syncWithoutDetaching($existingTag->id);
                } else {
                    // Tạo tag mới trong bảng "tag"
                    $newTag = Tag::create([
                        'name' => $tags
                    ]);

                    // Thêm tag mới vào bài viết trong bảng "post_tag"
                    $post->tags()->syncWithoutDetaching($newTag->id);
                }
            }
        }

        return redirect('')->with('success', 'Post created successfully!');
    }

    public function show($id, Request $request)
    {
        $data = $request->all();

        //Thay đổi trạng thái của thông báo
        // $notification_id = $request->input('notification_id');
        if (isset($data['notification_id'])) {
            $notification = Notification::findOrFail($data['notification_id']);
            $notification->status = 'read';
            $notification->save();
        }

        $types = $this->typeService->all();
        $subjects = $this->subjecService->all();
        $school_years = $this->shcool_yearService->all();
        $specialized = $this->specializedService->all();
        $categories = $this->categoriesService->all();
        $post = $this->postsService->find($id);

        $relatedPosts = Post::where('topic', $post->topic)->where('id', '<>', $id)->get();

        $count_comments = Comment::where('post_id', $id)->count();

        //Thay đổi số lượt xem bài viết
        $post->view_count += 1;
        $post->save();

        $notifications = Notification::getNotificationsForCurrentUser();
        $notificationsCount = $notifications->where('status', 'new')->count();

        if (Auth::check()) {
            $loggedInUserId = Auth::user()->id;

            $postId = $id;

            $liked = DB::table('likes')
                ->where('user_id', $loggedInUserId)
                ->where('post_id', $postId)
                ->exists();
        } else {
            $liked = false;
        }
        $users = User::all();
        $online = User::where('status', 1)->count();
        $total_posts = Post::all()->count();

        return view('front.what_news.show_post', compact('users', 'online', 'total_posts', 'types', 'subjects', 'school_years', 'specialized', 'categories', 'post', 'liked', 'count_comments', 'relatedPosts', 'notifications', 'notificationsCount'));
    }

    public function edit($id)
    {
    }

    public function update(Request $request, $postId)
    {
        $post = Post::findOrFail($postId);

        // Kiểm tra quyền truy cập
        if ($post->user_id != auth()->user()->id) {
            return back()->with('error', 'Bạn không có quyền chỉnh sửa bài viết này.');
        }

        $messages = [
            'content_edit.required' => 'Trường này không được để trống.',
            'image.required' => 'Vui lòng chọn hình ảnh',
            'image.mimes' => 'File tải lên không phải là hình ảnh',
            'image.max' => 'Dung lượng hình ảnh tối đa là 2MB',
        ];

        // Validate dữ liệu nhập vào
        $validator = Validator::make($request->all(), [
            'content_edit' => 'required',
            'file_path' => 'file', // Kiểm tra tệp tin
            'image' => 'required|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ], $messages);

        if ($validator->passes()) {
            // Lưu tên file cũ
            $oldFilePath = $post->file_path;
            $oldImg = $post->image;

            // Xử lý tệp tin
            if ($request->hasFile('file_path')) {
                $path_document = 'front/files';
                $get_file = $request->file('file_path');
                $get_name_file = $get_file->getClientOriginalName();
                $name_file =  current(explode('.', $get_name_file));
                $new_name_file = $name_file . rand(0, 99) . '.' . $get_file->getClientOriginalExtension();
                $get_file->move($path_document, $new_name_file);

                // Xóa tệp tin cũ
                if (!empty($oldFilePath)) {
                    unlink($path_document . '/' . $oldFilePath);
                }

                $post->file_path = $new_name_file;
            } else {
                // Giữ nguyên file cũ nếu không có file mới
                $post->file_path = $oldFilePath;
            }

            if ($request->hasFile('img_path')) {
                $path_document = 'front/img/stories';
                $get_file = $request->file('img_path');
                $get_name_file = $get_file->getClientOriginalName();
                $name_file =  current(explode('.', $get_name_file));
                $new_name_file = $name_file . rand(0, 99) . '.' . $get_file->getClientOriginalExtension();
                $get_file->move($path_document, $new_name_file);

                // Xóa tệp tin cũ
                if (!empty($oldFilePath)) {
                    unlink($path_document . '/' . $oldFilePath);
                }

                $post->file_path = $new_name_file;
            } else {
                // Giữ nguyên file cũ nếu không có file mới
                $post->file_path = $oldFilePath;
            }

            // Cập nhật bài viết
            $post->content = $request->input('content_edit');
            $post->save();
        }

        return response()->json(['error' => $validator->errors()->first(), 'file_path' => $post->file_path]);
    }

    public function destroy($postId)
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

        return redirect('/')->with('success', 'Xóa bài viết thành công');
    }

    public function create_daily_post(Request $request)
    {
        $userId = Auth::user()->id;

        $messages = [
            'content.required' => 'Bạn chưa nhập nội dung chia sẻ.',
        ];

        $validator = Validator::make($request->all(), [
            'content' => 'required',
        ], $messages);

        if ($validator->passes()) {
            $data = [
                'user_id' => $userId,
                'daily_post' => 1,
                'content' => $request->content
            ];

            if ($post = $this->postsService->create($data)) {
                $daily_posts = Post::where('daily_post', 1)->orderBy('id', 'DESC')->get();

                return view('front.list-daily-post', compact('daily_posts'));
            }
        }

        return response()->json(['error' => $validator->errors()->first()]);
    }

    public function create_stories_post(Request $request)
    {
        $messages = [
            'content.required' => 'Vui lòng nhập nội dung',
            'image.required' => 'Vui lòng chọn hình ảnh',
            'image.mimes' => 'File tải lên không phải là hình ảnh',
            'image.max' => 'Dung lượng hình ảnh tối đa là 2MB',
        ];

        $validator = Validator::make($request->all(), [
            'content' => 'required',
            'image' => 'required|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ], $messages);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()]);
        }

        $count_post = Post::where('story_post', 1)->where('user_id', Auth::user()->id)->count();
        if ($count_post == 0) {
            $exist = null;
        } else $exist = 1;

        $latestStoryByUser = null;
        if (Post::where('story_post', 1)->where('user_id', Auth::user()->id)->exists()) {
            $latestStoryByUser = Post::where('story_post', 1)->where('user_id', Auth::user()->id)->latest()->first()->id;
            $post = new Post;
            $post->user_id = Auth::user()->id;
            $post->content = $request->input('content');
            $post->story_post = 1;

            if ($request->hasFile('image')) {
                $image = $request->file('image');
                $imageName = time() . '_' . $image->getClientOriginalName();
                $image->move(public_path('front/img/stories'), $imageName);
                $post->image = $imageName;
                $post->save();
            }
        } else {
            $post = new Post;
            $post->user_id = Auth::user()->id;
            $post->content = $request->input('content');
            $post->story_post = 1;

            if ($request->hasFile('image')) {
                $image = $request->file('image');
                $imageName = time() . '_' . $image->getClientOriginalName();
                $image->move(public_path('front/img/stories'), $imageName);
                $post->image = $imageName;
                $post->save();
            }

            $latestStoryByUser = $post->id;
        }

        return response()->json([
            'success' => true,
            'image' => $post->image,
            'avatar' => Auth::user()->avatar,
            'name' => Auth::user()->name,
            'user_id' => Auth::user()->id,
            'id' => $latestStoryByUser,
            'new_id' =>  $post->id,
            'exist' => $exist
        ]);
    }

    public function disable_comment($id, Request $request)
    {
        $post = Post::find($id);
        // Lấy thông tin từ yêu cầu
        $commentMode = $request->input('comment_mode');

        // Cập nhật trường comment_mode của bài viết

        if ($commentMode == 1 || $commentMode == 0) {
            $post->comment_mode = $commentMode;
            $post->save();
            // Thực hiện cập nhật thành công
            return response()->json(['success' => true]);
        } else {
            // Xảy ra lỗi
            return response()->json(['success' => false]);
        }
    }
}
