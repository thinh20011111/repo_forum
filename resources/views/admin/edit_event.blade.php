@extends('admin.layout.master')

@section('title', 'Quản lý diễn đàn khoa CNTT - FITA VNUA || Chỉnh sửa sự kiện')

@section('body')
<!-- ============================================================== -->
<!-- Bread crumb and right sidebar toggle -->
<!-- ============================================================== -->
<div class="page-breadcrumb">
    <div class="row">
        <div class="col-7 align-self-center">
            <h4 class="page-title text-truncate text-dark font-weight-medium mb-1">Quản lý sự kiện</h4>
            <div class="d-flex align-items-center">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb m-0 p-0">
                        <li class="breadcrumb-item"><a href="./admin" class="text-muted">Trang chủ</a></li>
                        <li class="breadcrumb-item"><a href="./admin/manage_event" class="text-muted">Quản lý sự kiện</a></li>
                        <li class="breadcrumb-item text-muted active" aria-current="page">Chỉnh sửa sự kiện</li>
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
                    <div>
                        <a class="btn btn-cyan rounded-circle btn-circle font-12 popover-item" href="./admin/manage_event" title="Quay lại">
                            <i data-feather="arrow-left"></i>
                        </a>
                    </div>

                    <form method="post" action="admin/manage_event/edit_{{ $post->id }}" class="mt-4 activity" enctype="multipart/form-data">
                        @csrf
                        <div class="d-flex align-items-start justify-content-center -line pb-3">
                            <div>
                                <img id="img_event_preview" name="" src="front/img/event_post/{{ $post->image }}" alt="user" style="max-width: 300px; height: auto; margin: 0;">
                                <input type="file" name="image" id="image" style="display: none;">
                            </div>
                        </div>
                        @if($errors->any())
                        <div class="alert alert-danger">
                            <ul>
                                @foreach($errors->all() as $error)
                                <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                        @endif
                        <div>
                            <div class="mb-3 row">
                                <label class="col-sm-3 col-form-label font-weight-bold">Thời gian bắt đầu sự kiện</label>
                                <div class="col-sm-9">
                                    <input type="date" name="start_time" readonly class="form-control" value="{{ $post->created_at->format('Y-m-d') }}">
                                </div>
                            </div>
                            <div class="mb-3 row">
                                <label class="col-sm-3 col-form-label font-weight-bold">Thời gian kết thúc sự kiện</label>
                                <div class="col-sm-9">
                                    <input type="date" name="end_time" class="form-control" value="{{ old('end_time', $post->end_time_event ? \Carbon\Carbon::parse($post->end_time_event)->format('Y-m-d') : '') }}">
                                </div>
                            </div>
                            <div class="mb-3 row">
                                <label class="col-sm-3 col-form-label font-weight-bold">Tiêu đề</label>
                                <div class="col-sm-9">
                                    <input type="text" name="title" class="form-control" placeholder="Nhập tiêu đề sự kiện" value="{{ old('title') ?? $post->title }}" required />
                                </div>
                            </div>
                            <div class="mb-3 row">
                                <label class="col-sm-3 col-form-label font-weight-bold">Nội dung</label>
                                <div class="col-sm-9">
                                    <textarea class="" rows="2" placeholder="Nhập nội dung" id="content" name="content" required>{{ old('content') ?? $post->content }}</textarea>
                                </div>
                            </div>
                        </div>

                        <div class="float-end">
                            <div class="popover-icon">
                                <button type="submit" id="btn-create-user" class="btn btn-success rounded-circle btn-circle font-12 popover-item">
                                    <i data-feather="save"></i>
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
<script src="front/js/tinimce.js"></script>

<script>
    var imagePreview = document.getElementById('img_event_preview');
    var fileInput = document.getElementById('image');

    imagePreview.addEventListener('click', function() {
        // Kích hoạt sự kiện click cho input file ẩn
        fileInput.click();
    });

    // Xử lý sự kiện thay đổi file
    fileInput.addEventListener('change', function(event) {
        // Kiểm tra xem người dùng đã chọn file hay chưa
        if (event.target.files && event.target.files[0]) {
            var reader = new FileReader();

            // Đọc file hình ảnh và hiển thị nó
            reader.onload = function(e) {
                imagePreview.src = e.target.result;
            };

            reader.readAsDataURL(event.target.files[0]);
        }
    });
</script>
<!-- ============================================================== -->
<!-- End Container fluid  -->
@endsection