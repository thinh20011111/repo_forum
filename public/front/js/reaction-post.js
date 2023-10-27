//Like post
$(document).on('click', '.like', function () {
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
                $('.like-btn-' + postId + '[data-post-id="' + postId + '"]').addClass('liked');
                $('.icon_like_' + postId).addClass('fa-solid');
                $('.icon_like_' + postId).removeClass('fa-regular');
            } else {
                $('.like-btn' + postId + '[data-post-id="' + postId + '"]').removeClass('liked');
                $('.icon_like_' + postId).addClass('fa-regular');
                $('.icon_like_' + postId).removeClass('fa-solid');
            }
            $('.likes-count-' + postId + '[data-post-id="' + postId + '"]').text(response.likesCount);

        },
        error: function (xhr, status, error) {
            console.log(xhr.responseText);
        }
    });
});

//ajax comment
$('.btn-comment').click(function (ev) {
    ev.preventDefault();
    var postId = $(this).data('post-id');
    var token = $('meta[name="csrf-token"]').attr('content');

    let content = tinymce.get('comment-content-' + postId);

    $.ajax({
        url: '/new_posts/post_' + postId + '/comment',
        type: 'POST',
        data: {
            content: content.getContent(),
            _token: token,
        },
        success: function (response) {
            if (response.error) {
                $('#comment-error' + postId).html(response.error);
                if (response.comment_mode) {
                    alert('Bài viết này đã khóa bình luận');
                }
            } else {
                $('#comment-error' + postId).html('');
                content.setContent('');
                $('#comment-' + postId).html(response);

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

//Hiển thị form reply và reply
$(document).on('click', '.btn-show-reply-form', function (ev) {
    ev.preventDefault();
    var id = $(this).data('id');
    var form_reply = '.reply_form_' + id;

    if ($(form_reply).is(':visible')) {
        $(form_reply).slideUp();
    } else {
        $('.formReply').slideUp();
        $(form_reply).slideDown();
    }
});

$(document).on('click', '.btn-reply-comment', function (ev) {
    ev.preventDefault();

    var id = $(this).data('id');
    var postId = $(this).data('post-id');
    let content = tinymce.get('content-reply-' + id);
    var token = $('meta[name="csrf-token"]').attr('content');

    $.ajax({
        url: '/new_posts/post_' + postId + '/comment',
        type: 'POST',
        data: {
            content: content.getContent(),
            reply_id: id,
            _token: token,
        },
        success: function (response) {
            if (response.error) {
                $('#reply-comment-error-' + id).html(response.error);
                console.log(response);

            } else {
                $('#reply-comment-error-' + id).html('');
                var content2 = tinymce.get('content-reply-' + id);
                var content2Value = content.getContent();
                tinymce.remove('textarea');
                $('#comment-' + postId).html(response);

                // Cập nhật lại số lượng comment
                getCommentCount(postId);

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
});

//Xóa binh luận
$(document).on('click', '.btn-delete-comment', function (ev) {
    ev.preventDefault();

    var comment_id = $(this).data('comment-id');
    var reply_id = $(this).data('reply-id');
    var postId = $(this).data('post-id');
    var token = $('meta[name="csrf-token"]').attr('content');

    if (confirm('Bạn có chắc chắn muốn xóa bình luận này?')) {
        $.ajax({
            url: '/new_posts/post_' + postId + '/delete_comment_' + comment_id,
            type: 'DELETE',
            data: {
                _token: token,
                reply_id: reply_id,
                comment_id: comment_id
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
            $('#count_comment_' + postId).text(response.count);
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

//report post and comment
$('#report-post-form').submit(function (event) {
    event.preventDefault();
    var postId = $('#post_id_show').val();
    var token = $('meta[name="csrf-token"]').attr('content');
    var content = tinymce.get('content_report_post');

    $.ajax({
        method: "POST",
        url: '/new_posts/post_' + postId + '/report_post',
        data: {
            content: content.getContent(),
            _token: token,
        },
        success: function (response) {
            if (response.error) {
                $('#report-post-error').html(response.error);
                // console.log(response);
            } else {
                alert(response.message);
                $('#report-post-error').html('');
                content.setContent('');
            }
        },
        error: function (error) {
            console.log(error.responseJSON.message);
        }
    });
});

$(document).on('click', '.btn-report-post-daily', function (ev) {
    event.preventDefault();
    var postId = $(this).data('id');
    var token = $('meta[name="csrf-token"]').attr('content');
    var content = tinymce.get('content_report_post_' + postId);

    $.ajax({
        method: "POST",
        url: '/new_posts/post_' + postId + '/report_post',
        data: {
            content: content.getContent(),
            _token: token,
        },
        success: function (response) {
            if (response.error) {
                $('#report-post-error').html(response.error);
                // console.log(response);
            } else {
                alert(response.message);
                $('#report-post-error').html('');
                content.setContent('');
            }
        },
        error: function (error) {
            console.log(error.responseJSON.message);
        }
    });
});

$(document).on('click', '.btn-report-comment', function (ev) {
    ev.preventDefault();
    var comment_id = $(this).data('comment-id');
    var postId = $('#post_id_show').val();
    var token = $('meta[name="csrf-token"]').attr('content');
    var content = tinymce.get('content_report_comment_' + comment_id);


    $.ajax({
        url: '/new_posts/post_' + postId + '/report_comment_' + comment_id,
        type: 'POST',
        data: {
            _token: token,
            comment_id: comment_id,
            post_id: postId,
            content: content.getContent()
        },
        success: function (response) {
            if (response.error) {
                $('#report-comment-error-' + comment_id).html(response.error);
                // console.log(response);
            } else {
                alert(response.message);
                $('#report-comment-error-' + comment_id).html('');
                content.setContent('');
            }
        },
        error: function (error) {
            console.log(error.responseJSON.message);
        }
    });
});

//Chỉnh sửa bài viết
$('#edit-post-btn').click(function (e) {
    e.preventDefault();

    $('.post-content').addClass('d-none');
    $('.edit-form').removeClass('d-none');

    $('.old-file').addClass('d-none');
    $('.new-file').removeClass('d-none');
});

// Đóng phần chỉnh sửa bài viết và hiển thị lại nội dung ban đầu khi người dùng ấn vào nút Hủy
$('#cancel-edit-post-btn').click(function (e) {
    e.preventDefault();

    $('.edit-form').addClass('d-none');
    $('.post-content').removeClass('d-none');


    $('.old-file').remove('d-none');
});

$(document).on('click', '#save-edit-btn', function (e) {
    e.preventDefault();

    var postId = $('#post_id_show').val();
    var editedContent = tinymce.get('edit-content');

    var formData = new FormData($('#editForm')[0]);
    formData.append('_token', $('meta[name="csrf-token"]').attr('content'));
    formData.append('content_edit', editedContent.getContent());

    $.ajax({
        type: 'POST',
        url: '/new_posts/post_' + postId + '/update_post',
        data: formData,
        contentType: false,
        processData: false,
        success: function (response) {
            if (response.error) {
                $('#error-content-edit').html("Trường này không được để trống");
            } else {
                $('.edit-form').addClass('d-none');
                $('.post-content').html(editedContent.getContent());
                $('.post-content').removeClass('d-none');

                var newFileName = response.file_path;
                $('.file_location').empty();
                $('.file_location').append('<a class="font-weight-normal font-italic" target="_blank" href="http://127.0.0.1:8000/front/files/' + newFileName + '">' + newFileName + '</a>');

                $('.old-file').removeClass('d-none');
                console.log(newFileName);

                alert('Bài viết đã được cập nhật thành công!');
            }
        },
        error: function (response) {
            if (!editedContent || editedContent.getContent() === '') {
                $('#error-content-edit').html("Trường này không được để trống");
            }
            alert('Cập nhật bài viết thất bại!');
        }
    });
});

//create daily_post
$('#btn-daily-post').click(function (ev) {
    ev.preventDefault();
    var token = $('meta[name="csrf-token"]').attr('content');

    let content = tinymce.get('content_daily_post');

    $.ajax({
        url: '/create_daily_post',
        type: 'POST',
        data: {
            content: content.getContent(),
            _token: token,
        },
        success: function (response) {
            if (response.error) {
                $('#notification-error').html(response.error);
            } else {
                $('#notification-error').html('');
                $('#list_daily_post').html(response);
                content.setContent('');
            }
        },
        error: function (xhr, status, error) {
            console.log(xhr.responseText);
        }
    });
})


$('input[type="file"]').change(function (e) {
    var fileName = e.target.files[0].name;
    $(this).next('.custom-file-label').html(fileName);
});


//Tắt mở bình luận
$('#disable-comment-btn').click(function (e) {
    e.preventDefault();

    var form = $(this).closest('form');
    var postId = $(this).data('post-id');
    var token = $('meta[name="csrf-token"]').attr('content');
    var commentMode = $(this).data('comment-mode');
    var newCommentMode = commentMode === 1 ? 0 : 1;

    $.ajax({
        type: 'POST',
        url: './post_' + postId + '/disable_comment',
        data: {
            _token: token,
            comment_mode: newCommentMode
        },
        success: function (response) {
            // Thực hiện cập nhật giao diện tại đây
            if (response.success) {
                if (newCommentMode === 1) {
                    alert('Đã tắt bình luận');
                    $('#disable-comment-btn').text('Bật bình luận');
                } else {
                    alert('Đã bật bình luận');
                    $('#disable-comment-btn').text('Tắt bình luận');
                }

                // Cập nhật giá trị của thuộc tính data-comment-mode
                $('#disable-comment-btn').data('comment-mode', newCommentMode);
            } else {
                alert('Đã xảy ra lỗi. Vui lòng thử lại sau.');
            }
        },
        error: function (xhr, status, error) {
            alert('Đã xảy ra lỗi. Vui lòng thử lại sau.');
        }
    });
});