<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta http-equiv="X-UA-Compatible" content="ie=edge" />
    <meta name="Description" content="Enter your description here" />
    <title>
        Diễn đàn học tập khoa Công nghệ thông tin - Học viện Nông Nghiệp Việt Nam
    </title>
    <style>
        /* CSS */
        .button-65 {
            appearance: none;
            backface-visibility: hidden;
            background-color: #f8c600;
            border-radius: 10px;
            border-style: none;
            box-shadow: none;
            box-sizing: border-box;
            color: #000000;
            cursor: pointer;
            display: inline-block;
            font-family: Inter, -apple-system, system-ui, "Segoe UI", Helvetica,
                Arial, sans-serif;
            font-size: 15px;
            font-weight: 500;
            height: 50px;
            letter-spacing: normal;
            line-height: 1.5;
            outline: none;
            overflow: hidden;
            padding: 14px 30px;
            position: relative;
            text-align: center;
            text-decoration: none;
            transform: translate3d(0, 0, 0);
            transition: all 0.3s;
            user-select: none;
            -webkit-user-select: none;
            touch-action: manipulation;
            vertical-align: top;
            white-space: nowrap;
        }

        .button-65:hover {
            background-color: #1366d6;
            box-shadow: rgba(0, 0, 0, 0.05) 0 5px 30px,
                rgba(0, 0, 0, 0.05) 0 1px 4px;
            opacity: 1;
            transform: translateY(0);
            transition-duration: 0.35s;
        }

        .button-65:hover:after {
            opacity: 0.5;
        }

        .button-65:active {
            box-shadow: rgba(0, 0, 0, 0.1) 0 3px 6px 0,
                rgba(0, 0, 0, 0.1) 0 0 10px 0, rgba(0, 0, 0, 0.1) 0 1px 4px -1px;
            transform: translateY(2px);
            transition-duration: 0.35s;
        }

        .button-65:active:after {
            opacity: 1;
        }

        @media (min-width: 768px) {
            .button-65 {
                padding: 14px 22px;
                width: 176px;
            }
        }
    </style>
</head>

<body style="
      background-color: #e7eff8;
      font-family: trebuchet, sans-serif;
      margin-top: 0;
      box-sizing: border-box;
      line-height: 1.5;
    ">
    <div class="container-fluid">
        <div class="container" style="background-color: #e7eff8; width: 600px; margin: auto">
            <div class="col-12 mx-auto" style="width: 580px; margin: 0 auto">
                <div class="row">
                    <div class="container-fluid">
                        <div class="row" style="background-color: #e7eff8; height: 10px"></div>
                    </div>
                </div>
                <div class="row" style="
              height: 100px;
              padding: 10px 20px;
              line-height: 90px;
              background-color: white;
              box-sizing: border-box;
            ">
                    <img src="https://fita.vnua.edu.vn/wp-content/uploads/2014/06/logo-vi.png" alt="" />
                    <h1 class="pl-2" style="
                color: white;
                line-height: 30px;
                float: left;
                padding-left: 20px;
                font-size: 20px;
                font-weight: 500;
                text-align: center;
              ">
                        Diễn đàn học tập khoa Công nghệ thông tin - Học viện Nông Nghiệp
                        Việt Nam
                    </h1>
                </div>

                <div class="row" style="
              background-color: #00509d;
              height: 300px;
              padding: 35px;
              color: white;
            ">
                    <div class="container-fluid" style="text-align: center;">
                        <p class="m-0 p-0 mt-4" style="margin-top: 0">
                            <strong>Xin chào
                                <span style="color: orange; font-size: 30px">{{$user_name}}</span>, hãy nhấn vào đường link bên dưới để đổi mật khẩu</strong>
                        </p>
                        <a href="{{ $link }}" class="button-65" role="button">Đổi mật khẩu</a>
                    </div>
                </div>
                <div class="row">
                    <div class="container-fluid">
                        <div class="row" style="background-color: #e7eff8; height: 10px"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>

</html>