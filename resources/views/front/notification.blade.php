@extends('front.layout.master')

@section('title', 'Diễn đàn khoa CNTT - FITA VNUA || Thông báo')

@section('body')
<div class="col-lg-6">
    <div class="central-meta">
        <h1 class="h3 mb-3">Thông báo</h1>
        <p class="float-right cursor-pointer mark-notification-read">Đánh dấu đã đọc <span class="notification-count badge bg-danger text-white">{{ $notificationsCount > 99 ? '99+' : $notificationsCount }}</span></p>
        @if($notifications->count() > 0)
        <ul class="nearby-contct" id="list-notifications">
            @foreach($notifications as $notification)
            <li class="{{ $notification->status == 'new' ? 'bg-light' : '' }}">
                @if($notification->type === 'like' || $notification->type === 'comment' || $notification->type === 'create')
                <a href="./new_posts/post_{{ $notification->post_id }}?notification_id={{ $notification->id }}">
                    @elseif($notification->type === 'message')
                    <a href="./messages_{{ $notification->user_id }}?notification_id={{ $notification->id }}">
                        @elseif($notification->type === 'follow')
                        <a href="./user-profile-post-{{ $notification->user_id }}?notification_id={{ $notification->id }}">
                            @endif
                            <div class="nearly-pepls">
                                <figure>
                                    <div href="time-line.html" class="d-flex justify-content-center" title=""><img src="front/img/users/{{ $notification->user->avatar ?? 'default_user.png' }}" alt="{{ $notification->user->name }}" style="width: 35px;height: 35px;object-fit: cover;"></div>
                                </figure>
                                <div class="pepl-info">
                                    <p><strong class="text">{{ $notification->user->name  }}</strong> {{ $notification->content  }}
                                        @if($notification->status == 'new')
                                        <span class="badge badge-success">New</span>
                                        @endif
                                    </p>
                                </div>
                            </div>
                        </a>
            </li>
            @endforeach
        </ul>
        @else
        <div class="alert alert-warning" role="alert">
            Không có thông báo nào.
        </div>
        @endif
    </div><!-- photos -->
</div><!-- centerl meta -->

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
            <div class="banner medium-opacity bluesh">
                <div class="bg-image" style="background-image: url(front/img/resources/baner-widgetbg.jpg)"></div>
                <div class="baner-top">
                    <span><img alt="" src="front/img/book-icon.png"></span>
                    <i class="fa fa-ellipsis-h"></i>
                </div>
                <div class="banermeta">
                    <p>
                        create your own favourit page.
                    </p>
                    <span>like them all</span>
                </div>
            </div>
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
                    <p class="col-6 text-center">{{ $total_posts }}</p>
                </div>
            </div>
        </div>
    </aside>
</div><!-- sidebar -->
<script>
    $(document).ready(function() {
        $('.mark-notification-read').click(function(e) {
            e.preventDefault();

            // Lấy CSRF token từ meta tag
            var token = $('meta[name="csrf-token"]').attr('content');

            $.ajax({
                type: 'POST',
                url: '/notifications/read_all',
                dataType: 'json',
                data: {
                    _token: token
                },
                beforeSend: function(xhr) {
                    xhr.setRequestHeader('X-CSRF-TOKEN', token);
                },
                success: function(response) {
                    if (response.success) {
                        $('#list-notifications li').removeClass('bg-light');
                        $('#list-notifications li span.badge-success').remove();
                        
                        // Cập nhật số lượng thông báo
                        var notificationCount = $('.notification-count');
                        notificationCount.text(0);
                    }
                }
            });
        });
    });
</script>
@endsection