@foreach($comments as $comment)
@if($comment->reply_id == 0)
<li id="parent-comment-{{ $comment->id }}">
    <div class="comet-avatar">
        <img src="front/img/users/{{ $comment->user->avatar ?? 'default_user.png' }}" style="min-width: 50px;min-height: 50px;max-width: 50px;max-height: 50px;object-fit: cover;" alt="" />
    </div>
    <div class="we-comment">
        <div class="coment-head">
            <h5>
                <a href="./user-profile-post-{{ $comment->user->id }}" title="">{{ $comment->user->name }}</a>
            </h5>
            <span>{{ formatTime($comment->created_at) }}</span>

            @if(Auth::check())
            @if($comment->post->daily_post == 0)
            <a class="we-reply btn-show-reply-form" href="#" title="Reply" data-id="{{ $comment->id }}" data-post-id="{{ $comment->post->id }}"><i class="fa fa-reply"></i></a>
            @endif
            <div class="dropright">
                <i class="fa-solid fa-ellipsis float-right button-option-comment" data-toggle="dropdown" aria-expanded="false"></i>
                <div class="dropdown-menu">
                    <a class="dropdown-item" href="#" data-toggle="modal" data-comment-id="{{ $comment->id }}" data-target="#reportCommentModal{{ $comment->id }}">Báo cáo bình luận</a>
                    @if(Auth::user()->id == $comment->user_id || Auth::user()->id == $comment->post->user_id)
                    <a class="dropdown-item btn-delete-comment" data-comment-id="{{ $comment->id }}" data-reply-id="{{ $comment->reply_id }}" data-post-id="{{ $comment->post->id }}" href="#">Xóa bình luận</a>
                    @endif
                    @if(Auth::user()->id == $comment->user_id)
                    <a class="dropdown-item edit-comment-btn" data-comment-id="{{ $comment->id }}" href="#">Chỉnh sửa bình luận</a>
                    @endif
                </div>
            </div>
            @endif

            <!-- Modal -->
            <div class="modal fade" style="background-color: rgba(0, 0, 0, 0.75);" id="reportCommentModal{{ $comment->id }}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="modalReportCommentLabel">Report content</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <table class="table">
                                <tr>
                                    <th scope="col">Lý do báo cáo:</th>
                                    <th scope="col">
                                        <textarea class="form-control @error('content') is-invalid @enderror" placeholder="Nội dung báo cáo..." id="content_report_comment_{{ $comment->id }}"></textarea>
                                        <small id="report-comment-error-{{ $comment->id }}" class="text-danger"></small>
                                    </th>
                                </tr>
                            </table>
                        </div>
                        <div class="modal-footer">
                            <button type="button" data-comment-id="{{ $comment->id }}" class="btn btn-primary btn-report-comment">Report</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div id="comment-{{ $comment->id }}-text">
            {!! $comment->content !!}
        </div>

        <!--Textarea và button sẽ ẩn mặc định-->
        <form class="reply_form_{{ $comment->id }} formReply" style="margin-top: 5px; display: none;">
            <textarea placeholder="Nhập nội dung bình luận" id="content-reply-{{ $comment->id }}"></textarea>
            <br>
            <small id="reply-comment-error-{{ $comment->id }}" class="text-danger"></small>
            <div class="attachments">
                <button class="btn-reply-comment" data-id="{{ $comment->id }}" data-post-id="{{ $comment->post->id }}">Trả lời</button>
            </div>
        </form>

        <div id="edit-comment-{{ $comment->id }}" style="margin-top: 5px;display: none;">
            <textarea placeholder="Nhập nội dung bình luận" id="content-edit-{{ $comment->id }}"></textarea>
            <br>
            <small id="comment-error-{{ $comment->id }}" class="text-danger"></small>
            <button class="btn btn-success float-right btn-save-comment" data-comment-id="{{ $comment->id }}">Lưu</button>
        </div>
    </div>
    <ul>
        @foreach($comment->replies as $child)
        <li id="child-comment-{{ $child->id }}">
            <div class="comet-avatar">
                <img src="front/img/users/{{ $child->user->avatar ?? 'default_user.png' }}" style="min-width: 50px;min-height: 50px;max-width: 50px;max-height: 50px;object-fit: cover;" alt="" />
            </div>
            <div class="we-comment">
                <div class="coment-head">
                    <h5>
                        <a href="time-line.html" title="">{{ $child->user->name }}</a>
                    </h5>
                    <span>{{ formatTime($child->created_at) }}</span>

                    @if(Auth::check())
                    <div class="dropright">
                        <i class="fa-solid fa-ellipsis float-right button-option-comment" data-toggle="dropdown" aria-expanded="false"></i>
                        <div class="dropdown-menu">
                            <a class="dropdown-item" href="#" data-toggle="modal" data-target="#reportCommentModal{{ $child->id }}">Báo cáo bình luận</a>
                            @if(Auth::user()->id == $child->user_id || Auth::user()->id == $child->post->user_id)
                            <a data-comment-id="{{ $child->id }}" data-reply-id="{{ $child->reply_id }}" data-post-id="{{ $comment->post->id }}" class="dropdown-item btn-delete-comment" href="#">Xóa bình luận</a>
                            @endif
                            @if(Auth::user()->id == $child->user_id)
                            <a class="dropdown-item edit-comment-btn" data-comment-id="{{ $child->id }}" href="#">Chỉnh sửa bình luận</a>
                            @endif
                        </div>
                    </div>
                    @endif

                    <!-- Modal -->
                    <div class="modal fade" style="background-color: rgba(0, 0, 0, 0.75);" id="reportCommentModal{{ $child->id }}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                        <div class="modal-dialog" role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="modalReportCommentLabel">Report content</h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <div class="modal-body">
                                    <table class="table">
                                        <tr>
                                            <th scope="col">Lý do báo cáo:</th>
                                            <th scope="col">
                                                <textarea class="form-control @error('content') is-invalid @enderror" placeholder="Nội dung báo cáo..." id="content_report_comment_{{ $child->id }}"></textarea>
                                                <small id="report-comment-error-{{ $child->id }}" class="text-danger"></small>
                                            </th>
                                        </tr>
                                    </table>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" data-comment-id="{{ $child->id }}" class="btn btn-primary btn-report-comment">Report</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div id="comment-{{ $child->id }}-text">
                    {!! $child->content !!}
                </div>

                <div id="edit-comment-{{ $child->id }}" style="margin-top: 5px; display: none;">
                    <textarea placeholder="Nhập nội dung bình luận" id="content-edit-{{ $child->id }}"></textarea>
                    <br>
                    <small id="comment-error-{{ $child->id }}" class="text-danger"></small>
                    <button class="btn btn-success float-right btn-save-comment" data-comment-id="{{ $child->id }}">Lưu</button>
                </div>
            </div>
        </li>
        @endforeach
    </ul>
</li>
@endif
@endforeach