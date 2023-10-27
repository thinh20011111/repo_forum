@extends('admin.layout.master')

@section('title', 'Quản lý diễn đàn khoa CNTT - FITA VNUA || Trang chủ')

@section('body')
<!-- ============================================================== -->
<!-- Bread crumb and right sidebar toggle -->
<!-- ============================================================== -->
<div class="page-breadcrumb">
    <div class="row">
        <div class="col-7 align-self-center">
            <h4 class="page-title text-truncate text-dark font-weight-medium mb-1">Quản lý chung</h4>
            <div class="d-flex align-items-center">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb m-0 p-0">
                        <li class="breadcrumb-item text-muted active" aria-current="page">Trang chủ</li>
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
        <div class="col-md-6 col-lg-4">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title">Top like <span class="text-primary float-end"><i data-feather="thumbs-up"></i></span></h4>
                    <div class="mt-4 activity">
                        @foreach($top_like as $key => $user)
                        <div class="d-flex align-items-start border-left-line pb-3">
                            <div>
                                <a href="javascript:void(0)">
                                    <img src="front/img/users/{{ $user->avatar ?? 'default_user.png' }}" alt="user" class="btn btn-{{ ($key == 0) ? 'danger' : (($key == 1) ? 'success' : 'light') }} btn-circle btn-item" style="width: {{ ($key == 0) ? '80px' : (($key == 1) ? '60px' : '50px') }}; height: {{ ($key == 0) ? '80px' : (($key == 1) ? '60px' : '50px') }}; object-fit: cover;">
                                </a>
                            </div>
                            <div class="ms-3 mt-2">
                                <h5 class="text-dark font-weight-medium mb-2">
                                    {{ $user->name }}
                                </h5>
                                <p class="font-14 mb-2 text-muted">
                                    {{$user->total_likes }} <span><i data-feather="thumbs-up"></i></span>
                                </p>
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-6 col-lg-4">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title">Top comment <span class="text-warning float-end"><i data-feather="message-circle"></i></span></h4>
                    <div class="mt-4 activity">
                        @foreach($top_comment as $key => $user)
                        <div class="d-flex align-items-start border-left-line pb-3">
                            <div>
                                <a href="javascript:void(0)">
                                    <img src="front/img/users/{{ $user->avatar ?? 'default_user.png' }}" alt="user" class="btn btn-{{ ($key == 0) ? 'danger' : (($key == 1) ? 'success' : 'light') }} btn-circle btn-item" style="width: {{ ($key == 0) ? '80px' : (($key == 1) ? '60px' : '50px') }}; height: {{ ($key == 0) ? '80px' : (($key == 1) ? '60px' : '50px') }}; object-fit: cover;">
                                </a>
                            </div>
                            <div class="ms-3 mt-2">
                                <h5 class="text-dark font-weight-medium mb-2">
                                    {{ $user->name }}
                                </h5>
                                <p class="font-14 mb-2 text-muted">
                                    {{$user->total_comment }} <span><i data-feather="message-circle"></i></span>
                                </p>
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-6 col-lg-4">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title">Top bài viết <span class="text-secondary float-end"><i data-feather="trello"></i></span></h4>
                    <div class="mt-4 activity">
                        @foreach($top_post as $key => $user)
                        <div class="d-flex align-items-start border-left-line pb-3">
                            <div>
                                <a href="javascript:void(0)">
                                    <img src="front/img/users/{{ $user->avatar ?? 'default_user.png' }}" alt="user" class="btn btn-{{ ($key == 0) ? 'danger' : (($key == 1) ? 'success' : 'light') }} btn-circle btn-item" style="width: {{ ($key == 0) ? '80px' : (($key == 1) ? '60px' : '50px') }}; height: {{ ($key == 0) ? '80px' : (($key == 1) ? '60px' : '50px') }}; object-fit: cover;">
                                </a>
                            </div>
                            <div class="ms-3 mt-2">
                                <h5 class="text-dark font-weight-medium mb-2">
                                    {{ $user->name }}
                                </h5>
                                <p class="font-14 mb-2 text-muted">
                                    {{$user->total_posts }} <span><i data-feather="trello"></i></span>
                                </p>
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <div class="row">
                        <!-- Column -->
                        <a href="./admin/manage_posts" class="col-md-6 col-lg-3 col-xlg-3">
                            <div class="card card-hover">
                                <div class="p-2 bg-primary text-center">
                                    <h1 class="font-light text-white">{{ format_number($post_count) }}</h1>
                                    <h6 class="text-white">Bài viết</h6>
                                </div>
                            </div>
                        </a>
                        <!-- Column -->
                        <a href="./admin/manage_users" class="col-md-6 col-lg-3 col-xlg-3">
                            <div class="card card-hover">
                                <div class="p-2 bg-cyan text-center">
                                    <h1 class="font-light text-white">{{ format_number($user_count) }}</h1>
                                    <h6 class="text-white">Người dùng</h6>
                                </div>
                            </div>
                        </a>
                        <!-- Column -->
                        <a href="./admin/manage_reports/comments" class="col-md-6 col-lg-3 col-xlg-3">
                            <div class="card card-hover">
                                <div class="p-2 bg-success text-center">
                                    <h1 class="font-light text-white">{{ format_number($report_comments) }}</h1>
                                    <h6 class="text-white">Báo cáo bình luận</h6>
                                </div>
                            </div>
                        </a>
                        <!-- Column -->
                        <a href="./admin/manage_reports/posts" class="col-md-6 col-lg-3 col-xlg-3">
                            <div class="card card-hover">
                                <div class="p-2 bg-danger text-center">
                                    <h1 class="font-light text-white">{{ format_number($report_posts) }}</h1>
                                    <h6 class="text-white">Báo cáo bài viết</h6>
                                </div>
                            </div>
                        </a>
                        <!-- Column -->
                    </div>
                    <div class="nav-link">
                        <form>
                            <div class="customize-input border rounded-pill">
                                <input id="searchInput" class="form-control custom-shadow custom-radius border-0 bg-white" type="search" placeholder="Tìm kiếm người dùng" aria-label="Search">
                            </div>
                        </form>
                        <div id="searchResults" class="list-group p-2 overflow-auto" style="max-height: 250px;">

                        </div>
                    </div>
                    <div class="table-responsive">

                        <div class="d-flex align-items-center mb-4">
                            <h4 class="card-title">Danh sách người dùng</h4>
                            <div class="ms-auto">
                                <div class="dropdown sub-dropdown">
                                    <button class="btn btn-link text-muted dropdown-toggle" type="button" id="dd1" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                        <i data-feather="more-vertical"></i>
                                    </button>
                                    <div class="dropdown-menu dropdown-menu-right" aria-labelledby="dd1">
                                        <a class="dropdown-item" href="#">Thêm người dùng mới</a>

                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="table-responsive">
                            <table class="table no-wrap v-middle mb-0">
                                <thead>
                                    <tr class="border-0">
                                        <th class="border-0 font-14 font-weight-medium text-muted">Người dùng
                                        </th>
                                        <th class="border-0 font-14 font-weight-medium text-muted text-center">
                                            Giảng viên/Sinh viên
                                        </th>
                                        </th>
                                        <th class="border-0 font-14 font-weight-medium text-muted text-center">
                                            Trạng thái
                                        </th>
                                        <th class="border-0 font-14 font-weight-medium text-muted text-center">
                                            Bài viết
                                        </th>
                                        <th class="border-0 font-14 font-weight-medium text-muted text-center">
                                            Báo cáo
                                        </th>
                                        <th class="border-0 font-14 font-weight-medium text-muted text-center">
                                            Sinh nhật
                                        </th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($users as $user)
                                    @if($user->id != Auth::user()->id)
                                    <tr>
                                        <td class="border-top-0 px-2 py-4">
                                            <div class="d-flex no-block align-items-center">
                                                <div class="me-3"><img src="front/img/users/{{ $user->avatar ?? 'default_user.png' }}" alt="user" class="rounded-circle" style="width: 40px;height: 40px;object-fit: cover;" /></div>
                                                <div class="">
                                                    <h5 class="text-dark mb-0 font-16 font-weight-medium">{{ $user->name }}</h5>
                                                    <span class="text-muted font-14">{{ $user->email }}</span>
                                                </div>
                                            </div>
                                        </td>
                                        <td class="border-top-0 text-center font-weight-medium text-muted px-2 py-4">
                                            @if( $user->level == 0 )
                                            <span class="badge bg-danger text-white">Người kiểm duyệt</span>
                                            @elseif( $user->level == 1 )
                                            <span class="badge bg-success text-white">Giảng viên</span>
                                            @else
                                            <span class="badge bg-primary text-white">Sinh viên</span>
                                            @endif
                                        </td>
                                        <td class="border-top-0 text-center px-2 py-4"><i class="fa fa-circle text-{{ $user->status !== '0' ? 'success' : 'danger' }} font-12" data-bs-toggle="tooltip" data-placement="top" title="In Testing"></i></td>
                                        <td class="border-top-0 text-center font-weight-medium text-muted px-2 py-4">
                                            {{ format_number($user->posts->count()) }}
                                        </td>
                                        <td class="border-top-0 text-center font-weight-medium text-muted px-2 py-4">
                                            {{ format_number($user->reports->count()) }}
                                        </td>
                                        <td class="border-top-0 text-center font-weight-medium text-muted px-2 py-4">
                                            @if($user->birthday && date('Y-m-d', strtotime($user->birthday)) == date('Y-m-d'))
                                            <img src="dashboard/assets/images/birthday.gif" style="width: 30px;" alt="">
                                            @else
                                            Trống
                                            @endif
                                        </td>

                                    </tr>
                                    @endif
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <br>
                    <div>
                        {{ $users->links() }}
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