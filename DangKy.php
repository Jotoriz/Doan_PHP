<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="Bootstrap/bootstrap.min.css">
    <link rel="stylesheet" href="auth.css">
    <link rel="stylesheet" href="DangKys.css">
    <link rel="stylesheet" href="stylec.css">
    <title>Đăng Ký</title>
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
                            <a href="DangNhap.php">
                                <div class="au DangNhap">Đăng Nhập</div>
                            </a>
                        </div>
                        <div class="col">
                            <div class="au DangKy">Đăng Ký</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <form action="register_handler.php" method="POST">
                <div class="row form">
                    <div class="row">
                        <div class="col">
                            <input class="inputs" type="text" name="hoTen" placeholder="Họ Và Tên (*)" />
                        </div>
                    </div>
                    <div class="row">
                        <div class="col">
                            <input class="inputs" type="email" name="email" placeholder="Email (*)" />
                        </div>
                    </div>
                    <div class="row">
                        <div class="col">
                            <input class="inputs" type="tel" name="soDienThoai" placeholder="Số Điện Thoại (*)" />
                        </div>
                    </div>
                    <div class="row">
                        <div class="col">
                            <input class="inputs" type="text" name="diaChi" placeholder="Địa Chỉ (*)" />
                        </div>
                    </div>
                    <div class="row">
                        <div class="col">
                            <input class="inputs" type="password" name="matKhau" placeholder="Mật Khẩu (*)" />
                        </div>
                    </div>
                    <div class="row">
                        <div class="col">
                            <input class="inputs" type="password" name="nhapLaiMatKhau"
                                placeholder="Nhập Lại Mật Khẩu (*)" />
                        </div>
                    </div>
                </div>
                <?php
                if (isset($_GET['error']) && $_GET['error'] == 1) {
                    echo '<p id="errorMessage" class="error">Điền Thiếu thông tin</p>';
                } elseif (isset($_GET['error']) && $_GET['error'] == 2) {
                    echo '<p id="errorMessage" class="error">Nhập lại mật khẩu phải giống với mật khẩu</p>';
                } elseif (isset($_GET['error']) && $_GET['error'] == 3) {
                    echo '<p id="errorMessage" class="error">Email đã được đăng ký</p>';
                } else {
                    echo '<p id="errorMessage" class="error"></p>';
                }
                ?>
        </div>
        <div class="row">
            <div class="col">
                <button class="submit" type="submit">Đăng Ký</button>
            </div>
        </div>
        </form>
    </div>

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js"></script>
</body>

</html>