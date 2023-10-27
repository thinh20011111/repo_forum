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
                    <div class="d-flex align-items-center mb-4">
                        <h4 class="card-title">Danh sách các khóa</h4>
                        <div class="ms-auto">
                            <a id="add_school_year" class="btn btn-success rounded-circle btn-circle font-12 popover-item" title="Thêm niên khóa" href="./admin/school_years/add">
                                <i data-feather="plus" class="text-white"></i>
                            </a>
                        </div>
                    </div>
                    @if(session('success'))
                    <div class="alert alert-success">
                        {{ session('success') }}
                    </div>
                    @endif
                    <div class="table-responsive">
                        <table class="table no-wrap v-middle mb-0">
                            <thead>
                                <tr class="border-0">
                                    <th class="border-0 font-14 font-weight-medium text-muted text-center">ID
                                    </th>
                                    <th class="border-0 font-14 font-weight-medium text-muted text-center">
                                        Năm
                                    </th>
                                    </th>
                                    <th class="border-0 font-14 font-weight-medium text-muted text-center">
                                        Khóa
                                    </th>
                                    <th class="border-0 font-14 font-weight-medium text-muted text-center">Chỉnh sửa</th>
                                </tr>
                            </thead>
                            <tbody id="table_school_year">
                                @foreach($school_years as $year)
                                <tr>
                                    <td class="border-top-0 text-center px-2 py-4 text-muted ">
                                        {{$year->id}}
                                    </td>
                                    <td class="border-top-0 text-center font-weight-medium text-muted px-2 py-4">
                                        {{$year->year}}
                                    </td>
                                    <td class="border-top-0 text-center font-weight-medium text-muted px-2 py-4">
                                        {{$year->name}}
                                    </td>
                                    <td class="border-top-0 px-2 py-4 text-center">
                                        <div class="popover-icon">
                                            <a title="Chỉnh sửa thông tin" data-id="{{ $year->id }}" data-year="{{ $year->year }}" data-name="{{ $year->name }}" class="btn btn-cyan rounded-circle btn-circle font-12 popover-item edit-button" href="./admin/school_years/update_{{ $year->id }}">
                                                <i data-feather="edit-3"></i>
                                            </a>
                                        </div>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    <br>
                    <div>
                        {{ $school_years->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- ============================================================== -->
<!-- End Container fluid  -->

@endsection