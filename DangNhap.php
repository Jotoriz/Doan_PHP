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
        <div class="row">
            <form method="POST" action="login_handler.php">
                <div class="row form">
                    <div class="row">
                        <div class="col">
                            <input id="email" class="inputs" type="email" name="email" placeholder="Email" required />
                        </div>
                        <div class="col">
                            <input id="password" class="inputs" type="password" name="password" placeholder="Mật Khẩu"
                                required />
                            <?php
                            if (isset($_GET['error']) && $_GET['error'] == 1) {
                                echo '<p id="errorMessage" class="error">Email hoặc mật khẩu không đúng</p>';
                            } else {
                                echo '<p id="errorMessage" class="error"></p>';
                            }
                            ?>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col">
                            <button class="submit" type="submit">Đăng Nhập</button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <script src="Bootstrap/bootstrap.bundle.min.js"></script>
    <script src="https://kit.fontawesome.com/d3f4e54f8d.js" crossorigin="anonymous"></script>
</body>

</html>