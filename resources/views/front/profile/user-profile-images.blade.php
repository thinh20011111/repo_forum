@extends('front.profile.master')

@section('title', 'Diễn đàn khoa CNTT - FITA VNUA || Trang cá nhân')

@section('body')
<div class="central-meta">
    <ul class="photos">
        @if($stories->count() > 0)
        @foreach($stories as $story)
        <li>
            <a class="strip" href="front/img/stories/{{ $story->image }}" title="" data-strip-group="mygroup" data-strip-group-options="loop: false">
                <img src="front/img/stories/{{ $story->image }}" alt="" />
            </a>
        </li>
        @endforeach
        @else
        <div class="col">
            <div class="alert alert-warning" role="alert">
                Không có hình ảnh nào!
            </div>
        </div>
        @endif
    </ul>
</div>
@endsection