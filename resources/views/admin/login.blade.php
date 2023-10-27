<!DOCTYPE html>
<html lang="en">

<head>
    <base href="{{asset('/')}}">
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <!-- Tell the browser to be responsive to screen width -->
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">
    <!-- Favicon icon -->
    <link rel="icon" type="image/png" sizes="16x16" href="dashboard/assets/images/logo_fita.png">
    <title>Quản lý diễn đàn khoa CNTT - FITA VNUA || Đăng nhập</title>
    <!-- This page css -->
    <!-- Custom CSS -->
    <link href="dashboard/dist/css/style.min.css" rel="stylesheet">
    <style>
    </style>
</head>

<body>
    <div class="main-wrapper">
        <!-- ============================================================== -->
        <!-- Preloader - style you can find in spinners.css -->
        <!-- ============================================================== -->
        <div class="preloader">
            <div class="lds-ripple">
                <div class="lds-pos"></div>
                <div class="lds-pos"></div>
            </div>
        </div>
        <!-- ============================================================== -->
        <!-- Preloader - style you can find in spinners.css -->
        <!-- ============================================================== -->
        <!-- ============================================================== -->
        <!-- Login box.scss -->
        <!-- ============================================================== -->
        <div class="auth-wrapper d-flex no-block justify-content-center align-items-center position-relative" style="background:url(dashboard/assets/images/big/auth-bg.jpg) no-repeat center center;">
            <div class="auth-box row shadow-lg">
                <div class=" col-lg-7 col-md-5 modal-bg-img" style="background-image: url(dashboard/assets/images/hoc-vien-nong-nghiep.jpg);">
                </div>
                <div class="col-lg-5 col-md-7 bg-white">
                    <div class="p-3">
                        <div class="text-center">
                            <img src="dashboard/assets/images/logo_fita.png" width="60px" alt="wrapkit">
                        </div>
                        <h2 class="mt-3 text-center">Đăng nhập</h2>
                        <p class="text-center">Nhập địa chỉ email và mật khẩu của bạn để truy cập bảng quản trị.</p>

                        @if(session('notification'))
                        <div class="alert alert-warning" role="alert">
                            {{ session('notification') }}
                        </div>
                        @endif

                        <form method="post" action="" class="mt-4">
                            @csrf
                            <div class="row">
                                <div class="col-lg-12">
                                    <div class="form-group mb-3">
                                        <label class="form-label text-dark" for="uname">Tên đăng nhập</label>
                                        <input type="email" name="email" required="required" class="form-control" id="uname" placeholder="Nhập email...">
                                    </div>
                                </div>
                                <div class="col-lg-12">
                                    <div class="form-group mb-3">
                                        <label class="form-label text-dark" for="pwd">Mật khẩu</label>
                                        <input class="form-control" id="pwd" name="password" type="password" required="required" placeholder="Nhập mật khẩu...">
                                    </div>
                                </div>
                                <div class="col-lg-12 mb-3">
                                    <div class="checkbox">
                                        <label>
                                            <input type="checkbox" checked="checked" name="remember" /><i class="check-box"></i> Nhớ mật khẩu.
                                        </label>
                                    </div>
                                </div>
                                <div class="col-lg-12 text-center">
                                    <button type="submit" class="btn w-100 btn-dark">Đăng nhập</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <!-- ============================================================== -->
        <!-- Login box.scss -->
        <!-- ============================================================== -->
    </div>
    <!-- ============================================================== -->
    <!-- All Required js -->
    <!-- ============================================================== -->
    <script src="dashboard/assets/libs/jquery/dist/jquery.min.js "></script>
    <!-- Bootstrap tether Core JavaScript -->
    <script src="dashboard/assets/libs/popper.js/dist/umd/popper.min.js "></script>
    <script src="dashboard/assets/libs/bootstrap/dist/js/bootstrap.min.js "></script>
    <!-- ============================================================== -->
    <!-- This page plugin js -->
    <!-- ============================================================== -->
    <script>
        $(".preloader ").fadeOut();
    </script>
</body>

</html>