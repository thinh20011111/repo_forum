@extends('front.profile.master')

@section('title', 'Diễn đàn khoa CNTT - FITA VNUA || Trang cá nhân')

@section('body')

@if($posts->count() > 0)
@foreach($posts as $post)
<div class="central-meta item">
    <div class="user-post">
        <div class="friend-info">
            <figure>
                <img src="front/img/users/{{ $post->user->avatar ?? 'default_user.png' }}" alt="" style="min-width: 50px;min-height: 50px;max-width: 50px;max-height: 50px;object-fit: cover;" />
            </figure>
            <div class="friend-name">
                <ins><a href="time-line.html" title="">{{ $post->user->name }}</a> -

                    @if( $post->user->level == 0 )
                    <span class="badge bg-danger text-white">Người kiểm duyệt</span>
                    @elseif( $post->user->level == 1 )
                    <span class="badge bg-success text-white">Giảng viên</span>
                    @else
                    <span class="badge bg-primary text-white">Sinh viên</span>
                    @endif

                    <div class="dropleft float-right text dark ">
                        <span class="float-right text-dark" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-three-dots-vertical" viewBox="0 0 16 16">
                                <path d="M9.5 13a1.5 1.5 0 1 1-3 0 1.5 1.5 0 0 1 3 0zm0-5a1.5 1.5 0 1 1-3 0 1.5 1.5 0 0 1 3 0zm0-5a1.5 1.5 0 1 1-3 0 1.5 1.5 0 0 1 3 0z" />
                            </svg>
                        </span>
                        <div class="dropdown-menu cursor-pointer">
                            <form action="">
                                <button class="dropdown-item"><a href="./new_posts/post_{{ $post->id }}">Chi tiết bài viết</a></button>
                            </form>
                            <form action="./new_posts/post_{{ $post->id }}/delete_post" method="post">
                                @csrf
                                @method('DELETE')
                                @if(Auth::check() && $post->user_id == auth()->user()->id)
                                <button type="submit" onclick="return confirm('Bạn có muốn xóa người dùng này?')" class="dropdown-item delete-post-btn">Xóa bài viết</button>
                                @endif
                            </form>
                        </div>
                    </div>

                </ins>
                <span class="float-ri">{{ formatTime($post->created_at) }}</span>
            </div>
            <div class="post-meta">
                <input type="text" class="d-none" id="post_id_show" value="{{$post->id}}">
                <div class="post-content ">
                    {!! $post->content !!}
                </div>
                <img alt="" src="front/img/stories/{{$post->image}}" class="img-fluid mx-auto d-block">
                <div class="edit-form d-none">
                    <form>
                        <textarea id="edit-content" name="edit-content">{{ $post->content }}</textarea>
                        <div class="text-danger" id="error-content-edit">

                        </div>
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
                            @php
                            $userLikes = $post->likes->pluck('user_id')->toArray();
                            $liked = in_array(Auth::user()->id, $userLikes);
                            @endphp
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
                                <ins id="count_comment_{{ $post->id }}">{{ format_number($post->comments->count()) }}</ins>
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
                @else
                <div class="alert alert-warning central-meta item" role="alert">
                    <a href="./account/login">Đăng nhập để bình luận bài viết</a>
                </div>
                @endif
            </ul>
        </div>
    </div>
</div>
@endforeach
@else
<div class="central-meta item">
    <div class="alert alert-warning" role="alert">
        Không có bài viết nào!
    </div>
</div>
@endif
<script src="front/js/reaction-post.js"></script>
<script src="front/js/tinimce.js"></script>
@endsection