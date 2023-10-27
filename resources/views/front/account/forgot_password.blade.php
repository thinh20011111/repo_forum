<!DOCTYPE html>
<html lang="en">

<head>
    <base href="{{asset('/')}}">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="" />
    <meta name="keywords" content="" />
    <title>Diễn đàn học tập khoa CNTT</title>
    <link rel="icon" href="front/img/logo_fita.png" type="image/png" sizes="16x16">

    <link rel="stylesheet" href="front/css/main.min.css" type="text/css">
    <link rel="stylesheet" href="front/css/style.css" type="text/css">
    <link rel="stylesheet" href="front/css/color.css" type="text/css">
    <link rel="stylesheet" href="front/css/responsive.css" type="text/css">
</head>

<body>

    <!--<div class="se-pre-con"></div>-->
    <div class="theme-layout">
        <div class="container-fluid pdng0">
            <div class="row merged">
                <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                    <div class="land-featurearea">
                        <div class="land-meta">
                            <h1>FITA VNUA</h1>
                            <p>
                                Diễn đàn học tập khoa công nghệ thông tin Học Viện Nông Nghiệp Việt Nam.
                            </p>
                            <span><img src="front/img/logo_fita.png" alt="" style="width: 300px;"></span>
                        </div>
                    </div>
                </div>
                <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                    <div class="log-reg-area bg">
                        <h3 class="log-title">Quên mật khẩu</h3>
                        @if(session('error'))
                        <div class="alert alert-danger" role="alert">
                            {{ session('error') }}
                        </div>
                        @endif
                        @if(session('message'))
                        <div class="alert alert-success" role="alert">
                            {{ session('message') }}
                        </div>
                        @endif
                        <form method="post" action="./account/send_resset_password">
                            @csrf
                            <div class="form-group">
                                <input type="email" id="input" required="required" name="email" value="{{ old('email') }}" />
                                <label class="control-label" for="email">Email</label><i class="mtrl-select"></i>
                            </div>
                            <button class="mtr-btn signin" type="submit">
                                <span>Gửi</span>
                            </button>
                        </form>

                    </div>
                </div>
            </div>
        </div>
    </div>
    </div>

    <script src="front/js/main.min.js"></script>
    <script src="front/js/script.js"></script>
</body>

</html>