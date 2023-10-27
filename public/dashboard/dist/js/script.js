// Bắt sự kiện click vào nút xóa người dùng
var deleteBtn = document.querySelector('.delete-user-btn');
deleteBtn.addEventListener('click', function () {
    var userId = $(this).data('user-id'); // Lấy ID người dùng từ thuộc tính data
    var token = $('meta[name="csrf-token"]').attr('content');
    if (confirm('Bạn có chắc chắn muốn xóa người dùng này?')) {
        // Gửi yêu cầu DELETE đến máy chủ
        $.ajax({
            url: '/admin/manage_users/delete_' + userId,
            type: 'DELETE',
            data: {
                _token: token,
            },
            success: function (response) {
                console.log(response.message);
                // Thực hiện các hành động khác sau khi xóa thành công
                alert('Người dùng đã được xóa thành công!');
                window.location.href = '/admin/manage_users';
            },
            error: function (xhr, status, error) {
                console.log('Error: ' + error);
                // Xử lý lỗi (nếu có)
            }
        });
    }
});


var imagePreview = document.getElementById('image-user-preview');
var fileInput = document.getElementById('avatar');

// Xử lý sự kiện click vào ảnh
imagePreview.addEventListener('click', function () {
    // Kích hoạt sự kiện click cho input file ẩn
    fileInput.click();
});

// Xử lý sự kiện thay đổi file
fileInput.addEventListener('change', function (event) {
    // Kiểm tra xem người dùng đã chọn file hay chưa
    if (event.target.files && event.target.files[0]) {
        var reader = new FileReader();

        // Đọc file hình ảnh và hiển thị nó
        reader.onload = function (e) {
            imagePreview.src = e.target.result;
        };

        reader.readAsDataURL(event.target.files[0]);
    }
});

