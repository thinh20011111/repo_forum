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
							<span><img src="front/img/logo_fita.png" alt="" style="max-width: 200px;"></span>
						</div>
					</div>
				</div>
				<div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
					<div class="login-reg-bg">
						<div class="log-reg-area sign">
							<h2 class="log-title">Đăng nhập</h2>

							@if(session('message'))
							<div class="alert alert-success" role="alert">
								{{ session('message') }}
							</div>
							@endif

							@if(session('notification'))
							<div class="alert alert-warning" role="alert">
								{{ session('notification') }}
							</div>
							@endif

							<form method="post" action="">
								@csrf

								<div class="form-group">
									<input type="email" id="input" required="required" name="email" />
									<label class="control-label" for="input">Email</label><i class="mtrl-select"></i>
								</div>
								<div class="form-group">
									<input type="password" required="required" name="password" />
									<label class="control-label" for="input">Mật khẩu</label><i class="mtrl-select"></i>
								</div>
								<div class="checkbox">
									<label>
										<input type="checkbox" checked="checked" name="remember" /><i class="check-box"></i>Nhớ mật khẩu.
									</label>
								</div>
								<a href="./account/forgot_password" title="" class="forgot-pwd">Quên mật khẩu?</a>
								<div class="submit-btns d-flex justify-content-start">
									<button class="mtr-btn signin mr-2" type="submit"><span>Đăng nhập</span></button>
									<a href="./account/register" class="mtr-btn signup"><span>Đăng ký</span></a>
								</div>
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