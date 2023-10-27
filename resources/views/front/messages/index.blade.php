@extends('front.layout.master')

@section('title', 'Diễn đàn khoa CNTT - FITA VNUA || Tin nhắn')

@section('body')
<!-- =======MAIN MID======= -->
<div class="col-lg-6">
    <div class="central-meta item">
        <main class="content">
            <div class="container p-0">

                <h1 class="h3 mb-3">Tin nhắn</h1>

                <div class="card">
                    <div class="g-0">
                        <div id="chat_box">
                            <div class="py-2 px-4 border-bottom d-none d-lg-block">
                                <div class="d-flex align-items-center py-1">
                                    <div class="position-relative">
                                        <img src="front/img/users/{{ Auth::user()->avatar ?? 'default_user.png' }}" class="rounded-circle mr-1" alt="Sharon Lessman" style="width: 40px;height: 40px;object-fit: cover;">
                                    </div>
                                    <div class="flex-grow-1 pl-3">
                                        <strong id="name_receiver">Hãy chọn một đoạn hội thoại</strong>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </main>
    </div>
</div><!-- centerl meta -->

<div class="col-lg-3">
    <aside class="sidebar static">
        <div class="widget">
            <div>
                <div class="px-4 d-none d-md-block">
                    <div class="d-flex align-items-center">
                        <div class="flex-grow-1">
                            <input type="text" class="form-control my-3" id="searchInput" placeholder="Search...">
                        </div>
                    </div>
                </div>
                <div id="searchResults" class="list-group p-2 bg-light overflow-auto" style="max-height: 250px;">

                </div>

                @foreach ($mergedData as $data)
                <a href="./messages_{{ $data['id'] }}" class="get-messages list-group-item list-group-item-action border-0" data-receiver-id="{{ $data['displayUser'] }}">
                    <div class="d-flex align-items-start">
                        <img src="front/img/users/{{ $data['avatar'] ?? 'default_user.png' }}" class="rounded-circle mr-1" style="width: 40px;height: 40px;object-fit: cover;">
                        <div class="flex-grow-1 ml-3">
                            {{ $data['name'] }}
                            <div class="small"><span class="fas fa-circle chat-online"></span> Online</div>
                        </div>
                    </div>
                </a>
                @endforeach

                <!-- ==== -->

                <hr class="d-block d-lg-none mt-1 mb-0">
            </div>
        </div>
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

    </aside>
</div><!-- sidebar -->

<script src="front/js/tinimce.js"></script>
<script src="front/js/reaction-post.js"></script>
<script>

</script>
@endsection