@extends('front.layout.master')

@section('title', 'Diễn đàn khoa CNTT - FITA VNUA || Bài viết mới')

@section('body')
<div class="col-lg-6">
    @if($post->daily_post == 0 && $post->story_post == 0)
    <div class="central-meta item">
        <blockquote class="blockquote m-0">
            <p class="mb-0 text-dark font-weight-bold">{{ $post->title }}<span></p>
            <footer class="blockquote-footer p-0 pl-4"><cite title="Source Title">{{ $post->subject_->name ?? 'Không có' }}</cite></footer>
        </blockquote>
        <p>Tags: <span>
                @foreach($post->tags as $tag)
                <span class="tag badge badge-badge bg-secondary text-white mr-2">{{ $tag->name }}</span>
                @endforeach
            </span>
        </p>
    </div>
    @endif

    @if($post->daily_post == 0 && $post->story_post == 0)
    @if($post->file_path)
    <div class="central-meta item old-file">
        <h1 class="font-weight-bold">File chia sẻ: <span class="file_location"><a class="font-weight-normal font-italic" target="_blank" href="{{asset('front/files/'.$post->file_path)}}">{{ $post->file_path }}</a></span></h1>
    </div>
    @endif
    @endif

    <div class="central-meta item">
        <div class="user-post">
            <div class="friend-info">
                <figure>
                    <img src="front/img/users/{{ $post->user->avatar ?? 'default_user.png' }}" alt="" style="min-width: 50px;min-height: 50px;max-width: 50px;max-height: 50px;object-fit: cover;" />
                </figure>
                <div class="friend-name">
                    <ins><a href="./user-profile-post-{{ $post->user->id }}" title="">{{ $post->user->name }}</a> -

                        @if( $post->user->level == 0 )
                        <span class="badge bg-danger text-white">Người kiểm duyệt</span>
                        @elseif( $post->user->level == 1 )
                        <span class="badge bg-success text-white">Giảng viên</span>
                        @else
                        <span class="badge bg-primary text-white">Sinh viên</span>
                        @endif

                        @if(Auth::check() && $post->user_id == auth()->user()->id)
                        <div class="dropleft float-right text dark ">
                            <span class="float-right text-dark" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-three-dots-vertical" viewBox="0 0 16 16">
                                    <path d="M9.5 13a1.5 1.5 0 1 1-3 0 1.5 1.5 0 0 1 3 0zm0-5a1.5 1.5 0 1 1-3 0 1.5 1.5 0 0 1 3 0zm0-5a1.5 1.5 0 1 1-3 0 1.5 1.5 0 0 1 3 0z" />
                                </svg>
                            </span>
                            <div class="dropdown-menu cursor-pointer">
                                <form action="">
                                    <button type="button" class="dropdown-item" id="disable-comment-btn" data-comment-mode="{{ $post->comment_mode }}" data-post-id="{{ $post->id }}">{{ $post->comment_mode == 1 ? 'Bật bình luận': 'Tắt bình luận' }}</button>
                                    <button class="dropdown-item" id="edit-post-btn">Chỉnh sửa bài viết</button>
                                </form>
                                <form action="./new_posts/post_{{ $post->id }}/delete_post" method="post">
                                    @csrf
                                    @method('DELETE')

                                    <button type="submit" onclick="return confirm('Bạn có muốn xóa bài viết này?')" class="dropdown-item delete-post-btn">Xóa bài viết</button>
                                </form>
                            </div>
                        </div>
                        @endif

                    </ins>
                    <span class="float-ri">{{ formatTime($post->created_at) }}</span>
                </div>
                <div class="post-meta">
                    <input type="text" class="d-none" id="post_id_show" value="{{$post->id}}">
                    <div class="post-content text-break">
                        {!! $post->content !!}
                    </div>
                    @if($post->story_post === 1)
                    <img alt="" name="img_path" src="front/img/stories/{{$post->image}}" class="img-fluid mx-auto d-block mb-2" data-src="front/img/stories/{{$post->image}}">
                    @endif
                    @if($post->event_post === 1)
                    <img alt="" name="img_path" src="front/img/event_post/{{$post->image}}" class="img-fluid mx-auto d-block mb-2" data-src="front/img/stories/{{$post->image}}">
                    @endif
                    <div class="edit-form d-none">
                        <form id="editForm" enctype="multipart/form-data">
                            <textarea id="edit-content" name="edit-content">{{ $post->content }}</textarea>
                            <div class="text-danger" id="error-content-edit"></div>

                            @if($post->daily_post == 0 && $post->story_post == 0)
                            <div class="mb-3 mt-2">
                                <div class="font-weight-bold">File chia sẻ - <span class="font-weight-normal font-italic">{{ $post->file_path }}</span></div>
                                <div class="custom-file">
                                    <input type="file" class="custom-file-input" id="inputGroupFile01" aria-describedby="inputGroupFileAddon01" name="file_path">
                                    <label class="custom-file-label" for="inputGroupFile01">Chọn tệp</label>
                                </div>
                            </div>
                            @endif

                            <div class="attachments">
                                <button id="cancel-edit-post-btn" style="background-color: red;">Hủy</button>
                                <button id="save-edit-btn">Lưu</button>
                            </div>
                        </form>
                    </div>
                    <br>
                    <hr>
                    <div class="we-video-info">
                        <ul>
                            <li>
                                @if(Auth::check())
                                <span class="like like-btn-{{ $post->id }} {{ $post->likes->contains(auth()->user()->id) ? 'liked' : '' }}" data-toggle="tooltip" title="like" data-post-id="{{ $post->id }}" data-user-id="{{ auth()->user()->id }}">
                                    <i class="fa-sharp fa-thumbs-up icon_like_{{ $post->id }} {{ $liked ? 'fa-solid' : 'fa-regular' }}"></i>
                                    <ins class="likes-count-{{ $post->id }}" data-post-id="{{ $post->id }}">{{ format_number($post->likes->count()) }}</ins>
                                </span>
                                @else
                                <span data-toggle="tooltip" title="like">
                                    <i class="fa-sharp fa-thumbs-up fa-regular"></i>
                                    <ins>{{ format_number($post->likes->count()) }}</ins>
                                </span>
                                @endif
                            </li>
                            <li>
                                <span class="comment" data-toggle="tooltip" title="Comments">
                                    <i class="fa fa-comments-o"></i>
                                    <ins id="count_comment_{{ $post->id }}">{{ format_number($count_comments) }}</ins>
                                </span>
                            </li>
                            <li>
                                <span class="views" data-toggle="tooltip" title="views">
                                    <i class="fa fa-eye"></i>
                                    <ins>{{ format_number($post->view_count ?? 0) }}</ins>
                                </span>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
            <hr>
            <div class="coment-area">
                <ul class="we-comet" id="comment-{{ $post->id }}" style="padding-top: 15px;">
                    <!-- Bình luận bài viết -->
                    @include('front.what_news.list-comment', ['comments' => $post->comments])
                </ul>
                <ul>
                    @if(Auth::check())
                    @if($post->comment_mode == 0)
                    <div class="central-meta item">
                        <nav>
                            <div class="nav nav-tabs" id="myTab" role="tablist">
                                <a class="nav-item nav-link active" id="tab1-tab" data-toggle="tab" href="#tab1" role="tab" aria-controls="tab1" aria-selected="true"><span><i class="fa-solid fa-comment"></i></span> Bình luận</a>
                                <a class="nav-item nav-link" id="tab2-tab" data-toggle="tab" href="#tab2" role="tab" aria-controls="tab2" aria-selected="false"><span><i class="fa-sharp fa-solid fa-circle-exclamation"></i></span> Báo cáo</a>
                            </div>
                        </nav>
                        <div class="tab-content">
                            <div class="tab-pane fade show active" id="tab1" role="tabpanel">
                                <li class="post-comment" style="margin-top: 10px;">
                                    <div class="comet-avatar">
                                        <img src="front/img/users/{{ Auth::user()->avatar ?? 'default_user.png' }}" alt="" style="min-width: 40px;min-height: 40px;max-width: 40px;max-height: 40px;object-fit: cover;" />
                                    </div>
                                    <div class="post-comt-box">
                                        <form method="post">
                                            <textarea style="height: 100px;" class="@error('content') is-invalid @enderror" placeholder="write something" id="comment-content-{{ $post->id }}" name="content"></textarea>
                                            <small id="comment-error-{{ $post->id }}" class="text-danger"></small>

                                            <div class="attachments">
                                                <button type="submit" class="btn-comment" data-post-id="{{ $post->id }}">Bình luận</button>
                                            </div>
                                        </form>
                                    </div>
                                </li>
                            </div>
                            <div class="tab-pane fade" id="tab2" role="tabpanel">
                                <form id="report-post-form">
                                    <div class="form-group">
                                        <textarea class="@error('content') is-invalid @enderror form-control border" id="content_report_post" name="content_report_post" rows="3" placeholder="Lý do báo cáo..."></textarea>
                                        <small id="report-post-error" class="text-danger"></small>
                                    </div>
                                    <div class="attachments">
                                        <button type="submit" class="bg-danger">Báo cáo</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                    @endif
                    @else
                    <div class="alert alert-warning central-meta item" role="alert">
                        <a href="./account/login">Đăng nhập để bình luận bài viết</a>
                    </div>
                    @endif
                </ul>
            </div>
        </div>
    </div>
</div><!-- centerl meta -->
<div class="col-lg-3">
    @if($post->story_post !== 1)
    <aside class="sidebar static">
        <div class="widget">
            <h4 class="widget-title"><span><i class="fa-solid fa-chart-simple mr-3"></i></span>Bài viết liên quan</h4>
            <div class="m-3">
                @if($relatedPosts->count() > 0)
                @foreach($relatedPosts->slice(0, 15) as $post)
                <a href="./new_posts/post_{{ $post->id }}" class="list-group-item list-group-item-action" style="overflow: auto;">
                    <div class="media d-flex justify-content-start">
                        <div class="media-body" style="max-width: 100%;">
                            <h5 class="font-weight-bold text-dark">{{ $post->title }}</h5>
                            <p>{{ $post->user->name }}</p>
                            <p>{{ formatTime($post->created_at) }}</p>
                        </div>
                    </div>
                </a>
                @endforeach
                @else
                <div class="text-center">Không có bài viết nào</div>
                @endif
            </div>
        </div>


    </aside>
    @endif
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
            <h4 class="widget-title"><span><i class="fa-solid fa-users mr-2"></i></span>Đang online</h4>
            <div class="m-3">
                <div>Đang trực tuyến: {{ $online }}</div><br>
                <p>Giảng viên: {{ $users->where('level', 1)->count() }}</p>
                <p>Sinh viên: {{$users->where('level', 2)->count()}}</p>
                <p>Admin: {{$users->where('level', 0)->count()}}</p>
            </div>
        </div>

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

<script src="front/js/reaction-post.js"></script>
<script src="front/js/tinimce.js"></script>
<script>
    document.querySelector('.img-fluid').addEventListener('click', function() {
        // Tạo một input mới để cho phép người dùng chọn hình ảnh
        var input = document.createElement('input');
        input.type = 'file';
        input.accept = 'image/*';

        // Xử lý sự kiện khi người dùng chọn hình ảnh mới
        input.addEventListener('change', function(e) {
            var file = e.target.files[0];
            var reader = new FileReader();

            reader.onload = function(e) {
                var img = document.querySelector('.img-fluid');
                img.src = e.target.result;
                img.dataset.src = e.target.result;
            };

            reader.readAsDataURL(file);
        });

        // Kích hoạt sự kiện chọn tệp
        input.click();
    });

   
</script>
@endsection