

//like
$(document).on('click', '.like-btn', function () {
    var postId = $(this).data('post-id');
    var userId = $(this).data('user-id');
    var token = $('meta[name="csrf-token"]').attr('content');

    $.ajax({
        url: '/new_posts/post_' + postId + '/like',
        type: 'POST',
        data: {
            post_id: postId,
            user_id: userId,
            _token: token,
        },
        success: function (response) {
            if (response.liked) {
                $('.like-btn[data-post-id="' + postId + '"]').addClass('liked');
                $('.icon_like').addClass('fa-solid');
                $('.icon_like').removeClass('fa-regular');
            } else {
                $('.like-btn[data-post-id="' + postId + '"]').removeClass('liked');
                $('.icon_like').addClass('fa-regular');
                $('.icon_like').removeClass('fa-solid');
            }
            $('.likes-count[data-post-id="' + postId + '"]').text(response.likesCount);

        },
        error: function (xhr, status, error) {
            console.log(xhr.responseText);
        }
    });
});


//ajax comment
$('#btn-comment').click(function (ev) {
    ev.preventDefault();
    var postId = $(this).data('post-id');
    var token = $('meta[name="csrf-token"]').attr('content');

    let content = tinymce.get('comment-content');

    $.ajax({
        url: '/new_posts/post_' + postId + '/comment',
        type: 'POST',
        data: {
            content: content.getContent(),
            _token: token,
        },
        success: function (response) {
            if (response.error) {
                $('#comment-error').html(response.error);
            } else {
                $('#comment-error').html('');
                content.setContent('');
                $('#comment').html(response);

                // Cập nhật lại số lượng comment
                getCommentCount(postId);
                tinymce.remove('textarea');
                tinymce.init({
                    selector: 'textarea',
                    plugins: 'preview importcss searchreplace autolink autosave save directionality code visualblocks visualchars fullscreen image link media template codesample table charmap pagebreak nonbreaking anchor insertdatetime advlist lists wordcount charmap quickbars emoticons',
                    editimage_cors_hosts: ['picsum.photos'],
                    menubar: 'file edit view insert format tools table',
                    toolbar: 'undo redo | bold italic underline strikethrough | fontfamily fontsize blocks | alignleft aligncenter alignright alignjustify | outdent indent |  numlist bullist | forecolor backcolor removeformat | pagebreak | charmap emoticons | fullscreen  preview save print | insertfile image media template link anchor codesample | ltr rtl',
                    autosave_ask_before_unload: true,
                    autosave_interval: '30s',
                    autosave_prefix: '{path}{query}-{id}-',
                    autosave_restore_when_empty: false,
                    autosave_retention: '2m',
                    image_advtab: true,
                    link_list: [{
                        title: 'My page 1',
                        value: 'https://www.tiny.cloud'
                    },
                    {
                        title: 'My page 2',
                        value: 'http://www.moxiecode.com'
                    }
                    ],
                    image_list: [{
                        title: 'My page 1',
                        value: 'https://www.tiny.cloud'
                    },
                    {
                        title: 'My page 2',
                        value: 'http://www.moxiecode.com'
                    }
                    ],
                    image_class_list: [{
                        title: 'None',
                        value: ''
                    },
                    {
                        title: 'Some class',
                        value: 'class-name'
                    }
                    ],
                    importcss_append: true,
                    file_picker_callback: (callback, value, meta) => {
                        /* Provide file and text for the link dialog */
                        if (meta.filetype === 'file') {
                            callback('https://www.google.com/logos/google.jpg', {
                                text: 'My text'
                            });
                        }

                        /* Provide image and alt text for the image dialog */
                        if (meta.filetype === 'image') {
                            callback('https://www.google.com/logos/google.jpg', {
                                alt: 'My alt text'
                            });
                        }

                        /* Provide alternative source and posted for the media dialog */
                        if (meta.filetype === 'media') {
                            callback('movie.mp4', {
                                source2: 'alt.ogg',
                                poster: 'https://www.google.com/logos/google.jpg'
                            });
                        }
                    },
                    templates: [{
                        title: 'New Table',
                        description: 'creates a new table',
                        content: '<div class="mceTmpl"><table width="98%%"  border="0" cellspacing="0" cellpadding="0"><tr><th scope="col"> </th><th scope="col"> </th></tr><tr><td> </td><td> </td></tr></table></div>'
                    },
                    {
                        title: 'Starting my story',
                        description: 'A cure for writers block',
                        content: 'Once upon a time...'
                    },
                    {
                        title: 'New list with dates',
                        description: 'New List with dates',
                        content: '<div class="mceTmpl"><span class="cdate">cdate</span><br><span class="mdate">mdate</span><h2>My List</h2><ul><li></li><li></li></ul></div>'
                    }
                    ],
                    template_cdate_format: '[Date Created (CDATE): %m/%d/%Y : %H:%M:%S]',
                    template_mdate_format: '[Date Modified (MDATE): %m/%d/%Y : %H:%M:%S]',
                    height: 200,
                    online: false,
                    image_caption: true,
                    quickbars_selection_toolbar: 'bold italic | quicklink h2 h3 blockquote quickimage quicktable',
                    noneditable_class: 'mceNonEditable',
                    toolbar_mode: 'sliding',
                    contextmenu: 'link image table',
                    skin: useDarkMode ? 'oxide-dark' : 'oxide',
                    content_css: useDarkMode ? 'dark' : 'default',
                    content_style: 'body { font-family:Helvetica,Arial,sans-serif; font-size:16px }'
                });
            }
        },
        error: function (xhr, status, error) {
            console.log(xhr.responseText);
        }
    });
})

//Xóa binh luận
$(document).on('click', '.btn-delete-comment', function (ev) {
    ev.preventDefault();

    var comment_id = $(this).data('comment-id');
    var reply_id = $(this).data('reply-id');
    var postId = $('#post_id_show').val();
    var token = $('meta[name="csrf-token"]').attr('content');

    if (confirm('Bạn có chắc chắn muốn xóa bình luận này?')) {
        $.ajax({
            url: '/new_posts/post_' + postId + '/delete_comment_' + comment_id,
            type: 'DELETE',
            data: {
                _token: token,
                reply_id: reply_id
            },
            success: function (response) {
                // Xóa comment khỏi DOM
                if (reply_id == 0) {
                    $('#parent-comment-' + comment_id).remove();
                    // Cập nhật lại số lượng comment
                    getCommentCount(postId);
                } else {
                    $('#child-comment-' + comment_id).remove();
                    // Cập nhật lại số lượng comment
                    getCommentCount(postId);
                }
            },
            error: function (xhr) {
                console.log(xhr.responseText);
            }
        });
    }

});

//Cập nhật số lượng comment
function getCommentCount(postId) {
    $.ajax({
        url: '/new_posts/post_' + postId + '/comment_count',
        type: 'GET',
        success: function (response) {
            $('#count_comment').text(response.count);
        },
        error: function (xhr) {
            console.log(xhr.responseText);
        }
    });
}

$(document).ready(function () {
    var postId = $('#post_id_show').val();
    getCommentCount(postId);
});

//Edit comment
$(document).on('click', '.edit-comment-btn', function (ev) {
    ev.preventDefault();

    // Tìm bình luận tương ứng
    var commentId = $(this).data('comment-id');
    var commentText = $('#comment-' + commentId + '-text').html();

    // Hiển thị form nhập liệu và đưa nội dung ban đầu vào tinymce
    let content = tinymce.get('content-edit-' + commentId);
    content.setContent(commentText);
    $('#edit-comment-' + commentId).show();
});

//Save button
$(document).on('click', '.btn-save-comment', function (ev) {
    // Lấy dữ liệu từ form nhập liệu
    var postId = $('#post_id_show').val();
    var commentId = $(this).data('comment-id');
    var token = $('meta[name="csrf-token"]').attr('content');
    var content = tinymce.get('content-edit-' + commentId).getContent();

    // Gửi dữ liệu đến route comment.edit và cập nhật nội dung bình luận
    $.ajax({
        url: '/new_posts/post_' + postId + '/update_comment',
        method: 'POST',
        data: {
            commentId: commentId,
            content: content,
            _token: token,
        },
        success: function () {
            $('#comment-' + commentId + '-text').html(content);
            $('#edit-comment-' + commentId).hide();
        },
        error: function () {
            alert('Có lỗi xảy ra. Vui lòng thử lại sau!');
        }
    });
});
