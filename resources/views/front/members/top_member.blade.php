@extends('front.layout.master')

@section('title', 'Diễn đàn khoa CNTT - FITA VNUA || Top thành viên')

@section('body')
<div class="col-lg-6">
    <div class="central-meta">
        <div class="row">
            <div class="col m-2">
                <div class="list-group">
                    <div class="list-group-item list-group-item-action active">
                        Top lượt thích
                    </div>
                    @foreach($top_like as $key => $user)
                    <li class="list-group-item d-flex justify-content-between align-items-center">
                        <div class="friend-info w-auto">
                            <figure>
                                <img src="front/img/users/{{ $user->avatar ?? 'default_user.png' }}" alt="" style="min-width: 30px;min-height: 30px;max-width: 30px;max-height: 30px;object-fit: cover;" />
                            </figure>
                        </div>
                        <div class="friend-name">
                            <ins>
                                @if($user->level == 0)
                                <a class="d-flex justify-content-start align-items-center" href="./user-profile-post-{{ $user->id }}" title="">
                                    <span><img src="https://nhanhoa.com/uploads/attach/1618816460_tich_xanh_facebook.png" alt="" width="10px"></span>
                                    <span class="ml-1">{{ $user->name }}</span>
                                </a>
                                @else
                                <a class="font-weight-normal" href="./user-profile-post-{{ $user->id}}" title="">{{ $user->name }}</a>
                                @endif
                            </ins>
                        </div>
                        <span class="badge badge-primary badge-pill">{{ number_format($user->total_likes) }}</span>
                    </li>
                    @endforeach
                    <a href="./top_member/top_like" class="list-group-item list-group-item-action text-center" tabindex="-1" aria-disabled="true">Xem thêm...</a>
                </div>
            </div>
            <div class="col m-2">
                <div class="list-group">
                    <div class="list-group-item list-group-item-action active">
                        Top bài viết
                    </div>
                    @foreach($top_post as $key => $user)
                    <li class="list-group-item d-flex justify-content-between align-items-center">
                        <div class="friend-info w-auto">
                            <figure>
                                <img src="front/img/users/{{ $user->avatar ?? 'default_user.png' }}" alt="" style="min-width: 30px;min-height: 30px;max-width: 30px;max-height: 30px;object-fit: cover;" />
                            </figure>
                        </div>
                        <div class="friend-name">
                            <ins>
                                @if($user->level == 0)
                                <a class="d-flex justify-content-start align-items-center" href="./user-profile-post-{{ $user->id }}" title="">
                                    <span><img src="https://nhanhoa.com/uploads/attach/1618816460_tich_xanh_facebook.png" alt="" width="10px"></span>
                                    <span class="ml-1">{{ $user->name }}</span>
                                </a>
                                @else
                                <a class="font-weight-normal" href="./user-profile-post-{{ $user->id}}" title="">{{ $user->name }}</a>
                                @endif
                            </ins>
                        </div>
                        <span class="badge badge-primary badge-pill">{{ number_format($user->total_posts) }}</span>
                    </li>
                    @endforeach
                    <a href="./top_member/top_post" class="list-group-item list-group-item-action text-center" tabindex="-1" aria-disabled="true">Xem thêm...</a>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col m-2">
                <div class="list-group">
                    <div class="list-group-item list-group-item-action active">
                        Sinh nhật hôm nay
                    </div>
                    @foreach ($birthday as $user)
                    <li class="list-group-item d-flex justify-content-between align-items-center">
                        <div class="friend-info w-auto">
                            <figure>
                                <img src="front/img/users/{{ $user->avatar ?? 'default_user.png' }}" alt="" style="min-width: 30px;min-height: 30px;max-width: 30px;max-height: 30px;object-fit: cover;" />
                            </figure>
                        </div>
                        <div class="friend-name">
                            <ins>
                                @if($user->level == 0)
                                <a class="d-flex justify-content-start align-items-center" href="./user-profile-post-{{ $user->id }}" title="">
                                    <span><img src="https://nhanhoa.com/uploads/attach/1618816460_tich_xanh_facebook.png" alt="" width="10px"></span>
                                    <span class="ml-1">{{ $user->name }}</span>
                                </a>
                                @else
                                <a class="font-weight-normal" href="./user-profile-post-{{ $user->id}}" title="">{{ $user->name }}</a>
                                @endif
                            </ins>
                        </div>
                        <span>{{ $user->birthday ?$currentDate->diffInYears($user->birthday) : 'Trống' }}</span>
                    </li>
                    @endforeach
                    <a href="./top_member/birthday_today" class="list-group-item list-group-item-action text-center" tabindex="-1" aria-disabled="true">Xem thêm...</a>
                </div>
            </div>
            <div class="col m-2">
                <div class="list-group">
                    <div class="list-group-item list-group-item-action active">
                        Danh sách BQT
                    </div>
                    @foreach ($admin as $user)
                    <li class="list-group-item d-flex justify-content-between align-items-center">
                        <div class="friend-info w-auto">
                            <figure>
                                <img src="front/img/users/{{ $user->avatar ?? 'default_user.png' }}" alt="" style="min-width: 30px;min-height: 30px;max-width: 30px;max-height: 30px;object-fit: cover;" />
                            </figure>
                        </div>
                        <div class="friend-name">
                            <ins><a class="d-flex justify-content-start align-items-center" href="./user-profile-post-{{ $user->id }}" title="">
                                    <span><img src="https://nhanhoa.com/uploads/attach/1618816460_tich_xanh_facebook.png" alt="" width="10px"></span>
                                    <span class="ml-1">{{ $user->name }}</span>
                                </a>
                            </ins>
                        </div>
                    </li>
                    @endforeach
                    <a href="./top_member/list_admin" class="list-group-item list-group-item-action text-center" tabindex="-1" aria-disabled="true">Xem thêm...</a>
                </div>
            </div>
        </div>
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
            <h4 class="widget-title"><span><i class="fa-solid fa-users mr-2"></i></span>Top thành viên</h4>
            <br><br>
            <div class="m-3">
                <a href="./top_member" class="list-group-item list-group-item-action active">
                    Overview
                </a>
                <a href="./top_member/top_post" class="list-group-item list-group-item-action ">Top bài viết</a>
                <a href="./top_member/top_like" class="list-group-item list-group-item-action ">Top lượt thích</a>
                <a href="./top_member/birthday_today" class="list-group-item list-group-item-action ">Sinh nhật hôm nay</a>
                <a href="./top_member/list_admin" class="list-group-item list-group-item-action ">Danh sách BQT</a>
            </div>
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
                <div>Đang trực tuyến: {{ $online->count() }}</div><br>
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