@extends('admin.layout.master')

@section('title', 'Quản lý diễn đàn khoa CNTT - FITA VNUA || Sự kiện')

@section('body')
<!-- ============================================================== -->
<!-- Bread crumb and right sidebar toggle -->
<!-- ============================================================== -->
<div class="page-breadcrumb">
    <div class="row">
        <div class="col-7 align-self-center">
            <h4 class="page-title text-truncate text-dark font-weight-medium mb-1">Quản lý sự kiện <span class="text-danger">({{ $posts->count() }})</span></h4>
            <div class="d-flex align-items-center">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb m-0 p-0">
                        <li class="breadcrumb-item"><a href="./admin" class="text-muted">Trang chủ</a></li>
                        <li class="breadcrumb-item text-muted active" aria-current="page">Quản lý sự kiện</li>
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
                    <div class="d-flex align-items-center mb-4">
                        <h4 class="card-title">Danh sách sự kiện</h4>
                        <div class="ms-auto">
                            <a class="btn btn-success rounded-circle btn-circle font-12 popover-item" title="Thêm sự kiện mới" href="./admin/manage_event/create_event">
                                <i data-feather="plus"></i>
                            </a>
                        </div>
                    </div>
                    @if(session('success'))
                    <div class="alert alert-success">
                        {{ session('success') }}
                    </div>
                    @endif
                    <div class="customize-input border rounded-pill">
                        <input id="searchInput" class="form-control custom-shadow custom-radius border-0 bg-white" type="search" placeholder="Tìm kiếm theo tên sự kiện" aria-label="Search">
                    </div>
                    <div id="searchResultsEvents" class="list-group p-2 overflow-auto" style="max-height: 250px;"></div>
                    <form class="row" method="get" action="./admin/manage_event/search_by_date">
                        <div class="mb-3 col-md-4">
                            <label class="col-form-label font-weight-bold">Từ ngày</label>
                            <div class="d-flex align-items-center">
                                <input type="date"  name="start_date" class="form-control" value="{{ request('start_date') }}">
                            </div>
                        </div>
                        <div class="mb-3 col-md-4">
                            <label class="col-form-label font-weight-bold">Đến ngày</label>
                            <div class="d-flex align-items-center">
                                <input type="date"  name="end_date" class="form-control" value="{{ request('end_date') }}">
                            </div>
                        </div>

                        <div class="mb-3 col-md-3 d-flex justify-content-center align-items-end">
                            <button id="searchButton" type="submit" class="w-100 btn btn-primary">Tìm kiếm</button>
                        </div>

                        <div class="mb-3 col-md-1 d-flex justify-content-center align-items-end">
                            <a href="./admin/manage_event" title="Tải lại" class="btn"><span><i data-feather="rotate-ccw"></i></span></a>
                        </div>
                    </form>
                    <div class="tab-pane fade show active">
                        <div id="searchResultsContainer" class="list-group mb-3">
                            @if($posts->count() > 0)
                            @foreach($posts as $post)
                            <a href="./admin/manage_event/event_{{ $post->id }}" class="list-group-item list-group-item-action">
                                <div class="media d-flex justify-content-start">
                                    <div class="px-2">
                                        <img src="front/img/users/{{ $post->user->avatar ?? 'default_user.png' }}" alt="user" class="rounded-circle w-20" style="width: 40px;height: 40px;object-fit: cover;">
                                    </div>
                                    <div class="media-body overflow-hidden" style="width: 100%;">
                                        <p class="fw-medium">Tiêu đề: <span title="{{ $post->subject_->name ?? '' }}" class="badge bg-{{ collect(['primary', 'secondary', 'success', 'danger', 'warning', 'info', 'dark'])->random()}} text-white tag-subject">{{ $post->subject_->name ?? '' }}</span> {{ $post->title ?? 'Trống' }}</p>
                                        <p>Người đăng: {{ $post->user->name }} <span>{{$post->school_year ? '. K'.$post->school_year_->name : ''}}</span> <span>{{$post->specialized ? '. '.$post->specialized_->name : ''}}</span> . <span>{{ formatTime($post->created_at) }}</span></p>
                                        <p>Thời gian kết thúc: {{ $post->end_time_event }}</p>
                                        <p><i class="fa-solid fa-thumbs-up"></i> : {{ $post->like_count ?? 0 }}<span> . <i class="fa-sharp fa-solid fa-comments"></i></span> : {{ $post->comment_count ?? 0 }} . <span><i class="fa-solid fa-eye"></i></span> : {{ $post->view_count ?? 0 }}</p>
                                    </div>
                                    <h6 class="message-title mb-0 mt-1 float-end"><span class="badge bg-info">Event</span></h6>
                                </div>
                            </a>
                            @endforeach
                            @else
                            <div class="alert alert-info">
                                Không tìm thấy sự kiện nào.
                            </div>
                            @endif
                        </div>
                        <br>
                        <div>
                            {{ $posts->links() }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
</div>
<!-- ============================================================== -->
<!-- End Container fluid  -->
<script>

</script>

@endsection