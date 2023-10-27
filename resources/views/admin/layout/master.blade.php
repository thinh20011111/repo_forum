<!DOCTYPE html>
<html lang="en">

<head>
    <base href="{{asset('/')}}">
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <!-- Tell the browser to be responsive to screen width -->
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">
    <!-- Favicon icon -->
    <link rel="icon" href="front/img/logo_fita.png" type="image/png" sizes="16x16">

    <title>@yield('title')</title>
    <!-- This page css -->
    <!-- Custom CSS -->
    <link rel="stylesheet" href="dashboard/dist/css/style.css" type="text/css">

    <link href="dashboard/dist/css/style.min.css" rel="stylesheet">
    <script src="https://kit.fontawesome.com/47f1aaf7ca.js" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.tiny.cloud/1/1dvwoen7mpwcn3jcbkd98qo9kas9hy7rlkt8ul00jera0bge/tinymce/6/tinymce.min.js" referrerpolicy="origin"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/css/select2.min.css" rel="stylesheet" />
    <style>
        /* Messages */
        .chat-online {
            color: #34ce57
        }

        .chat-offline {
            color: #e4606d
        }

        .chat-messages {
            display: flex;
            flex-direction: column;
            max-height: 800px;
            overflow-y: scroll
        }

        .chat-message-left,
        .chat-message-right {
            display: flex;
            flex-shrink: 0
        }

        .chat-message-left {
            margin-right: auto
        }

        .chat-message-right {
            flex-direction: row-reverse;
            margin-left: auto
        }

        .py-3 {
            padding-top: 1rem !important;
            padding-bottom: 1rem !important;
        }

        .px-4 {
            padding-right: 1.5rem !important;
            padding-left: 1.5rem !important;
        }

        .flex-grow-0 {
            flex-grow: 0 !important;
        }

        .border-top {
            border-top: 1px solid #dee2e6 !important;
        }

        .sm\:hidden {
            display: none !important;
        }

        .sm\:flex {
            display: flex;
            width: 100%;
        }

        .sm\:justify-between {
            justify-content: space-between;
        }

        .sm\:items-center {
            align-items: center;
        }

        .w-5 {
            width: 20px;
        }

        .h-5 {
            height: 20px;
        }

        .container_post img {
            width: 100%;
        }
    </style>
</head>

<body>
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
    <!-- Main wrapper - style you can find in pages.scss -->
    <!-- ============================================================== -->
    <div id="main-wrapper" data-theme="light" data-layout="vertical" data-navbarbg="skin6" data-sidebartype="full" data-sidebar-position="fixed" data-header-position="fixed" data-boxed-layout="full">
        <!-- ============================================================== -->
        <!-- Topbar header - style you can find in pages.scss -->
        <!-- ============================================================== -->
        <header class="topbar" data-navbarbg="skin6">
            <nav class="navbar top-navbar navbar-expand-lg">
                <div class="navbar-header" data-logobg="skin6">
                    <!-- This is for the sidebar toggle which is visible on mobile only -->
                    <a class="nav-toggler waves-effect waves-light d-block d-lg-none" href="" onclick="event.preventDefault()"><i class="ti-menu ti-close"></i></a>
                    <!-- ============================================================== -->
                    <!-- Logo -->
                    <!-- ============================================================== -->
                    <div class="navbar-brand d-flex justify-content-center">
                        <!-- Logo icon -->
                        <a href="./admin">
                            <img src="dashboard/assets/images/logo_fita.png" width="60px" alt="" class="img-fluid">
                        </a>
                    </div>
                    <!-- ============================================================== -->
                    <!-- End Logo -->
                    <!-- ============================================================== -->
                    <!-- ============================================================== -->
                    <!-- Toggle which is visible on mobile only -->
                    <!-- ============================================================== -->
                    <a class="topbartoggler d-block d-lg-none waves-effect waves-light" href="" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation"><i class="ti-more"></i></a>
                </div>
                <!-- ============================================================== -->
                <!-- End Logo -->
                <!-- ============================================================== -->
                <div class="navbar-collapse collapse" id="navbarSupportedContent">
                    <!-- ============================================================== -->
                    <!-- toggle and nav items -->
                    <!-- ============================================================== -->
                    <ul class="navbar-nav float-left me-auto ms-3 ps-1">
                        <!-- Notification -->
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle pl-md-3 position-relative" href="" id="bell" role="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <span><i data-feather="bell" class="svg-icon"></i></span>
                                <span class="badge text-bg-primary notify-no rounded-circle total-notification">{{ $notification_count > 99 ? '99+' : $notification_count }}</span>
                            </a>
                            <div class="dropdown-menu dropdown-menu-left mailbox animated bounceInDown">
                                <ul class="list-style-none w-100">
                                    <li>
                                        <div class="message-center notifications position-relative list-notification-admin">
                                            @if($noti_small)
                                            @foreach($noti_small as $notification)
                                            <a href="/admin/manage_reports/posts/report_{{ $notification->report_id }}" class="message-item d-flex align-items-center border-bottom px-3 py-2">
                                                <img src="front/img/users/{{ $notification->owner->avatar ?? 'default_user.png' }}" alt="user" class="rounded-circle mb-2" style="width: 40px;height: 40px;object-fit: cover;">
                                                <div class="w-75 d-inline-block v-middle ps-2">
                                                    <h6 class="message-title mb-0 mt-1">{{ $notification->owner->name }}
                                                        @if( $notification->status === 'new')
                                                        <span class="float-end"><span class="badge bg-success">NEW</span></span>
                                                        @endif
                                                    </h6>
                                                    <span class="font-12 text-nowrap d-block text-muted text-truncate">{{ $notification->content }}</span>
                                                    <span class="font-12 text-nowrap d-block text-muted">{{ formatTime($notification->created_at) }}</span>
                                                </div>
                                            </a>
                                            @endforeach
                                            @endif
                                        </div>
                                    </li>
                                    <li>
                                        <a class="nav-link pt-3 text-center text-dark" href="./admin/notification">
                                            <strong>Xem tất cả</strong>
                                            <i class="fa fa-angle-right"></i>
                                        </a>
                                    </li>
                                </ul>
                            </div>
                        </li>
                        <!-- End Notification -->
                        <!-- ============================================================== -->
                        <!-- create new -->
                        <!-- ============================================================== -->
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <i data-feather="settings" class="svg-icon"></i>
                            </a>
                            <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                                <a class="dropdown-item" href="#">Action</a>
                                <a class="dropdown-item" href="#">Another action</a>
                                <div class="dropdown-divider"></div>
                                <a class="dropdown-item" href="#">Something else here</a>
                            </div>
                        </li>
                    </ul>
                    <!-- ============================================================== -->
                    <!-- Right side toggle and nav items -->
                    <!-- ============================================================== -->
                    <ul class="navbar-nav float-end">
                        <!-- ============================================================== -->
                        <!-- Search -->
                        <!-- ============================================================== -->
                        <!-- <li class="nav-item d-none d-md-block">
                            <div class="nav-link" href="">
                                <form>
                                    <div class="customize-input">
                                        <input class="form-control custom-shadow custom-radius border-0 bg-white" type="search" placeholder="Search" aria-label="Search">
                                        <i class="form-control-icon" data-feather="search"></i>
                                    </div>
                                </form>
                            </div>
                        </li> -->
                        <!-- ============================================================== -->
                        <!-- User profile and search -->
                        <!-- ============================================================== -->
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle show" href="" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <img src="front/img/users/{{ Auth::user()->avatar ?? 'default_user.png'}}" alt="user" class="rounded-circle" style="width: 40px;height: 40px;object-fit: cover;">
                                <span class="ms-2 d-none d-lg-inline-block"><span>Hello,</span> <span class="text-dark">{{ Auth::user()->name }}</span> <i data-feather="chevron-down" class="svg-icon"></i></span>
                            </a>
                            <div class="dropdown-menu dropdown-menu-end dropdown-menu-right user-dd animated flipInY">
                                <a class="dropdown-item" href="./admin/manage_users/user_{{ Auth::user()->id }}"><i data-feather="user" class="svg-icon me-2 ms-1"></i>
                                    Thông tin cá nhân</a>
                                <a class="dropdown-item" href=""><i data-feather="mail" class="svg-icon me-2 ms-1"></i>
                                    Tin nhắn</a>
                                <div class="dropdown-divider"></div>
                                <a class="dropdown-item" href="./admin/manage_users/edit_{{ Auth::user()->id }}"><i data-feather="settings" class="svg-icon me-2 ms-1"></i>
                                    Cài đặt tài khoản</a>
                                <div class="dropdown-divider"></div>
                                <a class="dropdown-item" href="./admin/logout"><i data-feather="power" class="svg-icon me-2 ms-1"></i>
                                    Đăng xuất</a>
                            </div>
                        </li>
                        <!-- ============================================================== -->
                        <!-- User profile and search -->
                        <!-- ============================================================== -->
                    </ul>
                </div>
            </nav>
        </header>
        <!-- ============================================================== -->
        <!-- End Topbar header -->
        <!-- ============================================================== -->
        <!-- ============================================================== -->
        <!-- Left Sidebar - style you can find in sidebar.scss  -->
        <!-- ============================================================== -->
        <aside class="left-sidebar" data-sidebarbg="skin6">
            <!-- Sidebar scroll-->
            <div class="scroll-sidebar" data-sidebarbg="skin6">
                <!-- Sidebar navigation-->
                <nav class="sidebar-nav">
                    <ul id="sidebarnav">
                        <li class="sidebar-item {{ (request()->segment(1) == 'admin') ? 'active' : '' }}"> <a class="sidebar-link sidebar-link" href="./admin" aria-expanded="false"><i data-feather="home" class="feather-icon"></i><span class="hide-menu">Quản lý chung</span></a></li>
                        <li class="list-divider"></li>
                        <li class="nav-small-cap"><span class="hide-menu">Chức năng</span></li>

                        <li class="sidebar-item"> <a class="sidebar-link {{ (request()->segment(1) == 'admin/notification') ? 'active' : '' }}" href="./admin/notification" aria-expanded="false"><i data-feather="tag" class="feather-icon"></i><span class="hide-menu">Thông báo
                                </span></a>
                        </li>
                        <li class="list-divider"></li>
                        <li class="nav-small-cap"><span class="hide-menu">Quản lý Trang</span></li>
                        <li class="sidebar-item"> <a class="sidebar-link {{ (request()->segment(1) == 'admin/manage_posts') ? 'active' : '' }}" href="./admin/manage_posts" aria-expanded="false"><i data-feather="file-text" class="feather-icon"></i><span class="hide-menu">Quản lý bài viết </span></a>
                        </li>
                        <li class="sidebar-item"> <a class="sidebar-link {{ (request()->segment(1) == 'admin/manage_users') ? 'active' : '' }}" href="./admin/manage_users" aria-expanded="false"><i data-feather="users" class="feather-icon"></i><span class="hide-menu">Quản lý người dùng </span></a>
                        </li>
                        <li class="sidebar-item"> <a class="sidebar-link {{ (request()->segment(1) == 'admin/school_years') ? 'active' : '' }}" href="admin/school_years" aria-expanded="false"><i data-feather="bookmark" class="feather-icon"></i><span class="hide-menu">Cập nhật niên khóa </span></a>
                        </li>
                        <li class="sidebar-item"> <a class="sidebar-link {{ (request()->segment(1) == 'admin/manage_event') ? 'active' : '' }}" href="admin/manage_event" aria-expanded="false"><i data-feather="calendar" class="feather-icon"></i><span class="hide-menu">Sự kiện</span></a>

                        </li>
                        <li class="sidebar-item"> <a class="sidebar-link {{ (request()->segment(1) == 'admin/manage_subject') ? 'active' : '' }}" href="admin/manage_subject" aria-expanded="false"><i data-feather="book-open" class="feather-icon"></i><span class="hide-menu">Quản lý môn học</span></a>

                        </li>
                        <li class="sidebar-item">
                            <a class="sidebar-link has-arrow {{ (request()->segment(2) == 'manage_reports' && request()->segment(3) == 'posts') ? 'active' : '' }}" href="javascript:void(0)" aria-expanded="false">
                                <i data-feather="bar-chart" class="feather-icon"></i>
                                <span class="hide-menu">
                                    Quản lý báo cáo
                                </span>
                            </a>
                            <ul aria-expanded="false" class="collapse first-level base-level-line">
                                <li class="sidebar-item {{ (request()->segment(2) == 'manage_reports' && request()->segment(3) == 'posts') ? 'active' : '' }}">
                                    <a href="{{ url('admin/manage_reports/posts') }}" class="sidebar-link">
                                        <span class="hide-menu">Báo cáo bài viết</span>
                                    </a>
                                </li>
                                <li class="sidebar-item {{ (request()->segment(2) == 'manage_reports' && request()->segment(3) == 'comments') ? 'active' : '' }}">
                                    <a href="{{ url('admin/manage_reports/comments') }}" class="sidebar-link">
                                        <span class="hide-menu">Báo cáo bình luận</span>
                                    </a>
                                </li>
                            </ul>
                        </li>
                        <li class="list-divider"></li>

                        <li class="sidebar-item"> <a class="sidebar-link sidebar-link" href="./admin/logout" aria-expanded="false"><i data-feather="log-out" class="feather-icon"></i><span class="hide-menu">Đăng xuất</span></a></li>
                    </ul>
                </nav>
                <!-- End Sidebar navigation -->
            </div>
            <!-- End Sidebar scroll-->
        </aside>
        <!-- ============================================================== -->
        <!-- End Left Sidebar - style you can find in sidebar.scss  -->
        <!-- ============================================================== -->
        <!-- ============================================================== -->
        <!-- Page wrapper  -->
        <!-- ============================================================== -->
        <div class="page-wrapper">


            @yield('body')

            <!-- ============================================================== -->
            <!-- ============================================================== -->
            <!-- footer -->
            <!-- ============================================================== -->
            <footer class="footer text-center text-muted">
                Diễn đàn học tập khoa Công nghệ thông tin - Học viện Nông Nghiệp Việt Nam <a href="/">Forum Fita - Vnua</a>.
            </footer>
            <!-- ============================================================== -->
            <!-- End footer -->
            <!-- ============================================================== -->
        </div>
        <!-- ============================================================== -->
        <!-- End Page wrapper  -->
        <!-- ============================================================== -->
    </div>
    <!-- ============================================================== -->
    <!-- End Wrapper -->
    <!-- ============================================================== -->
    <!-- End Wrapper -->
    <!-- ============================================================== -->
    <!-- All Jquery -->
    <!-- ============================================================== -->
    <script src="dashboard/assets/libs/jquery/dist/jquery.min.js"></script>
    <script src="dashboard/assets/libs/popper.js/dist/umd/popper.min.js"></script>
    <script src="https://js.pusher.com/7.0/pusher.min.js"></script>

    <script src="dashboard/assets/libs/bootstrap/dist/js/bootstrap.bundle.min.js"></script>
    <!-- apps -->

    <!-- apps -->
    <script src="dashboard/dist/js/app-style-switcher.js"></script>
    <script src="dashboard/dist/js/feather.min.js"></script>
    <script src="dashboard/assets/libs/perfect-scrollbar/dist/perfect-scrollbar.jquery.min.js"></script>
    <script src="dashboard/dist/js/sidebarmenu.js"></script>
    <!--Custom JavaScript -->
    <script src="dashboard/dist/js/custom.min.js"></script>
    <script src="dashboard/dist/js/script.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/js/select2.min.js"></script>
    @yield('script')
    <script>
        $(document).ready(function() {
            // Khởi tạo Select2 cho thẻ select
            $('#subject').select2();

            // Gán sự kiện 'keyup' cho trường tìm kiếm
            $('#searchInput').on('keyup', function() {
                var value = $(this).val().toLowerCase(); // Lấy giá trị nhập vào và chuyển sang chữ thường

                // Lặp qua tất cả các tùy chọn trong thẻ select
                $('#subject option').filter(function() {
                    $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1); // Ẩn hiện các tùy chọn dựa trên kết quả tìm kiếm
                });
            });
        });

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
                        var listItem = $('<a href="./admin/manage_users/user_' + user.id + '" class="get-messages list-group-item list-group-item-action border-0" data-receiver-id="' + user.id + '">');
                        var badge = $('<div class="badge bg-success float-right">').text(user.unreadCount);
                        var image = $('<img src="front/img/users/' + avatar + '" class="rounded-circle mx-1 bg-light" alt="' + user.name + '" style="width: 40px;height: 40px;object-fit: cover;">');
                        var name = $('<div class="flex-grow-1 ml-3">').text(user.name);
                        var status = $('<div class="small">').html('<span class="fas fa-circle chat-' + (user.online ? 'online' : 'offline') + '"></span> ' + (user.online ? 'Online' : 'Offline'));

                        listItem.append(badge);
                        listItem.append($('<div class="d-flex align-items-center">').append(image).append(name.append(status)));
                        searchResults.append(listItem);
                    });
                },
                error: function(xhr, status, error) {
                    console.error(error);
                }
            });
        });

        var pusher = new Pusher('{{ env("PUSHER_APP_KEY") }}', {
            cluster: '{{ env("PUSHER_APP_CLUSTER") }}',
            encrypted: true
        });
        //Pusher
        var post_channel = pusher.subscribe('report-channel');

        //Like
        post_channel.bind('send-report-event', function(data) {
            // Kiểm tra xem người thích bài viết có phải là chủ bài viết không
            var avatar = data.avatar ? data.avatar : 'default_user.png';

            $(document).ready(function() {
                $(
                    '<a href="/admin/manage_reports/posts/report_' + data.report_id + '" class="message-item d-flex align-items-center border-bottom px-3 py-2">' +
                    '<img src="front/img/users/' + avatar + '" alt="user" class="rounded-circle mb-2" style="width: 40px;height: 40px;object-fit: cover;">' +
                    '<div class="w-75 d-inline-block v-middle ps-2">' +
                    '<h6 class="message-title mb-0 mt-1">' + data.user_report + ' <span class="float-end"><span class="badge bg-success">NEW</span></span></h6>' +
                    '<span class="font-12 text-nowrap d-block text-muted text-truncate">' + data.content + '</span>' +
                    '<span class="font-12 text-nowrap d-block text-muted">' + data.time + '</span>' +
                    '</div>' +
                    '</a>'
                ).prependTo($('.list-notification-admin'));
            });

            const spanElement = document.querySelector('.total-notification');
            const notificationCount = spanElement.innerText;

            $('.total-notification').html(data.notifications_count);
        });

        //TÌm kiếm sự kiện
        $('#searchInput').on('keyup', function() {
            var searchTerm = $(this).val().trim();
            var searchResultsContainer = $('#searchResultsEvents');

            // Xóa các kết quả tìm kiếm hiện tại
            searchResultsContainer.empty();

            if (searchTerm !== '') {
                // Gửi yêu cầu tìm kiếm bằng Ajax
                var url = 'admin/manage_event/search?searchTerm=' + encodeURIComponent(searchTerm);
                $.ajax({
                    url: url,
                    type: 'GET',
                    data: {
                        searchTerm: searchTerm
                    },
                    dataType: 'json',
                    success: function(response) {
                        response.forEach(function(event) {
                            var resultItem = $('<a href="./admin/manage_event/event_'+ event.id +'" class="list-group-item list-group-item-action">' +
                                '<div class="media d-flex justify-content-start">' +
                                '<div class="px-2">' +
                                '</div>' +
                                '<div class="media-body overflow-hidden" style="width: 100%;">' +
                                '<p class="fw-medium text-dark">' + event.title + '</p>' +
                                '</div>' +
                                '<h6 class="message-title mb-0 mt-1 float-end"><span class="badge bg-info">Event</span></h6>' +
                                '</div>' +
                                '</a>');

                            $('#searchResultsEvents').append(resultItem);
                        });
                    },
                    error: function(xhr, status, error) {
                        console.log(xhr.responseText);
                    }
                });
            }
        });
    </script>
</body>

</html>