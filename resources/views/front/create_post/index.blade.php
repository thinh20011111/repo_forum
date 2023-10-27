@extends('front.layout.master')

@section('title', 'Diễn đàn khoa CNTT - FITA VNUA || Đăng bài')

@section('body')
<div class="col-lg-6">
    <div class="central-meta">
        <div class="new-postbox">
            <form method="post" enctype="multipart/form-data" class="d-grid gap-3">
                @csrf
                <div class="mb-3">
                    <div class="font-weight-bold">Chọn nội dung bài đăng <span class="text-danger">*</span></div>
                    <select class="custom-select @error('type') is-invalid @enderror" name="type" id="type-select">
                        <option selected value="" disabled>---Chọn nội dung bài đăng---</option>
                        @foreach($types as $type)
                        <option value="{{ $type->id }}">{{ $type->name }}</option>
                        @endforeach
                    </select>
                    @error('type')
                    <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                <div class="mb-3">
                    <div class="font-weight-bold">Danh mục<span class="text-danger">*</span></div>
                    <select class="custom-select @error('category') is-invalid @enderror" name="category">
                        <option selected value="" disabled>---Chọn danh mục---</option>
                        @foreach($categories as $category)
                        <option value="{{ $category->id }}">{{ $category->name }}</option>
                        @endforeach
                    </select>
                    @error('category')
                    <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                <div class="mb-3">
                    <div class="font-weight-bold">Chủ đề</div>
                    <input class="form-control" type="text" placeholder="Chủ đề bài đăng" aria-label="chủ đề" name="topic" value="{{ old('topic') }}">
                </div>

                <div class="mb-3" id="specialized-section">
                    <div class="font-weight-bold">Chuyên ngành</div>
                    <select id="specialized" class="custom-select" name="specialized">
                        <option selected value="" disabled>---Chuyên ngành---</option>
                        @foreach($specialized as $specialized)
                        <option value="{{ $specialized->id }}">{{ $specialized->name }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="mb-3" id="subject-section">
                    <div class="font-weight-bold">Môn học</div>
                    <select id="subject" class="custom-select" name="subject">
                        <option selected value="">---Môn học---</option>
                        @foreach($subjects as $subject)
                        <option value="{{ $subject->id }}">{{ $subject->name }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="mb-3" id="school-year">
                    <div class="font-weight-bold">Niên Khóa</div>
                    <select class="custom-select" name="school_year">
                        <option selected disabled>---Khóa---</option>
                        @foreach($school_years as $number)
                        <option value="{{$number->id}}">{{$number->name}}</option>
                        @endforeach
                    </select>
                </div>

                <div class="mb-3" id="list-tags">
                    <div class="tag-container">
                        <div class="font-weight-bold">Tags</div>
                        <div id="tag-input" class="input-group">
                            <input type="text" id="tag-text" class="form-control" placeholder="Nhập tag" />
                            <div class="input-group-append">
                                <button type="button" id="add-button" class="btn btn-primary">Thêm</button>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="mb-3">
                    <div class="font-weight-bold">Tiêu đề <span class="text-danger">*</span></div>
                    <input class="form-control @error('title') is-invalid @enderror" type="text" placeholder="Tiêu đề bài đăng" aria-label="tiêu đề" name="title" value="{{ old('title') }}">
                    @error('title')
                    <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <div class="font-weight-bold">Tệp</div>
                    <div class="custom-file">
                        <input type="file" class="custom-file-input" id="inputGroupFile01" aria-describedby="inputGroupFileAddon01" name="file_path">
                        <label class="custom-file-label" for="inputGroupFile01">Chọn tệp</label>
                    </div>
                </div>

                <div class="font-weight-bold">Nội dung <span class="text-danger">*</span></div>
                <textarea class="@error('content') is-invalid @enderror" rows="2" placeholder="write something" id="content" name="content">{{ old('content') }}</textarea>
                @error('content')
                <div class="invalid-feedback">{{ $message }}</div>
                @enderror

                <div class="attachments">
                    <ul>
                        <li>
                            <button type="submit">Đăng bài</button>
                        </li>
                    </ul>
                </div>
            </form>

            <script>
                document.getElementById('type-select').addEventListener('change', function() {
                    var specializedSection = document.getElementById('specialized-section');
                    var subjectSection = document.getElementById('subject-section');
                    var school_year = document.getElementById('school-year');



                    if (this.value === '2') {
                        specializedSection.style.display = 'none';
                        subjectSection.style.display = 'none';
                        school_year.style.display = 'none';
                    } else {
                        specializedSection.style.display = 'block';
                        subjectSection.style.display = 'block';
                        school_year.style.display = 'block';
                    }
                });
            </script>

        </div>
    </div><!-- add post new box -->
</div><!-- centerl meta -->

<div class="col-lg-3">
    <aside class="sidebar static">
        <div class="widget">
            <div class="banner medium-opacity bluesh">
                <div class="bg-image" style="background-image: url(front/img/resources/baner-widgetbg.jpg)"></div>
                <div class="baner-top">
                    <span><img alt="" src="front/img/book-icon.png"></span>
                    <i class="fa fa-ellipsis-h"></i>
                </div>
                <div class="banermeta">
                    <p>
                        create your own favourit page.
                    </p>
                    <span>like them all</span>
                </div>
            </div>
        </div>

        @if(Auth::check())
        <div class="widget friend-list stick-widget">
            <h4 class="widget-title">Người theo dõi</h4>
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

    </aside>
</div><!-- sidebar -->


<script src="front/js/tinimce.js"></script>
<script>
    const tagContainer = document.querySelector(".tag-container");
    const tagInput = document.getElementById("tag-text");
    const addButton = document.getElementById("add-button");

    addButton.addEventListener("click", function() {
        const tagText = tagInput.value.trim();
        if (tagText !== "") {
            createTag(tagText);
            tagInput.value = "";
        }
    });

    function createTag(text) {
        const tag = document.createElement("span");
        tag.classList.add("tag", "badge", "badge-secondary", "mr-2");
        tag.innerHTML = `<input type="hidden" name="tags[]" value="${text}">${text}<i class="delete-button fas fa-times ml-2"></i>`;
        tagContainer.appendChild(tag);

        const deleteButton = tag.querySelector(".delete-button");
        deleteButton.addEventListener("click", function() {
            tag.remove();
        });
    }
</script>
@endsection