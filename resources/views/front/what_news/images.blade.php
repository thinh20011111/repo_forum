@extends('front.layout.master')

@section('title', 'Diễn đàn khoa CNTT - FITA VNUA || Hình ảnh mới')

@section('body')
<div class="col-lg-6">
    <div class="central-meta item">
        <nav>
            <div class="nav nav-tabs" id="myTab" role="tablist">
                <a class="nav-item nav-link" href="./what_news" role="tab">Có gì mới?</a>
                <a class="nav-item nav-link " href="./new_posts">Bài viết mới</a>
                <a class="nav-item nav-link active bg-light" href="./new_images">Hình ảnh</a>
                <a class="nav-item nav-link" href="./new_documents">Tài liệu</a>
                <a class="nav-item nav-link  " href="./new_status">Status thành viên</a>
            </div>
        </nav>
        <div class="tab-content">
            <div class="tab-pane fade show active">
                <div class="list-group mb-3 p-3">
                    <ul class="photos">
                        @foreach($posts as $post)
                        <li>
                            @php
                            $randomNumber = rand(0, 1);
                            @endphp

                            @if($randomNumber == 0)
                            <div class="mb-1 d-flex justify-content-start align-items-center">
                                <img class="rounded-circle mr-1" src="front/img/users/{{ $post->user->avatar ?? 'default_user.png' }}" alt="" style="min-width: 20px;min-height: 20px;max-width: 20px;max-height: 20px;object-fit: cover;" />
                                <p>{{ $post->user->name }}</p>
                                <p class="ml-auto bd-highlight">{{ formatTime($post->created_at) }}</p>
                            </div>
                            @endif

                            <a class="strip" href="front/img/stories/{{ $post->image }}" title="" data-strip-group="mygroup" data-strip-group-options="loop: false">
                                <img src="front/img/stories/{{ $post->image }}" alt="" />
                            </a>

                            @if($randomNumber == 1)
                            <div class="mb-1 d-flex justify-content-start align-items-center">
                                <img class="rounded-circle mr-1" src="front/img/users/{{ $post->user->avatar ?? 'default_user.png' }}" alt="" style="min-width: 20px;min-height: 20px;max-width: 20px;max-height: 20px;object-fit: cover;" />
                                <p>{{ $post->user->name }}</p>
                                <p class="ml-auto bd-highlight">{{ formatTime($post->created_at) }}</p>
                            </div>
                            @endif
                        </li>
                        @endforeach
                    </ul>
                </div>
                <div>
                    {{ $posts->links() }}
                </div>
            </div>
        </div>
    </div>
</div><!-- centerl meta -->

<div class="col-lg-3">
    <aside class="sidebar static">
        <div class="widget">
            <h4 class="widget-title"><span><i class="fa-solid fa-magnifying-glass mr-2"></i></i></span>Tìm kiếm thành viên</h4>
            <div class="input-group mb-3 p-2">
                <input type="text" class="form-control" placeholder="Tên thành viên...">
                <div class="input-group-append">
                    <button class="btn btn-outline-secondary" type="button">
                        <i class="fas fa-search"></i>
                    </button>
                </div>
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