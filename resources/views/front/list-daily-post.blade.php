@if($daily_posts)
@foreach($daily_posts->sortByDesc('created_at')->take(15) as $post)
<div class="media">
    <div class="rounded-img mr-3" style="background-image: url('front/img/users/{{ $post->user->avatar ?? 'default_user.png' }}')"></div>
    <div class="media-body">
        <div>
            <div class="d-flex justify-content-start align-items-center">
                <a href="" class="align-middle font-weight-bold">{{ $post->user->name }}</a>
            </div>
            <div>{!! $post->content !!}</div>
            <div class="d-flex justify-content-between">
                <p>{{ formatTime($post->created_at) }}</p>
                <i class="fa-solid fa-ellipsis" data-toggle="modal" data-target="#modal_{{ $post->id }}"></i>
                <div class="modal" style="background-color: rgba(0, 0, 0, 0.75);" tabindex="-1" role="dialog" id="modal_{{ $post->id }}">
                    <div class="modal-dialog modal-lg" role="document">
                        <div class="modal-content bg-light text-dark">
                            <!-- Modal header -->
                            <div class="modal-header">
                                <h5 class="modal-title">Được đăng bởi <span class="font-weight-bold">{{ $post->user->name }}</span></h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>

                            <!-- Modal body -->
                            <div class="modal-body">
                                <div class="row">
                                    <div class="col-2">
                                        <img src="front/img/users/{{ $post->user->avatar ?? 'default_user.png' }}" alt="" style="width: 50px;height: 50px;object-fit: cover;">
                                        <!-- <div class="rounded-img mr-3" style="background-image: url('front/img/users/user1.jpg')"></div> -->
                                    </div>
                                    <div class="col-10">
                                        <div class="d-flex justify-content-start align-items-center">
                                            <a href="" class="align-middle font-weight-bold"> {{ $post->user->name }} </a>
                                            <strong class="mr-2 ml-2"> - </strong>
                                            <div> {{ formatTime($post->created_at) }} </div>
                                            <strong class="mr-2 ml-2"> - </strong>
                                            <a href="./new_posts/post_{{ $post->id }}"> Xem chi tiết </a>
                                        </div>
                                        <hr>
                                        <div>
                                            {!! $post->content !!}
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Modal footer -->
                            <div class="d-flex bd-highlight modal-footer">
                                <div class="flex-grow-1">
                                    <div class="btn" data-bs-toggle="modal" data-bs-target="#modal_report_{{ $post->id }}">
                                        <span><i class="fa-solid fa-exclamation"></i></span> Report
                                    </div>
                                </div>
                                <div class="bd-highlight">
                                    <div class="d-flex justify-content-center">
                                        <div class="we-video-info">
                                            <ul>
                                                <li>
                                                    @if(Auth::check())
                                                    @php
                                                    $userLikes = $post->likes->pluck('user_id')->toArray();
                                                    $liked = in_array(Auth::user()->id, $userLikes);
                                                    @endphp
                                                    <span class="like like-btn-{{ $post->id }} {{ $post->likes->contains(auth()->user()->id) ? 'liked' : '' }}" data-toggle="tooltip" title="like" data-post-id="{{ $post->id }}" data-user-id="{{ auth()->user()->id }}">
                                                        <i class="fa-sharp fa-thumbs-up icon_like_{{ $post->id }} {{ $liked ? 'fa-solid' : 'fa-regular' }}"></i>
                                                        <ins class="likes-count-{{ $post->id }}" data-post-id="{{ $post->id }}">{{ format_number($post->likes->count()) }}</ins>
                                                    </span>
                                                    @else
                                                    <span data-toggle="tooltip" title="like">
                                                        <i class="fa-sharp fa-thumbs-up fa-regular"></i>
                                                        <ins>{{ format_number($post->likes->count()) }}</ins>
                                                    </span>
                                                    @endif
                                                </li>
                                                <li>
                                                    <span class="comment" data-toggle="tooltip" title="Comments">
                                                        <i class="fa fa-comments-o"></i>
                                                        <ins id="count_comment">{{ format_number($post->comments->count()) }}</ins>
                                                    </span>
                                                </li>
                                                <li>
                                                    <span class="comment" data-toggle="tooltip" title="Comments">
                                                        <i class='far fa-comment-dots'></i>
                                                        <a href="./new_posts/post_{{ $post->id }}">Bình luận</a>
                                                    </span>
                                                </li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <hr>
                            <div class="d-flex justify-content-between">
                                <div class="coment-area">
                                    <ul class="we-comet" id="comment" style="padding: 15px;">
                                        <!-- Bình luận bài viết -->
                                        @include('front.what_news.list-comment', ['comments' => $post->comments])
                                    </ul>
                                </div>
                                <!-- Modal -->
                                <div class="modal fade" style="background-color: rgba(0, 0, 0, 0.75);" id="modal_report_{{ $post->id }}" tabindex="-1" aria-labelledby="modal_report_{{ $post->id }}Label" aria-hidden="true">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="modal_report_{{ $post->id }}Label">Report content</h5>

                                                <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                                                    <span aria-hidden="true">&times;</span>
                                                </button>
                                            </div>
                                            <div class="modal-body">
                                                <table class="table">
                                                    <tr>
                                                        <th scope="col">Lý do báo cáo:</th>
                                                        <th scope="col">
                                                            <textarea class="form-control" placeholder="Nội dung báo cáo..." id="content_report_post_{{ $post->id }}"></textarea>
                                                        </th>
                                                    </tr>
                                                </table>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-primary btn-report-post-daily" data-id="{{ $post->id }}">Report</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endforeach
@endif