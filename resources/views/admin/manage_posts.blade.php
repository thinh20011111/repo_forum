@extends('admin.layout.master')

@section('title', 'Quản lý diễn đàn khoa CNTT - FITA VNUA || Quản lý bài viết')

@section('body')
<!-- ============================================================== -->
<!-- Bread crumb and right sidebar toggle -->
<!-- ============================================================== -->
<div class="page-breadcrumb">
    <div class="row">
        <div class="col-7 align-self-center">
            <h4 class="page-title text-truncate text-dark font-weight-medium mb-1">Quản lý bài viết <span class="text-danger">({{ $post_count }})</span></h4>
            <div class="d-flex align-items-center">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb m-0 p-0">
                        <li class="breadcrumb-item"><a href="./admin" class="text-muted">Trang chủ</a></li>
                        <li class="breadcrumb-item text-muted active" aria-current="page">Quản lý bài viết</li>
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
        <div class="col-sm-8">
            <div class="card">
                <div class="card-body">
                    <div class="tab-pane fade show active">
                        @if (empty($posts))
                        <div class="alert alert-info">
                            Không tìm thấy bài post nào.
                        </div>
                        @else
                        <div class="list-group mb-3">
                            @foreach($posts as $post)
                            <a href="./admin/manage_posts/post_{{ $post->id }}" class="list-group-item list-group-item-action">
                                <div class="media d-flex justify-content-start">
                                    <div class="px-2">
                                        <img src="front/img/users/{{ $post->user->avatar ?? 'default_user.png' }}" alt="user" class="rounded-circle w-20" style="width: 40px;height: 40px;object-fit: cover;">
                                    </div>
                                    <div class="media-body overflow-hidden" style="width: 100%;">
                                        <p class="fw-medium"><span title="{{ $post->subject_->name ?? '' }}" class="badge bg-{{ collect(['primary', 'secondary', 'success', 'danger', 'warning', 'info', 'dark'])->random()}} text-white tag-subject">{{ $post->subject_->name ?? '' }}</span> {{ $post->title ?? 'Trống' }}</p>
                                        <p>{{ $post->user->name }} <span>{{$post->school_year ? '. K'.$post->school_year_->name : ''}}</span> <span>{{$post->specialized ? '. '.$post->specialized_->name : ''}}</span> . <span>{{ formatTime($post->created_at) }}</span></p>

                                        <p>Tags: @foreach($post->tags as $tag)
                                            <span class="tag badge badge-badge bg-secondary text-white mr-2">{{ $tag->name }}</span>
                                            @endforeach
                                        </p>
                                        <p><i class="fa-solid fa-thumbs-up"></i> : {{ $post->like_count ?? 0 }}<span> . <i class="fa-sharp fa-solid fa-comments"></i></span> : {{ $post->comment_count ?? 0 }} . <span><i class="fa-solid fa-eye"></i></span> : {{ $post->view_count ?? 0 }}</p>
                                    </div>
                                    @if($post->story_post == 1)
                                    <h6 class="message-title mb-0 mt-1 float-end"><span class="badge bg-success">Story</span></h6>
                                    @elseif($post->daily_post == 1)
                                    <h6 class="message-title mb-0 mt-1 float-end"><span class="badge bg-warning">Daily</span></h6>
                                    @elseif($post->event_post != 1)
                                    <h6 class="message-title mb-0 mt-1 float-end"><span class="badge bg-info">Post</span></h6>
                                    @endif

                                </div>
                            </a>
                            @endforeach
                        </div>
                        <br>
                        <div>
                            {{ $posts->links() }}
                        </div>
                        @endif
                    </div>
                </div>

            </div>

        </div>
        <div class="col-sm-4">
            <div class="card">
                <div class="card-body">
                    <form action="">
                        <h4 class="widget-title"><span><i class="fa-solid fa-magnifying-glass mr-3"></i></i></span> Tìm kiếm bài viết</h4>
                        <div class="input-group mb-3 p-2">
                            <input name="search" value="{{request('search')}}" id="search" type="text" class="form-control" placeholder="Nhập tiêu đề, tên người dùng, tags...">
                            <div class="input-group-append">
                                <button class="btn btn-outline-secondary" type="submit">
                                    <i class="fas fa-search"></i>
                                </button>
                            </div>
                        </div>
                    </form>

                    <div class="font-weight-bold mb-3"><span><i data-feather="filter" class="feather-icon"></i></span> Lọc bài viết</div>
                    <form action="">
                        <div class="mb-3">
                            <select name="sort_by" class="form-select" onchange="this.form.submit();">
                                <option {{ request('sort_by') ==  'oldest' ? 'selected' : ''}} value="oldest">Bài viết mới nhất</option>
                                <option {{ request('sort_by') ==  'latest' ? 'selected' : ''}} value="latest">Bài viết cũ nhât</option>
                            </select>
                        </div>
                        <div class="mb-3">
                            <div class="font-weight-bold">Bộ môn</div>
                            <select name="specialized" id="specialized" class="form-select" onchange="this.form.submit();">
                                <option selected value="">---Bộ môn---</option>
                                @foreach($specialized as $sp)
                                <option value="{{ $sp->id }}" {{ request('specialized') == $sp->id ? 'selected' : '' }}>
                                    {{ $sp->name }}
                                </option>
                                @endforeach
                            </select>

                        </div>
                        <div class="mb-3">
                            <div class="font-weight-bold">Môn học</div>
                            <select id="subject" class="custom-select" name="subject" onchange="this.form.submit();">
                                <option selected value="">---Môn học---</option>
                                @foreach($subjects as $subject)
                                <option value="{{ $subject->id }}" {{ request('subject') ==  $subject->id ? 'selected' : ''}}>{{ $subject->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="mb-3">
                            <div class="font-weight-bold">Danh mục</div>
                            <select class="form-select" name="category" onchange="this.form.submit();">
                                <option selected value="">---Chọn danh mục---</option>

                                @foreach($categories as $category)
                                <option value="{{ $category->id }}" {{ request('category') ==  $category->id ? 'selected' : ''}}>{{ $category->name }}</option>
                                @endforeach

                            </select>
                        </div>
                    </form>

                    <a href="./admin/manage_posts" class="btn btn-warning">Bỏ lọc</a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection