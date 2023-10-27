@extends('admin.layout.master')

@section('title', 'Quản lý diễn đàn khoa CNTT - FITA VNUA || Thông tin người dùng')

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
                        <li class="breadcrumb-item text-muted active" aria-current="page">User: <span class="text-danger">{{ $user->id}}</span></li>
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
                    <div class="mt-4 activity">
                        <div class="d-flex align-items-start justify-content-center pb-3">
                            <div>
                                <a href="javascript:void(0)">
                                    <img src="front/img/users/{{ $user->avatar ?? 'default_user.png' }}" alt="user" class="btn btn-info btn-circle btn-item" style="width: 150px;height: 150px;object-fit: cover;margin: 0;">
                                </a>

                            </div>
                        </div>
                        <div class="fs-1 d-flex align-items-start justify-content-center pb-3">
                            {{ $user->name }}
                        </div>
                        <div class="d-flex align-items-start justify-content-center pb-3">
                            {{ $user->email }}
                        </div>
                        <div>
                            <div class="mb-3 row">
                                <label class="col-sm-2 col-form-label font-weight-bold">Ngày sinh</label>
                                <div class="col-sm-10">
                                    <input type="text" readonly class="form-control-plaintext" value="{{ $user->birthday ?? 'Trống'}}">
                                </div>
                            </div>
                            <div class="mb-3 row">
                                <label class="col-sm-2 col-form-label font-weight-bold">Địa chỉ</label>
                                <div class="col-sm-10">
                                    <input type="text" readonly class="form-control-plaintext" value="{{ $user->address ?? 'Trống'}}">
                                </div>
                            </div>
                            <div class="mb-3 row">
                                <label class="col-sm-2 col-form-label font-weight-bold">Giới tính</label>
                                <div class="col-sm-10 d-flex align-items-center">
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input border" disabled type="radio" name="gender" id="male" value="Nam" {{ $user->gender === 'Nam' ? 'checked' : ''  }}>
                                        <label class="form-check-label" for="male">Nam</label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input border" disabled type="radio" name="gender" id="female" value="Nữ" {{ $user->gender === 'Nữ' ? 'checked' : ''  }}>
                                        <label class="form-check-label" for="female">Nữ</label>
                                    </div>
                                </div>
                            </div>
                            <div class="mb-3 row">
                                <label class="col-sm-2 col-form-label font-weight-bold">Số điện thoại</label>
                                <div class="col-sm-10">
                                    <input type="text" readonly class="form-control-plaintext" value="{{ $user->phone ?? 'Trống'}}">
                                </div>
                            </div>
                            <div class="mb-3 row">
                                <label class="col-sm-2 col-form-label font-weight-bold">Lớp</label>
                                <div class="col-sm-10">
                                    <input type="text" readonly class="form-control-plaintext" value="{{ $user->class ?? 'Trống'}}">
                                </div>
                            </div>
                            <div class="mb-3 row">
                                <label class="col-sm-2 col-form-label font-weight-bold">Trạng thái</label>
                                <div class="col-sm-10 d-flex align-items-center">
                                    <i class="fa fa-circle text-{{ $user->status !== '0' ? 'success' : 'danger' }} font-12" data-bs-toggle="tooltip" data-placement="top" title="In Testing"> {{ $user->status !== '0' ? 'Online' : 'Offline' }}</i>
                                </div>
                            </div>
                            <div class="mb-3 row">
                                <label class="col-sm-2 col-form-label font-weight-bold">Vai trò</label>
                                <div class="col-sm-10 d-flex align-items-center">
                                    @if( $user->level == 0 )
                                    <span class="badge bg-danger text-white">Người kiểm duyệt</span>
                                    @elseif( $user->level == 1 )
                                    <span class="badge bg-success text-white">Giảng viên</span>
                                    @else
                                    <span class="badge bg-primary text-white">Sinh viên</span>
                                    @endif
                                </div>
                            </div>
                            <div class="mb-3 row">
                                <label class="col-sm-2 col-form-label font-weight-bold">Ngày tham gia</label>
                                <div class="col-sm-10 d-flex align-items-center">
                                    <input type="text" readonly class="form-control-plaintext" value="{{ $user->created_at ?? 'Trống' }}">
                                </div>
                            </div>
                        </div>
                        <div class="float-end">
                            <div class="popover-icon">
                                <a class="btn btn-cyan rounded-circle btn-circle font-12 popover-item" href="./admin/manage_users/edit_{{ $user->id }}">
                                    <i data-feather="edit-3"></i>
                                </a>
                                @if(Auth::user()->id != $user->id)
                                <a data-user-id="{{ $user->id }}" class="delete-user-btn btn btn-danger rounded-circle btn-circle font-12 popover-item">
                                    <i data-feather="trash-2"></i>
                                </a>
                                @endif
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
@endsection