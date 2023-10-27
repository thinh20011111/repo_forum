@extends('front.profile.master')

@section('title', 'Diễn đàn khoa CNTT - FITA VNUA || Trang cá nhân')

@section('body')
@if(Auth::user()->id == $user->id)
<div class="central-meta">
    <ul class="nav nav-tabs" id="myTab" role="tablist">

        <li class="nav-item">
            <a class="nav-link active" id="profile-tab" data-toggle="tab" href="#profile" role="tab" aria-controls="profile" aria-selected="false">Thông tin cá nhân</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" id="password-tab" data-toggle="tab" href="#password" role="tab" aria-controls="home" aria-selected="true">Đổi mật khẩu</a>
        </li>

    </ul>
    <div class="tab-content" id="myTabContent">
        <div class="tab-pane fade show active pt-3" id="profile" role="tabpanel" aria-labelledby="profile-tab">
            <div class="mb-3 row">
                <label for="staticEmail" class="col-sm-2 col-form-label font-weight-bold">Email</label>
                <div class="col-sm-10">
                    <input type="text" readonly class="form-control-plaintext" id="staticEmail" value="{{ $user->email }}">
                </div>
            </div>
            <div class="mb-3 row">
                <label for="name" class="col-sm-2 col-form-label font-weight-bold">Tên</label>
                <div class="col-sm-10">
                    <input type="text" class="form-control" id="name" name="name" value="{{ old('name') ?? $user->name }}">
                </div>
            </div>
            <div class="mb-3 row">
                <label for="birthday" class="col-sm-2 col-form-label font-weight-bold">Ngày sinh</label>
                <div class="col-sm-10">
                    <input type="date" class="form-control" id="birthday" name="birthday" value="{{ old('birthday') ?? $user->birthday }}">
                </div>
            </div>
            <div class="mb-3 row">
                <label for="address" class="col-sm-2 col-form-label font-weight-bold">Địa chỉ</label>
                <div class="col-sm-10">
                    <input type="text" class="form-control" id="address" name="address" value="{{ old('address') ?? $user->address }}">
                </div>
            </div>
            <div class="mb-3 row">
                <label for="gender" class="col-sm-2 col-form-label font-weight-bold">Giói tính</label>
                <div class="col-sm-10 d-flex align-items-center">
                    <div class="form-check form-check-inline">
                        <input class="form-check-input" type="radio" name="gender" id="male" value="Nam" {{ $user->gender === 'Nam' ? 'checked' : ''  }}>
                        <label class="form-check-label" for="male">Nam</label>
                    </div>
                    <div class="form-check form-check-inline">
                        <input class="form-check-input" type="radio" name="gender" id="female" value="Nữ" {{ $user->gender === 'Nữ' ? 'checked' : ''  }}>
                        <label class="form-check-label" for="female">Nữ</label>
                    </div>
                </div>
            </div>
            <div class="mb-3 row">
                <label for="phoneNumber" class="col-sm-2 col-form-label font-weight-bold">Số điện thoại</label>
                <div class="col-sm-10">
                    <input type="tel" class="form-control" id="phoneNumber" name="phoneNumber" value="{{ $user->phone }}">
                    <span id="phoneNumber-error" class="text-danger"></span>
                </div>
            </div>
            <div class="mb-3 row">
                <label for="bio" class="col-sm-2 col-form-label font-weight-bold">Lớp</label>
                <div class="col-sm-10">
                    <input type="text" class="form-control" id="className" name="className" value="{{ $user->class }}">
                </div>
            </div>
            <form action="">
                <div class="attachments">
                    <button><a href="" id="btn-update-profile">Cập nhật thông tin cá nhân</a></button>
                </div>
            </form>
        </div>
        <div class="tab-pane fade pt-3" id="password" role="tabpanel" aria-labelledby="password-tab">
            <form method="post" action="">
                @csrf
                <div class="mb-3 row">
                    <label for="inputPassword" class="col-sm-2 col-form-label font-weight-bold">Mật khẩu</label>
                    <div class="col-sm-10">
                        <input type="password" class="form-control" id="inputPassword" name="password">
                        <div class="form-text">
                            <span>
                                <i id="btn_hide_password" class="fa-solid fa-eye" onclick="togglePasswordVisibility()"></i>
                                <p class="inline" id="text_hide_password">Hiển thị mật khẩu</p>
                            </span>
                        </div>
                        <span id="password-error" class="error-text text-danger"></span> <!-- Hiển thị lỗi mật khẩu -->
                    </div>
                </div>
                <div class="mb-3 row">
                    <label for="password_confirmation" class="col-sm-2 col-form-label font-weight-bold">Nhập lại mật khẩu</label>
                    <div class="col-sm-10">
                        <input type="password" class="form-control" id="password_confirmation" name="password_confirmation">
                        <span id="password-confirmation-error" class="error-text text-danger"></span> <!-- Hiển thị lỗi xác nhận mật khẩu -->
                    </div>
                </div>
                <div class="attachments">
                    <button id="btn-update-password">Đổi mật khẩu</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    function togglePasswordVisibility() {
        var passwordInput = document.getElementById("inputPassword");
        var passwordConfirm = document.getElementById("password_confirmation");
        var eyeIcon = document.getElementById("btn_hide_password");
        var text = document.getElementById("text_hide_passworđ");

        if (passwordInput.type === "password") {
            passwordInput.type = "text";
            passwordConfirm.type = "text";
            eyeIcon.classList.remove("fa-eye");
            eyeIcon.classList.add("fa-eye-slash");
            text.textContent = "Ẩn mật khẩu";
        } else {
            passwordInput.type = "password";
            passwordConfirm.type = "password";
            eyeIcon.classList.remove("fa-eye-slash");
            eyeIcon.classList.add("fa-eye");
            text.textContent = "Hiển thị mật khẩu";
        }
    }

    //Update infor
    $(document).ready(function() {
        // Bắt sự kiện click vào nút "Cập nhật thông tin cá nhân"
        $('#btn-update-profile').click(function(e) {
            e.preventDefault();

            // Lấy giá trị từ các trường input
            var name = $('#name').val();
            var birthday = $('#birthday').val();
            var address = $('#address').val();
            var gender = $('input[name="gender"]:checked').val();
            var phoneNumber = $('#phoneNumber').val();
            var className = $('#className').val();

            // Gửi yêu cầu Ajax
            $.ajax({
                url: './update_profie',
                method: 'POST',
                data: {
                    name: name,
                    birthday: birthday,
                    address: address,
                    gender: gender,
                    phoneNumber: phoneNumber,
                    className: className,
                    _token: '{{ csrf_token() }}'
                },
                success: function(response) {
                    if (response.success) {
                        $('#phoneNumber-error').addClass('d-none');
                        alert('Cập nhật thông tin cá nhân thành công.');
                        // Cập nhật lại thông tin trên view nếu cần thiết
                    } else if (response.errors) {
                        var errors = response.errors;
                        if (errors.phoneNumber) {
                            $('#phoneNumber-error').removeClass('d-none');
                            $('#phoneNumber-error').text(errors.phoneNumber[0]);
                        }
                    }
                },
                error: function(xhr, status, error) {
                    console.log(xhr.responseText);
                }
            });
        });
    });

    //Update password
    $(document).ready(function() {
        $('#btn-update-password').click(function(event) {
            event.preventDefault();

            var password = $('#inputPassword').val();
            var confirmation = $('#password_confirmation').val();

            $.ajax({
                url: './update_password',
                type: 'POST',
                data: {
                    password: password,
                    password_confirmation: confirmation,
                    _token: '{{ csrf_token() }}'
                },
                success: function(response) {
                    // Xóa bỏ thông báo lỗi cũ (nếu có)
                    $('#password-error').text('');
                    $('#password-confirmation-error').text('');

                    // Kiểm tra kết quả trả về từ server
                    if (response.error) {
                        // Hiển thị thông báo lỗi
                        if (response.error.password) {
                            $('#password-error').text(response.error.password[0]);
                        }
                        if (response.error.password_confirmation) {
                            $('#password-confirmation-error').text(response.error.password_confirmation[0]);
                        }
                    } else if (response.success) {
                        // Hiển thị thông báo thành công
                        alert(response.success);
                        $('#inputPassword').val('');
                        $('#password_confirmation').val('');
                        // Thực hiện các tác vụ khác (nếu cần)
                    }
                },
            });
        });
    });
</script>
@else
<div class="central-meta">
    <div class="alert alert-danger" role="alert">
        Bạn không có quyền truy cập trang này!
    </div>
</div>
@endif
@endsection