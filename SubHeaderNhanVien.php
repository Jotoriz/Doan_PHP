<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Menu with Cart Icon</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">

    <style>
        .subHeader {
            background-color: #FFB0BD;
            padding: 10px;
        }

        .nav-link {
            color: black;
            font-size: 20px;
            text-decoration: none;
            margin: 0 20px;
            transition: color 0.3s;
        }

        .nav-link:hover {
            color: #ff0000;
        }
    </style>
</head>

<body>

    <div class="subHeader">
        <div class="container">
            <nav class="navbar navbar-expand-lg">
                <ul class="navbar-nav mx-auto">
                    <li class="nav-item">
                        <a class="nav-link" href="QLNhanVien.php">Nhân viên</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="QLKhachHang.php">Khách Hàng</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="QL_SanPham.php">Sản Phẩm</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="donhang.php">Đơn Hàng</a>
                    </li>
                </ul>
            </nav>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>
</body>

</html>