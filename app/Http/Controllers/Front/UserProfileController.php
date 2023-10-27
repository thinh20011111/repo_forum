<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Models\Follower;
use App\Models\Notification;
use App\Models\Post;
use App\Models\User;
use App\Services\User\UserServiceInterface;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Pusher\Pusher;

class UserProfileController extends Controller
{
    private $userService;

    public function __construct(UserServiceInterface $userService)
    {
        $this->userService = $userService;
    }

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
    public function user_image($id)
    {
        $notifications = Notification::getNotificationsForCurrentUser();
        $notificationsCount = $notifications->where('status', 'new')->count();

        $user = User::find($id);

        $stories = Post::where('story_post', 1)
            ->where('user_id', $id)
            ->get();

        $users = User::all();
        $online = User::where('status', 1)->count();
        $total_posts = Post::all()->count();

        return view('front.profile.user-profile-images', compact('notifications', 'total_posts', 'users', 'online', 'notificationsCount', 'user', 'stories'));
    }

    public function user_posts($id, Request $request)
    {
        $data = $request->all();

        $notifications = Notification::getNotificationsForCurrentUser();
        $notificationsCount = $notifications->where('status', 'new')->count();

        if (isset($data['notification_id'])) {
            $notification = Notification::findOrFail($data['notification_id']);
            $notification->status = 'read';
            $notification->save();
        }

        $user = User::find($id);
        $users = User::all();
        $online = User::where('status', 1)->count();
        $posts = Post::where('daily_post', 0)->where('story_post', 0)->where('user_id', $id)->orderBy('id', 'ASC')->get();
        $total_posts = Post::all()->count();
        return view('front.profile.user-profile-posts', compact('notifications', 'users', 'online', 'notificationsCount', 'user', 'posts', 'total_posts'));
    }

    public function user_stories($id)
    {
        $notifications = Notification::getNotificationsForCurrentUser();
        $notificationsCount = $notifications->where('status', 'new')->count();

        $user = User::find($id);

        $stories = Post::where('story_post', 1)
            ->where('user_id', $id)
            ->get();
        $users = User::all();
        $online = User::where('status', 1)->count();
        $total_posts = Post::all()->count();
        return view('front.profile.user-profile-stories', compact('notifications', 'users', 'online', 'total_posts', 'notificationsCount', 'user', 'stories'));
    }

    public function user_edit($id)
    {
        $notifications = Notification::getNotificationsForCurrentUser();
        $notificationsCount = $notifications->where('status', 'new')->count();

        $user = User::find($id);
        $users = User::all();
        $online = User::where('status', 1)->count();
        $total_posts = Post::all()->count();

        return view('front.profile.user-profile-edit', compact('notifications', 'notificationsCount', 'total_posts', 'user', 'users', 'online'));
    }

    public function update_profie(Request $request)
    {
        // Lấy người dùng hiện tại
        $user = User::findOrFail(Auth::user()->id);

        $messages = [
            'phoneNumber.regex' => 'Số điện thoại không hợp lệ.',
        ];
        // Validate dữ liệu đầu vào
        $validator = Validator::make($request->all(), [
            'phoneNumber' => 'regex:/^[0-9]{10}$/',
        ], $messages);

        // Nếu validation không thành công, trả về thông báo lỗi
        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()]);
        }

        // Cập nhật thông tin cá nhân
        $user->name = $request->name;
        $user->birthday = $request->birthday;
        $user->address = $request->address;
        $user->gender = $request->gender;
        $user->phone = $request->phoneNumber;
        $user->class = $request->className;

        // Lưu lại thông tin cập nhật
        $user->save();

        // Trả về dữ liệu cập nhật thành công dưới dạng JSON
        return response()->json(['success' => true, 'data' => $user]);
    }

    public function updatePassword(Request $request)
    {
        $password = $request->input('password');
        $confirmation = $request->input('password_confirmation');

        //Kiểm tra rỗng
        if ($password === null) {
            return response()->json(['error' => ['password' => ['Chưa điền mật khẩu.']]]);
        }

        if ($confirmation === null) {
            return response()->json(['error' => ['password_confirmation' => ['Chưa xác nhận mật khẩu.']]]);
        }

        // Kiểm tra mật khẩu có đáp ứng yêu cầu không
        if (strlen($password) < 8 || !preg_match('/[A-Z]/', $password) || !preg_match('/[0-9]/', $password)) {
            return response()->json(['error' => ['password' => ['Mật khẩu phải có ít nhất 8 ký tự, 1 chữ hoa, 1 chỗ số.']]]);
        }

        // Kiểm tra mật khẩu và xác nhận mật khẩu khớp nhau
        if ($password !== $confirmation) {
            return response()->json(['error' => ['password_confirmation' => ['Xác nhận mật khẩu không khớp.']]]);
        }

        // Lưu mật khẩu mới vào cơ sở dữ liệu hoặc thực hiện các tác vụ khác liên quan
        // Ví dụ:
        $user = $request->user();
        $user->password = Hash::make($password);
        $user->save();

        return response()->json(['success' => 'Mật khẩu đã được thay đổi thành công.']);
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
    public function destroy($id)
    {
        //
    }

    public function updateCoverPhoto(Request $request)
    {
        // Kiểm tra xem người dùng đã đăng nhập chưa
        if (!Auth::check()) {
            return response()->json(['error' => 'Bạn cần đăng nhập để cập nhật ảnh bìa.'], 401);
        }

        // Lấy người dùng hiện tại
        $user = User::findOrFail(Auth::user()->id);

        //Lưu lại hình ảnh cũ
        $oldImgBackground = $user->background;
        $oldImgAvatar = $user->avatar;

        // Kiểm tra xem người dùng đã tải lên tệp tin ảnh bìa hay chưa
        // Xử lý tệp tin
        if ($request->hasFile('img_background')) {
            $path_document = 'front/img/users';
            $get_file = $request->file('img_background');
            $get_name_file = $get_file->getClientOriginalName();
            $name_file =  current(explode('.', $get_name_file));
            $new_name_file = $name_file . rand(0, 99) . '.' . $get_file->getClientOriginalExtension();
            $get_file->move($path_document, $new_name_file);

            // Xóa tệp tin cũ
            if (!empty($oldImgBackground) && file_exists($path_document . '/' . $oldImgBackground)) {
                unlink($path_document . '/' . $oldImgBackground);
            }

            $user->background = $new_name_file;
        } else {
            // Giữ nguyên file cũ nếu không có file mới
            $user->background = $oldImgBackground;
        }

        // Kiểm tra xem người dùng đã tải lên tệp tin ảnh đại diện hay chưa
        if ($request->hasFile('img_avatar')) {
            $path_document = 'front/img/users';
            $get_file = $request->file('img_avatar');
            $get_name_file = $get_file->getClientOriginalName();
            $name_file =  current(explode('.', $get_name_file));
            $new_name_file = $name_file . rand(0, 99) . '.' . $get_file->getClientOriginalExtension();
            $get_file->move($path_document, $new_name_file);

            // Xóa tệp tin cũ
            if (!empty($oldImgAvatar) && file_exists($path_document . '/' . $oldImgAvatar)) {
                unlink($path_document . '/' . $oldImgAvatar);
            }

            $user->avatar = $new_name_file;
        } else {
            // Giữ nguyên file cũ nếu không có file mới
            $user->avatar = $oldImgAvatar;
        }

        // Lưu thông tin người dùng
        $user->save();

        // Trả về đường dẫn ảnh bìa và ảnh đại diện mới
        $response = [
            'background' => 'front/img/users/' . $user->background,
            'avatar' => 'front/img/users/' . $user->avatar
        ];

        return response()->json($response, 200);
    }


    public function followUser($userId)
    {
        $followerId = Auth::user()->id;

        $follow = Follower::where('user_id', $userId)
            ->where('follower_id', $followerId)
            ->first();

        $pusher = new Pusher(env('PUSHER_APP_KEY'), env('PUSHER_APP_SECRET'), env('PUSHER_APP_ID'), [
            'cluster' => env('PUSHER_APP_CLUSTER'),
            'useTLS' => true
        ]);

        if ($follow) {
            $notification = Notification::where('owner_id', $follow->user_id)->where('user_id', $follow->follower_id)->where('type', 'follow')->where('interact_id', $follow->id)->first();;

            //Cập nhật lại số lượng
            $notificationsCount = Notification::where('user_id', '!=', $follow->user_id)->where('owner_id', $follow->user_id)->where('status', 'new')->count();

            if ($notification) {
                $notification->delete();
            }

            // Người dùng đã follow, xóa dữ liệu trong bảng "followers"
            $follow->delete();
            $message = 'Đã hủy theo dõi';
        } else {
            // Người dùng chưa follow, thêm dữ liệu vào bảng "followers"
            $follow = new Follower();
            $follow->user_id = $userId;
            $follow->follower_id = $followerId;
            $follow->save();
            $message = 'Đã theo dõi';

            // Tạo thông báo
            $notification = new Notification();
            $notification->owner_id = $follow->user_id;; // id của người đăng bài viết
            $notification->user_id =  $follow->follower_id;
            $notification->content = 'Đã theo dõi bạn.';
            $notification->status = 'new';
            $notification->type = 'follow';
            $notification->interact_id = $follow->id;
            $notification->save();

            $notification_id =  $notification->id;

            //Lấy số lượng thông báo
            $notificationsCount = Notification::where('user_id', '!=', $follow->user_id)->where('owner_id', $follow->user_id)->where('status', 'new')->count();

            $pusher->trigger('post-channel', 'follow-event', [
                'ownerId' => $notification->owner_id,
                'userId' => $notification->user_id,
                'userName' => Auth::user()->name,
                'notification_id' => $notification_id,
                'avatar' => Auth::user()->avatar,
                'time' => formatTime($follow->created_at),
                'notifications_count' => $notificationsCount
            ]);
        }

        return response()->json(['message' => $message]);
    }
}
