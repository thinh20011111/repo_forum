@extends('admin.layout.master')

@section('title', 'Quản lý diễn đàn khoa CNTT - FITA VNUA || Quản lý môn học')

@section('body')
<!-- ============================================================== -->
<!-- Bread crumb and right sidebar toggle -->
<!-- ============================================================== -->
<div class="page-breadcrumb">
    <div class="row">
        <div class="col-7 align-self-center">
            <h4 class="page-title text-truncate text-dark font-weight-medium mb-1">Quản lý môn học <span class="text-danger">({{ $total }})</span></h4>
            <div class="d-flex align-items-center">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb m-0 p-0">
                        <li class="breadcrumb-item"><a href="./admin" class="text-muted">Trang chủ</a></li>
                        <li class="breadcrumb-item text-muted active" aria-current="page">Quản lý môn học</li>
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
                        <h4 class="card-title">Danh sách môn học</h4>
                        <div class="ms-auto">
                            <a class="btn btn-success rounded-circle btn-circle font-12 popover-item" title="Thêm người dùng mới" href="./admin/manage_subject/create_subject">
                                <i data-feather="plus"></i>
                            </a>
                        </div>
                    </div>
                    <div class="table-responsive">
                        @if(session('success'))
                        <div class="alert alert-success">
                            {{ session('success') }}
                        </div>
                        @endif
                        <div class="nav-link">
                            <form>
                                <div class="customize-input border rounded-pill">
                                    <input id="searchInput" class="form-control custom-shadow custom-radius border-0 bg-white" type="search" placeholder="Search" aria-label="Search">
                                </div>
                            </form>
                            <div id="searchResultsSubject" class="list-group p-2 overflow-auto" style="max-height: 250px;">

                            </div>
                        </div>
                        <table class="table no-wrap v-middle mb-0">
                            <thead>
                                <tr class="border-0">
                                    <th class="border-0 font-14 font-weight-medium text-muted text-center">ID
                                    </th>
                                    <th class="border-0 font-14 font-weight-medium text-muted">
                                        Tên môn học
                                    </th>
                                    <th class="border-0 font-14 font-weight-medium text-muted text-center">Hành động</th>
                                </tr>
                            </thead>
                            <tbody>
                                @if($subjects->count() > 0)
                                @foreach($subjects as $subject)
                                <tr>
                                    <td class="border-top-0 px-2 py-4 text-center">
                                        {{ $subject->id }}
                                    </td>
                                    <td class="border-top-0 font-weight-medium text-muted px-2 py-4">
                                        {{ $subject->name }}
                                    </td>
                                    <td class="border-top-0 px-2 py-4 text-center">
                                        <div class="popover-icon">
                                            <a title="Chỉnh sửa thông tin" class="btn btn-cyan rounded-circle btn-circle font-12 popover-item" href="admin/manage_subject/subject_{{ $subject->id }}">
                                                <i data-feather="edit-3"></i>
                                            </a>
                                        </div>
                                    </td>
                                </tr>
                                @endforeach
                                @else
                                <div class="alert alert-info">
                                    Không có môn học nào
                                </div>
                                @endif
                            </tbody>
                        </table>
                    </div>
                    <br>
                    <div>
                        {{ $subjects->links() }}
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