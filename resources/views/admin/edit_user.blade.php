@extends('admin.layout.master')

@section('title', 'Quản lý diễn đàn khoa CNTT - FITA VNUA || Chỉnh sửa thông tin')

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
                        <li class="breadcrumb-item"><a href="./admin/manage_users/user_{{ $user->id }}" class="text-muted">User: <span class="text-danger">{{ $user->id}}</a></li>
                        <li class="breadcrumb-item text-muted active" aria-current="page">Chỉnh sửa thông tin</li>
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
                        <a class="btn btn-cyan rounded-circle btn-circle font-12 popover-item" href="./admin/manage_users/user_{{ $user->id }}" title="Quay lại">
                            <i data-feather="arrow-left"></i>
                        </a>
                    </div>

                    <form method="post" action="" class="mt-4 activity" enctype="multipart/form-data">
                        @csrf

                        <div class="d-flex align-items-start justify-content-center -line pb-3">
                            <div>
                                <img id="image-user-preview" name="" src="front/img/users/{{ $user->avatar ?? 'default_user.png' }}" alt="user" class="btn btn-info btn-circle btn-item" style="width: 150px;height: 150px;object-fit: cover;margin: 0;">
                                <input type="file" name="avatar" id="avatar" style="display: none;">
                            </div>
                        </div>
                        <div class="d-flex align-items-start justify-content-center pb-3">
                            {{ $user->email }}
                        </div>
                        <div>
                            <div class="mb-3 row">
                                <label class="col-sm-2 col-form-label font-weight-bold">Tên</label>
                                <div class="col-sm-10">
                                    <input placeholder="Nhập thông tin ..." type="text" id="username" name="username" class="form-control" value="{{ old('username', $user->name) }}">
                                </div>
                            </div>
                            <div class="mb-3 row">
                                <label class="col-sm-2 col-form-label font-weight-bold">Ngày sinh</label>
                                <div class="col-sm-10">
                                    <input type="date" id="birthday" name="birthday" class="form-control" value="{{ old('birthday', $user->birthday ? \Carbon\Carbon::parse($user->birthday)->format('Y-m-d') : '') }}">
                                </div>
                            </div>
                            <div class="mb-3 row">
                                <label class="col-sm-2 col-form-label font-weight-bold">Địa chỉ</label>
                                <div class="col-sm-10">
                                    <input placeholder="Nhập thông tin ..." type="text" id="address" name="address" class="form-control" value="{{ old('address', $user->address) }}">
                                </div>
                            </div>
                            <div class="mb-3 row">
                                <label class="col-sm-2 col-form-label font-weight-bold">Giới tính</label>
                                <div class="col-sm-10 d-flex align-items-center">
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input" type="radio" name="gender" id="male" value="Nam" {{ (old('gender', $user->gender) === 'Nam') ? 'checked' : '' }}>
                                        <label class="form-check-label" for="male">Nam</label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input" type="radio" name="gender" id="female" value="Nữ" {{ (old('gender', $user->gender) === 'Nữ') ? 'checked' : '' }}>
                                        <label class="form-check-label" for="female">Nữ</label>
                                    </div>
                                </div>
                            </div>
                            <div class="mb-3 row">
                                <label class="col-sm-2 col-form-label font-weight-bold">Số điện thoại</label>
                                <div class="col-sm-10">
                                    <input placeholder="Nhập thông tin ..." type="text" id="phone" name="phone" class="form-control" value="{{ old('phone', $user->phone) }}">
                                    @error('phone')
                                    <small class="text-danger">{{ $message }}</small>
                                    @enderror
                                </div>
                            </div>
                            <div class="mb-3 row">
                                <label class="col-sm-2 col-form-label font-weight-bold">Lớp</label>
                                <div class="col-sm-10">
                                    <input placeholder="Nhập thông tin ..." type="text" id="className" name="className" class="form-control" value="{{ old('className', $user->class) }}">
                                </div>
                            </div>
                            <div class="mb-3 row">
                                <label class="col-sm-2 col-form-label font-weight-bold">Trạng thái</label>
                                <div class="col-sm-10 d-flex align-items-center">
                                    <i class="fa fa-circle text-{{ ($user->status !== '0') ? 'success' : 'danger' }} font-12" data-bs-toggle="tooltip" data-placement="top" title="In Testing"> Offline</i>
                                </div>
                            </div>
                            <div class="mb-3 row">
                                <label class="col-sm-2 col-form-label font-weight-bold">Vai trò</label>
                                <div class="col-sm-10 d-flex align-items-center">
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input" type="radio" name="role" id="admin" value="0" {{ (old('role', $user->level) == 0) ? 'checked' : '' }}>
                                        <label class="form-check-label" for="male"><span class="badge bg-danger text-white">Người kiểm duyệt</span></label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input" type="radio" name="role" id="teacher" value="1" {{ (old('role', $user->level) == 1) ? 'checked' : '' }}>
                                        <label class="form-check-label" for="female"><span class="badge bg-success text-white">Giảng viên</span></label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input" type="radio" name="role" id="student" value="2" {{ (old('role', $user->level) == 2) ? 'checked' : '' }}>
                                        <label class="form-check-label" for="female"><span class="badge bg-primary  text-white">Sinh viên</span></label>
                                    </div>
                                </div>
                            </div>
                            <div class="mb-3 row">
                                <label class="col-sm-2 col-form-label font-weight-bold">Ngày tham gia</label>
                                <div class="col-sm-10 d-flex align-items-center">
                                    <input type="date" id="date_join" name="date_join" class="form-control" value="{{ old('date_join', $user->created_at ? \Carbon\Carbon::parse($user->created_at)->format('Y-m-d') : '') }}">
                                </div>
                            </div>
                        </div>

                        <div class="float-end">
                            <div class="popover-icon">
                                <button type="submit" id="btn-update-user" class="btn btn-success rounded-circle btn-circle font-12 popover-item">
                                    <i data-feather="save"></i>
                                </button>
                                @if(Auth::user()->id != $user->id)
                                <button data-user-id="{{ $user->id }}" type="button" class="delete-user-btn btn btn-danger rounded-circle btn-circle font-12 popover-item">
                                    <i data-feather="trash-2"></i>
                                </button>
                                @endif
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- ============================================================== -->
<!-- End Container fluid  -->
@endsection