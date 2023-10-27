@extends('admin.layout.master')

@section('title', 'Quản lý diễn đàn khoa CNTT - FITA VNUA || Cập nhật niên khóa')

@section('body')
<!-- ============================================================== -->
<!-- Bread crumb and right sidebar toggle -->
<!-- ============================================================== -->
<div class="page-breadcrumb">
    <div class="row">
        <div class="col-7 align-self-center">
            <h4 class="page-title text-truncate text-dark font-weight-medium mb-1">Niên khóa</h4>
            <div class="d-flex align-items-center">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb m-0 p-0">
                        <li class="breadcrumb-item"><a href="./admin" class="text-muted">Trang chủ</a></li>
                        <li class="breadcrumb-item"><a href="./admin/school_years" class="text-muted">Cập nhật niên khóa</a></li>
                        <li class="breadcrumb-item text-muted active" aria-current="page">Thêm niên khóa mới</li>
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
                    @if($errors->any())
                    <div class="alert alert-danger">
                        <ul>
                            @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                    @endif
                    <div class="nav-link">
                        <div>
                            <a class="btn btn-cyan rounded-circle btn-circle font-12 popover-item" href="./admin/school_years" title="Quay lại">
                                <i data-feather="arrow-left"></i>
                            </a>
                        </div>
                        <br>
                        <form method="post" action="">
                            @csrf
                            <div class="row">
                                <div class="col-md-6">
                                    <label for="inputCity" class="form-label">Năm</label>
                                    <input type="text" class="form-control" name="year" id="year" placeholder="Nhập thông tin...">
                                </div>
                                <div class="col-md-6">
                                    <label for="inputCity" class="form-label">Khóa</label>
                                    <input type="text" class="form-control" name="name" id="name" placeholder="Nhập thông tin...">
                                </div>
                            </div>
                            <div class="mt-3 float-end">
                                <button type="submit" class="btn btn-success rounded-circle btn-circle font-12 popover-item" title="Lưu niên khóa">
                                    <i data-feather="save"></i>
                                </button>
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