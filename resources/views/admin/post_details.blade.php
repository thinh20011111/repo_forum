@extends('admin.layout.master')

@section('title', 'Quản lý diễn đàn khoa CNTT - FITA VNUA || Chi tiết bài viết')

@section('body')
<div class="page-breadcrumb">
    <div class="row">
        <div class="col-7 align-self-center">
            <h4 class="page-title text-truncate text-dark font-weight-medium mb-1">Quản lý bài viết</span></h4>
            <div class="d-flex align-items-center">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb m-0 p-0">
                        <li class="breadcrumb-item"><a href="./admin" class="text-muted">Trang chủ</a></li>
                        <li class="breadcrumb-item"><a href="./admin/manage_posts" class="text-muted">Quản lý bài viết</a></li>
                        <li class="breadcrumb-item text-muted active" aria-current="page">Bài viết <span class="text-danger">{{ $post->id }}</span></li>
                    </ol>
                </nav>
            </div>
        </div>
    </div>
</div>
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body ">
                    <div class="d-flex align-items-center mb-4">
                        <a href="#user" class="d-flex align-items-center">
                            <div class="d-flex align-items-center flex-column bd-highlight">
                                <img class="bd-highlight" src="front/img/users/{{ $post->user->avatar ?? 'default_user.png' }}" alt="" style="width: 50px;height: 50px;object-fit: cover; border-radius: 50%;">
                                <p class="align-middle m-2 fw-bolder font-weight-bold">{{ $post->user->name }}</p>
                            </div>
                        </a>
                        <div class="ms-auto">
                            <form action="./admin/manage_posts/post_{{ $post->id }}/delete_post" method="post">
                                @csrf
                                @method('DELETE')
                                <div class="popover-icon">
                                    <button type="submit" onclick="return confirm('Bạn có muốn xóa bài viết này?')" class="btn btn-danger rounded-circle btn-circle font-12 popover-item">
                                        <i data-feather="trash-2"></i>
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                    <hr>
                    <div class="d-flex justify-content-between align-items-center">
                        <p><i class="fa-solid fa-thumbs-up"></i> : {{ $post->like_count ?? 0 }}<span> . <i class="fa-sharp fa-solid fa-comments"></i></span> : {{ $post->comment_count ?? 0 }} . <span><i class="fa-solid fa-eye"></i></span> : {{ $post->view_count ?? 0 }} . <span> @if($post->story_post == 1)</span></p>
                        <p class="badge bg-success">Story</p>
                        @elseif($post->daily_post == 1)
                        <p class="badge bg-warning">Daily</p>
                        @else
                        <p class="badge bg-info">Post</p>
                        @endif
                    </div>

                    <hr>
                    <div>
                        Tiêu đề: <span class="text-primary"><strong>{{ $post->title ?? 'Trống' }}</strong></span>
                    </div>
                    <div>
                        Thể loại: <span class="text-primary"><strong>{{ $post->type_->name ?? 'Trống' }}</strong></span>
                    </div>
                    <div>
                        Danh mục: <span class="text-primary"><strong>{{ $post->category_->name ?? 'Trống' }}</strong></span>
                    </div>
                    <div>
                        Chủ đề: <span class="text-primary"><strong>{{ $post->topic_->name ?? 'Trống' }}</strong></span>
                    </div>
                    <div>
                        Bộ môn: <span class="text-primary"><strong>{{ $post->specialized_->name ?? 'Trống' }}</strong></span>
                    </div>
                    <div>
                        Môn học: <span class="text-primary"><strong>{{ $post->subject_->name ?? 'Trống' }}</strong></span>
                    </div>
                    <div>
                        Tags:
                        @if($post->tags->count() >0 )
                        @foreach($post->tags as $tag)
                        <span class="tag badge badge-badge bg-secondary text-white mr-2">{{ $tag->name }}</span>
                        @endforeach
                        @else
                        Trống
                        @endif

                    </div>
                    <hr>
                    <div class="text-primary text-center">Nội dung</div>
                    <div class="container_post">
                        {!! $post->content !!}
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection