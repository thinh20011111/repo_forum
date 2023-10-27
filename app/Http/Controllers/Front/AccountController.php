<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Services\User\UserServiceInterface;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Validator;

class AccountController extends Controller
{
    private $userService;

    public function __construct(UserServiceInterface $userService)
    {
        $this->userService = $userService;
    }

    public function login()
    {
        return view('front.account.login');
    }

    public function checkMemberLogin(Request $request)
    {
        $credentials = [
            'email' => $request->email,
            'password' => $request->password,
        ];

        $remember = $request->remember;


        if (Auth::attempt($credentials, $remember)) {
            // return redirect(''); //Trang chủ
            $user = User::find(Auth::user()->id);
            $user->status = '1';

            $user->save();

            return redirect()->intended('');
        } else {
            return back()->with('notification', 'Sai thông tin đăng nhập');
        }
    }

    public function logout()
    {
        $user = User::find(Auth::user()->id);
        $user->status = '0';

        $user->save();

        Auth::logout();
        return back();
    }

    public function register()
    {
        return view('front.account.register');
    }

    public function postRegister(Request $request)
    {
        $messages = [
            'name.required' => 'Trường Tên là bắt buộc.',
            'email.required' => 'Trường Email là bắt buộc.',
            'email.email' => 'Định dạng Email không hợp lệ.',
            'email.unique' => 'Email này đã dược đăng ký.',
            'password.required' => 'Trường Mật khẩu là bắt buộc.',
            'password.min' => 'Mật khẩu phải chứa ít nhất :min ký tự.',
            'password.regex' => 'Mật khẩu phải chứa ít nhất một chữ viết hoa và một số.',
            'password_confirmation.required' => 'Trường Nhập lại mật khẩu là bắt buộc.',
            'password_confirmation.same' => 'Mật khẩu không khớp.',
            // Thêm các thông báo lỗi khác tại đây...
        ];

        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'email' => 'required|email|unique:users',
            'password' => 'required|min:8|regex:/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d).+$/',
            'password_confirmation' => 'required|same:password'
        ], $messages);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        // Tạo dữ liệu người dùng mới
        $data = [
            'name' => $request->name,
            'email' => $request->email,
            'password' => bcrypt($request->password),
            'level' => 2, // đăng ký tài khoản cấp khách hàng bình thường
        ];

        $user = $this->userService->create($data);
        $userCreated = true;

        $email_to = $user->email;
        $user_name = $user->name;
        Mail::send(
            'front.email',
            compact('user_name'),
            function ($message) use ($email_to) {
                $message->from('forumfita@gmail.com', 'FORUM-FITA-VNUA'); // Thay 'Your Name' bằng tên bạn muốn hiển thị là người gửi
                $message->to($email_to);
                $message->subject('Welcome');
            }
        );


        return redirect('account/login')->with('notification', 'Đăng ký thành công!');
    }

    public function fogot_password()
    {
        return view('front.account.forgot_password');
    }

    public function reset_password(Request $request)
    {
        $data = $request->all();

        $user = User::where('email', $data['email'])->first();

        if (!$user) {
            return redirect()->back()->with('error', 'Email này chưa được đăng ký!');
        }

        $token_random = Str::random();
        $user->user_token = $token_random;
        $user->save();

        //Gửi email
        $email_to = $user->email;
        $user_name = $user->name;
        $link = url('account/change_password?email=' . $email_to . '&token=' . $token_random);
        Mail::send(
            'front.email_forgot_password',
            compact('user_name', 'link'),
            function ($message) use ($email_to) {
                $message->from('forumfita@gmail.com', 'FORUM-FITA-VNUA'); // Thay 'Your Name' bằng tên bạn muốn hiển thị là người gửi
                $message->to($email_to);
                $message->subject('Welcome');
            }
        );

        return redirect()->back()->with('message', 'Gửi email thành công vui lòng kiểm tra email để lấy lại mật khẩu!');
    }

    public function change_password()
    {
        return view('front.account.change_password');
    }

    public function update_password(Request $request)
    {
        $data = $request->all();
        $token_random = Str::random();
        $user = User::where('email', $data['email'])->first();

        if (!$user) {
            return redirect('account/forgot_password')->with('error', 'Vui lòng nhập lại email vì link đã quá hạn');
        }

        $messages = [
            'email.required' => 'Trường Email là bắt buộc.',
            'email.email' => 'Định dạng Email không hợp lệ.',
            'password.required' => 'Trường Mật khẩu là bắt buộc.',
            'password.min' => 'Mật khẩu phải chứa ít nhất :min ký tự.',
            'password.regex' => 'Mật khẩu phải chứa ít nhất một chữ viết hoa và một số.',
            'password_confirmation.required' => 'Trường Nhập lại mật khẩu là bắt buộc.',
            'password_confirmation.same' => 'Mật khẩu không khớp.',
            // Thêm các thông báo lỗi khác tại đây...
        ];

        $validator = Validator::make($request->all(), [
            'email' => 'required|email',
            'password' => 'required|min:8|regex:/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d).+$/',
            'password_confirmation' => 'required|same:password'
        ], $messages);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        $user->password = bcrypt($data['password']);
        $user->user_token = $token_random;
        $user->save();

        return redirect('account/login')->with('message', 'Đổi mật khẩu thành công');
    }
}
