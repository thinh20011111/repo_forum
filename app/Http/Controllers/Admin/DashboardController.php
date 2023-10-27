<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Like;
use App\Models\Notification_admin;
use App\Models\Post;
use App\Models\Report;
use App\Models\School_year;
use App\Models\Subject;
use App\Models\User;
use App\Services\PostCategories\PostCategoriesServiceInterface;
use App\Services\Posts\PostsServiceInterface;
use App\Services\Report\ReportServiceInterface;
use App\Services\Specialized\SpecializedServiceInterface;
use App\Services\Subject\SubjectServiceInterface;
use App\Services\Type\TypeServiceInterface;
use App\Services\User\UserServiceInterface;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    private $typeService;
    private $specializedService;
    private $subjecService;
    private $categoriesService;
    private $postsService;
    private $notificationsService;
    private $userService;
    private $reportsService;

    public function __construct(
        SpecializedServiceInterface $specializedService,
        SubjectServiceInterface $subjecService,
        TypeServiceInterface $typeService,
        PostCategoriesServiceInterface $categoriesService,
        PostsServiceInterface $postsService,
        UserServiceInterface $userService,
        ReportServiceInterface $reportsService
    ) {
        $this->typeService =  $typeService;
        $this->subjecService = $subjecService;
        $this->specializedService = $specializedService;
        $this->categoriesService = $categoriesService;
        $this->postsService = $postsService;
        $this->userService = $userService;
        $this->reportsService = $reportsService;
    }

    public function index()
    {
        $post_count = Post::count();
        $user_count = User::count();
        $report_posts = Report::where('type', 'post')->count();
        $report_comments = Report::where('type', 'comment')->count();
        $users = User::orderByDesc('id')->paginate(10);

        $top_like = DB::table('users')
            ->join('posts', 'users.id', '=', 'posts.user_id')
            ->join('likes', 'posts.id', '=', 'likes.post_id')
            ->select('users.id', 'users.name', 'users.avatar', DB::raw('count(likes.id) as total_likes'))
            ->groupBy('users.id', 'users.name', 'users.avatar')
            ->orderByDesc('total_likes')
            ->limit(3)
            ->get();

        $top_comment = DB::table('users')
            ->join('posts', 'users.id', '=', 'posts.user_id')
            ->join('comments', 'posts.id', '=', 'comments.post_id')
            ->select('users.id', 'users.name', 'users.avatar', DB::raw('count(comments.id) as total_comment'))
            ->groupBy('users.id', 'users.name', 'users.avatar')
            ->orderByDesc('total_comment')
            ->limit(3)
            ->get();

        $top_post = DB::table('users')
            ->join('posts', 'users.id', '=', 'posts.user_id')
            ->select('users.id', 'users.name', 'users.avatar', DB::raw('count(posts.id) as total_posts'))
            ->groupBy('users.id', 'users.name', 'users.avatar')
            ->orderByDesc('total_posts')
            ->limit(3)
            ->get();

        $noti_small = Notification_admin::orderBy('created_at', 'desc')
            ->limit(5)
            ->get();
        $notification_count = Notification_admin::where('status', 'new')->count();
        return view('admin.index', compact('post_count', 'noti_small', 'notification_count', 'user_count', 'report_comments', 'report_posts', 'users', 'top_like', 'top_comment', 'top_post'));
    }

    public function manage_posts(Request $request)
    {
        $post_count = Post::all()->count();
        $posts = $this->postsService->getPostsOnIndex($request);
        $types = $this->typeService->all();
        $subjects = $this->subjecService->all();
        $specialized = $this->specializedService->all();
        $categories = $this->categoriesService->all();

        if (empty($posts)) {
            session()->flash('error', 'Không tìm thấy bài post nào.');
        }

        $noti_small = Notification_admin::orderBy('created_at', 'desc')
            ->limit(5)
            ->get();
        $notification_count = Notification_admin::where('status', 'new')->count();

        return view('admin.manage_posts', compact('noti_small', 'notification_count', 'posts', 'specialized', 'categories', 'subjects', 'types', 'post_count'));
    }

    public function manage_users(Request $request)
    {
        $user_count = User::count();
        $users = User::orderByDesc('id')->paginate(10);

        $noti_small = Notification_admin::orderBy('created_at', 'desc')
            ->limit(5)
            ->get();
        $notification_count = Notification_admin::where('status', 'new')->count();
        return view('admin.manage_users', compact('noti_small', 'notification_count', 'users', 'user_count'));
    }

    public function manage_report_posts(Request $request)
    {
        $report_count = Report::where('type', 'post')->count();
        $reports = $this->reportsService->getPostsOnIndex($request);

        if (empty($posts)) {
            session()->flash('error', 'Không tìm thấy report nào.');
        }
        $noti_small = Notification_admin::orderBy('created_at', 'desc')
            ->limit(5)
            ->get();
        $notification_count = Notification_admin::where('status', 'new')->count();

        return view('admin.manage_report_posts', compact('noti_small', 'notification_count', 'reports', 'report_count'));
    }

    public function manage_report_comments(Request $request)
    {
        $report_count = Report::where('type', 'comment')->count();
        $reports = $this->reportsService->getCommentsOnIndex($request);

        if (empty($posts)) {
            session()->flash('error', 'Không tìm thấy report nào.');
        }
        $noti_small = Notification_admin::orderBy('created_at', 'desc')
            ->limit(5)
            ->get();
        $notification_count = Notification_admin::where('status', 'new')->count();
        return view('admin.manage_report_comments', compact('noti_small', 'notification_count', 'reports', 'report_count'));
    }

    public function manage_event(Request $request)
    {

        $noti_small = Notification_admin::orderBy('created_at', 'desc')
            ->limit(5)
            ->get();
        $notification_count = Notification_admin::where('status', 'new')->count();

        $posts = Post::where('event_post', '1')->orderBy('created_at', 'desc')->paginate(10);
        $types = $this->typeService->all();
        $subjects = $this->subjecService->all();
        $specialized = $this->specializedService->all();
        $categories = $this->categoriesService->all();

        if (empty($posts)) {
            session()->flash('error', 'Không tìm thấy bài post nào.');
        }

        return view('admin.manage_event', compact('noti_small', 'notification_count', 'posts', 'types', 'subjects', 'specialized', 'categories'));
    }

    public function notification()
    {
        $noti_small = Notification_admin::orderBy('created_at', 'desc')
            ->limit(5)
            ->get();

        $notification_count = Notification_admin::where('status', 'new')->count();
        $notifications = Notification_admin::orderByDesc('id')->paginate(25);
        return view('admin.notification', compact('noti_small', 'notification_count', 'notifications'));
    }

    public function school_years()
    {
        $noti_small = Notification_admin::orderBy('created_at', 'desc')
            ->limit(5)
            ->get();

        $notification_count = Notification_admin::where('status', 'new')->count();
        $total_school_years = School_year::all()->count();
        $school_years = School_year::orderByDesc('id')->paginate(10);
        return view('admin.school_years', compact('noti_small', 'notification_count', 'school_years', 'total_school_years'));
    }


    public function login()
    {
        return view('admin.login');
    }

    public function checkAdminLogin(Request $request)
    {
        $credentials = [
            'email' => $request->email,
            'password' => $request->password,
            'level' => 0
        ];

        $remember = $request->remember;


        if (Auth::attempt($credentials, $remember)) {
            // return redirect(''); //Trang chủ
            // return redirect(''); //Trang chủ
            $user = User::find(Auth::user()->id);
            $user->status = '1';

            $user->save();
            return redirect()->intended('admin');
        } else {
            return back()->with('notification', 'Sai thông tin đăng nhập');
        }
    }

    public function manage_subject(Request $request)
    {
        $noti_small = Notification_admin::orderBy('created_at', 'desc')
            ->limit(5)
            ->get();

        $notification_count = Notification_admin::where('status', 'new')->count();

        $subjects = Subject::orderByDesc('id')->paginate(10);
        $total = Subject::count();
        return view('admin.manage_subject', compact('total','subjects','noti_small', 'notification_count'));
    }

    public function logout()
    {
        $user = User::find(Auth::user()->id);
        $user->status = '0';

        $user->save();

        Auth::logout();
        return redirect('admin/login');
    }

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
}
