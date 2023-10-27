@extends('front.layout.master')

@section('title', 'Diễn đàn khoa CNTT - FITA VNUA || Trang chủ')

@section('body')
<div class="col-lg-6">
    @foreach($subjects as $subject)
    <div class="central-meta item">
        <h4 class="font-weight-bold mb-2">{{ $subject->name }}</h4>
        <hr>
        <br>
        @foreach($subject->posts->take(5) as $post)
        <a href="./new_posts/post_{{ $post->id }}" class="list-group-item list-group-item-action">
            <div class="media d-flex justify-content-start">
                <div class="rounded-img mr-3" style="background-image: url('front/img/users/{{ $post->user->avatar ?? 'default_user.png' }}');"></div>
                <div class="media-body overflow-hidden">
                    <p class="font-weight-bold text-dark"><span title="{{ $post->subject_->name ?? '' }}" class="badge bg-{{ collect(['primary', 'secondary', 'success', 'danger', 'warning', 'info', 'dark'])->random()}} text-white tag-subject">{{ $post->subject_->name ?? '' }}</span> {{ $post->title }}</p>
                    <p>{{ $post->user->name }} <span>{{$post->school_year ? '. K'.$post->school_year_->name : ''}}</span> <span>{{$post->specialized ? '. '.$post->specialized_->name : ''}}</span> . <span>{{ formatTime($post->created_at) }}</span></p>
                    @foreach($post->tags as $tag)
                    <span class="tag badge badge-badge bg-secondary text-white mr-2">{{ $tag->name }}</span>
                    @endforeach
                    <p><i class="fa-solid fa-thumbs-up"></i> : {{ $post->likes->count() }}<span> . <i class="fa-sharp fa-solid fa-comments"></i></span> : {{ $post->comment_count ?? 0 }} . <span><i class="fa-solid fa-eye"></i></span> : {{ $post->view_count ?? 0 }}</p>
                </div>
            </div>
        </a>
        @endforeach
    </div>
    @endforeach

    <div class="central-meta item">
        <h4 class="font-weight-bold mb-2">Story mới</h4>
        <hr>
        <br>
        <div class="slider" id="list_stories">
            @if(Auth::check())
            <a class="d-flex justify-content-center" id="addStory">
                <div class="mr-3 d-flex align-items-end justify-content-center blur-story rounded" style="background-image: url('front/img/users/{{ Auth::user()->avatar ?? 'default_user.png' }}'); width: 150px; height: 150px; background-position: center;">
                    <div class="d-flex justify-content-center align-items-center mb-3" data-toggle="modal" data-target="#create-story-modal">
                        <img src="front/img/addStory.jpg" alt="Add story" title="thêm mới story" style="width: 50px;height: 50px;object-fit: cover; border-radius: 50%;">
                    </div>
                </div>
            </a>
            @endif

            @foreach($stories as $story)
            <a class="d-flex justify-content-center" href="./new_posts/post_{{ $story->id }}" id="story_{{ $story->id }}">
                <div id="bg_story_{{ $story->id }}" class="mr-3 blur-story rounded" style="background-image: url('front/img/stories/{{ $story->image }}');background-size: cover; width: 150px; height: 150px;">
                    <div class="d-flex align-items-start flex-column bd-highlight mb-3 h-100">
                        <img class="mb-auto p-2 bd-highlight" src="front/img/users/{{ $story->user->avatar ?? 'default_user.png' }}" alt="" style="width: 50px;height: 50px;object-fit: cover; border-radius: 50%;">
                        <p class="text-white align-middle m-2 fw-bolder font-weight-bold">{{ $story->user->name }}</p>
                    </div>
                </div>
            </a>
            @endforeach
        </div>

    </div>

    <!-- Modal create story-->
    <div class="modal fade" style="background-color: rgba(0, 0, 0, 0.75);" id="create-story-modal" tabindex="-1" role="dialog" aria-labelledby="createStoryTitle" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title font-weight-bold" id="createStoryTitle">Tạo story mới</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form method="post" id="story-post-form" enctype="multipart/form-data">
                    @csrf
                    <div class="modal-body">
                        <textarea name="story_content" id="story_content" placeholder="Nội dung..."></textarea>
                        <span id="content-error" class="text-danger"></span>
                        <label for="image_story" id="post-image-label" class="w-100 mt-2">
                            <img id="post-image-preview" src="{{ asset('front/img/default_img.png') }}" alt="Hình ảnh" title="Chọn hình ảnh cho bài viết" width="100%">
                        </label>
                        <input type="file" name="image_story" id="image_story" style="display: none;">
                        <span id="image-error" class="text-danger"></span>
                    </div>
                    <div class="modal-footer">
                        <div class="post-comt-box">
                            <form method="post">
                                <div class="attachments">
                                    <button type="button" id="submit-story-post">Đăng</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div class="central-meta item">
        <h4 class="font-weight-bold mb-2">Chia sẻ ngày của bạn</h4>
        <hr>
        <br>
        @if(Auth::check())
        <form action="">
            <textarea type="text" id="content_daily_post" class="form-control" placeholder="Hãy chia sẻ ngày của bạn...."></textarea>
            <small id="notification-error" class="text-danger"></small>
            <div class="attachments">
                <button type="submit" id="btn-daily-post">Chia sẻ</button>
            </div>
        </form>
        <hr>
        <br>
        @endif
        <div id="list_daily_post">
            @include('front.list-daily-post', ['daily_posts' => $daily_posts])
        </div>
    </div>

    <div class="central-meta item">
        <h4 class="font-weight-bold mb-2">Học tập</h4>
        <hr>
        <br>
        <div class="row">
            <div class="col-sm-3 p-2">
                <div class="nav flex-column nav-pills" id="v-pills-tab" role="tablist" aria-orientation="vertical">
                    @foreach($specializeds as $specialized)
                    <a class="shadow mb-3 rounded nav-link {{ $specialized->id == '1' ? 'active' : '' }}" id="v-pills-{{ $specialized->id }}-tab" data-toggle="pill" href="#v-pills-{{ $specialized->id }}" role="tab" aria-controls="v-pills-{{ $specialized->id }}" aria-selected="true">{{ $specialized->name }}</a>
                    @endforeach
                </div>
            </div>
            <div class="col-sm-9">
                <div class="tab-content" id="v-pills-tabContent">
                    @foreach($specializeds as $specialized)
                    <div class="tab-pane fade show {{ $specialized->id == 1 ? 'active' : '' }}" id="v-pills-{{ $specialized->id }}" role="tabpanel" aria-labelledby="v-pills-{{ $specialized->id }}-tab">
                        <div class="list-group">
                            @foreach($school_years as $year)
                            @php
                            $subjects = [];
                            $subjectPostsCount = [];
                            $latestPost = null;
                            @endphp
                            @foreach($year->posts as $post)
                            @if($post->specialized == $specialized->id)
                            @php
                            $subjectName = $post->subject_->name ?? '';
                            if (!in_array($subjectName, $subjects)) {
                            $subjects[] = $subjectName;
                            $subjectPostsCount[$subjectName] = 1;
                            } else {
                            $subjectPostsCount[$subjectName]++;
                            }

                            if ($latestPost === null || $post->created_at > $latestPost->created_at) {
                            $latestPost = $post;
                            }
                            @endphp
                            @endif
                            @endforeach

                            @if(count($subjects) > 0 && $latestPost !== null)
                            <div class="list-group-item list-group-item-action">
                                <div class="d-flex align-items-center row">
                                    <h5 class="col-10 font-weight-bold"><span><i class="fa-sharp fa-solid fa-folder-open"></i></span> Khóa {{ $year->name}}</h5>
                                    <p class="text-center col-2">{{ count($subjects) }}<br><span>Bài viết</span></p>
                                </div>
                                <div>
                                    <ul class="list-group list-group-flush"> <!-- Add 'list-group-flush' class to remove border styling -->
                                        @foreach($subjects as $subject)
                                        <li class="list-group-item d-flex justify-content-between align-items-center cursor-pointer">{{ $subject }} <span class="badge badge-primary badge-pill">{{ $subjectPostsCount[$subject] }} bài viết</span></li>
                                        @endforeach
                                    </ul>
                                </div>
                                <hr>
                                <p class="font-italic">Bài viết gần nhất</p>
                                <div>
                                    <a href="./new_posts/post_{{ $latestPost->id }}" class="list-group-item list-group-item-action">
                                        <div class="media d-flex justify-content-start">
                                            <div class="rounded-img mr-3" style="background-image: url('front/img/users/{{ $latestPost->user->avatar ?? 'default_user.png' }}');"></div>
                                            <div class="media-body overflow-hidden">
                                                <p class="font-weight-bold text-dark"><span title="{{ $latestPost->subject_->name ?? '' }}" class="badge bg-{{ collect(['primary', 'secondary', 'success', 'danger', 'warning', 'info', 'dark'])->random()}} text-white tag-subject">{{ $latestPost->subject_->name ?? '' }}</span> {{ $latestPost->title }}</p>
                                                <p>{{ $latestPost->user->name }} <span>{{$latestPost->school_year ? '. K'.$latestPost->school_year_->name : ''}}</span> <span>{{$latestPost->specialized ? '. '.$latestPost->specialized_->name : ''}}</span> . <span>{{ formatTime($latestPost->created_at) }}</span></p>
                                                @foreach($latestPost->tags as $tag)
                                                <span class="tag badge badge-badge bg-secondary text-white mr-2">{{ $tag->name }}</span>
                                                @endforeach
                                                <p><i class="fa-solid fa-thumbs-up"></i> : {{ $latestPost->likes->count() }}<span> . <i class="fa-sharp fa-solid fa-comments"></i></span> : {{ $latestPost->comment_count ?? 0 }} . <span><i class="fa-solid fa-eye"></i></span> : {{ $latestPost->view_count ?? 0 }}</p>
                                            </div>
                                        </div>
                                    </a>
                                </div>
                            </div>
                            @endif
                            @endforeach
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
    <div class="central-meta item">
        <h4 class="font-weight-bold mb-2">Cộng đồng</h4>
        <hr>
        <br>
        <div class="container">
            <div class="row">
                <div class="col-sm-9">
                    <div class="tab-content" id="v-pills-tabContent">

                        @foreach($categories as $category)
                        <div class="tab-pane fade show {{ $category->id == 1 ? 'active' : '' }}" id="v-pills-category-{{ $category->id }}" role="tabpanel" aria-labelledby="v-pills-category-{{ $category->id }}">
                            <div class="list-group">
                                <div class="d-flex align-items-center row">

                                    <p style="margin-left: 15px; margin-right: 15px; width: 100%;">{{ $category->name  }} <span class="float-right">{{format_number($category->posts()->where('type', 2)->count()) }} Bài viết</span></p>
                                </div>
                                @foreach($category->posts()->where('type', 2)->latest()->take(5)->get() as $post)
                                <div class="list-group-item list-group-item-action">
                                    <p class="font-italic">Bài viết gần nhất</p>
                                    <div>
                                        <a href="./new_posts/post_{{ $post->id }}" class="list-group-item list-group-item-action">
                                            <div class="media d-flex justify-content-start">
                                                <div class="rounded-img mr-3" style="background-image: url('front/img/users/{{ $post->user->avatar ?? 'default_user.png' }}');"></div>
                                                <div class="media-body overflow-hidden">
                                                    <p class="font-weight-bold text-dark"><span title="{{ $post->subject_->name ?? '' }}" class="badge bg-{{ collect(['primary', 'secondary', 'success', 'danger', 'warning', 'info', 'dark'])->random()}} text-white tag-subject">{{ $post->subject_->name ?? '' }}</span> {{ $post->title }}</p>
                                                    <p>{{ $post->user->name }} <span>{{ $post->school_year ? '. K'.$post->school_year_->name : '' }}</span> <span>{{ $post->specialized ? '. '.$post->specialized_->name : '' }}</span> . <span>{{ formatTime($post->created_at) }}</span></p>
                                                    @foreach($post->tags as $tag)
                                                    <span class="tag badge badge-badge bg-secondary text-white mr-2">{{ $tag->name }}</span>
                                                    @endforeach
                                                    <p><i class="fa-solid fa-thumbs-up"></i> : {{ $post->likes->count() }}<span> . <i class="fa-sharp fa-solid fa-comments"></i></span> : {{ $post->comment_count ?? 0 }} . <span><i class="fa-solid fa-eye"></i></span> : {{ $post->view_count ?? 0 }}</p>
                                                </div>
                                            </div>
                                        </a>
                                    </div>
                                </div>
                                @endforeach

                            </div>
                        </div>
                        @endforeach

                    </div>
                </div>
                <div class="col-sm-3 p-2">
                    <div class="nav flex-column nav-pills" id="v-pills-tab" role="tablist" aria-orientation="vertical">
                        @foreach($categories as $category)
                        <a class="shadow rounded mb-3 nav-link {{ $category->id == 1 ? 'active' : '' }}" id="v-pills-category-tab-{{ $category->id }}" data-toggle="pill" href="#v-pills-category-{{ $category->id }}" role="tab" aria-controls="v-pills-category-{{ $category->id }}" aria-selected="true">{{ $category->name }}</a>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>

</div>

<div class="col-lg-3">
    <aside class="sidebar static">
        <div class="widget">
            <form action="list_member">
                <h4 class="widget-title"><span><i class="fa-solid fa-magnifying-glass mr-2"></i></i></span>Tìm kiếm thành viên</h4>
                <div class="input-group mb-3 p-2">
                    <input type="text" name="search_member" value="{{ request('search_member') }}" class="form-control" placeholder="Tên thành viên...">
                    <div class="input-group-append">
                        <button class="btn btn-outline-secondary" type="submit">
                            <i class="fas fa-search"></i>
                        </button>
                    </div>
                </div>
            </form>
        </div>

        @foreach($events as $event)
        <div class="widget">
            <div class="banner medium-opacity bluesh">
                <div class="bg-image" style="background-image: url(front/img/event_post/{{ $event->image }})"></div>
                <div class="baner-top">
                    <span><img alt="" src="front/img/book-icon.png"></span>
                    <i class="fa fa-ellipsis-h"></i>
                </div>
                <div class="banermeta">
                    <p>
                        {{ $event->title }}
                    </p>
                    <span><a href="./new_posts/post_{{ $event->id }}">xem chi tiết...</a></span>
                </div>
            </div>
        </div>
        @endforeach

        <div class="widget">
            <h4 class="widget-title"><span><i class="fa-solid fa-users mr-2"></i></span>Đang online</h4>
            <div class="m-3">
                <div>Đang trực tuyến: {{ $online }}</div><br>
                <p>Giảng viên: {{ $users->where('level', 1)->count() }}</p>
                <p>Sinh viên: {{$users->where('level', 2)->count()}}</p>
                <p>Admin: {{$users->where('level', 0)->count()}}</p>
            </div>
        </div>

        @if(Auth::check())
        <div class="widget friend-list">
            <h4 class="widget-title"><span><i class="fa-solid fa-users mr-2"></i></span>Người theo dõi</h4>
            <div id="searchDir"></div>
            <ul id="people-list" class="friendz-list">
                @foreach(Auth::user()->followers as $follower)
                <li>
                    <figure>
                        <img src="front/img/users/{{ $follower->avatar ?? 'default_user.png' }}" style="width: 40px;height: 40px;object-fit: cover;" alt="">
                        <span class="status f-{{ $follower->status == 1 ? 'online' : 'offline' }}"></span>
                    </figure>
                    <div class="friendz-meta">
                        <a href="./user-profile-post-{{ $follower->id }}">{{ $follower->name }}</a>
                        <i><a href="./user-profile-post-{{ $follower->id }}" class="__cf_email__">{{ $follower->email }}</a></i>
                    </div>
                </li>
                @endforeach
            </ul>
        </div><!-- friends list sidebar -->
        @endif

        <div class="widget">
            <h4 class="widget-title"><span><i class="fa-solid fa-chart-simple mr-3"></i></span>Thống kê</h4>
            <div class="m-3">
                <div class="row">
                    <h6 class="col-6">Thành viên:</h6>
                    <p class="col-6 text-center">{{ $users->count() }}</p>
                </div>
                <div class="row">
                    <h6 class="col-6">Bài viết:</h6>
                    <p class="col-6 text-center">{{ $total_posts }}</p>
                </div>
            </div>
        </div>
    </aside>
</div><!-- sidebar -->

<script src="front/js/tinimce.js"></script>
<script src="front/js/reaction-post.js"></script>
<script>
    $(document).ready(function() {
        $('.story-slider').slick({

        });
    });

    $(document).ready(function() {
        $('.slider').slick({
            infinite: false,
            speed: 300,
            slidesToShow: 4,
            slidesToScroll: 4,
            responsive: [{
                    breakpoint: 1024,
                    settings: {
                        slidesToShow: 3,
                        slidesToScroll: 3,
                        infinite: true,
                        dots: true,
                    }
                },
                {
                    breakpoint: 600,
                    settings: {
                        slidesToShow: 2,
                        slidesToScroll: 2
                    }
                },
                {
                    breakpoint: 480,
                    settings: {
                        slidesToShow: 1,
                        slidesToScroll: 1
                    }
                }
            ]
        });

    });

    $("input[name='image_story']").change(function() {
        readURL(this);
    });

    function readURL(input) {
        if (input.files && input.files[0]) {
            var reader = new FileReader();
            reader.onload = function(e) {
                $("#post-image-preview").attr("src", e.target.result);
            }
            reader.readAsDataURL(input.files[0]);
        }
    }

    $(document).ready(function() {
        // Lấy dữ liệu đã lưu trong localStorage
        var content = localStorage.getItem('story_content');
        var image = localStorage.getItem('image_story');

        // Điền giá trị đã lưu vào các trường
        if (content) {
            tinymce.get('story_content').setContent(content);
        }
        // if (image) {
        //     $('#image_story').val(image);
        // }

        $('#submit-story-post').click(function(event) {
            event.preventDefault();
            var content = tinymce.get('story_content').getContent();
            var image = $('#image_story')[0].files[0];
            var formData = new FormData();
            formData.append('content', content);
            formData.append('image', image);

            // Lưu dữ liệu vào localStorage
            localStorage.setItem('story_content', content);
            localStorage.setItem('image_story', image);

            $.ajax({
                url: '/create_new_story',
                type: 'POST',
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                data: formData,
                processData: false,
                contentType: false,
                success: function(response) {
                    // Xóa dữ liệu đã lưu khi submit thành công
                    localStorage.removeItem('story_content');
                    localStorage.removeItem('image_story');

                    if (response.success) {
                        console.log('Thành công!');
                        // Xóa nội dung trong form
                        $('#story-post-form')[0].reset();
                        tinymce.get('story_content').setContent('');
                        $('#post-image-preview').attr('src', '{{ asset("front/img/default_img.png")}}');
                        // console.log(response)
                        $('#content-error').text('');
                        $('#image-error').text('');
                        document.querySelector('[data-dismiss="modal"]').click();

                        if (response.exist != null) {
                            $('#bg_story_' + response.id).css('background-image', 'url(\'front/img/stories/' + response.image + '\')');

                            console.log(response.new_id);
                            $('div#bg_story_' + response.id).attr('id', 'bg_story_' + response.new_id);
                            $('a#story_' + response.id).attr('id', 'story_' + response.new_id);
                            $('a#story_' + response.new_id).attr('href', './new_posts/post_' + response.new_id);

                            console.log(response.user_id);
                            console.log(response.id);
                        } else {
                            // Lấy danh sách slide của slider
                            var slider = $('.slider');
                            var avatar = response.avatar ? response.avatar : 'default_user.png';
                            var newStory = '<a class="d-flex justify-content-center" href="./new_posts/post_' + response.id + '" id="story_' + response.id + '">' +
                                '<div id="bg_story_' + response.id + '" class="mr-3 blur-story rounded" style="background-image: url(\'front/img/stories/' + response.image + '\');background-size: cover; width: 150px; height: 150px;">' +
                                '<div class="d-flex align-items-start flex-column bd-highlight mb-3 h-100">' +
                                '<img class="mb-auto p-2 bd-highlight" src="front/img/users/' + avatar + '" alt="" style="width: 50px;height: 50px;object-fit: cover; border-radius: 50%;">' +
                                '<p class="text-white align-middle m-2 fw-bolder font-weight-bold">' + response.name + '</p>' +
                                '</div>' +
                                '</div>' +
                                '</a>';

                            var firstSlideIndex = $('.slider .slick-slide[id="addStory"]').data('slick-index');

                            // Thêm đoạn mã HTML mới vào slider
                            $('.slider').slick('slickAdd', newStory, firstSlideIndex);
                        }
                        alert('Đăng thành công!');
                    } else {
                        $.each(response.errors, function(key, value) {
                            if (key == 'image') {
                                $('#' + key + '-error').text(value[0]);
                                $('#content-error').text('');
                            } else if (key == 'content') {
                                $('#' + key + '-error').text(value[0]);
                                $('#image-error').text('');
                            } else {
                                $('#' + key + '-error').text(value[0]);
                            }
                        });
                    }
                }
            });
        });
    });
</script>
@endsection