@extends('admin.layout.master')

@section('title', 'Quản lý diễn đàn khoa CNTT - FITA VNUA || Quản lý binh luận')

@section('body')
<!-- ============================================================== -->
<!-- Bread crumb and right sidebar toggle -->
<!-- ============================================================== -->
<div class="page-breadcrumb">
    <div class="row">
        <div class="col-7 align-self-center">
            <h4 class="page-title text-truncate text-dark font-weight-medium mb-1">Quản lý báo cáo bình luận <span class="text-danger">({{ $report_count }})</span></h4>
            <div class="d-flex align-items-center">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb m-0 p-0">
                        <li class="breadcrumb-item"><a href="./admin" class="text-muted">Trang chủ</a></li>
                        <li class="breadcrumb-item text-muted active" aria-current="page">Quản lý báo cáo bình luận</li>
                    </ol>
                </nav>
            </div>
        </div>
    </div>
</div>
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
                        <h4 class="card-title">Danh sách báo cáo</h4>
                    </div>
                    <div class="table-responsive">
                        <div class="nav-link float-end">
                            <form class="d-flex justify-content-start" method="">
                                <div class="customize-input border rounded-pill">
                                    <input id="search_report" name="search_report" class="form-control custom-shadow custom-radius border-0 bg-white" type="search" placeholder="Tìm kiếm theo tên người gửi báo cáo" aria-label="Search" value="{{request('search_report')}}">
                                </div>
                                <button class="mx-2 btn btn-primary rounded-pill">Tìm kiếm</button>
                            </form>
                        </div>
                        <table class="table no-wrap v-middle mb-0">
                            <thead>
                                <tr class="border-0">
                                    <th class="border-0 font-14 font-weight-medium text-muted">Người báo cáo
                                    </th>
                                    <th class="border-0 font-14 font-weight-medium text-muted">Người bình luận
                                    </th>
                                    <th class="border-0 font-14 font-weight-medium text-muted text-center">
                                        ID bài đăng
                                    </th>
                                    <th class="border-0 font-14 font-weight-medium text-muted text-center">
                                        Thời gian
                                    </th>
                                    <th class="border-0 font-14 font-weight-medium text-muted text-center">Hành động</th>
                                </tr>
                            </thead>
                            <tbody>
                                @if (empty($reports))
                                <tr class="alert alert-info">
                                    <td colspan="5">
                                        Không tìm thấy báo cáo nào.
                                    </td>
                                </tr>
                                @else
                                @foreach($reports as $report)
                                <tr>
                                    <td class="border-top-0 px-2 py-4">
                                        <div class="d-flex no-block align-items-center">
                                            <div class="me-3"><img src="front/img/users/{{ $report->owner->avatar ?? 'default_user.png' }}" alt="user" class="rounded-circle" style="width: 40px;height: 40px;object-fit: cover;" /></div>
                                            <div>
                                                <h5 class="text-dark mb-0 font-16 font-weight-medium">{{ $report->owner->name }}</h5>
                                                <span class="text-muted font-14">{{ $report->owner->email  }}</span>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="border-top-0 px-2 py-4">
                                        <div class="d-flex no-block align-items-center">
                                            <div class="me-3"><img src="front/img/users/{{ $report->user_report->avatar ?? 'default_user.png' }}" alt="user" class="rounded-circle" style="width: 40px;height: 40px;object-fit: cover;" /></div>
                                            <div>
                                                <h5 class="text-dark mb-0 font-16 font-weight-medium">{{ $report->user_report->name }}</h5>
                                                <span class="text-muted font-14">{{ $report->user_report->email }}</span>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="border-top-0 text-center font-weight-medium text-muted px-2 py-4">
                                        {{ $report->post_id }}
                                    </td>
                                    <td class="border-top-0 text-center font-weight-medium text-muted px-2 py-4">
                                        {{ $report->created_at }}
                                    </td>
                                    <td class="border-top-0 px-2 py-4 text-center">
                                        <div class="popover-icon">
                                            <a title="Xem chi tiết" class="btn btn-primary rounded-circle btn-circle font-12" href="./admin/manage_reports/posts/report_{{ $report->id }}">
                                                <i class="fa-solid fa-eye"></i>
                                            </a>
                                        </div>
                                    </td>
                                </tr>
                                @endforeach
                                <tr>
                                    <td colspan="5">
                                        {{$reports->links()}}
                                    </td>
                                </tr>
                                @endif
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection