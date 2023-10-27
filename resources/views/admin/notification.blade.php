@extends('admin.layout.master')

@section('title', 'Quản lý diễn đàn khoa CNTT - FITA VNUA || Thông báo')

@section('body')
<!-- ============================================================== -->
<!-- Bread crumb and right sidebar toggle -->
<!-- ============================================================== -->
<div class="page-breadcrumb">
    <div class="row">
        <div class="col-7 align-self-center">
            <h4 class="page-title text-truncate text-dark font-weight-medium mb-1 total-notification">Thông báo (<span class="text-danger">{{ $notification_count }}</span>)</h4>
            <div class="d-flex align-items-center">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb m-0 p-0">
                        <li class="breadcrumb-item"><a href="./admin" class="text-muted">Trang chủ</a></li>
                        <li class="breadcrumb-item text-muted active" aria-current="page">Thông báo</li>
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
                    <div class="mt-4 activity">
                        <div class="message-center notifications position-relative list-notification-admin">
                            @if($notifications)
                            @foreach($notifications as $notification)
                            <a href="/admin/manage_reports/posts/report_{{ $notification->report_id }}" class="message-item d-flex align-items-center border-bottom px-3 py-2">
                                <img src="front/img/users/{{ $notification->owner->avatar ?? 'default_user.png' }}" alt="user" class="rounded-circle mb-2" style="width: 40px;height: 40px;object-fit: cover;">
                                <div class="w-100 d-inline-block v-middle ps-2">
                                    <h6 class="message-title mb-0 mt-1">{{ $notification->owner->name }}
                                        @if( $notification->status === 'new')
                                        <span class="float-end"><span class="badge bg-success">NEW</span></span>
                                        @endif
                                    </h6>
                                    <span class="font-12 text-nowrap d-block text-muted">{{ $notification->content }}</span>
                                    <span class="font-12 text-nowrap d-block text-muted">{{ formatTime($notification->created_at) }}</span>
                                </div>
                            </a>
                            @endforeach
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection