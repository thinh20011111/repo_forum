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
                        <li class="breadcrumb-item text-muted active" aria-current="page">Niên khóa <span class="text-danger">({{ $school_year->id  }})</span></li>
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
                        <form method="post" action="{{ route('school_years.update', $school_year->id) }}">
                            @csrf
                            @method('PUT')
                            <div class="row">
                                <div class="col-md-2">
                                    <label for="inputCity" class="form-label">ID</label>
                                    <input type="text" readonly class="form-control" id="id_school_year" name="id_school_year" placeholder="" value="{{ $school_year->id }}">
                                </div>
                                <div class="col-md-5">
                                    <label for="inputCity" class="form-label">Năm</label>
                                    <input type="text" class="form-control" name="year" id="year" placeholder="Nhập thông tin..." value="{{ $school_year->year }}">
                                </div>
                                <div class="col-md-5">
                                    <label for="inputCity" class="form-label">Khóa</label>
                                    <input type="text" class="form-control" name="name" id="name" placeholder="Nhập thông tin..." value="{{ $school_year->name }}">
                                </div>
                            </div>
                            <div class="mt-3 float-end">
                                <button type="submit" id="save_school_year" class="btn btn-success rounded-circle btn-circle font-12 popover-item" title="Lưu niên khóa">
                                    <i data-feather="save"></i>
                                </button>
                                <button id="delete_school_year" class="btn btn-danger rounded-circle btn-circle font-12 popover-item" title="Xóa niên khóa" type="button">
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
        $('#delete_school_year').click(function() {
            var confirmation = confirm('Sau khi xóa niên khóa các bài viết liên quan sẽ bị gỡ, bạn có chắc chắn muốn xóa niên khóa này?');
            if (confirmation) {
                var schoolYearId = $('#id_school_year').val();
                $.ajax({
                    url: '/admin/school_years/delete/' + schoolYearId,
                    type: 'DELETE',
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    success: function(response) {
                        alert(response.message); // Hiển thị thông báo xóa thành công
                        window.location.href = '/admin/school_years'; // Redirect lại trang danh sách niên khóa
                    },
                    error: function(xhr) {
                        // Xử lý lỗi khi xóa niên khóa
                        console.log(xhr.responseText);
                        alert('Đã có lỗi xảy ra. Vui lòng thử lại sau.');
                    }
                });
            }
        });
    });
</script>

@endsection