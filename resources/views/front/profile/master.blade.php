<!DOCTYPE html>
<html lang="en">

<head>
    <base href="{{asset('/')}}">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="" />
    <meta name="keywords" content="" />
    <title>@yield('title')</title>
    <link rel="icon" href="front/img/logo_fita.png" type="image/png" sizes="16x16">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="stylesheet" href="front/css/main.min.css" type="text/css">
    <link rel="stylesheet" href="front/css/style.css" type="text/css">
    <link rel="stylesheet" href="front/css/color.css" type="text/css">
    <link rel="stylesheet" href="front/css/responsive.css" type="text/css">
    <link rel="stylesheet" href="front/css/bootstrap.min.css" type="text/css">

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/slick-carousel/1.8.1/slick.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/slick-carousel/1.8.1/slick-theme.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.3/jquery.min.js"></script>

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.3.0/css/all.min.css" integrity="sha512-SzlrxWUlpfuzQ+pcUCosxcglQRNAq/DZjVsC0lE40xsADsfeQoEypE+enwcOiGjk/bSuGGKHEyjSoQ1zVisanQ==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <script src="https://kit.fontawesome.com/47f1aaf7ca.js" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.tiny.cloud/1/1dvwoen7mpwcn3jcbkd98qo9kas9hy7rlkt8ul00jera0bge/tinymce/6/tinymce.min.js" referrerpolicy="origin"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/css/select2.min.css" rel="stylesheet" />
</head>

<body>
    <div class="theme-layout">
        <div class="responsive-header">
            <div class="mh-head first Sticky">
                <span class="mh-btns-left">
                    <a class="" href="#menu"><i class="fa fa-align-justify"></i></a>
                </span>
                <span class="mh-text">
                    <a href="./" title="logo"><img src="front/img/logo_fita.png" alt="" style="max-width: 50px;"></a>
                </span>
            </div>
            <div class="mh-head second">
                <form class="mh-form">
                    <input placeholder="search" />
                    <a href="#/" class="fa fa-search"></a>
                </form>
            </div>
            <nav id="menu" class="res-menu">
                <ul>
                    <li>
                        <a href="./create_post">Đăng bài</a>
                    </li>
                    <li>
                        <a href="./what_news">Có gì mới?</a>
                    </li>
                    <li>
                        <a href="./stories_post" title="">Story</a>
                    </li>
                    <li><span><a href="/list_member">Thành viên</a></span>
                        <ul>
                            <li><a href="./" title="">Đang truy cập</a></li>
                            <li><a href="./" title="">Bảng xếp hạng</a></li>
                        </ul>
                    </li>

                    @if(Auth::check())
                    <li>
                        <a href="./user-profile-post-{{ Auth::user()->id }}">Trang cá nhân</a>
                    </li>
                    <li>
                        <a href="">Đang theo dõi</a>
                    </li>
                    <li>
                        <a href="./user-profile-image-{{ Auth::user()->id }}">Hình ảnh</a>
                    </li>
                    <li>
                        <a href="/messages">Tin nhắn</a>
                    </li>
                    <li>
                        <a href="./notifications">Thông báo</a>
                    </li>
                    @endif

                    @if(!Auth::check())
                    <li>
                        <a href="./account/login" title="">Đăng nhập</a>
                    </li>
                    <li>
                        <a href="./account/register" title="">Đăng ký</a>
                    </li>
                    @else
                    <li class="extend-nav-menu">
                        <a href="./account/logout"></i>Đăng xuất</a>
                    </li>
                    @endif
                </ul>
            </nav>
        </div><!-- responsive header -->

        <div class="topbar sticky-top">
            <div class="logo">
                <a title="Trang chủ" href="./"><img src="front/img/logo_fita.png" class="shadow rounded-circle" alt="" width="48px"></a>
            </div>

            <div class="top-area">
                <ul class="main-menu">
                    <li>
                        <a href="./create_post" title="">Đăng bài</a>
                    </li>
                    <li>
                        <a href="./what_news" title="">Có gì mới?</a>
                    </li>
                    <li>
                        <a href="./stories_post" title="">Story</a>
                    </li>
                    <li class="dropdown-area">
                        <a href="./" title="">Thành viên</a>
                        <ul>
                            <li><a href="./" title="">Đang truy cập</a></li>
                            <li><a href="./" title="">Tìm kiếm status cá nhân</a></li>
                        </ul>
                    </li>
                </ul>

                @if(Auth::check())
                <ul class="setting-area">
                    <li>
                        <div class="dropdown">
                            <div href="#" title="Notification" id="notificationDropdown" data-bs-toggle="dropdown" aria-expanded="false">
                                <i class="ti-bell"></i>
                                @if($notificationsCount > 0)
                                <span class="notification-count badge bg-danger text-white">{{ $notificationsCount > 99 ? '99+' : $notificationsCount }}</span>
                                @else
                                <span class="notification-count badge bg-danger text-white"></span>
                                @endif
                            </div>
                            <ul class="drops-menu dropdown-menu notifications p-0" id="notification-list" aria-labelledby="notificationDropdown">
                                <li class="bg-white d-flex">
                                    <a href="#thongbao" title="" class="more-mesg text-right"><small>Xem tất cả</small></a>
                                </li>
                                @if($notifications->count() > 0)
                                @foreach($notifications as $notification)
                                @if($notification->type === 'like' || $notification->type === 'comment' || $notification->type === 'create')
                                <li data-notification-id="{{ $notification->id }}" class="{{ $notification->status == 'new' ? 'bg-light' : '' }}">
                                    <a href="./new_posts/post_{{ $notification->post_id }}?notification_id={{ $notification->id }}">
                                        <img src="front/img/users/{{ $notification->user->avatar ?? 'default_user.png' }}" alt="" style="width: 50px;height: 50px;object-fit: cover;">
                                        <div class="mesg-meta">
                                            <h6>{{ $notification->user->name }}</h6>
                                            <span>{{ $notification->content}}</span>
                                            <i>{{ formatTime($notification->created_at) }}</i>
                                        </div>
                                    </a>
                                    @if($notification->status == 'new')
                                    <span class="tag green">New</span>
                                    @endif
                                </li>
                                @elseif($notification->type === 'message')
                                <li data-notification-id="{{ $notification->id }}" class="{{ $notification->status == 'new' ? 'bg-light' : '' }}">
                                    <a href="./messages_{{ $notification->user_id }}?notification_id={{ $notification->id }}">
                                        <img src="front/img/users/{{ $notification->user->avatar ?? 'default_user.png' }}" alt="" style="width: 50px;height: 50px;object-fit: cover;">
                                        <div class="mesg-meta">
                                            <h6>{{ $notification->user->name }}</h6>
                                            <span>{{ $notification->content}}</span>
                                            <i>{{ formatTime($notification->created_at) }}</i>
                                        </div>
                                    </a>
                                    @if($notification->status == 'new')
                                    <span class="tag green">New</span>
                                    @endif
                                </li>
                                @elseif($notification->type === 'follow')
                                <li data-notification-id="{{ $notification->id }}" class="{{ $notification->status == 'new' ? 'bg-light' : '' }}">
                                    <a href="./user-profile-post-{{ $notification->user_id }}?notification_id={{ $notification->id }}">
                                        <img src="front/img/users/{{ $notification->user->avatar ?? 'default_user.png' }}" alt="" style="width: 50px;height: 50px;object-fit: cover;">
                                        <div class="mesg-meta">
                                            <h6>{{ $notification->user->name }}</h6>
                                            <span>{{ $notification->content}}</span>
                                            <i>{{ formatTime($notification->created_at) }}</i>
                                        </div>
                                    </a>
                                    @if($notification->status == 'new')
                                    <span class="tag green">New</span>
                                    @endif
                                </li>
                                @endif
                                @endforeach
                                @else
                                <div class="p-2 text-center">Không có thông báo nào.</div>
                                @endif
                            </ul>
                        </div>
                    </li>
                </ul>
                <div class="user-img">
                    <img src="front/img/users/{{ Auth::user()->avatar }}" alt="" id="menu_avatar">
                    <span class="status f-online"></span>
                    <div class="user-setting">
                        <a href="#" class="disabled d-flex justify-content-center" aria-disabled="true">
                            <div class="badge badge-success text-center">Sinh viên</div>
                        </a>
                        <a href="./user-profile-post-{{ Auth::user()->id }}" title=""><i class="ti-user"></i>Trang cá nhân</a>
                        <a href="./user-profile-edit-{{ Auth::user()->id }}" title=""><i class="ti-pencil-alt"></i>Chỉnh sửa trang cá nhân</a>
                        <a href="./account/logout" title=""><i class="ti-power-off"></i>Đăng xuất</a>
                    </div>
                </div>
                @endif
            </div>
        </div><!-- topbar -->

        <section>
            <div class="feature-photo">
                <figure>
                    <img src="front/img/users/{{ $user->background ?? 'background_landscape.jpg' }}" alt="" id="img_background" name="img_background" />
                </figure>
                <div class="add-btn">
                    <span>{{ number_format($user->followers->count()) }} followers</span>
                    @if(Auth::check())
                    @if(Auth::user()->id != $user->id)
                    <a href="#" title="" class="btn-follow" data-user-id="{{ $user->id }}">
                        @php
                        $isFollowing = $user->followers->contains(Auth::user()->id);
                        @endphp
                        @if ($isFollowing)
                        Hủy theo dõi
                        @else
                        Theo dõi
                        @endif
                    </a>
                    @else
                    <a href="#" title="" data-ripple="" id="updateCoverPhotoBtn">Cập nhật ảnh</a>
                    @endif
                    @endif
                </div>

                @if(Auth::check())
                @if(Auth::user()->id == $user->id)
                <form class="edit-phto">
                    <i class="fa fa-camera-retro"></i>
                    <label class="fileContainer">
                        Edit Cover Photo
                        <input type="file" id="coverPhotoInput" />
                    </label>
                </form>
                @endif
                @endif

                <div class="container-fluid">
                    <div class="row merged">
                        <div class="col-lg-2 col-sm-3">
                            <div class="user-avatar">
                                <figure>
                                    <img src="front/img/users/{{ $user->avatar ?? 'default_user.png' }}" alt="" id="img_avatar" name="img_avatar" />
                                    @if(Auth::check())
                                    @if(Auth::user()->id == $user->id)
                                    <form class="edit-phto">
                                        <i class="fa fa-camera-retro"></i>
                                        <label class="fileContainer">
                                            Edit Display Photo
                                            <input type="file" id="displayPhotoInput" />
                                        </label>
                                    </form>
                                    @endif
                                    @endif
                                </figure>
                            </div>
                        </div>
                        <div class="col-lg-10 col-sm-9">
                            <div class="timeline-info">
                                <ul>
                                    <li class="admin-name">
                                        <h5>{{ $user->name }}</h5>
                                        <span>
                                            <div class="badge badge-success text-center">Sinh viên</div>
                                        </span>
                                    </li>
                                    <li>
                                        <a class="{{ (request()->segment(1) == 'user-profile-post-'. $user->id) ? 'active' : '' }}" href="./user-profile-post-{{ $user->id }}" title="" data-ripple="">Bài viết</a>
                                        <a class="{{ (request()->segment(1) == 'user-profile-stories-'. $user->id) ? 'active' : '' }}" href="./user-profile-stories-{{ $user->id }}" title="" data-ripple="">Story</a>
                                        <a class="{{ (request()->segment(1) == 'user-profile-image-'. $user->id) ? 'active' : '' }}" href="./user-profile-image-{{ $user->id }}" title="" data-ripple="">Hình ảnh</a>
                                        @if(Auth::check())
                                        @if($user->id == Auth::user()->id)
                                        <a class="{{ (request()->segment(1) == 'user-profile-edit-'. $user->id) ? 'active' : '' }}" href="./user-profile-edit-{{ $user->id }}" title="" data-ripple="">Chỉnh sửa trang cá nhân</a>
                                        @endif
                                        @endif
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <section>
            <div class="gap gray-bg">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="row" id="page-contents">
                                <div class="col-lg-3">
                                    <aside class="sidebar static">
                                        @if(Auth::check())
                                        <div id="nav-moblie" class="widget">
                                            <div class="d-flex bd-highlight">
                                                <div class="mr-auto p-2 bd-highlight">
                                                    <form action="">
                                                        <div class="attachments">
                                                            <button type="submit"><a href="./create_post">Đăng bài</a></button>
                                                        </div>
                                                    </form>
                                                </div>
                                                <div class="p-2 bd-highlight">
                                                    <div class="d-flex align-items-center h-100">
                                                        <a href="#thôngbáo" title="Notification">
                                                            <i class="ti-bell"></i>
                                                            @if($notificationsCount > 0)
                                                            <span class="notification-count badge bg-danger text-white">{{ $notificationsCount > 99 ? '99+' : $notificationsCount }}</span>
                                                            @endif
                                                        </a>
                                                    </div>
                                                </div>
                                                <div class="p-2 bd-highlight">
                                                    <div class="btn-group dropleft d-flex align-items-center h-100">
                                                        <img src="front/img/users/{{ Auth::user()->avatar ?? 'default_user.png' }}" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" class="rounded-circle" alt="" style="width: 30px;height: 30px;object-fit: cover;">

                                                        <div class="dropdown-menu user-mobile">
                                                            <a href="#" title=""><i class="ti-user"></i> Trang cá nhân</a>
                                                            <a href="#" title=""><i class="ti-pencil-alt"></i> Chỉnh sửa trang cá nhân</a>
                                                            @if(Auth::check())
                                                            <a href="./account/logout" title=""><i class="ti-power-off"></i> Đăng xuất</a>
                                                            @endif
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        @endif
                                        <div id="shortcuts" class="widget">
                                            <h4 class="widget-title">Phím tắt</h4>
                                            <ul class="naves">
                                                @if(Auth::check())
                                                <li class="d-flex justify-content-start align-items-center">
                                                    <i class="ti-clipboard"></i>
                                                    <a href="./" title="">Trang chủ</a>
                                                </li>
                                                <li class="d-flex justify-content-start align-items-center">
                                                    <i class="ti-files"></i>
                                                    <a href="fav-page.html" title="">Trang cá nhân</a>
                                                </li>
                                                <li class="d-flex justify-content-start align-items-center">
                                                    <i class="ti-user"></i>
                                                    <a href="timeline-friends.html" title="">Đang theo dõi</a>
                                                </li>
                                                <li class="d-flex justify-content-start align-items-center">
                                                    <i class="ti-image"></i>
                                                    <a href="timeline-photos.html" title="">Hình ảnh</a>
                                                </li>
                                                <li class="d-flex justify-content-start align-items-center">
                                                    <i class="ti-comments-smiley"></i>
                                                    <a href="messages.html" title="">Tin nhắn</a>
                                                </li>
                                                <li class="d-flex justify-content-start align-items-center">
                                                    <i class="ti-bell"></i>
                                                    <a href="notifications.html" title="">Thông báo</a>
                                                </li>
                                                <li class="d-flex justify-content-start align-items-center">
                                                    <i class="ti-power-off"></i>
                                                    <a href="./account/logout" title="">Logout</a>
                                                </li>
                                                @else
                                                <li class="d-flex justify-content-start align-items-center">
                                                    <i class="fa-solid fa-right-to-bracket"></i>
                                                    <a href="./account/login" title="">Đăng nhập</a>
                                                </li>
                                                <li class="d-flex justify-content-start align-items-center">
                                                    <i class="fa-solid fa-user-plus"></i>
                                                    <a href="./account/register" title="">Đăng ký</a>
                                                </li>
                                                @endif
                                            </ul>
                                        </div>

                                        @if(Auth::check())
                                        <div id="your-page" class="widget">
                                            <h4 class="widget-title">Trang của bạn</h4>
                                            <div class="your-page">
                                                <figure>
                                                    <a href="./user-profile-post-{{ Auth::user()->id }}" title=""><img src="front/img/users/{{ Auth::user()->avatar ?? 'default_user.png' }}" alt="" style="width: 50px;height: 50px;object-fit: cover;"></a>
                                                </figure>
                                                <div class="page-meta">
                                                    <a href="./user-profile-post-{{ Auth::user()->id }}" title="" class="underline">{{ Auth::user()->name }}</a>
                                                </div>
                                                <div class="page-likes">
                                                    <ul class="nav nav-tabs likes-btn">
                                                        <li class="nav-item"><a class="active" href="#link1" data-toggle="tab">Thích</a></li>
                                                        <li class="nav-item"><a class="" href="#link2" data-toggle="tab">Theo dõi</a></li>
                                                    </ul>
                                                    <!-- Tab panes -->
                                                    <div class="tab-content">
                                                        <div class="tab-pane active fade show" id="link1">
                                                            @php
                                                            $total_like_week = DB::table('users')
                                                            ->join('posts', 'users.id', '=', 'posts.user_id')
                                                            ->join('likes', 'posts.id', '=', 'likes.post_id')
                                                            ->select('users.id', 'users.name', 'users.avatar', DB::raw('count(likes.id) as total_likes'))
                                                            ->where('likes.created_at', '>=', now()->startOfWeek()) // Lấy ra like trong tuần này
                                                            ->groupBy('users.id', 'users.name', 'users.avatar')
                                                            ->orderByDesc('total_likes')
                                                            ->get();

                                                            $user_total_like = DB::table('users')
                                                            ->join('posts', 'users.id', '=', 'posts.user_id')
                                                            ->join('likes', 'posts.id', '=', 'likes.post_id')
                                                            ->select('users.id', 'users.name', 'users.avatar', DB::raw('count(likes.id) as total_likes'))
                                                            ->groupBy('users.id', 'users.name', 'users.avatar')
                                                            ->orderByDesc('total_likes')
                                                            ->get();

                                                            foreach($total_like_week as $user)
                                                            {
                                                            if($user->id == Auth::user()->id)
                                                            {
                                                            $count_like_week = $user->total_likes;
                                                            }
                                                            }

                                                            foreach($user_total_like as $user)
                                                            {
                                                            if($user->id == Auth::user()->id)
                                                            {
                                                            $count = $user->total_likes;
                                                            }
                                                            }
                                                            @endphp

                                                            <span><i class="ti-heart"></i>{{ format_number($count ?? '0') }}</span>
                                                            <a onclick="return false;" title="weekly-likes">{{ format_number($count_like_week ?? '0')  }} lượt thích mới trong tuần này</a>
                                                            <div class="users-thumb-list">

                                                            </div>
                                                        </div>
                                                        <div class="tab-pane fade" id="link2">
                                                            @php
                                                            $weeklyFollowsCount = App\Models\Follower::where('created_at', '>=', now()->startOfWeek())
                                                            ->where('user_id', Auth::user()->id)
                                                            ->count();

                                                            $latestFollows = Auth::user()->followers()
                                                            ->orderBy('created_at', 'desc')
                                                            ->take(7)
                                                            ->get();
                                                            @endphp

                                                            <span><i class="ti-eye"></i>{{ format_number($weeklyFollowsCount) }}</span>
                                                            <a title="weekly-likes">{{ format_number($weeklyFollowsCount) }} lượt theo dõi mới trong tuần này</a>
                                                            <div class="users-thumb-list">
                                                                @foreach($latestFollows as $follow)
                                                                <a onclick="return false;" href="/user-profile-post-{{ $follow->id }}" title="{{ $follow->name }}" data-toggle="tooltip">
                                                                    <img src="front/img/users/{{ $follow->avatar ?? 'default_user.png' }}" style="width: 30px;height: 30px;object-fit: cover;" alt="">
                                                                </a>
                                                                @endforeach
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div><!-- page like widget -->
                                        @endif

                                    </aside>
                                </div><!-- sidebar -->

                                <div class="col-lg-6">
                                    @yield('body')
                                </div>


                                <div class="col-lg-3">
                                    <aside class="sidebar static">
                                        <div class="widget">
                                            <form action="list_member">
                                                <h4 class="widget-title"><span><i class="fa-solid fa-magnifying-glass mr-2"></i></i></span>Tìm kiếm thành viên</h4>
                                                <div class="input-group mb-3 p-2">
                                                    <input type="text" name="search_member" value="{{ request('search_member') }}" class="form-control" placeholder="Tên thành viên...">
                                                    <div class="input-group-append">
                                                        <button class="btn btn-outline-secondary" type="submit">
                                                            <i class="fas fa-search"></i>
                                                        </button>
                                                    </div>
                                                </div>
                                            </form>
                                        </div>

                                        <div class="widget">
                                            <h4 class="widget-title"><span><i class="fa-solid fa-users mr-2"></i></span>Đang online</h4>
                                            <div class="m-3">
                                                <div>Đang trực tuyến: {{ $online }}</div><br>
                                                <p>Giảng viên: {{ $users->where('level', 1)->count() }}</p>
                                                <p>Sinh viên: {{$users->where('level', 2)->count()}}</p>
                                                <p>Admin: {{$users->where('level', 0)->count()}}</p>
                                            </div>
                                        </div>

                                        @if(Auth::check())
                                        <div class="widget friend-list">
                                            <h4 class="widget-title"><span><i class="fa-solid fa-users mr-2"></i></span>Người theo dõi</h4>
                                            <div id="searchDir"></div>
                                            <ul id="people-list" class="friendz-list">
                                                @foreach(Auth::user()->followers as $follower)
                                                <li>
                                                    <figure>
                                                        <img src="front/img/users/{{ $follower->avatar ?? 'default_user.png' }}" style="width: 40px;height: 40px;object-fit: cover;" alt="">
                                                        <span class="status f-{{ $follower->status == 1 ? 'online' : 'offline' }}"></span>
                                                    </figure>
                                                    <div class="friendz-meta">
                                                        <a href="./user-profile-post-{{ $follower->id }}">{{ $follower->name }}</a>
                                                        <i><a href="./user-profile-post-{{ $follower->id }}" class="__cf_email__">{{ $follower->email }}</a></i>
                                                    </div>
                                                </li>
                                                @endforeach
                                            </ul>
                                        </div><!-- friends list sidebar -->
                                        @endif

                                        <div class="widget">
                                            <h4 class="widget-title"><span><i class="fa-solid fa-chart-simple mr-3"></i></span>Thống kê</h4>
                                            <div class="m-3">
                                                <div class="row">
                                                    <h6 class="col-6">Thành viên:</h6>
                                                    <p class="col-6 text-center">{{ $users->count() }}</p>
                                                </div>
                                                <div class="row">
                                                    <h6 class="col-6">Bài viết:</h6>
                                                    <p class="col-6 text-center">{{$total_posts}}</p>
                                                </div>
                                            </div>
                                        </div>
                                    </aside>
                                </div><!-- sidebar -->
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>


        <!-- top area -->

        <footer>
            <div class="container">
                <div class="row">
                    <div class="col-lg-4 col-md-4">
                        <div class="widget">
                            <div class="foot-logo">
                                <div class="logo">
                                    <a href="./" title=""><img src="front/img/logo_fita.png" alt="" /></a>
                                </div>
                                <p>
                                    The trio took this simple idea and built it into the world’s
                                    leading carpooling platform.
                                </p>
                            </div>
                            <ul class="location">
                                <li>
                                    <i class="ti-map-alt"></i>
                                    <p>33 new montgomery st.750 san francisco, CA USA 94105.</p>
                                </li>
                                <li>
                                    <i class="ti-mobile"></i>
                                    <p>+1-56-346 345</p>
                                </li>
                            </ul>
                        </div>
                    </div>
                    <div class="col-lg-2 col-md-4">
                        <div class="widget">
                            <div class="widget-title">
                                <h4>follow</h4>
                            </div>
                            <ul class="list-style">
                                <li>
                                    <i class="fa fa-facebook-square"></i>
                                    <a href="https://web.facebook.com/shopcircut/" title="">facebook</a>
                                </li>
                                <li>
                                    <i class="fa fa-twitter-square"></i><a href="https://twitter.com/login?lang=en" title="">twitter</a>
                                </li>
                                <li>
                                    <i class="fa fa-instagram"></i><a href="https://www.instagram.com/?hl=en" title="">instagram</a>
                                </li>
                                <li>
                                    <i class="fa fa-google-plus-square"></i>
                                    <a href="https://plus.google.com/discover" title="">Google+</a>
                                </li>
                                <li>
                                    <i class="fa fa-pinterest-square"></i>
                                    <a href="https://www.pinterest.com/" title="">Pintrest</a>
                                </li>
                            </ul>
                        </div>
                    </div>
                    <div class="col-lg-2 col-md-4">
                        <div class="widget">
                            <div class="widget-title">
                                <h4>Navigate</h4>
                            </div>
                            <ul class="list-style">
                                <li><a href="about.html" title="">about us</a></li>
                                <li><a href="contact.html" title="">contact us</a></li>
                                <li><a href="terms.html" title="">terms & Conditions</a></li>
                                <li><a href="#" title="">RSS syndication</a></li>
                                <li><a href="sitemap.html" title="">Sitemap</a></li>
                            </ul>
                        </div>
                    </div>
                    <div class="col-lg-2 col-md-4">
                        <div class="widget">
                            <div class="widget-title">
                                <h4>useful links</h4>
                            </div>
                            <ul class="list-style">
                                <li><a href="#" title="">leasing</a></li>
                                <li><a href="#" title="">submit route</a></li>
                                <li><a href="#" title="">how does it work?</a></li>
                                <li><a href="#" title="">agent listings</a></li>
                                <li><a href="#" title="">view All</a></li>
                            </ul>
                        </div>
                    </div>
                    <div class="col-lg-2 col-md-4">
                        <div class="widget">
                            <div class="widget-title">
                                <h4>download apps</h4>
                            </div>
                            <ul class="colla-apps">
                                <li>
                                    <a href="https://play.google.com/store?hl=en" title=""><i class="fa fa-android"></i>android</a>
                                </li>
                                <li>
                                    <a href="https://www.apple.com/lae/ios/app-store/" title=""><i class="ti-apple"></i>iPhone</a>
                                </li>
                                <li>
                                    <a href="https://www.microsoft.com/store/apps" title=""><i class="fa fa-windows"></i>Windows</a>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </footer>
        <!-- footer -->
        <div class="bottombar">
            <div class="container">
                <div class="row">
                    <div class="col-md-12">
                        <span class="copyright"><a target="_blank" href="https://www.templateshub.net">Templates Hub</a></span>
                        <i><img src="front/img/credit-cards.png" alt="" /></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="side-panel">
        <h4 class="panel-title">General Setting</h4>
        <form method="post">
            <div class="setting-row">
                <span>use night mode</span>
                <input type="checkbox" id="nightmode1" />
                <label for="nightmode1" data-on-label="ON" data-off-label="OFF"></label>
            </div>
            <div class="setting-row">
                <span>Notifications</span>
                <input type="checkbox" id="switch22" />
                <label for="switch22" data-on-label="ON" data-off-label="OFF"></label>
            </div>
            <div class="setting-row">
                <span>Notification sound</span>
                <input type="checkbox" id="switch33" />
                <label for="switch33" data-on-label="ON" data-off-label="OFF"></label>
            </div>
            <div class="setting-row">
                <span>My profile</span>
                <input type="checkbox" id="switch44" />
                <label for="switch44" data-on-label="ON" data-off-label="OFF"></label>
            </div>
            <div class="setting-row">
                <span>Show profile</span>
                <input type="checkbox" id="switch55" />
                <label for="switch55" data-on-label="ON" data-off-label="OFF"></label>
            </div>
        </form>
        <h4 class="panel-title">Account Setting</h4>
        <form method="post">
            <div class="setting-row">
                <span>Sub users</span>
                <input type="checkbox" id="switch66" />
                <label for="switch66" data-on-label="ON" data-off-label="OFF"></label>
            </div>
            <div class="setting-row">
                <span>personal account</span>
                <input type="checkbox" id="switch77" />
                <label for="switch77" data-on-label="ON" data-off-label="OFF"></label>
            </div>
            <div class="setting-row">
                <span>Business account</span>
                <input type="checkbox" id="switch88" />
                <label for="switch88" data-on-label="ON" data-off-label="OFF"></label>
            </div>
            <div class="setting-row">
                <span>Show me online</span>
                <input type="checkbox" id="switch99" />
                <label for="switch99" data-on-label="ON" data-off-label="OFF"></label>
            </div>
            <div class="setting-row">
                <span>Delete history</span>
                <input type="checkbox" id="switch101" />
                <label for="switch101" data-on-label="ON" data-off-label="OFF"></label>
            </div>
            <div class="setting-row">
                <span>Expose author name</span>
                <input type="checkbox" id="switch111" />
                <label for="switch111" data-on-label="ON" data-off-label="OFF"></label>
            </div>
        </form>
    </div>
    <script src="front/js/main.min.js"></script>
    <script src="front/js/script.js"></script>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/slick-carousel/1.8.1/slick.min.js"></script>
    <link href="https://unpkg.com/tailwindcss@^1.0/dist/tailwind.min.css" rel="stylesheet">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js" integrity="sha384-IQsoLXl5PILFhosVNubq5LC7Qb9DXgDA9i+tQ8Zj3iwWAwPtgFTxbJ8NT4GN1R8p" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.min.js" integrity="sha384-cVKIPhGWiC2Al4u+LWgxfKTRIcfu0JTxR+EQDz/bgldoEyl4H0zUF0QKbrJ0EcQF" crossorigin="anonymous"></script>
    <script src="https://js.pusher.com/7.0/pusher.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/js/select2.min.js"></script>

    @yield('script')

    <!-- Pusher -->
    <script src="https://js.pusher.com/7.0/pusher.min.js"></script>
    @if(Auth::check())
    <script>
        var pusher = new Pusher('{{ env("PUSHER_APP_KEY") }}', {
            cluster: '{{ env("PUSHER_APP_CLUSTER") }}',
            encrypted: true
        });

        var user_id = '{{ Auth::user()->id }}';

        var post_channel = pusher.subscribe('post-channel');

        //Like
        post_channel.bind('like-event', function(data) {
            // Kiểm tra xem người thích bài viết có phải là chủ bài viết không
            if (user_id != data.userId && user_id == data.ownerId) {
                $(document).ready(function() {
                    $(
                        '<li data-notification-id="' + data.notification_id + '" class="bg-light">' +
                        '<a href="./new_posts/post_' + data.postId + '?notification_id=' + data.notification_id + '">' +
                        '<img src="front/img/users/' + data.avatar + '" alt="" style="width: 50px;height: 50px;object-fit: cover;">' +
                        '<div class="mesg-meta">' +
                        '<h6>' + data.userName + '</h6>' +
                        '<span>Đã thích bài viết của bạn</span>' +
                        '<i>' + data.time + '</i>' +
                        '</div>' +
                        '	</a>' +
                        '<span class="tag green">New</span>' +
                        '</li>'
                    ).insertAfter($('#notification-list li:first'));
                });

                const spanElement = document.querySelector('.notification-count');
                const notificationCount = spanElement.innerText;

                $('.notification-count').html(data.notifications_count);
            }
        });

        post_channel.bind('unlike-event', function(data) {
            // Kiểm tra xem người thích bài viết có phải là chủ bài viết không
            if (user_id != data.userId && user_id == data.ownerId) {
                // Hiển thị thông báo cho chủ bài viết
                $('#notification-list li[data-notification-id="' + data.notification_id + '"]').remove();

                //Cập nhật lại số lượng
                if (data.notifications_count == 0) {
                    $('.notification-count').html('');
                } else {
                    $('.notification-count').html(data.notifications_count);
                }
            }
        });

        //Comment
        post_channel.bind('comment-event', function(data) {
            // Kiểm tra xem người thích bài viết có phải là chủ bài viết không
            if (user_id != data.userId && user_id == data.ownerId) {
                $(document).ready(function() {
                    $(
                        '<li data-notification-id="' + data.notification_id + '" class="bg-light">' +
                        '<a href="./new_posts/post_' + data.postId + '?notification_id=' + data.notification_id + '">' +
                        '<img src="front/img/users/' + data.avatar + '" alt="" style="width: 50px;height: 50px;object-fit: cover;">' +
                        '<div class="mesg-meta">' +
                        '<h6>' + data.userName + '</h6>' +
                        '<span>Đã bình luận bài viết của bạn</span>' +
                        '<i>' + data.time + '</i>' +
                        '</div>' +
                        '	</a>' +
                        '<span class="tag green">New</span>' +
                        '</li>'
                    ).insertAfter($('#notification-list li:first'));

                    //Cập nhật lại số lượng
                    $('.notification-count').html(data.notifications_count);
                });
            }
        });

        post_channel.bind('reply-comment-event', function(data) {
            // Kiểm tra xem người thích bài viết có phải là chủ bài viết không
            if (user_id != data.userId && user_id == data.ownerId) {
                $(document).ready(function() {
                    $(
                        '<li data-notification-id="' + data.notification_id + '" class="bg-light">' +
                        '<a href="./new_posts/post_' + data.postId + '?notification_id=' + data.notification_id + '">' +
                        '<img src="front/img/users/' + data.avatar + '" alt="" style="width: 50px;height: 50px;object-fit: cover;">' +
                        '<div class="mesg-meta">' +
                        '<h6>' + data.userName + '</h6>' +
                        '<span>Đã bình luận bài viết của bạn</span>' +
                        '<i>' + data.time + '</i>' +
                        '</div>' +
                        '	</a>' +
                        '<span class="tag green">New</span>' +
                        '</li>'
                    ).insertAfter($('#notification-list li:first'));

                    console.log(data.notifications_count)

                    //Cập nhật lại số lượng
                    $('.notification-count').html(data.notifications_count);
                });
            }
        });

        post_channel.bind('delete-comment-event', function(data) {
            // Kiểm tra xem người thích bài viết có phải là chủ bài viết không
            if (user_id != data.userId && user_id == data.ownerId) {
                // Hiển thị thông báo cho chủ bài viết
                $('#notification-list li[data-notification-id="' + data.notification_id + '"]').remove();

                //Cập nhật lại số lượng
                if (data.notifications_count == 0) {
                    $('.notification-count').html('');
                } else {
                    $('.notification-count').html(data.notifications_count);
                }
            }
        });

        //=========================================================================================
        // Xử lý sự kiện khi người dùng chọn ảnh bìa
        document.getElementById('coverPhotoInput').addEventListener('change', function(e) {
            var file = e.target.files[0];
            var reader = new FileReader();
            reader.onload = function(event) {
                document.getElementById('img_background').src = event.target.result;
            };
            reader.readAsDataURL(file);
        });

        // Xử lý sự kiện khi người dùng chọn ảnh đại diện
        document.getElementById('displayPhotoInput').addEventListener('change', function(e) {
            var file = e.target.files[0];
            var reader = new FileReader();
            reader.onload = function(event) {
                document.getElementById('img_avatar').src = event.target.result;
            };
            reader.readAsDataURL(file);
        });

        //xử lý để lưu vào csdl
        $(document).ready(function() {
            $('#updateCoverPhotoBtn').click(function(e) {
                e.preventDefault();

                // Lấy tệp tin ảnh bìa và ảnh đại diện đã chọn
                var coverPhotoInput = document.getElementById('coverPhotoInput');
                var coverPhotoFile = coverPhotoInput.files[0];
                var displayPhotoInput = document.getElementById('displayPhotoInput');
                var displayPhotoFile = displayPhotoInput.files[0];

                // Tạo đối tượng FormData chứa tệp tin ảnh
                var formData = new FormData();

                if (coverPhotoFile) {
                    formData.append('img_background', coverPhotoFile);
                }

                if (displayPhotoFile) {
                    formData.append('img_avatar', displayPhotoFile);
                }

                formData.append('_token', $('meta[name="csrf-token"]').attr('content'));

                // Gửi yêu cầu Ajax
                $.ajax({
                    url: './update-user-photo',
                    type: 'POST',
                    data: formData,
                    processData: false,
                    contentType: false,
                    success: function(response) {
                        // Cập nhật đường dẫn ảnh bìa và ảnh đại diện mới
                        // console.log('1', response.background);
                        // console.log('2', response.avatar);
                        var background = response.background != 'front/img/users/' ? response.background : 'front/img/users/background_landscape.jpg';
                        console.log(background);
                        if (response.background) {
                            $('#img_background').attr('src', background);
                        }

                        if (response.avatar) {
                            $('#img_avatar').attr('src', response.avatar);
                            $('#menu_avatar').attr('src', response.avatar);
                            $('#your_page_avatar').attr('src', response.avatar);
                        }

                        alert('Cập nhật thành công!');
                    },
                    error: function(error) {
                        console.log(error);
                    }
                });
            });
        });
    </script>
    @endif
</body>

</html>