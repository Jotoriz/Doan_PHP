<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Đổi Mật Khẩu</title>
    <link rel="stylesheet" href="Bootstrap/bootstrap.min.css">
    <link rel="stylesheet" href="styles.css">
    <link rel="stylesheet" href="DangNhaps.css">
    <link rel="stylesheet" href="ThongTinCaNhanKH.css">
</head>


<body>
    <?php
    include "Header.php";
    ?>
    <div class="container auth">
        <div class="row">
            <div class="col">
                <div class="swich">
                    <div class="row">
                        <div class="col">
                            <div class="au DangNhap">Đổi Mật Khẩu</div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <form method="POST" action="ChangePassword.php">
                <div class="row form">
                    <div class="row">
                        <div class="col">
                            <label>Mật Khẩu Cũ </label>
                            <input type="text" name="Old_Pasword" class="in">
                        </div>
                    </div>
                    <div class="row">
                        <div class="col">
                            <label>Mật Khẩu Mới </label>
                            <input type="text" name="NewPassword" class="in">
                        </div>
                    </div>
                    <div class="row">
                        <div class="col">
                            <label>Nhập Lại Mật Khẩu Mới </label>
                            <input type="text" name="ReNewPassword" class="in">
                        </div>
                    </div>
                    <div class="row">
                        <div class="col">
                            <p class="error">
                                <?php
                                if (isset($_GET['error'])) {
                                    if ($_GET['error'] == 1) {
                                        echo "Sai Mật Khẩu Cũ";
                                    } elseif ($_GET['error'] == 2) {
                                        echo "Nhập lại mật khẩu không khớp";
                                    } elseif ($_GET['error'] == 3) {
                                        echo "Vui lòng nhập đầy đủ thông tin";
                                    } else {
                                        echo "";
                                    }
                                }
                                ?>
                            </p>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col">
                            <input type="email" name="email" class="in"
                                value="<?php echo isset($_GET['email']) ? $_GET['email'] : ''; ?>" hidden>
                            <button class="submit" type="submit">Đổi Mật Khẩu</button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
    <div>

    </div>

    <?php
    include "Footer.php";
    ?>
</body>

</html>
<script>
    if (window.history.replaceState) {
        window.history.replaceState(null, null, window.location.href.split('&')[0]);
    }
</script>
<script src="Bootstrap/bootstrap.bundle.min.js" crossorigin="anonymous"></script>