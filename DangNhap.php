<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="Bootstrap/bootstrap.min.css">
    <link rel="stylesheet" href="auth.css">
    <link rel="stylesheet" href="DangNhaps.css">
    <link rel="stylesheet" href="stylec.css">
    <title>Đăng Nhập</title>
</head>

<body>
    <?php
    include "Header.php";

    include "SubHeader.php";
    ?>


    <div class="container auth">
        <div class="row">
            <div class="col">
                <div class="swich">
                    <div class="row">
                        <div class="col">
                            <div class="au DangNhap">Đăng Nhập</div>
                        </div>
                        <div class="col">
                            <a href="DangKy.php">
                                <div class="au DangKy">Đăng Ký</div>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row ">
            <form>
                <div class="row form">
                    <div class="row">
                        <div class="col">
                            <input class="inputs" type="email" placeholder="Email" />
                        </div>
                    </div>
                    <div class="row">
                        <div class="col">
                            <input class="inputs" type="password" placeholder="Mật Khẩu" />
                        </div>
                    </div>
                </div>
        </div>
        <div class="row">
            <div class="col">
                <button class="submit" type="submit">Đăng Nhập</button>
            </div>
        </div>
        </form>
    </div>

    <script src="Bootstrap/bootstrap.bundle.min.js"></script>
    <script src="https://kit.fontawesome.com/d3f4e54f8d.js" crossorigin="anonymous"></script>
</body>

</html>