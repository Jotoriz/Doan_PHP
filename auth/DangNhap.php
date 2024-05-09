<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../Bootstrap/bootstrap.min.css">
    <link rel="stylesheet" href="./auth.css">
    <link rel="stylesheet" href="./DangNhap.css">
    <link rel="stylesheet" href="../stylea.css">
    <title>Đăng Nhập</title>
</head>

<body>
    <div class="header">
        <div class="container">
            <div class="row">
                <div class="col-3">
                    <a href="../index.php"><img class="logo" src="../image/logo.jpg" /></a>
                </div>
                <div class="col-5">
                    <div class="search-container">
                        <input type="text" id="search-input" class="search-input" placeholder="Tìm kiếm sản phẩm">
                        <span class="search-icon"><i class="fas fa-search"></i></span>
                    </div>
                </div>
                <div class="col-4">
                    <div class="Icon">
                        <a href="#" class="cart"> </a>
                        <img class="giohang" src="../image/giohang.png">
                    </div>
                </div>
            </div>
        </div>
    </div>


    <div class="container auth">
        <div class="row">
            <div class="col">
                <div class="swich">
                    <div class="row">
                        <div class="col">
                            <div class="au DangNhap">Đăng Nhập</div>
                        </div>
                        <div class="col">
                            <a href="./DangKy.php">
                                <div class="au DangKy">Đăng Ký</div>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <form>
                <div class="row form">
                    <div class="row">
                        <input class="inputs" type="text" placeholder="Tên Tài Khoản" />
                    </div>
                    <div class="row">
                        <input class="inputs" type="password" placeholder="Mật Khẩu" />
                    </div>
                </div>
        </div>
        <div class="row">
            <button class="submit" type="submit">Đăng Nhập</button>
        </div>
        </form>
    </div>

    <script src="../Bootstrap/bootstrap.bundle.min.js"></script>
    <script src="https://kit.fontawesome.com/d3f4e54f8d.js" crossorigin="anonymous"></script>
</body>

</html>