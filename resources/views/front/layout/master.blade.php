<!DOCTYPE html>
<html lang="en">

<head>
	<base href="{{asset('/')}}">
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<meta name="description" content="" />
	<meta name="keywords" content="" />
	<title>@yield('title')</title>
	<link rel="icon" href="front/img/logo_fita.png" type="image/png" sizes="16x16">
	<meta name="csrf-token" content="{{ csrf_token() }}">
	<link rel="stylesheet" href="front/css/main.min.css" type="text/css">
	<link rel="stylesheet" href="front/css/style.css" type="text/css">
	<link rel="stylesheet" href="front/css/color.css" type="text/css">
	<link rel="stylesheet" href="front/css/responsive.css" type="text/css">
	<link rel="stylesheet" href="front/css/bootstrap.min.css" type="text/css">

	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/slick-carousel/1.8.1/slick.min.css">
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/slick-carousel/1.8.1/slick-theme.min.css">
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.3/jquery.min.js"></script>

	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.3.0/css/all.min.css" integrity="sha512-SzlrxWUlpfuzQ+pcUCosxcglQRNAq/DZjVsC0lE40xsADsfeQoEypE+enwcOiGjk/bSuGGKHEyjSoQ1zVisanQ==" crossorigin="anonymous" referrerpolicy="no-referrer" />
	<script src="https://kit.fontawesome.com/47f1aaf7ca.js" crossorigin="anonymous"></script>
	<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>
	<script src="https://cdn.tiny.cloud/1/1dvwoen7mpwcn3jcbkd98qo9kas9hy7rlkt8ul00jera0bge/tinymce/6/tinymce.min.js" referrerpolicy="origin"></script>
	<link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/css/select2.min.css" rel="stylesheet" />
</head>

<body>
	<div class="theme-layout">
		<div class="responsive-header">
			<div class="mh-head first Sticky">
				<span class="mh-btns-left">
					<a class="" href="#menu"><i class="fa fa-align-justify"></i></a>
				</span>
				<span class="mh-text">
					<a href="./" title="logo"><img src="front/img/logo_fita.png" alt="" style="max-width: 50px;"></a>
				</span>
			</div>
			<div class="mh-head second">
				<form class="mh-form">
					<input placeholder="search" />
					<a href="#/" class="fa fa-search"></a>
				</form>
			</div>
			<nav id="menu" class="res-menu">
				<ul>
					<li>
						<a href="./create_post">Đăng bài</a>
					</li>
					<li>
						<a href="./what_news">Có gì mới?</a>
					</li>
					<li>
						<a href="./stories_post" title="">Story</a>
					</li>
					<li><span><a href="/list_member">Thành viên</a></span>
						<ul>
							<li><a href="./online_member" title="">Đang truy cập</a></li>
							<li><a href="./top_member" title="">Bảng xếp hạng</a></li>
						</ul>
					</li>

					@if(Auth::check())
					<li>
						<a href="./user-profile-post-{{ Auth::user()->id }}">Trang cá nhân</a>
					</li>
					<li>
						<a href="./list_follows">Đang theo dõi</a>
					</li>
					<li>
						<a href="./user-profile-image-{{ Auth::user()->id }}">Hình ảnh</a>
					</li>
					<li>
						<a href="/messages">Tin nhắn</a>
					</li>
					<li>
						<a href="./notifications">Thông báo</a>
					</li>
					@endif

					@if(!Auth::check())
					<li>
						<a href="./account/login" title="">Đăng nhập</a>
					</li>
					<li>
						<a href="./account/register" title="">Đăng ký</a>
					</li>
					@else
					<li class="extend-nav-menu">
						<a href="./account/logout"></i>Đăng xuất</a>
					</li>
					@endif
				</ul>
			</nav>
		</div><!-- responsive header -->

		<div class="topbar sticky-top">
			<div class="logo">
				<a title="Trang chủ" href="./"><img src="front/img/logo_fita.png" class="shadow rounded-circle" alt="" width="48px"></a>
			</div>

			<div class="top-area">
				<ul class="main-menu">
					<li>
						<a href="./create_post" title="">Đăng bài</a>
					</li>
					<li>
						<a href="./what_news" title="">Có gì mới?</a>
					</li>
					<li>
						<a href="./stories_post" title="">Story</a>
					</li>
					<li class="dropdown-area">
						<a href="./list_member" title="">Thành viên</a>
						<ul>
							<li><a href="./online_member" title="">Đang truy cập</a></li>
							<li><a href="./top_member" title="">Bảng xếp hạng</a></li>
						</ul>
					</li>
				</ul>

				@if(Auth::check())
				<ul class="setting-area">
					<li>
						<div class="dropdown">
							<div href="#" title="Notification" id="notificationDropdown" data-bs-toggle="dropdown" aria-expanded="false">
								<i class="ti-bell"></i>
								@if($notificationsCount > 0)
								<span class="notification-count badge bg-danger text-white">{{ $notificationsCount > 99 ? '99+' : $notificationsCount }}</span>
								@else
								<span class="notification-count badge bg-danger text-white"></span>
								@endif
							</div>
							<ul class="drops-menu dropdown-menu notifications p-0" id="notification-list" aria-labelledby="notificationDropdown">
								<li class="bg-white d-flex">
									<a href="./notifications" title="" class="more-mesg text-right"><small>Xem tất cả</small></a>
								</li>
								@if($notifications->count() > 0)
								@foreach($notifications as $notification)
								@if($notification->type === 'like' || $notification->type === 'comment' || $notification->type === 'create')
								<li data-notification-id="{{ $notification->id }}" class="{{ $notification->status == 'new' ? 'bg-light' : '' }}">
									<a href="./new_posts/post_{{ $notification->post_id }}?notification_id={{ $notification->id }}">
										<img src="front/img/users/{{ $notification->user->avatar ?? 'default_user.png' }}" alt="" style="width: 50px;height: 50px;object-fit: cover;">
										<div class="mesg-meta">
											<h6>{{ $notification->user->name }}</h6>
											<span>{{ $notification->content}}</span>
											<i>{{ formatTime($notification->created_at) }}</i>
										</div>
									</a>
									@if($notification->status == 'new')
									<span class="tag green">New</span>
									@endif
								</li>
								@elseif($notification->type === 'message')
								<li data-notification-id="{{ $notification->id }}" class="{{ $notification->status == 'new' ? 'bg-light' : '' }}">
									<a href="./messages_{{ $notification->user_id }}?notification_id={{ $notification->id }}">
										<img src="front/img/users/{{ $notification->user->avatar ?? 'default_user.png' }}" alt="" style="width: 50px;height: 50px;object-fit: cover;">
										<div class="mesg-meta">
											<h6>{{ $notification->user->name }}</h6>
											<span>{{ $notification->content}}</span>
											<i>{{ formatTime($notification->created_at) }}</i>
										</div>
									</a>
									@if($notification->status == 'new')
									<span class="tag green">New</span>
									@endif
								</li>
								@elseif($notification->type === 'follow')
								<li data-notification-id="{{ $notification->id }}" class="{{ $notification->status == 'new' ? 'bg-light' : '' }}">
									<a href="./user-profile-post-{{ $notification->user_id }}?notification_id={{ $notification->id }}">
										<img src="front/img/users/{{ $notification->user->avatar ?? 'default_user.png' }}" alt="" style="width: 50px;height: 50px;object-fit: cover;">
										<div class="mesg-meta">
											<h6>{{ $notification->user->name }}</h6>
											<span>{{ $notification->content}}</span>
											<i>{{ formatTime($notification->created_at) }}</i>
										</div>
									</a>
									@if($notification->status == 'new')
									<span class="tag green">New</span>
									@endif
								</li>
								@endif
								@endforeach
								@else
								<div class="p-2 text-center" id="none-noti">Không có thông báo nào.</div>
								@endif
							</ul>
						</div>
					</li>
				</ul>
				<div class="user-img">
					<img src="front/img/users/{{ Auth::user()->avatar ?? 'default_user.png' }}" alt="">
					<span class="status f-online"></span>
					<div class="user-setting">
						<a href="#" class="disabled d-flex justify-content-center" aria-disabled="true">
							@if( Auth::user()->level == 0 )
							<span class="badge bg-danger text-white">Người kiểm duyệt</span>
							@elseif( Auth::user()->level == 1 )
							<span class="badge bg-success text-white">Giảng viên</span>
							@else
							<span class="badge bg-primary text-white">Sinh viên</span>
							@endif

						</a>
						<a href="./user-profile-post-{{ Auth::user()->id }}" title=""><i class="ti-user"></i>Trang cá nhân</a>
						<a href="./user-profile-edit-{{ Auth::user()->id }}" title=""><i class="ti-pencil-alt"></i>Chỉnh sửa trang cá nhân</a>
						<a href="./account/logout" title=""><i class="ti-power-off"></i>Đăng xuất</a>
					</div>
				</div>
				@endif
			</div>
		</div><!-- topbar -->

		<section>
			<div class="gap gray-bg">
				<div class="container-fluid">
					<div class="row">
						<div class="col-lg-12">
							<div class="row" id="page-contents">
								<div class="col-lg-3 ">
									<aside class="sidebar static">
										@if(Auth::check())
										<div id="nav-moblie" class="widget">
											<div class="d-flex bd-highlight">
												<div class="mr-auto p-2 bd-highlight">
													<form action="">
														<div class="attachments">
															<button type="submit"><a href="./create_post">Đăng bài</a></button>
														</div>
													</form>
												</div>
												<div class="p-2 bd-highlight">
													<div class="d-flex align-items-center h-100">
														<a href="./notifications" title="Notification">
															<i class="ti-bell"></i>
															@if($notificationsCount > 0)
															<span class="notification-count badge bg-danger text-white">{{ $notificationsCount > 99 ? '99+' : $notificationsCount }}</span>
															@endif
														</a>
													</div>
												</div>
												<div class="p-2 bd-highlight">
													<div class="btn-group dropleft d-flex align-items-center h-100">
														<img src="front/img/users/{{ Auth::user()->avatar ?? 'default_user.png' }}" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" class="rounded-circle" alt="" style="width: 30px;height: 30px;object-fit: cover;">

														<div class="dropdown-menu user-mobile">
															<a href="./user-profile-post-{{ Auth::user()->id }}" title=""><i class="ti-user"></i> Trang cá nhân</a>
															<a href="./user-profile-post-{{ Auth::user()->id }}" title=""><i class="ti-pencil-alt"></i> Chỉnh sửa trang cá nhân</a>
															@if(Auth::check())
															<a href="./account/logout" title=""><i class="ti-power-off"></i> Đăng xuất</a>
															@endif
														</div>
													</div>
												</div>
											</div>
										</div>
										@endif
										<div id="shortcuts" class="widget">
											<h4 class="widget-title">Phím tắt</h4>
											<ul class="naves">
												@if(Auth::check())
												<li class="d-flex justify-content-start align-items-center">
													<i class="ti-clipboard"></i>
													<a href="./" title="">Trang chủ</a>
												</li>
												<li class="d-flex justify-content-start align-items-center">
													<i class="ti-files"></i>
													<a href="./user-profile-post-{{ Auth::user()->id }}" title="">Trang cá nhân</a>
												</li>
												<li class="d-flex justify-content-start align-items-center">
													<i class="ti-user"></i>
													<a href="./list_follows" title="">Đang theo dõi</a>
												</li>
												<li class="d-flex justify-content-start align-items-center">
													<i class="ti-image"></i>
													<a href="./user-profile-image-{{ Auth::user()->id }}" title="">Hình ảnh</a>
												</li>
												<li class="d-flex justify-content-start align-items-center">
													<i class="ti-comments-smiley"></i>
													<a href="/messages" title="">Tin nhắn</a>
												</li>
												<li class="d-flex justify-content-start align-items-center">
													<i class="ti-bell"></i>
													<a href="./notifications" title="">Thông báo</a>
												</li>
												<li class="d-flex justify-content-start align-items-center">
													<i class="ti-power-off"></i>
													<a href="./account/logout" title="">Đăng xuất</a>
												</li>
												@else
												<li class="d-flex justify-content-start align-items-center">
													<i class="fa-solid fa-right-to-bracket"></i>
													<a href="./account/login" title="">Đăng nhập</a>
												</li>
												<li class="d-flex justify-content-start align-items-center">
													<i class="fa-solid fa-user-plus"></i>
													<a href="./account/register" title="">Đăng ký</a>
												</li>
												@endif
											</ul>
										</div>

										@if(Auth::check())
										<div id="your-page" class="widget">
											<h4 class="widget-title">Trang của bạn</h4>
											<div class="your-page">
												<figure>
													<a href="./user-profile-post-{{ Auth::user()->id }}" title=""><img src="front/img/users/{{ Auth::user()->avatar ?? 'default_user.png' }}" alt="" style="width: 50px;height: 50px;object-fit: cover;"></a>
												</figure>
												<div class="page-meta">
													<a href="./user-profile-post-{{ Auth::user()->id }}" title="" class="underline">{{ Auth::user()->name }}</a>
												</div>
												<div class="page-likes">
													<ul class="nav nav-tabs likes-btn">
														<li class="nav-item"><a class="active" href="#link1" data-toggle="tab">Thích</a></li>
														<li class="nav-item"><a class="" href="#link2" data-toggle="tab">Theo dõi</a></li>
													</ul>
													<!-- Tab panes -->
													<div class="tab-content">
														<div class="tab-pane active fade show" id="link1">
															@php
															$total_like_week = DB::table('users')
															->join('posts', 'users.id', '=', 'posts.user_id')
															->join('likes', 'posts.id', '=', 'likes.post_id')
															->select('users.id', 'users.name', 'users.avatar', DB::raw('count(likes.id) as total_likes'))
															->where('likes.created_at', '>=', now()->startOfWeek()) // Lấy ra like trong tuần này
															->groupBy('users.id', 'users.name', 'users.avatar')
															->orderByDesc('total_likes')
															->get();

															$user_total_like = DB::table('users')
															->join('posts', 'users.id', '=', 'posts.user_id')
															->join('likes', 'posts.id', '=', 'likes.post_id')
															->select('users.id', 'users.name', 'users.avatar', DB::raw('count(likes.id) as total_likes'))
															->groupBy('users.id', 'users.name', 'users.avatar')
															->orderByDesc('total_likes')
															->get();

															foreach($total_like_week as $user)
															{
															if($user->id == Auth::user()->id)
															{
															$count_like_week = $user->total_likes;
															}
															}

															foreach($user_total_like as $user)
															{
															if($user->id == Auth::user()->id)
															{
															$count = $user->total_likes;
															}
															}
															@endphp

															<span><i class="ti-heart"></i>{{ format_number($count ?? '0') }}</span>
															<a onclick="return false;" title="weekly-likes">{{ format_number($count_like_week ?? '0')  }} lượt thích mới trong tuần này</a>
															<div class="users-thumb-list">

															</div>
														</div>
														<div class="tab-pane fade" id="link2">
															@php
															$weeklyFollowsCount = App\Models\Follower::where('created_at', '>=', now()->startOfWeek())
															->where('user_id', Auth::user()->id)
															->count();

															$latestFollows = Auth::user()->followers()
															->orderBy('created_at', 'desc')
															->take(7)
															->get();
															@endphp

															<span><i class="ti-eye"></i>{{ format_number($weeklyFollowsCount) }}</span>
															<a onclick="return false;" title="weekly-likes">{{ format_number($weeklyFollowsCount) }} lượt theo dõi mới trong tuần này</a>
															<div class="users-thumb-list">
																@foreach($latestFollows as $follow)
																<a href="/user-profile-post-{{ $follow->id }}" title="{{ $follow->name }}" data-toggle="tooltip">
																	<img src="front/img/users/{{ $follow->avatar ?? 'default_user.png' }}" style="width: 30px;height: 30px;object-fit: cover;" alt="">
																</a>
																@endforeach
															</div>
														</div>
													</div>
												</div>
											</div>
										</div><!-- page like widget -->
										@endif

									</aside>
								</div><!-- sidebar -->

								@yield('body')
							</div>
						</div>
					</div>
				</div>
			</div>
		</section>


		<footer>
			<div class="container">
				<div class="row">
					<div class="col-lg-4 col-md-4">
						<div class="widget">
							<div class="foot-logo text-center">
								<div class="logo d-flex justify-content-center">
									<a href="./" title=""><img src="front/img/logo_fita.png" width="100px" alt=""></a>
								</div>
								<h3 class="text-primary">KHOA CÔNG NGHỆ THÔNG TIN - HỌC VIỆN NÔNG NGHIỆP VIỆT NAM</h3>
								<p>
									Đoàn kết chặt chẽ, cố gắng không ngừng, để tiến bộ mãi
								</p>
							</div>
							<ul class="location">
								<li>
									<i class="ti-map-alt"></i>
									<p>Địa chỉ: Học viện Nông nghiệp Việt Nam – Trâu Quỳ – Gia Lâm – Hà Nội.</p>
								</li>
								<li>
									<i class="ti-mobile"></i>
									<p>+1-56-346 345</p>
								</li>
							</ul>
						</div>
					</div>
					<div class="col-lg-2 col-md-4">
						<div class="widget">
							<div class="widget-title">
								<h4>follow</h4>
							</div>
							<ul class="list-style">
								<li><i class="fa fa-facebook-square"></i> <a href="https://web.facebook.com/shopcircut/" title="">facebook</a></li>
								<li><i class="fa fa-twitter-square"></i><a href="https://twitter.com/login?lang=en" title="">twitter</a></li>
								<li><i class="fa fa-instagram"></i><a href="https://www.instagram.com/?hl=en" title="">instagram</a></li>
								<li><i class="fa fa-google-plus-square"></i> <a href="https://plus.google.com/discover" title="">Google+</a></li>
								<li><i class="fa fa-pinterest-square"></i> <a href="https://www.pinterest.com/" title="">Pintrest</a></li>
							</ul>
						</div>
					</div>
					<div class="col-lg-2 col-md-4">
						<div class="widget">
							<div class="widget-title">
								<h4>Navigate</h4>
							</div>
							<ul class="list-style">
								<li><a href="about.html" title="">about us</a></li>
								<li><a href="contact.html" title="">contact us</a></li>
								<li><a href="terms.html" title="">terms & Conditions</a></li>
								<li><a href="#" title="">RSS syndication</a></li>
								<li><a href="sitemap.html" title="">Sitemap</a></li>
							</ul>
						</div>
					</div>
					<div class="col-lg-2 col-md-4">
						<div class="widget">
							<div class="widget-title">
								<h4>useful links</h4>
							</div>
							<ul class="list-style">
								<li><a href="#" title="">leasing</a></li>
								<li><a href="#" title="">submit route</a></li>
								<li><a href="#" title="">how does it work?</a></li>
								<li><a href="#" title="">agent listings</a></li>
								<li><a href="#" title="">view All</a></li>
							</ul>
						</div>
					</div>
					<div class="col-lg-2 col-md-4">
						<div class="widget">
							<div class="widget-title">
								<h4>download apps</h4>
							</div>
							<ul class="colla-apps">
								<li><a href="https://play.google.com/store?hl=en" title=""><i class="fa fa-android"></i>android</a></li>
								<li><a href="https://www.apple.com/lae/ios/app-store/" title=""><i class="ti-apple"></i>iPhone</a></li>
								<li><a href="https://www.microsoft.com/store/apps" title=""><i class="fa fa-windows"></i>Windows</a></li>
							</ul>
						</div>
					</div>
				</div>
			</div>
		</footer><!-- footer -->
		<div class="bottombar">
			<div class="container">
				<div class="row">
					<div class="col-md-12">
						<span class="copyright"><a target="_blank" href="https://www.templateshub.net">Templates Hub</a></span>
						<i><img src="front/img/credit-cards.png" alt=""></i>
					</div>
				</div>
			</div>
		</div>
	</div>
	<script src="front/js/main.min.js"></script>
	<script src="front/js/script.js"></script>


	<script src="https://cdnjs.cloudflare.com/ajax/libs/slick-carousel/1.8.1/slick.min.js"></script>
	<link href="https://unpkg.com/tailwindcss@^1.0/dist/tailwind.min.css" rel="stylesheet">
	<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
	<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
	<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js" integrity="sha384-IQsoLXl5PILFhosVNubq5LC7Qb9DXgDA9i+tQ8Zj3iwWAwPtgFTxbJ8NT4GN1R8p" crossorigin="anonymous"></script>
	<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.min.js" integrity="sha384-cVKIPhGWiC2Al4u+LWgxfKTRIcfu0JTxR+EQDz/bgldoEyl4H0zUF0QKbrJ0EcQF" crossorigin="anonymous"></script>
	<script src="https://js.pusher.com/7.0/pusher.min.js"></script>
	@yield('script')

	<!-- Pusher -->
	<script src="https://js.pusher.com/7.0/pusher.min.js"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/js/select2.min.js"></script>
	@if(Auth::check())
	<script>
		var pusher = new Pusher('{{ env("PUSHER_APP_KEY") }}', {
			cluster: '{{ env("PUSHER_APP_CLUSTER") }}',
			encrypted: true
		});

		var user_id = '{{ Auth::user()->id }}';

		var post_channel = pusher.subscribe('post-channel');

		//Like
		post_channel.bind('like-event', function(data) {
			// Kiểm tra xem người thích bài viết có phải là chủ bài viết không
			if (user_id != data.userId && user_id == data.ownerId) {
				$(document).ready(function() {
					$(
						'<li data-notification-id="' + data.notification_id + '" class="bg-light">' +
						'<a href="./new_posts/post_' + data.postId + '?notification_id=' + data.notification_id + '">' +
						'<img src="front/img/users/' + data.avatar + '" alt="" style="width: 50px;height: 50px;object-fit: cover;">' +
						'<div class="mesg-meta">' +
						'<h6>' + data.userName + '</h6>' +
						'<span>Đã thích bài viết của bạn</span>' +
						'<i>' + data.time + '</i>' +
						'</div>' +
						'	</a>' +
						'<span class="tag green">New</span>' +
						'</li>'
					).insertAfter($('#notification-list li:first'));

					$(
						'<li data-notification-id="' + data.notification_id + '" class="bg-light">' +
						'<a href="./new_posts/post_' + data.postId + '?notification_id=' + data.notification_id + '">' +
						'<div class="nearly-pepls">' +
						'<figure>' +
						'<div href="time-line.html" class="d-flex justify-content-center" title=""><img src="front/img/users/' + data.avatar + '" alt="' + data.userName + '" style="width: 35px;height: 35px;object-fit: cover;"></div>' +
						'</figure>' +
						'<div class="pepl-info">' +
						'<p><strong class="text">' + data.userName + '</strong> Đã thích bài viết của bạn.' +
						'<span class="badge badge-success">New</span>' +
						'</p>' +
						'</div>' +
						'</div>' +
						'</a>' +
						'</li>'
					).prependTo($('#list-notifications'));
				});

				const spanElement = document.querySelector('.notification-count');
				const notificationCount = spanElement.innerText;

				$('.notification-count').html(data.notifications_count);
			}
		});

		post_channel.bind('unlike-event', function(data) {
			// Kiểm tra xem người thích bài viết có phải là chủ bài viết không
			if (user_id != data.userId && user_id == data.ownerId) {
				// Hiển thị thông báo cho chủ bài viết
				$('#notification-list li[data-notification-id="' + data.notification_id + '"]').remove();
				$('#list-notifications li[data-notification-id="' + data.notification_id + '"]').remove();

				//Cập nhật lại số lượng
				if (data.notifications_count == 0) {
					$('.notification-count').html('');
				} else {
					$('.notification-count').html(data.notifications_count);
				}
			}
		});

		//Comment
		post_channel.bind('comment-event', function(data) {
			// Kiểm tra xem người thích bài viết có phải là chủ bài viết không
			if (user_id != data.userId && user_id == data.ownerId) {
				$(document).ready(function() {
					if (data.notifications_count > 0) {
						$('#none-noti').remove();
					}

					$(
						'<li data-notification-id="' + data.notification_id + '" class="bg-light">' +
						'<a href="./new_posts/post_' + data.postId + '?notification_id=' + data.notification_id + '">' +
						'<img src="front/img/users/' + data.avatar + '" alt="" style="width: 50px;height: 50px;object-fit: cover;">' +
						'<div class="mesg-meta">' +
						'<h6>' + data.userName + '</h6>' +
						'<span>Đã bình luận bài viết của bạn</span>' +
						'<i>' + data.time + '</i>' +
						'</div>' +
						'	</a>' +
						'<span class="tag green">New</span>' +
						'</li>'
					).insertAfter($('#notification-list li:first'));

					$(
						'<li data-notification-id="' + data.notification_id + '" class="bg-light">' +
						'<a href="./new_posts/post_' + data.postId + '?notification_id=' + data.notification_id + '">' +
						'<div class="nearly-pepls">' +
						'<figure>' +
						'<div href="time-line.html" class="d-flex justify-content-center" title=""><img src="front/img/users/' + data.avatar + '" alt="' + data.userName + '" style="width: 35px;height: 35px;object-fit: cover;"></div>' +
						'</figure>' +
						'<div class="pepl-info">' +
						'<p><strong class="text">' + data.userName + '</strong> Đã bình luận bài viết của bạn.' +
						'<span class="badge badge-success">New</span>' +
						'</p>' +
						'</div>' +
						'</div>' +
						'</a>' +
						'</li>'
					).prependTo($('#list-notifications'));

					//Cập nhật lại số lượng
					$('.notification-count').html(data.notifications_count);
				});
			}
		});

		post_channel.bind('reply-comment-event', function(data) {
			// Kiểm tra xem người thích bài viết có phải là chủ bài viết không
			if (user_id != data.userId && user_id == data.ownerId) {
				$(document).ready(function() {
					$(
						'<li data-notification-id="' + data.notification_id + '" class="bg-light">' +
						'<a href="./new_posts/post_' + data.postId + '?notification_id=' + data.notification_id + '">' +
						'<img src="front/img/users/' + data.avatar + '" alt="" style="width: 50px;height: 50px;object-fit: cover;">' +
						'<div class="mesg-meta">' +
						'<h6>' + data.userName + '</h6>' +
						'<span>Đã bình luận bài viết của bạn</span>' +
						'<i>' + data.time + '</i>' +
						'</div>' +
						'	</a>' +
						'<span class="tag green">New</span>' +
						'</li>'
					).insertAfter($('#notification-list li:first'));

					$(
						'<li data-notification-id="' + data.notification_id + '" class="bg-light">' +
						'<a href="./new_posts/post_' + data.postId + '?notification_id=' + data.notification_id + '">' +
						'<div class="nearly-pepls">' +
						'<figure>' +
						'<div href="time-line.html" class="d-flex justify-content-center" title=""><img src="front/img/users/' + data.avatar + '" alt="' + data.userName + '" style="width: 35px;height: 35px;object-fit: cover;"></div>' +
						'</figure>' +
						'<div class="pepl-info">' +
						'<p><strong class="text">' + data.userName + '</strong> Đã bình luận bài viết của bạn.' +
						'<span class="badge badge-success">New</span>' +
						'</p>' +
						'</div>' +
						'</div>' +
						'</a>' +
						'</li>'
					).prependTo($('#list-notifications'));

					console.log(data.notifications_count)

					//Cập nhật lại số lượng
					$('.notification-count').html(data.notifications_count);
				});
			}
		});

		post_channel.bind('delete-comment-event', function(data) {
			// Kiểm tra xem người thích bài viết có phải là chủ bài viết không
			if (user_id != data.userId && user_id == data.ownerId) {
				// Tìm thẻ li cần xóa bằng cách sử dụng selector ID
				$('#notification-list li[data-notification-id="' + data.notification_id + '"]').remove();
				$('#list-notifications li[data-notification-id="' + data.notification_id + '"]').remove();

				console.log(data);
				//Cập nhật lại số lượng
				if (data.notifications_count == 0) {
					$('.notification-count').html('');
				} else {
					$('.notification-count').html(data.notifications_count);
				}
			}
		});

		//=====================================Messages====================================================
		$('.friend-drawer--onhover').on('click', function() {

			$('.chat-bubble').hide('slow').show('slow');

		});

		var messages_channel = pusher.subscribe('messages-channel');

		//gửi tin nhắn
		messages_channel.bind('send-event', function(data) {
			var messageContainer = $('#messages_container_' + data.sender_id + '_' + user_id);
			var avatar_sender = data.sender_avatar ? data.sender_avatar : 'default_user.png';
			console.log('messages_container_' + data.sender_id + '_' + user_id);
			var message = '';
			if (user_id === data.sender_id) {
				message += '<div class="chat-message-right pb-4">';
			} else {
				message += '<div class="chat-message-left pb-4">';
			}

			message += '<div>';
			message += '<img src="front/img/users/' + avatar_sender + '" class="rounded-circle mr-1" alt="' + data.sender_name + '" style="width: 40px;height: 40px;object-fit: cover;">';
			message += '</div>';

			if (user_id === data.sender_id) {
				message += '<div class="flex-shrink-1 bg-light rounded py-2 px-3 mr-3">';
			} else {
				message += '<div class="flex-shrink-1 bg-light rounded py-2 px-3 ml-3">';
			}

			message += '<span class="d-inline-block d-sm-block messages-content">' + data.content + '</span>'; // Bọc nội dung trong thẻ span

			message += '<div class="text-muted small text-nowrap mt-2">';
			message += data.time;
			message += '</div>';
			message += '</div>';
			message += '</div>';

			messageContainer.append(message);
			if (user_id != data.sender_id && user_id == data.receiver_id) {
				//cập nhật thông báo
				$(
					'<li data-notification-id="' + data.notification_id + '" class="bg-light">' +
					'<a href="./messages_' + data.sender_id + '?notification_id=' + data.notification_id + '">' +
					'<img src="front/img/users/' + avatar_sender + '" alt="" style="width: 50px;height: 50px;object-fit: cover;">' +
					'<div class="mesg-meta">' +
					'<h6>' + data.sender_name + '</h6>' +
					'<span>Đã gửi cho bạn một tin nhắn.</span>' +
					'<i>' + data.time + '</i>' +
					'</div>' +
					'	</a>' +
					'<span class="tag green">New</span>' +
					'</li>'
				).insertAfter($('#notification-list li:first'));

				$(
					'<li data-notification-id="' + data.notification_id + '" class="bg-light">' +
					'<a href="./messages_' + data.sender_id + '?notification_id=' + data.notification_id + '">' +
					'<div class="nearly-pepls">' +
					'<figure>' +
					'<div href="time-line.html" class="d-flex justify-content-center" title=""><img src="front/img/users/' + avatar_sender + '" alt="' + data.sender_name + '" style="width: 35px;height: 35px;object-fit: cover;"></div>' +
					'</figure>' +
					'<div class="pepl-info">' +
					'<p><strong class="text">' + avatar_sender + '</strong> Đã bình luận bài viết của bạn.' +
					'<span class="badge badge-success">New</span>' +
					'</p>' +
					'</div>' +
					'</div>' +
					'</a>' +
					'</li>'
				).prependTo($('#list-notifications'));

				//Cập nhật lại số lượng

				$('.notification-count').html(data.notification_count);
			}
		});

		// Lắng nghe sự kiện khi người dùng nhập vào input
		$('#searchInput').on('keyup', function() {
			var searchTerm = $(this).val();

			if (searchTerm.length === 0) {
				$('#searchResults').empty();
				return;
			}

			// Gửi yêu cầu AJAX để tìm kiếm người dùng
			$.ajax({
				url: '/search_user',
				method: 'GET',
				dataType: 'json',
				data: {
					searchTerm: searchTerm
				},
				success: function(response) {
					var searchResults = $('#searchResults');
					searchResults.empty();

					// Hiển thị kết quả tìm kiếm
					response.forEach(function(user) {
						var avatar = user.avatar ? user.avatar : 'default_user.png';
						var listItem = $('<a href="./messages_' + user.id + '" class="get-messages list-group-item list-group-item-action border-0" data-receiver-id="' + user.id + '">');
						var badge = $('<div class="badge bg-success float-right">').text(user.unreadCount);
						var image = $('<img src="front/img/users/' + avatar + '" class="rounded-circle mr-1" alt="' + user.name + '" style="width: 30px;height: 30px;object-fit: cover;">');
						var name = $('<div class="flex-grow-1 ml-3">').text(user.name);
						var status = $('<div class="small">').html('<span class="fas fa-circle chat-' + (user.online ? 'online' : 'offline') + '"></span> ' + (user.online ? 'Online' : 'Offline'));

						listItem.append(badge);
						listItem.append($('<div class="d-flex align-items-start">').append(image).append(name.append(status)));
						searchResults.append(listItem);
					});
				},
				error: function(xhr, status, error) {
					console.error(error);
				}
			});
		});


		$(document).on('click', '#user-send-message', function(ev) {
			ev.preventDefault();

			var receiver_id = $(this).data('receiver-id');
			var messageContent = $('#message-input').val();
			var token = $('meta[name="csrf-token"]').attr('content');

			$.ajax({
				url: '/send-messages',
				type: 'POST',
				data: {
					content: messageContent,
					receiver_id: receiver_id,
					_token: token,
				},
				success: function(response) {
					if (response.error) {
						console.log('Gửi tin nhắn thất bại: ' + response.error);
					} else {
						// Xử lý kết quả thành công tại đây
						console.log('Gửi tin nhắn thành công');
						$('#messages_container_' + receiver_id + '_' + user_id).html(response);
						console.log('#messages_container_' + user_id + '_' + receiver_id);
						$('#message-input').val('');
					}
				},
				error: function(xhr, status, error) {
					console.log(xhr.responseText);
				}
			});
		});

		$('input[type="file"]').change(function(e) {
			var fileName = e.target.files[0].name;
			$(this).next('.custom-file-label').html(fileName);
		});

		// JavaScript code
		// const subjectDropdown = document.querySelector("#subject-dropdown");
		// const subjectSearch = document.querySelector("#subject-search");
		// const subjectOptions = document.querySelectorAll(".subject-option");
		// const selectedSubject = document.querySelector("#selected-subject");

		// subjectSearch.addEventListener("input", function() {
		// 	const searchValue = subjectSearch.value.toLowerCase();
		// 	subjectOptions.forEach(function(option) {
		// 		const optionText = option.innerText.toLowerCase();
		// 		if (optionText.includes(searchValue)) {
		// 			option.style.display = "block";
		// 		} else {
		// 			option.style.display = "none";
		// 		}
		// 	});
		// });

		// subjectOptions.forEach(function(option) {
		// 	option.addEventListener("click", function(event) {
		// 		event.preventDefault();
		// 		const value = option.getAttribute("data-value");
		// 		const text = option.innerText;
		// 		selectedSubject.value = value;
		// 		subjectDropdown.innerText = text;
		// 	});
		// });

		//Follow
		post_channel.bind('follow-event', function(data) {
			// Kiểm tra xem người thích bài viết có phải là chủ bài viết không
			if (user_id != data.userId && user_id == data.ownerId) {
				$(document).ready(function() {
					var notificationHtml =
						'<li data-notification-id="' + data.notification_id + '" class="bg-light">' +
						'<a href="/user-profile-post-' + data.userId + '?notification_id=' + data.notification_id + '">' +
						'<img src="front/img/users/' + data.avatar + '" alt="" style="width: 50px;height: 50px;object-fit: cover;">' +
						'<div class="mesg-meta">' +
						'<h6>' + data.userName + '</h6>' +
						'<span>Đã theo dõi bạn</span>' +
						'<i>' + data.time + '</i>' +
						'</div>' +
						'	</a>' +
						'<span class="tag green">New</span>' +
						'</li>';

					$('#notification-list li:first').after(notificationHtml);

					const spanElement = document.querySelector('.notification-count');
					const notificationCount = spanElement.innerText;

					$('.notification-count').html(data.notifications_count);
				});
			}
		});

		post_channel.bind('create-event', function(data) {
			// Kiểm tra xem người thích bài viết có phải là chủ bài viết không
			if (user_id != data.userId && user_id == data.ownerId) {
				$(document).ready(function() {
					var notificationHtml =
						'<li data-notification-id="' + data.notification_id + '" class="bg-light">' +
						'<a href="/new_posts/post_' + data.post_id + '?notification_id=' + data.notification_id + '">' +
						'<img src="front/img/users/' + data.avatar + '" alt="" style="width: 50px;height: 50px;object-fit: cover;">' +
						'<div class="mesg-meta">' +
						'<h6>' + data.userName + '</h6>' +
						'<span>Đã đăng một bài viết mới.</span>' +
						'<i>' + data.time + '</i>' +
						'</div>' +
						'	</a>' +
						'<span class="tag green">New</span>' +
						'</li>';

					$('#notification-list li:first').after(notificationHtml);

					const spanElement = document.querySelector('.notification-count');
					const notificationCount = spanElement.innerText;

					$('.notification-count').html(data.notifications_count);
				});
			}
		});
	</script>
	@endif
</body>

</html>