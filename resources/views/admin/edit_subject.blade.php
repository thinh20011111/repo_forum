@extends('admin.layout.master')

@section('title', 'Quản lý diễn đàn khoa CNTT - FITA VNUA || Cập nhật môn học')

@section('body')
<!-- ============================================================== -->
<!-- Bread crumb and right sidebar toggle -->
<!-- ============================================================== -->
<div class="page-breadcrumb">
    <div class="row">
        <div class="col-7 align-self-center">
            <h4 class="page-title text-truncate text-dark font-weight-medium mb-1">Cập nhật môn học</h4>
            <div class="d-flex align-items-center">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb m-0 p-0">
                        <li class="breadcrumb-item"><a href="./admin" class="text-muted">Trang chủ</a></li>
                        <li class="breadcrumb-item"><a href="./admin/manage_subject" class="text-muted">Quản lý môn học</a></li>
                        <li class="breadcrumb-item text-muted active" aria-current="page">Môn học: <span class="text-danger">({{ $subject->name  }})</span></li>
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
                    @if(session('error'))
                    <div class="alert alert-danger" role="alert">
                        {{ session('error') }}
                    </div>
                    @endif
                    <div class="nav-link">
                        <div>
                            <a class="btn btn-cyan rounded-circle btn-circle font-12 popover-item" href="./admin/manage_subject" title="Quay lại">
                                <i data-feather="arrow-left"></i>
                            </a>
                        </div>
                        <br>
                        <form method="post" action="./admin/manage_subject/subject_{{ $subject->id }}">
                            @csrf
                            @method('PUT')
                            <div class="row">
                                <div class="col-md-2">
                                    <label for="inputCity" class="form-label">ID</label>
                                    <input type="text" readonly id="subject_id" class="form-control" value="{{ $subject->id }}">
                                </div>
                                <div class="col-md-10">
                                    <label for="inputCity" class="form-label">Tên môn học</label>
                                    <input type="text" required class="form-control" name="subject_name" id="subject_name" placeholder="Nhập thông tin..." value="{{ $subject->name }}">
                                </div>
                            </div>
                            <div class="mt-3 float-end">
                                <button type="submit" id="save_school_year" class="btn btn-success rounded-circle btn-circle font-12 popover-item" title="Lưu môn học">
                                    <i data-feather="save"></i>
                                </button>
                                <button id="delete_subject" class="btn btn-danger rounded-circle btn-circle font-12 popover-item" title="Xóa môn học" type="button">
                                    <i data-feather="trash-2"></i>
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- ============================================================== -->
<!-- End Container fluid  -->
<script>
    document.addEventListener('DOMContentLoaded', function() {
        $('#delete_subject').click(function() {
            var confirmation = confirm('Khi xóa môn học này các bài viết liên quan sẽ được gỡ, bạn có chắc chắn muốn xóa môn học này?');
            if (confirmation) {
                var subject_id = $('#subject_id').val();
                $.ajax({
                    url: '/admin/manage_subject/delete_' + subject_id,
                    type: 'DELETE',
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    success: function(response) {
                        alert(response.message); // Hiển thị thông báo xóa thành công
                        window.location.href = '/admin/manage_subject'; // Redirect lại trang danh sách môn học
                    },
                    error: function(xhr) {
                        // Xử lý lỗi khi xóa môn học
                        console.log(xhr.responseText);
                        alert('Đã có lỗi xảy ra. Vui lòng thử lại sau.');
                    }
                });
            }
        });
    });
</script>

@endsection