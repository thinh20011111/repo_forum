@extends('admin.layout.master')

@section('title', 'Quản lý diễn đàn khoa CNTT - FITA VNUA || Chi tiêt báo cáo')

@section('body')
<!-- ============================================================== -->
<!-- Bread crumb and right sidebar toggle -->
<!-- ============================================================== -->
<div class="page-breadcrumb">
    <div class="row">
        <div class="col-7 align-self-center">
            <h4 class="page-title text-truncate text-dark font-weight-medium mb-1">Chi tiết báo cáo</span></h4>
            <div class="d-flex align-items-center">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb m-0 p-0">
                        <li class="breadcrumb-item"><a href="./admin" class="text-muted">Trang chủ</a></li>
                        <li class="breadcrumb-item"><a href="./admin/manage_report_posts" class="text-muted">Quản lý báo cáo bài viết</a></li>
                        <li class="breadcrumb-item text-muted active" aria-current="page">Chi tiết báo cáo: <span class="text-danger">{{ $report->id }}</span></li>
                    </ol>
                </nav>
            </div>
        </div>
    </div>
</div>
<!-- ============================================================== -->
<!-- End Bread crumb and right sidebar toggle -->
<!-- ============================================================== -->
<!-- ============================================================== -->
<!-- Container fluid  -->
<!-- ============================================================== -->
<div class="container-fluid">
    <!-- ============================================================== -->
    <!-- Start Page Content -->
    <!-- ============================================================== -->
    <!-- basic table -->
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center mb-4">
                        @if($report->type === 'post')
                        <a class="btn btn-cyan rounded-circle btn-circle font-12 " href="./admin/manage_reports/posts" title="Quay lại">
                            <i data-feather="arrow-left"></i>
                        </a>
                        @else
                        <a class="btn btn-cyan rounded-circle btn-circle font-12 " href="./admin/manage_reports/comments" title="Quay lại">
                            <i data-feather="arrow-left"></i>
                        </a>
                        @endif

                        <form action="/admin/manage_reports/posts/report_{{ $report->id}}" method="POST">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger rounded-circle btn-circle font-12 float-end" onclick="return confirm('Bạn có chắc chắn muốn xóa báo cáo này?')" title="Xóa">
                                <i data-feather="trash-2"></i>
                            </button>
                        </form>
                    </div>
                    <hr>
                    <div>
                        <div class="mb-3 row">
                            <div class="col-3">
                                <div class="me-2">Báo cáo được đăng bởi: </div>
                            </div>
                            <div class="d-flex no-block align-items-center col-9">
                                <div class="me-3"><img src="front/img/users/{{ $report->owner->avatar ?? 'default_user.png' }}" alt="user" class="rounded-circle" style="width: 40px;height: 40px;object-fit: cover;" /></div>
                                <div>
                                    <h5 class="text-dark mb-0 font-16 font-weight-medium">{{ $report->owner->name }}</h5>
                                    <span class="text-muted font-14">{{ $report->owner->email  }}</span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div>
                        <div class="mb-3 row">
                            <div class="col-3">
                                <div class="me-2">Bài viết được đăng bởi: </div>
                            </div>
                            <div class="d-flex no-block align-items-center col-9">
                                <div class="me-3"><img src="front/img/users/{{ $report->user_report->avatar ?? 'default_user.png' }}" alt="user" class="rounded-circle" style="width: 40px;height: 40px;object-fit: cover;" /></div>
                                <div>
                                    <h5 class="text-dark mb-0 font-16 font-weight-medium">{{ $report->user_report->name }}</h5>
                                    <span class="text-muted font-14">{{ $report->user_report->email  }}</span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div>
                        <div class="mb-3 row">
                            <div class="col-3">
                                <div class="me-2">Thời gian: </div>
                            </div>
                            <div class="d-flex no-block align-items-center col-9">
                                {{ $report->created_at }}
                            </div>
                        </div>
                    </div>
                    <div>
                        <div class="mb-3 row">
                            <div class="col-3">
                                <div class="me-2">Hành động: </div>
                            </div>
                            <div class="d-flex no-block align-items-center col-9">
                                @if($report->type === 'post')
                                @if($report->post)
                                <a class="badge text-bg-info me-2" href="./new_posts/post_{{ $report->post->id }}">Đến trang tiết bài viết <span><i data-feather="eye"></i></a>

                                <form action="./admin/manage_posts/post_{{ $report->post_id }}/delete_post" method="post">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" onclick="return confirm('Bạn có muốn xóa bài viết này?')" class="badge text-bg-danger border border-0">Gỡ bài viết <span><i data-feather="trash-2"></i></span></button>
                                </form>
                                @endif
                                @elseif($report->type === 'comment')
                                @if($report->comment)
                                <a class="badge text-bg-info me-2" href="./new_posts/post_{{ $report->post_id }}">Đến trang bài viết <span><i data-feather="eye"></i></a>

                                <form action="admin/manage_reports/comments/delete_comment_{{ $report->id }}" method="post">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" onclick="return confirm('Bạn có muốn xóa bình luận này?')" class="badge text-bg-danger border border-0">Gỡ bình luận <span><i data-feather="trash-2"></i></span></button>
                                </form>
                                @endif
                                @endif
                            </div>
                        </div>
                    </div>
                    <hr>
                    <div>
                        <div class="d-flex justify-content-center text-primary">Nội dung báo cáo:</div>
                    </div>
                    <div class="container_post">
                        {!! $report->content !!}
                    </div>
                    <hr>
                    <div>
                        <div class="d-flex justify-content-center text-primary">Nội dung bài viết:</div>
                    </div>
                    <div class="container_post">
                        @if($report->type === 'post')
                            @if($report->post)
                                {!! $report->post->content !!}
                            @else
                                <div class="text-danger">Bài viết này đã được gỡ</div>
                            @endif
                        @elseif($report->type === 'comment')
                            @if($report->comment)
                                {!! $report->comment->content !!}
                            @else
                            <div class="text-danger">Bình luận này đã được gỡ</div>
                            @endif
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
</div>
<!-- ============================================================== -->
<!-- End Container fluid  -->


@endsection