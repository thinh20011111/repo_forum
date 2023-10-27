@extends('admin.layout.master')

@section('title', 'Quản lý diễn đàn khoa CNTT - FITA VNUA || Thêm người dùng mới')

@section('body')
<!-- ============================================================== -->
<!-- Bread crumb and right sidebar toggle -->
<!-- ============================================================== -->
<div class="page-breadcrumb">
    <div class="row">
        <div class="col-7 align-self-center">
            <h4 class="page-title text-truncate text-dark font-weight-medium mb-1">Quản lý người dùng</h4>
            <div class="d-flex align-items-center">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb m-0 p-0">
                        <li class="breadcrumb-item"><a href="./admin" class="text-muted">Trang chủ</a></li>
                        <li class="breadcrumb-item"><a href="./admin/manage_users" class="text-muted">Quản lý người dùng</a></li>
                        <li class="breadcrumb-item text-muted active" aria-current="page">Thêm thành viên mới</li>
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
                        <a class="btn btn-cyan rounded-circle btn-circle font-12 popover-item" href="./admin/manage_users" title="Quay lại">
                            <i data-feather="arrow-left"></i>
                        </a>
                    </div>

                    <form method="post" action="" class="mt-4 activity" enctype="multipart/form-data">
                        @csrf
                        @if($errors->any())
                        <div class="alert alert-danger">
                            <ul>
                                @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                        @endif
                        <div class="d-flex align-items-start justify-content-center -line pb-3">
                            <div>
                                <img id="image-user-preview" name="" src="front/img/users/default_user.png" alt="user" class="btn btn-info btn-circle btn-item" style="width: 150px;height: 150px;object-fit: cover;margin: 0;">
                                <input type="file" name="avatar" id="avatar" style="display: none;">
                            </div>
                        </div>
                        <div>
                            <div class="mb-3 row">
                                <label class="col-sm-2 col-form-label font-weight-bold">Email</label>
                                <div class="col-sm-10">
                                    <input placeholder="Nhập thông tin ..." type="email" id="email" name="email" class="form-control" value="{{ old('email') }}">
                                </div>
                            </div>
                            <div class="mb-3 row">
                                <label class="col-sm-2 col-form-label font-weight-bold">Mật khẩu</label>
                                <div class="col-sm-10">
                                    <input placeholder="Nhập thông tin ..." type="password" id="password" name="password" class="form-control">
                                </div>
                            </div>
                            <div class="mb-3 row">
                                <label class="col-sm-2 col-form-label font-weight-bold">Nhập lại mật khẩu</label>
                                <div class="col-sm-10">
                                    <input placeholder="Nhập thông tin ..." type="password" id="password_confirmation" name="password_confirmation" class="form-control">
                                </div>
                            </div>
                            <div class="mb-3 row">
                                <label class="col-sm-2 col-form-label font-weight-bold">Tên</label>
                                <div class="col-sm-10">
                                    <input placeholder="Nhập thông tin ..." type="text" id="username" name="username" class="form-control" value="{{ old('username') }}">
                                </div>
                            </div>
                            <div class="mb-3 row">
                                <label class="col-sm-2 col-form-label font-weight-bold">Ngày sinh</label>
                                <div class="col-sm-10">
                                    <input type="date" id="birthday" name="birthday" class="form-control" value="{{ old('birthday') }}">
                                </div>
                            </div>
                            <div class="mb-3 row">
                                <label class="col-sm-2 col-form-label font-weight-bold">Địa chỉ</label>
                                <div class="col-sm-10">
                                    <input placeholder="Nhập thông tin ..." type="text" id="address" name="address" class="form-control" value="{{ old('address') }}">
                                </div>
                            </div>
                            <div class="mb-3 row">
                                <label class="col-sm-2 col-form-label font-weight-bold">Giới tính</label>
                                <div class="col-sm-10 d-flex align-items-center">
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input" type="radio" name="gender" id="male" value="Nam" {{ (old('gender') === 'Nam') ? 'checked' : '' }}>
                                        <label class="form-check-label" for="male">Nam</label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input" type="radio" name="gender" id="female" value="Nữ" {{ (old('gender') === 'Nữ') ? 'checked' : '' }}>
                                        <label class="form-check-label" for="female">Nữ</label>
                                    </div>
                                </div>
                            </div>
                            <div class="mb-3 row">
                                <label class="col-sm-2 col-form-label font-weight-bold">Số điện thoại</label>
                                <div class="col-sm-10">
                                    <input placeholder="Nhập thông tin ..." type="text" id="phone" name="phone" class="form-control" value="{{ old('phone') }}">
                                    @error('phone')
                                    <small class="text-danger">{{ $message }}</small>
                                    @enderror
                                </div>
                            </div>
                            <div class="mb-3 row">
                                <label class="col-sm-2 col-form-label font-weight-bold">Lớp</label>
                                <div class="col-sm-10">
                                    <input placeholder="Nhập thông tin ..." type="text" id="className" name="className" class="form-control" value="{{ old('className') }}">
                                </div>
                            </div>
                            <div class="mb-3 row">
                                <label class="col-sm-2 col-form-label font-weight-bold">Vai trò</label>
                                <div class="col-sm-10 d-flex align-items-center">
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input" type="radio" name="role" id="admin" value="0" {{ (old('role') == 0) ? 'checked' : '' }}>
                                        <label class="form-check-label" for="male"><span class="badge bg-danger text-white">Người kiểm duyệt</span></label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input" type="radio" name="role" id="teacher" value="1" {{ (old('role') == 1) ? 'checked' : '' }}>
                                        <label class="form-check-label" for="female"><span class="badge bg-success text-white">Giảng viên</span></label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input" type="radio" name="role" id="student" value="2" {{ (old('role') == 2) ? 'checked' : '' }}>
                                        <label class="form-check-label" for="female"><span class="badge bg-primary  text-white">Sinh viên</span></label>
                                    </div>
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
<!-- <script src="dashboard/dist/js/script.js"></script> -->
<script>
    var imagePreview = document.getElementById('image-user-preview');
    var fileInput = document.getElementById('avatar');

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