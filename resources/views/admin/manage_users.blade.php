@extends('admin.layout.master')

@section('title', 'Quản lý diễn đàn khoa CNTT - FITA VNUA || Quản lý người dùng')

@section('body')
<!-- ============================================================== -->
<!-- Bread crumb and right sidebar toggle -->
<!-- ============================================================== -->
<div class="page-breadcrumb">
    <div class="row">
        <div class="col-7 align-self-center">
            <h4 class="page-title text-truncate text-dark font-weight-medium mb-1">Quản lý người dùng <span class="text-danger">({{ $user_count}})</span></h4>
            <div class="d-flex align-items-center">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb m-0 p-0">
                        <li class="breadcrumb-item"><a href="./admin" class="text-muted">Trang chủ</a></li>
                        <li class="breadcrumb-item text-muted active" aria-current="page">Quản lý người dùng</li>
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
                        <h4 class="card-title">Danh sách người dùng</h4>
                        <div class="ms-auto">
                            <a class="btn btn-success rounded-circle btn-circle font-12 popover-item" title="Thêm người dùng mới" href="./admin/manage_users/create_user">
                                <i data-feather="plus"></i>
                            </a>
                        </div>
                    </div>
                    <div class="table-responsive">
                        <div class="nav-link">
                            <form>
                                <div class="customize-input border rounded-pill">
                                    <input id="searchInput" class="form-control custom-shadow custom-radius border-0 bg-white" type="search" placeholder="Search" aria-label="Search">
                                </div>
                            </form>
                            <div id="searchResults" class="list-group p-2 overflow-auto" style="max-height: 250px;">

                            </div>
                        </div>
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
                                    <th class="border-0 font-14 font-weight-medium text-muted text-center">Hành động</th>
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
                                    <td class="border-top-0 px-2 py-4 text-center">
                                        <div class="popover-icon">
                                            <a title="Xem chi tiết" class="btn btn-primary rounded-circle btn-circle font-12" href="./admin/manage_users/user_{{$user->id}}">
                                                <i class="fa-solid fa-eye"></i>
                                            </a>
                                            <a title="Chỉnh sửa thông tin" class="btn btn-cyan rounded-circle btn-circle font-12 popover-item" href="/admin/manage_users/edit_{{$user->id}}">
                                                <i data-feather="edit-3"></i>
                                            </a>
                                        </div>
                                    </td>
                                </tr>
                                @endif
                                @endforeach
                            </tbody>
                        </table>
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
<!-- ============================================================== -->
<!-- End Container fluid  -->
<script>

</script>

@endsection