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
                                        <img src="front/img/users/{{ $receiver->avatar ?? 'default_user.png' }}" id="img_receiver" class="rounded-circle mr-1" alt="Sharon Lessman" style="width: 40px;height: 40px;object-fit: cover;">
                                    </div>
                                    <div class="flex-grow-1 pl-3">
                                        <strong id="name_receiver">{{ $receiver->name }}</strong>
                                    </div>
                                    <div>
                                        <button class="btn btn-light border btn-lg px-3 bg-secondary"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-more-horizontal feather-lg">
                                                <circle cx="12" cy="12" r="1"></circle>
                                                <circle cx="19" cy="12" r="1"></circle>
                                                <circle cx="5" cy="12" r="1"></circle>
                                            </svg></button>
                                    </div>
                                </div>
                            </div>

                            <div class="position-relative">
                                <div class="chat-messages p-4" id="messages_container_{{ $receiver->id }}_{{ Auth::user()->id }}" style="max-height: 50rem;">

                                    @include('front.messages.get-messages', ['messages' => $messages])

                                </div>
                            </div>

                            <div class="flex-grow-0 py-3 px-4 border-top">
                                <div class="input-group p-0 d-flex align-items-center">
                                    <input type="text" id="message-input" class="form-control" placeholder="Aa">
                                    <form>
                                        <div class="attachments">
                                            <button type="button" id="user-send-message" data-receiver-id="{{ $receiver->id }}">Gửi <i class="fas fa-paper-plane"></i></button>
                                        </div>
                                    </form>
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

                <hr class="d-block d-lg-none mt-1 mb-0">
            </div>
        </div>

    </aside>
</div><!-- sidebar -->

<script src="front/js/tinimce.js"></script>
<script src="front/js/reaction-post.js"></script>
@endsection