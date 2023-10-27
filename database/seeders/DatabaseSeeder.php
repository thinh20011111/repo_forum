<?php

namespace Database\Seeders;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->insert([
            [
                'id' => 1,
                'name' => 'user1',
                'email' => 'user1@gmail.com',
                'password' => Hash::make('123456'),
                'level' => 2,
                'avatar' => 'user1.jpg',
                'status' => 0
            ],
            [
                'id' => 2,
                'name' => 'user2',
                'email' => 'user2@gmail.com',
                'password' => Hash::make('123456'),
                'level' => 1,
                'avatar' => 'user2.jpg',
                'status' => 0
            ],
            [
                'id' => 3,
                'name' => 'user3',
                'email' => 'user3@gmail.com',
                'password' => Hash::make('123456'),
                'level' => 1,
                'avatar' => 'user3.jpg',
                'status' => 0
            ],
            [
                'id' => 4,
                'name' => 'admin',
                'email' => 'admin@gmail.com',
                'password' => Hash::make('123456'),
                'level' => 0,
                'avatar' => '513.jpg',
                'status' => 0
            ],
            [
                'id' => 5,
                'name' => 'Trần minh',
                'email' => 'tranminh@gmail.com',
                'password' => Hash::make('123456'),
                'level' => 2,
                'avatar' => null,
                'status' => 0
            ],
            [
                'id' => 6,
                'name' => 'Ngọc Hân',
                'email' => 'ngochan@gmail.com',
                'password' => Hash::make('123456'),
                'level' => 2,
                'avatar' => null,
                'status' => 0
            ],
            [
                'id' => 7,
                'name' => 'Bảo Vũ',
                'email' => 'bao@gmail.com',
                'password' => Hash::make('123456'),
                'level' => 2,
                'avatar' => null,
                'status' => 0
            ],
            [
                'id' => 8,
                'name' => 'Vũ Minh Hoàng',
                'email' => 'hoang@gmail.com',
                'password' => Hash::make('123456'),
                'level' => 2,
                'avatar' => null,
                'status' => 0
            ],
            [
                'id' => 9,
                'name' => 'Hương Giang',
                'email' => 'giang@gmail.com',
                'password' => Hash::make('123456'),
                'level' => 2,
                'avatar' => null,
                'status' => 0
            ],
            [
                'id' => 10,
                'name' => 'Hiền Hồ',
                'email' => 'hienho@gmail.com',
                'password' => Hash::make('123456'),
                'level' => 2,
                'avatar' => null,
                'status' => 0
            ],
            [
                'id' => 11,
                'name' => 'Trấn Thành',
                'email' => 'tranthanh@gmail.com',
                'password' => Hash::make('123456'),
                'level' => 2,
                'avatar' => null,
                'status' => 0
            ],
            [
                'id' => 12,
                'name' => 'Linh Miu',
                'email' => 'miu@gmail.com',
                'password' => Hash::make('123456'),
                'level' => 2,
                'avatar' => null,
                'status' => 0
            ],
            [
                'id' => 13,
                'name' => 'Yến Vũ',
                'email' => 'vuyen@gmail.com',
                'password' => Hash::make('123456'),
                'level' => 2,
                'avatar' => null,
                'status' => 0
            ],
            [
                'id' => 14,
                'name' => 'Huy nguyen',
                'email' => 'nguyenhuy@gmail.com',
                'password' => Hash::make('123456'),
                'level' => 2,
                'avatar' => null,
                'status' => 0
            ],
            [
                'id' => 15,
                'name' => 'Đô Mixi',
                'email' => 'mixi@gmail.com',
                'password' => Hash::make('123456'),
                'level' => 2,
                'avatar' => null,
                'status' => 0
            ],
            [
                'id' => 16,
                'name' => 'Đị mixo',
                'email' => 'mixo@gmail.com',
                'password' => Hash::make('123456'),
                'level' => 2,
                'avatar' => null,
                'status' => 0
            ],
            [
                'id' => 17,
                'name' => 'Mixi',
                'email' => 'miuxinh@gmail.com',
                'password' => Hash::make('123456'),
                'level' => 2,
                'avatar' => null,
                'status' => 0
            ],
            [
                'id' => 18,
                'name' => 'Mỡ',
                'email' => 'momo@gmail.com',
                'password' => Hash::make('123456'),
                'level' => 2,
                'avatar' => null,
                'status' => 0
            ],
            [
                'id' => 19,
                'name' => 'facebook',
                'email' => 'facebook@gmail.com',
                'password' => Hash::make('123456'),
                'level' => 2,
                'avatar' => null,
                'status' => 0
            ],
            [
                'id' => 20,
                'name' => 'monstergenz',
                'email' => 'monstergenz@gmail.com',
                'password' => Hash::make('123456'),
                'level' => 2,
                'avatar' => null,
                'status' => 0
            ],
            [
                'id' => 21,
                'name' => 'mck',
                'email' => 'mck@gmail.com',
                'password' => Hash::make('123456'),
                'level' => 2,
                'avatar' => null,
                'status' => 0
            ],
            [
                'id' => 22,
                'name' => 'tLink',
                'email' => 'linhhh@gmail.com',
                'password' => Hash::make('123456'),
                'level' => 2,
                'avatar' => null,
                'status' => 0
            ],
            [
                'id' => 23,
                'name' => 'Mexc',
                'email' => 'Mexc@gmail.com',
                'password' => Hash::make('123456'),
                'level' => 2,
                'avatar' => null,
                'status' => 0
            ],
            [
                'id' => 24,
                'name' => 'Ghệ iu',
                'email' => 'loveiu@gmail.com',
                'password' => Hash::make('123456'),
                'level' => 2,
                'avatar' => null,
                'status' => 0
            ],
            [
                'id' => 25,
                'name' => 'Bin zét',
                'email' => 'binzzzz@gmail.com',
                'password' => Hash::make('123456'),
                'level' => 2,
                'avatar' => null,
                'status' => 0
            ],
        ]);

        DB::table('types')->insert([
            [
                'id' => 1,
                'name' => 'Nội dung học tập',
            ],
            [
                'id' => 2,
                'name' => 'Nội dung cộng đồng',
            ],
        ]);

        DB::table('school_years')->insert([

            [
                'id' => 1,
                'year' => '2005',
                'name' => '50',
            ],
            [
                'id' => 2,
                'year' => '2006',
                'name' => '51',
            ],
            [
                'id' => 3,
                'year' => '2007',
                'name' => '52',
            ],
            [
                'id' => 4,
                'year' => '2008',
                'name' => '53',
            ],
            [
                'id' => 5,
                'year' => '2009',
                'name' => '54',
            ],
            [
                'id' => 6,
                'year' => '2010',
                'name' => '55',
            ],
            [
                'id' => 7,
                'year' => '2011',
                'name' => '56',
            ],
            [
                'id' => 8,
                'year' => '2012',
                'name' => '57',
            ],
            [
                'id' => 9,
                'year' => '2013',
                'name' => '58',
            ],
            [
                'id' => 10,
                'year' => '2014',
                'name' => '59',
            ],
            [
                'id' => 11,
                'year' => '2015',
                'name' => '60',
            ],
            [
                'id' => 12,
                'year' => '2016',
                'name' => '61',
            ],
            [
                'id' => 13,
                'year' => '2017',
                'name' => '62',
            ],
            [
                'id' => 14,
                'year' => '2018',
                'name' => '63',
            ],
            [
                'id' => 15,
                'year' => '2019',
                'name' => '64',
            ],
            [
                'id' => 16,
                'year' => '2020',
                'name' => '65',
            ],
            [
                'id' => 17,
                'year' => '2021',
                'name' => '66',
            ],
            [
                'id' => 18,
                'year' => '2022',
                'name' => '67',
            ],
        ]);

        DB::table('subjects')->insert([
            //Khoa CNPM
            [
                'id' => 1,
                'name' => 'Tin học cơ sở'
            ],
            [
                'id' => 2,
                'name' => 'Độ phức tạp thuật toán'
            ],
            [
                'id' => 3,
                'name' => 'Kỹ thuật lập trình'
            ],
            [
                'id' => 4,
                'name' => 'Cấu trúc dữ liệu và giải thuật'
            ],
            [
                'id' => 5,
                'name' => 'Cơ sở dữ liệu'
            ],
            [
                'id' => 6,
                'name' => 'Nhập môn Công nghệ phần mềm'
            ],
            [
                'id' => 7,
                'name' => 'Quản lý dự án phần mềm'
            ],
            [
                'id' => 8,
                'name' => 'Phân tích yêu cầu phần mềm'
            ],
            [
                'id' => 9,
                'name' => 'Kiến trúc và thiết kế phần mềm'
            ],
            [
                'id' => 10,
                'name' => 'Xây dựng và phát triển phần mềm'
            ],
            [
                'id' => 11,
                'name' => 'Kiểm thử và đảm bảo chất lượng phần mềm'
            ],
            [
                'id' => 12,
                'name' => 'Lập trình hướng đối tượng'
            ],
            [
                'id' => 13,
                'name' => 'Hệ quản trị cơ sở dữ liệu 1'
            ],
            [
                'id' => 14,
                'name' => 'Lập trình .NET'
            ],
            [
                'id' => 15,
                'name' => 'Phát triển ứng dụng web'
            ],
            [
                'id' => 16,
                'name' => 'Phát triển ứng dụng web 2'
            ],
            [
                'id' => 17,
                'name' => 'Lập trình JAVA'
            ],
            [
                'id' => 18,
                'name' => 'Kiểm thử và bảo mật ứng dụng web'
            ],
            [
                'id' => 19,
                'name' => 'Phát triển phần mềm phân tán'
            ],
            [
                'id' => 20,
                'name' => 'Linux và phần mềm nguồn mở'
            ],
            [
                'id' => 21,
                'name' => 'Phát triển ứng dụng GIS'
            ],
            [
                'id' => 22,
                'name' => 'Thương mại điện tử'
            ],
            [
                'id' => 23,
                'name' => 'Hệ thống hoạch định nguồn lực doanh nghiệp'
            ],

            //BM KHMT
            [
                'id' => 24,
                'name' => 'TIN HỌC ĐẠI CƯƠNG'
            ],
            [
                'id' => 25,
                'name' => 'KIẾN TRÚC MÁY TÍNH VÀ VI XỬ LÝ'
            ],
            [
                'id' => 26,
                'name' => 'NGUYÊN LÝ HỆ ĐIỀU HÀNH'
            ],
            [
                'id' => 27,
                'name' => 'PHÂN TÍCH VÀ THIẾT KẾ HỆ THỐNG'
            ],
            [
                'id' => 28,
                'name' => 'QUẢN LÝ CÁC PHIÊN BẢN PHẦN MỀM'
            ],
            [
                'id' => 29,
                'name' => 'KHAI PHÁ DỮ LIỆU WEB'
            ],
            [
                'id' => 30,
                'name' => 'PHÂN TÍCH VÀ THIẾT KẾ HỆ THỐNG HƯỚNG ĐỐI TƯỢNG'
            ],
            [
                'id' => 31,
                'name' => 'CHƯƠNG TRÌNH DỊCH'
            ],
            [
                'id' => 32,
                'name' => 'TRÍ TUỆ NHÂN TẠO'
            ],
            [
                'id' => 33,
                'name' => 'HỌC MÁY'
            ],
            [
                'id' => 34,
                'name' => '	THIẾT KẾ GIAO DIỆN WEB'
            ],
            [
                'id' => 35,
                'name' => 'PHÁT TRIỂN WEB FRONT-END'
            ],
            [
                'id' => 36,
                'name' => 'PHÁT TRIỂN WEB FRONT-END 2'
            ],
            [
                'id' => 37,
                'name' => 'PHÁT TRIỂN WEB BACK-END'
            ],
            [
                'id' => 38,
                'name' => 'PHÁT TRIỂN WEB BACK-END 2'
            ],
            [
                'id' => 39,
                'name' => 'NGUYÊN LÝ TRUYỀN THÔNG KHÔNG DÂY'
            ],
            [
                'id' => 40,
                'name' => 'PHÁT TRIỂN ỨNG DỤNG WEB CƠ BẢN'
            ],
            [
                'id' => 41,
                'name' => 'QUẢN LÝ VÀ XÂY DỰNG CHÍNH SÁCH AN TOÀN THÔNG TIN'
            ],
            [
                'id' => 42,
                'name' => 'KHOA HỌC DỮ LIỆU'
            ],
            [
                'id' => 43,
                'name' => 'PHÂN TÍCH NGHIỆP VỤ'
            ],
            [
                'id' => 44,
                'name' => 'HỌC SÂU'
            ],
            [
                'id' => 45,
                'name' => 'HỆ KHUYẾN NGHỊ'
            ],
            [
                'id' => 46,
                'name' => 'HỆ HỖ TRỢ RA QUYẾT ĐỊNH'
            ],
            [
                'id' => 47,
                'name' => 'PHÂN TÍCH DỮ LIỆU LỚN'
            ],
            [
                'id' => 48,
                'name' => 'MẬT MÃ VÀ AN TOÀN THÔNG TIN'
            ],
            [
                'id' => 49,
                'name' => 'XỬ LÝ NGÔN NGỮ TỰ NHIÊN'
            ],
            [
                'id' => 50,
                'name' => 'THỰC TẬP CHUYÊN NGÀNH 1'
            ],
            [
                'id' => 51,
                'name' => 'THỰC TẬP CHUYÊN NGÀNH 2'
            ],

            //BM Mạng và HTTT
            [
                'id' => 52,
                'name' => 'Phương pháp tính'
            ],
            [
                'id' => 53,
                'name' => 'Toán rời rạc'
            ],
            [
                'id' => 54,
                'name' => 'An toàn thông tin'
            ],
            [
                'id' => 55,
                'name' => 'Cơ sở mã hóa thông tin'
            ],
            [
                'id' => 56,
                'name' => 'Tối ưu hóa'
            ],
            [
                'id' => 57,
                'name' => 'Thiết kế và QL DA CNTT'
            ],
            [
                'id' => 58,
                'name' => 'Các mô hình toán tài chính'
            ],
            [
                'id' => 59,
                'name' => 'Hệ thống thông tin quản lý'
            ],
            [
                'id' => 60,
                'name' => 'Hệ hỗ trợ ra quyết định'
            ],
            [
                'id' => 61,
                'name' => 'Hệ cơ sở tri thức'
            ],
            [
                'id' => 62,
                'name' => 'Độ phức tạp thuật toán'
            ],
            [
                'id' => 63,
                'name' => 'Mật mã và ứng dụng'
            ],
            [
                'id' => 64,
                'name' => 'Đánh giá kiểm định AT HTTT'
            ],

            //BM Toán
            [
                'id' => 65,
                'name' => 'Mã hóa và an toàn dữ liệu (Cao học)'
            ],
            [
                'id' => 66,
                'name' => 'Các mô hình và phương pháp tối ưu (Cao học)'
            ],
            [
                'id' => 67,
                'name' => 'Toán cao cấp'
            ],
            [
                'id' => 68,
                'name' => 'Toán cao cấp 1'
            ],
            [
                'id' => 69,
                'name' => 'Toán cao cấp 2'
            ],
            [
                'id' => 70,
                'name' => 'Xác suất thống kê'
            ],
            [
                'id' => 71,
                'name' => 'Giải tích'
            ],
            [
                'id' => 72,
                'name' => 'Giải tích 1'
            ],
            [
                'id' => 73,
                'name' => 'Giải tích 2'
            ],
            [
                'id' => 74,
                'name' => 'Toán giải tích'
            ],
            [
                'id' => 75,
                'name' => 'Đại số tuyến tính'
            ],
            [
                'id' => 76,
                'name' => 'Toán học 1, 2 (Chương trình tiến tiến)'
            ],
            [
                'id' => 77,
                'name' => 'Thống kê ứng dụng trong KHNN'
            ],
            [
                'id' => 78,
                'name' => 'Phân tích số liệu'
            ],
            [
                'id' => 79,
                'name' => 'XSTK ứng dụng trong KHNN'
            ],
            [
                'id' => 80,
                'name' => 'Cơ sở Toán cho các nhà Kinh tế 1, 2'
            ],

            //BM Vật lý
            [
                'id' => 81,
                'name' => 'Vật lý đại cương A'
            ],
            [
                'id' => 82,
                'name' => 'Vật lý đại cương A2'
            ],
            [
                'id' => 83,
                'name' => 'Vật lý'
            ],
            [
                'id' => 84,
                'name' => 'Lý sinh'
            ],
            [
                'id' => 85,
                'name' => 'Thực hành vật lý đại cương'
            ],
            [
                'id' => 86,
                'name' => 'Vật lý đại cương 1 – Principle of Physics 1 (dạy bằng tiếng anh)'
            ],
            [
                'id' => 87,
                'name' => 'Vật lý đại cương 2 – Principle of Physics 2 (dạy bằng tiếng anh)'
            ],
            [
                'id' => 88,
                'name' => 'Vật lý cơ nhiệt'
            ],
            [
                'id' => 89,
                'name' => 'Vật lý điện quang'
            ],
            [
                'id' => 90,
                'name' => 'Cơ sở vật lý cho tin học'
            ],
            [
                'id' => 91,
                'name' => 'Điện tử ứng dụng trong tin học'
            ],
            [
                'id' => 92,
                'name' => 'Nguyên lý điện tử truyền thông'
            ],
            [
                'id' => 93,
                'name' => 'Thực hành điện tử truyền thông'
            ],
            [
                'id' => 94,
                'name' => 'Truyền dữ liệu'
            ],
            [
                'id' => 95,
                'name' => 'Kỹ thuật truyền số liệu'
            ],
            [
                'id' => 96,
                'name' => 'Truyền thông đa phương tiện'
            ],
            [
                'id' => 97,
                'name' => 'Truyền thông số và mã hóa'
            ],
            [
                'id' => 98,
                'name' => 'Truyền thông quang'
            ],
            [
                'id' => 99,
                'name' => 'Truyền thông vệ tinh và vô tuyến'
            ],

        ]);

        DB::table('specializeds')->insert([
            [
                'id' => 1,
                'name' => 'Chuyên ngành công nghệ phần mềm',
            ],
            [
                'id' => 2,
                'name' => 'Chuyên ngành công nghệ thông tin',
            ],
            [
                'id' => 3,
                'name' => 'Chuyên ngành hệ thống thông tin',
            ],
            [
                'id' => 4,
                'name' => 'Chuyên ngành an toàn thông tin',
            ],
        ]);

        DB::table('post_categories')->insert([
            [
                'id' => 1,
                'name' => 'Hỏi đáp',
            ],
            [
                'id' => 2,
                'name' => 'Thảo luận',
            ],
        ]);
    }
}
