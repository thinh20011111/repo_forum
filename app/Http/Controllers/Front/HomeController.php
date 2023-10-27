<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Models\Like;
use App\Models\Message;
use App\Models\Notification;
use Illuminate\Http\Request;
use App\Models\Post;
use App\Models\PostCategories;
use App\Models\Story;
use App\Models\Subject;
use App\Models\User;
use App\Services\Notification\NotificationServiceInterface;
use App\Services\PostCategories\PostCategoriesServiceInterface;
use App\Services\Posts\PostsServiceInterface;
use App\Services\School_year\School_yearServiceInterface;
use App\Services\Specialized\SpecializedServiceInterface;
use App\Services\Subject\SubjectServiceInterface;
use App\Services\Type\TypeServiceInterface;
use App\Services\User\UserServiceInterface;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class HomeController extends Controller
{
    private $school_yearService;
    private $typeService;
    private $specializedService;
    private $subjecService;
    private $categoriesService;
    private $postsService;
    private $notificationsService;
    private $userService;

    public function __construct(
        SpecializedServiceInterface $specializedService,
        SubjectServiceInterface $subjecService,
        TypeServiceInterface $typeService,
        PostCategoriesServiceInterface $categoriesService,
        PostsServiceInterface $postsService,
        NotificationServiceInterface $notificationsService,
        UserServiceInterface $userService,
        School_yearServiceInterface $school_yearService
    ) {
        $this->typeService =  $typeService;
        $this->subjecService = $subjecService;
        $this->specializedService = $specializedService;
        $this->categoriesService = $categoriesService;
        $this->postsService = $postsService;
        $this->notificationsService = $notificationsService;
        $this->userService = $userService;
        $this->school_yearService = $school_yearService;
    }

    public function index()
    {
        $posts = Post::where('daily_post', 0)->where('story_post', 0)->orderBy('id', 'DESC')->get();
        // Lấy thông tin người dùng đang đăng nhập
        $userId = auth()->id();

        // Lấy danh sách các thông báo của người dùng đó
        $notifications = Notification::getNotificationsForCurrentUser();
        $notificationsCount = $notifications->where('status', 'new')->count();
        $specializeds = $this->specializedService->all();
        $subjects = Subject::has('posts')
            ->with(['posts' => function ($query) {
                $query->latest(); // Remove the take(5) method
            }])
            ->take(10)
            ->get();
        $school_years = $this->school_yearService->all();
        $categories = $this->categoriesService->all();
        $daily_posts = Post::where('daily_post', 1)->orderBy('id', 'DESC')->get();

        $stories = Post::select('posts.*', 'users.name')
            ->join('users', 'posts.user_id', '=', 'users.id')
            ->whereIn('posts.id', function ($query) {
                $query->select(DB::raw('MAX(id)'))
                    ->from('posts')
                    ->where('story_post', '=', 1)
                    ->groupBy('user_id');
            })->orderBy('created_at', 'desc')
            ->get();
        $likes = Like::all();
        $users = User::all();
        $online = User::where('status', 1)->count();
        $total_posts = Post::all()->count();

        $all_story = $posts = Post::where('story_post', 1)->orderBy('id', 'DESC')->get();

        $events = Post::where('event_post', '1')->latest()->limit(3)->get();

        return view('front.index', compact('posts', 'notifications', 'notificationsCount', 'total_posts', 'subjects', 'specializeds', 'categories', 'school_years', 'daily_posts', 'likes', 'stories', 'all_story', 'users', 'online', 'events'));
    }

    public function what_news()
    {
        $notifications = Notification::getNotificationsForCurrentUser();
        $notificationsCount = $notifications->where('status', 'new')->count();

        $posts = Post::where('daily_post', '<>', 1)->orderBy('id', 'DESC')->take(15)->get();
        $daily_posts = Post::where('daily_post', 1)->orderBy('id', 'DESC')->get();
        $users = User::all();
        $online = User::where('status', 1)->count();
        $total_posts = Post::all()->count();
        $events = Post::where('event_post', '1')->latest()->limit(3)->get();

        $top_post_ids = Like::select('post_id', DB::raw('COUNT(id) as like_count'))
            ->groupBy('post_id')
            ->orderBy('like_count', 'desc')
            ->take(5)
            ->pluck('post_id');

        $top_post_favorite = Post::whereIn('id', $top_post_ids)
            ->orderBy(DB::raw('FIELD(id, ' . $top_post_ids->implode(',') . ')'))
            ->get();

        return view('front.what_news.what_news', compact('top_post_favorite', 'events', 'posts', 'notifications', 'total_posts', 'users', 'online', 'notificationsCount', 'daily_posts'));
    }

    public function new_posts(Request $request)
    {
        $posts = $this->postsService->getPostsOnIndex($request);
        $types = $this->typeService->all();
        $subjects = $this->subjecService->all();
        $specialized = $this->specializedService->all();
        $categories = $this->categoriesService->all();
        $notifications = Notification::getNotificationsForCurrentUser();
        $notificationsCount = $notifications->where('status', 'new')->count();

        if (empty($posts)) {
            session()->flash('error', 'Không tìm thấy bài post nào.');
        }

        return view('front.what_news.new_posts', compact('posts', 'specialized', 'categories', 'subjects', 'types', 'notifications', 'notificationsCount'));
    }


    public function new_images()
    {
        $users = User::all();
        $online = User::where('status', 1)->count();
        $total_posts = Post::all()->count();

        $notifications = Notification::getNotificationsForCurrentUser();
        $notificationsCount = $notifications->where('status', 'new')->count();
        $events = Post::where('event_post', '1')->latest()->limit(3)->get();

        $posts = Post::where('story_post', 1)->orderBy('id', 'DESC')->paginate(15);
        return view('front.what_news.images', compact('events', 'posts', 'users', 'online', 'notifications', 'notificationsCount', 'total_posts'));
    }

    public function new_documents(Request $request)
    {
        $users = User::all();
        $online = User::where('status', 1)->count();
        $total_posts = Post::all()->count();

        $types = $this->typeService->all();
        $subjects = $this->subjecService->all();
        $specialized = $this->specializedService->all();
        $categories = $this->categoriesService->all();
        $notifications = Notification::getNotificationsForCurrentUser();
        $notificationsCount = $notifications->where('status', 'new')->count();

        // $posts = Post::whereNotNull('file_path')->orderBy('id', 'DESC')->paginate(15);
        $posts = $this->postsService->getDocumentsOnIndex($request);

        if (empty($posts)) {
            session()->flash('error', 'Không tìm thấy bài post nào.');
        }
        return view('front.what_news.new_documents', compact('posts', 'users', 'online', 'total_posts', 'notifications', 'notificationsCount', 'types', 'subjects', 'specialized', 'categories'));
    }

    public function new_status(Request $request)
    {
        try {
            $total_posts = Post::all()->count();
            $users = User::all();
            $online = User::where('status', 1)->count();
            $posts = Post::where('daily_post', 1)->orderBy('id', 'DESC')->paginate(20);
            $notifications = Notification::getNotificationsForCurrentUser();
            $notificationsCount = $notifications->where('status', 'new')->count();
            $events = Post::where('event_post', '1')->latest()->limit(3)->get();
        } catch (\Exception $e) {
            session()->flash('error', $e->getMessage());
            return redirect()->back();
        }

        return view('front.what_news.new_status', compact('events', 'total_posts', 'posts', 'users', 'online', 'notifications', 'notificationsCount'));
    }

    public function stories_post()
    {
        $notifications = Notification::getNotificationsForCurrentUser();
        $notificationsCount = $notifications->where('status', 'new')->count();

        $stories_post = Post::where('story_post', 1)->orderBy('id', 'DESC')->get();
        $users = User::all();
        $online = User::where('status', 1)->count();
        $total_posts = Post::all()->count();
        $events = Post::where('event_post', '1')->latest()->limit(3)->get();

        return view('front.stories_post.index', compact('events', 'stories_post', 'users', 'online', 'total_posts', 'notifications', 'notificationsCount'));
    }

    public function list_member(Request $request)
    {
        try {
            $notifications = Notification::getNotificationsForCurrentUser();
            $notificationsCount = $notifications->where('status', 'new')->count();

            $list_member = $this->userService->getUserOnIndex($request);
        } catch (\Exception $e) {
            session()->flash('error', $e->getMessage());
            return redirect()->back();
        }

        $users = User::all();
        $online = User::where('status', 1)->count();
        $total_posts = Post::all()->count();
        $events = Post::where('event_post', '1')->latest()->limit(3)->get();

        return view('front.list_member', compact('events', 'notifications', 'total_posts', 'notificationsCount', 'users', 'list_member', 'online'));
    }

    public function top_member()
    {
        $notifications = Notification::getNotificationsForCurrentUser();
        $notificationsCount = $notifications->where('status', 'new')->count();
        $users = User::all();
        $online = User::where('status', 1)->get();
        $total_posts = Post::all()->count();

        $top_like = DB::table('users')
            ->join('posts', 'users.id', '=', 'posts.user_id')
            ->join('likes', 'posts.id', '=', 'likes.post_id')
            ->select('users.id', 'users.name', 'users.avatar', 'users.level', DB::raw('count(likes.id) as total_likes'))
            ->groupBy('users.id', 'users.name', 'users.avatar', 'users.level')
            ->orderByDesc('total_likes')
            ->limit(5)
            ->get();

        $top_post = DB::table('users')
            ->join('posts', 'users.id', '=', 'posts.user_id')
            ->select('users.id', 'users.name', 'users.avatar', 'users.level', DB::raw('count(posts.id) as total_posts'))
            ->groupBy('users.id', 'users.name', 'users.avatar', 'users.level')
            ->orderByDesc('total_posts')
            ->limit(5)
            ->get();

        $admin = User::where('level', 0)->take(5)->get();

        $currentDate = Carbon::today();
        $birthday = User::whereMonth('birthday', $currentDate->month)
            ->whereDay('birthday', $currentDate->day)
            ->take(5)
            ->get();
        $events = Post::where('event_post', '1')->latest()->limit(3)->get();

        return view('front.members.top_member', compact('events', 'currentDate', 'birthday', 'admin', 'top_post', 'top_like', 'users', 'notifications', 'notificationsCount', 'online', 'total_posts'));
    }

    public function top_like()
    {
        $notifications = Notification::getNotificationsForCurrentUser();
        $notificationsCount = $notifications->where('status', 'new')->count();
        $users = User::all();
        $online = User::where('status', 1)->get();
        $total_posts = Post::all()->count();

        $top_like = DB::table('users')
            ->join('posts', 'users.id', '=', 'posts.user_id')
            ->join('likes', 'posts.id', '=', 'likes.post_id')
            ->select('users.id', 'users.name', 'users.avatar', 'users.level', DB::raw('count(likes.id) as total_likes'))
            ->groupBy('users.id', 'users.name', 'users.avatar', 'users.level')
            ->orderByDesc('total_likes')
            ->paginate(15);
        $events = Post::where('event_post', '1')->latest()->limit(3)->get();

        return view('front.members.list_top_likes', compact('events', 'top_like', 'users', 'notifications', 'notificationsCount', 'online', 'total_posts'));
    }

    public function top_post()
    {
        $notifications = Notification::getNotificationsForCurrentUser();
        $notificationsCount = $notifications->where('status', 'new')->count();
        $users = User::all();
        $online = User::where('status', 1)->get();
        $total_posts = Post::all()->count();
        $events = Post::where('event_post', '1')->latest()->limit(3)->get();

        $top_post = DB::table('users')
            ->join('posts', 'users.id', '=', 'posts.user_id')
            ->select('users.id', 'users.name', 'users.avatar', 'users.level', DB::raw('count(posts.id) as total_posts'))
            ->groupBy('users.id', 'users.name', 'users.avatar', 'users.level')
            ->orderByDesc('total_posts')
            ->paginate(15);

        return view('front.members.list_top_posts', compact('events', 'top_post', 'users', 'notifications', 'notificationsCount', 'online', 'total_posts'));
    }

    public function list_admin()
    {
        $notifications = Notification::getNotificationsForCurrentUser();
        $notificationsCount = $notifications->where('status', 'new')->count();
        $users = User::all();
        $online = User::where('status', 1)->get();
        $total_posts = Post::all()->count();
        $admin = User::where('level', 0)->paginate(15);
        $events = Post::where('event_post', '1')->latest()->limit(3)->get();

        return view('front.members.list_admin', compact('events', 'admin', 'users', 'notifications', 'notificationsCount', 'online', 'total_posts'));
    }

    public function birthday_today()
    {
        $notifications = Notification::getNotificationsForCurrentUser();
        $notificationsCount = $notifications->where('status', 'new')->count();
        $users = User::all();
        $online = User::where('status', 1)->get();
        $total_posts = Post::all()->count();

        $currentDate = Carbon::today();
        $birthday = User::whereMonth('birthday', $currentDate->month)
            ->whereDay('birthday', $currentDate->day)
            ->paginate(15);
        $events = Post::where('event_post', '1')->latest()->limit(3)->get();

        return view('front.members.list_top_birthday', compact('events', 'currentDate', 'birthday', 'users', 'notifications', 'notificationsCount', 'online', 'total_posts'));
    }

    public function online_member()
    {
        $notifications = Notification::getNotificationsForCurrentUser();
        $notificationsCount = $notifications->where('status', 'new')->count();
        $users = User::all();
        if (Auth::check()) {
            $online = User::where('status', 1)->where('id', '<>', Auth::user()->id)->paginate(15);
        } else {
            $online = User::where('status', 1)->paginate(15);
        }
        $total_posts = Post::all()->count();
        $events = Post::where('event_post', '1')->latest()->limit(3)->get();

        return view('front.members.online_member', compact('events', 'users', 'notifications', 'notificationsCount', 'online', 'total_posts'));
    }

    public function notifications()
    {
        $notifications = Notification::getNotificationsForCurrentUser();
        $notificationsCount = $notifications->where('status', 'new')->count();

        $users = User::all();
        $online = User::where('status', 1)->count();
        $total_posts = Post::all()->count();

        return view('front.notification', compact('notifications', 'users', 'online', 'total_posts', 'notificationsCount'));
    }

    public function list_follow(Request $request)
    {
        $search = $request->input('search_member');
        $users = User::all();

        $list_follows = Auth::user()->isFollowing()
            ->where(function ($query) use ($search) {
                $query->where('name', 'like', '%' . $search . '%')
                    ->orWhere('email', 'like', '%' . $search . '%');
            })
            ->get();

        $notifications = Notification::getNotificationsForCurrentUser();
        $notificationsCount = $notifications->where('status', 'new')->count();

        $online = User::where('status', 1)->count();
        $total_posts = Post::all()->count();

        $events = Post::where('event_post', '1')->latest()->limit(3)->get();

        // Check the number of users before returning the results

        return view('front.list_follows', compact('users', 'events', 'list_follows', 'notifications', 'online', 'total_posts', 'notificationsCount'));
    }

    public function read_all_notification()
    {
        $notifications = Notification::getNotificationsForCurrentUser();

        foreach ($notifications as $notification) {
            $notification->status = 'read';
            $notification->save();
        }

        return response()->json(['success' => true]);
    }
}
