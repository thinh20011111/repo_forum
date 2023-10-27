@extends('admin.layout.master')

@section('title', 'Quản lý diễn đàn khoa CNTT - FITA VNUA || Chi tiết sự kiện')

@section('body')
<div class="page-breadcrumb">
    <div class="row">
        <div class="col-7 align-self-center">
            <h4 class="page-title text-truncate text-dark font-weight-medium mb-1">Quản lý sự kiện</span></h4>
            <div class="d-flex align-items-center">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb m-0 p-0">
                        <li class="breadcrumb-item"><a href="./admin" class="text-muted">Trang chủ</a></li>
                        <li class="breadcrumb-item"><a href="./admin/manage_event" class="text-muted">Quản lý sự kiện</a></li>
                        <li class="breadcrumb-item text-muted active" aria-current="page">Chi tiết sự kiện</li>
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
                            <form action="./admin/manage_event/event_{{ $post->id }}/delete_post" method="post">
                                @csrf
                                @method('DELETE')
                                <div class="popover-icon">
                                    <a title="Chỉnh sửa thông tin" class="btn btn-cyan rounded-circle btn-circle font-12 popover-item" href="/admin/manage_event/edit_{{ $post->id }}">
                                        <i data-feather="edit-3"></i>
                                    </a>
                                    <button type="submit" onclick="return confirm('Bạn có muốn xóa sự kiện này?')" class="btn btn-danger rounded-circle btn-circle font-12 popover-item">
                                        <i data-feather="trash-2"></i>
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                    <hr>
                    <div class="d-flex justify-content-between align-items-center">
                        <p><i class="fa-solid fa-thumbs-up"></i> : {{ $post->like_count ?? 0 }}<span> . <i class="fa-sharp fa-solid fa-comments"></i></span> : {{ $post->comment_count ?? 0 }} . <span><i class="fa-solid fa-eye"></i></span> : {{ $post->view_count ?? 0 }} . <span>
                                <p class="badge bg-info">Event</p>
                            </span>
                    </div>
                    <hr>
                    <div>
                        Tiêu đề: <span class="text-primary"><strong>{{ $post->title ?? 'Trống' }}</strong></span>
                    </div>
                    <div>
                        Thời gian diễn ra: <span class="text-primary"><strong>{{ $post->created_at }}</strong></span> đến ngày: <span class="text-primary"><strong>{{ $post->end_time_event }}</strong></span>
                    </div>
                    <hr>
                    <div>

                        <img alt="" src="front/img/event_post/{{$post->image}}" class="img-fluid mx-auto d-block">

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