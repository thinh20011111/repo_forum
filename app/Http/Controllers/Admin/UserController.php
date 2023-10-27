<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Notification_admin;
use App\Models\User;
use App\Services\User\UserServiceInterface;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{
    private $userService;

    public function __construct(UserServiceInterface $userService)
    {
        $this->userService = $userService;
    }

    public function index()
    {
        //
    }

    public function create()
    {
        $noti_small = Notification_admin::orderBy('created_at', 'desc')
            ->limit(5)
            ->get();
        $notification_count = Notification_admin::where('status', 'new')->count();
        return view('admin.create_user',compact('noti_small', 'notification_count'));
    }


    public function store(Request $request)
    {
        $messages = [
            'username.required' => 'Trường Tên là bắt buộc.',
            'email.required' => 'Trường Email là bắt buộc.',
            'email.email' => 'Định dạng Email không hợp lệ.',
            'password.required' => 'Trường Mật khẩu là bắt buộc.',
            'password.min' => 'Mật khẩu phải chứa ít nhất :min ký tự.',
            'password.regex' => 'Mật khẩu phải chứa ít nhất một chữ viết hoa và một số.',
            'password_confirmation.required' => 'Trường Nhập lại mật khẩu là bắt buộc.',
            'password_confirmation.same' => 'Mật khẩu không khớp.',
            'phone.regex' => 'Số điện thoại không hợp lệ.',
            'email.unique' => 'Địa chỉ email đã được sử dụng.',
            'role.required' => 'Chưa chọn quyền cho người dùng này.',
            // Thêm các thông báo lỗi khác tại đây...
        ];

        $validator = Validator::make($request->all(), [
            'username' => 'required',
            'email' => 'required|email|unique:users',
            'password' => 'required|min:8|regex:/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d).+$/',
            'password_confirmation' => 'required|same:password',
            'phone' => 'nullable|regex:/^[0-9]{10}$/',
            'role' => 'required',
        ], $messages);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        if ($request->hasFile('avatar')) {
            $path_document = 'front/img/users';
            $get_file = $request->file('avatar');
            $get_name_file = $get_file->getClientOriginalName();
            $name_file =  current(explode('.', $get_name_file));
            $new_name_file = $name_file . rand(0, 99) . '.' . $get_file->getClientOriginalExtension();
            $get_file->move($path_document, $new_name_file);

            $avatar = $new_name_file;
        }

        // Tạo dữ liệu người dùng mới
        $data = [
            'name' => $request->username,
            'email' => $request->email,
            'password' => bcrypt($request->password),
            'level' =>  $request->role,
            'birthday' => $request->birthday ? Carbon::createFromFormat('Y-m-d', $request->birthday)->format('Y-m-d') : null,
            'gender'  => $request->gender,
            'class'  => $request->class,
            'phone'  => $request->phoneNumber,
            'created_at' => Carbon::now(),
            'status' => 0,
            'avatar' =>  $avatar ?? null,
        ];

        $this->userService->create($data);

        return redirect('admin/manage_users')->with('notification', 'Đăng ký thành công!');
    }

    public function show($id)
    {
        $user = User::find($id);
        $noti_small = Notification_admin::orderBy('created_at', 'desc')
        ->limit(5)
        ->get();
    $notification_count = Notification_admin::where('status', 'new')->count();
        return view('admin.user_show', compact('user', 'noti_small', 'notification_count'));
    }

    public function edit($id)
    {
        $user = User::find($id);
        $noti_small = Notification_admin::orderBy('created_at', 'desc')
            ->limit(5)
            ->get();
        $notification_count = Notification_admin::where('status', 'new')->count();
        return view('admin.edit_user', compact('user', 'noti_small', 'notification_count'));
    }

    public function update(Request $request, $id)
    {
        // Lấy người dùng hiện tại
        $user = User::findOrFail($id);

        $messages = [
            'phone.regex' => 'Số điện thoại không hợp lệ.',
        ];
        // Validate dữ liệu đầu vào
        $validator = Validator::make($request->all(), [
            'phone' => 'nullable|regex:/^[0-9]{10}$/',
        ], $messages);

        // Nếu validation không thành công, trả về thông báo lỗi
        if ($validator->fails()) {
            if ($validator->fails()) {
                return back()
                    ->withErrors($validator)  // Lưu thông tin lỗi vào session
                    ->withInput();  // Lưu lại giá trị đã nhập của người dùng
            }
        }

        //Lưu lại hình ảnh cũ
        $oldImgAvatar = $user->avatar;

        // Kiểm tra xem người dùng đã tải lên tệp tin ảnh đại diện hay chưa
        if ($request->hasFile('avatar')) {
            $path_document = 'front/img/users';
            $get_file = $request->file('avatar');
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


        // Cập nhật thông tin cá nhân
        $user->name = $request->username;


        $user->birthday = $request->birthday ? Carbon::createFromFormat('Y-m-d', $request->birthday)->format('Y-m-d') : null;
        $user->address = $request->address ? $request->address : null;
        $user->gender = $request->gender;
        $user->phone = $request->phone;
        $user->created_at = $request->date_join ?  Carbon::createFromFormat('Y-m-d', $request->date_join)->format('Y-m-d') : null;
        $user->class = $request->className;
        $user->level = $request->role;

        // Lưu lại thông tin cập nhật
        $user->save();

        return redirect()->to('/admin/manage_users/user_' . $id);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function delete($userId)
    {
        // Tìm người dùng
        $user = User::find($userId);

        if (!$user) {
            // Người dùng không tồn tại
            return response()->json(['message' => 'User not found'], 404);
        }

        // Xóa bài viết
        $user->posts()->delete();

        // Xóa like
        $user->likes()->delete();

        // Xóa comment
        $user->comments()->delete();

        // Xóa messages (tính cả sender và receiver)
        $user->messagesSent()->delete();
        $user->messagesReceived()->delete();

        // Xóa notification
        $user->notifications()->delete();

        // Xóa hình ảnh avatar và background
        if ($user->avatar) {
            $path_document = 'front/img/users';

            // Xóa tệp tin cũ
            if (!empty($user->avatar) && file_exists($path_document . '/' . $user->avatar)) {
                unlink($path_document . '/' . $user->avatar);
            }
        }

        // Xóa người dùng
        $user->delete();

        return response()->json(['message' => 'User deleted successfully'], 200);
    }

    public function searchUser(Request $request)
    {
        $searchTerm = $request->input('searchTerm');

        // Tìm kiếm người dùng dựa trên tên chứa ký tự được nhập vào
        $users = User::where('name', 'like', '%' . $searchTerm . '%')->get();

        return response()->json($users);
    }
}
