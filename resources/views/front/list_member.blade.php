@extends('front.layout.master')

@section('title', 'Diễn đàn khoa CNTT - FITA VNUA || Thành viên')

@section('body')
<div class="col-lg-6">
    <div class="central-meta">
        @if (session()->has('error'))
        <div class="alert alert-danger mt-2">
            {{ session('error') }}
        </div>
        @else
        <ul class="nearby-contct">
            @foreach($list_member as $user)
            @if(Auth::check())
            @if($user->id != Auth::user()->id)
            <li>
                <div class="nearly-pepls">
                    <figure>
                        <a href="time-line.html" class="d-flex justify-content-center" title="">
                            <img src="front/img/users/{{ $user->avatar ?? 'default_user.png' }}" alt="{{ $user->name }}" style="width: 35px;height: 35px;object-fit: cover;">
                        </a>
                    </figure>
                    <div class="pepl-info">
                        <h4>
                            <a class="font-weight-normal" href="./user-profile-post-{{ $user->id }}" title="">{{ $user->name }}</a>
                        </h4>
                        <span>{{ $user->email }}</span>
                        <span><a href="./user-profile-post-{{ $user->id }}">trang cá nhân</a></span>
                        <em><i class='fas fa-book-open'></i>{{ number_format($user->posts->count()) }} Bài viết</em>
                        @php
                        $isFollowing = $user->followers->contains(Auth::user()->id);
                        @endphp

                        <a href="#" title="" class="add-butn btn-follow" data-user-id="{{ $user->id }}">
                            @if ($isFollowing)
                            Hủy theo dõi
                            @else
                            Theo dõi
                            @endif
                        </a>
                    </div>
                </div>
            </li>
            @endif
            @else
            <li>
                <div class="nearly-pepls">
                    <figure>
                        <a href="time-line.html" class="d-flex justify-content-center" title="">
                            <img src="front/img/users/{{ $user->avatar ?? 'default_user.png' }}" alt="{{ $user->name }}" style="width: 35px;height: 35px;object-fit: cover;">
                        </a>
                    </figure>
                    <div class="pepl-info">
                        <h4>
                            <a class="font-weight-normal" href="./user-profile-post-{{ $user->id }}" title="">{{ $user->name }}</a>
                        </h4>
                        <span>{{ $user->email }}</span>
                        <span><a href="./user-profile-post-{{ $user->id }}">trang cá nhân</a></span>
                        <em><i class='fas fa-book-open'></i>{{ number_format($user->posts->count()) }} Bài viết</em>
                    </div>
                </div>
            </li>
            @endif
            @endforeach
        </ul>
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
        @foreach($events as $event)
        <div class="widget">
            <div class="banner medium-opacity bluesh">
                <div class="bg-image" style="background-image: url(front/img/event_post/{{ $event->image }})"></div>
                <div class="baner-top">
                    <span><img alt="" src="front/img/book-icon.png"></span>
                    <i class="fa fa-ellipsis-h"></i>
                </div>
                <div class="banermeta">
                    <p>
                        {{ $event->title }}
                    </p>
                    <span><a href="./new_posts/post_{{ $event->id }}">xem chi tiết...</a></span>
                </div>
            </div>
        </div>
        @endforeach

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

@endsection