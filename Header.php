<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Menu with Cart Icon</title>
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">

    <!-- Font Awesome CSS -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">

    <style>
        #menu {
            margin-top: 20px;
            /* Thay đổi giá trị của margin-top tùy ý */
        }

        .nav-item.nav-link.active {
            color: white;
        }

        .fa-shopping-cart {
            margin-right: 5px;
            color: black;
        }

        #header {
            margin-bottom: 20px;
        }

        .cart-badge {
            position: absolute;
            top: -8px;
            right: -8px;
        }

        .giohang .fa-shopping-cart {
            margin-right: 0;
        }

        #cartItem {
            position: relative;
        }

        #cartItem.active .fas.fa-shopping-cart {
            position: absolute;
            z-index: 1;
            top: 8px;
            right: 8px;
        }

        .auth_link {
            color: #495057;
            /* Màu chữ mặc định */
            text-decoration: none;
            transition: color 0.3s;
        }

        .auth_link:hover {
            color: #ff0000;
            /* Màu chữ khi di chuột qua */
        }
    </style>
</head>

<body>

    <div id="menu">
        <div class="container">
            <div class="row">
                <div class="col-3">
                    <a href="index.php"><img class="logo" src="image/logo.png" /></a>
                </div>
                <div class="col-5">
                    <form action="index.php" method="get">
                        <div class="search-container">
                            <input type="text" id="search-input" name="search" class="search-input"
                                placeholder="Tìm kiếm sản phẩm">
                            <button type="submit" class="NoBtn search-icon"><i class="fas fa-search"></i></button>
                        </div>
                    </form>
                    <script>
                        document.addEventListener('DOMContentLoaded', function () {
                            document.getElementById('search-input').focus();
                        });
                    </script>
                </div>
                <div class="col-4">
                    <div class="Icon">
                        <?php
                        if (session_status() == PHP_SESSION_NONE) {
                            session_start();
                        }
                        $role = isset($_SESSION['role']) ? $_SESSION['role'] : '';

                        if ($role == 'KH') {
                            echo '<i class="fa-regular fa-user icons user dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false"></i>';
                            echo '<ul class="dropdown-menu">';
                            echo '</ul>';
                        } elseif ($role == 'NV') {
                            echo '<i class="fa-solid fa-user icons user dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false"></i>';
                            echo '<ul class="dropdown-menu">';
                            echo '</ul>';
                        } else {
                            echo '<a href="DangKy.php" class="auth_link">Đăng Ký</a>';
                            echo '<span style="margin: 0 10px;">|</span>';
                            echo '<a href="DangNhap.php" class="auth_link">Đăng Nhập</a>';
                        }
                        ?>
                        <li class="nav-item nav-link active giohang" id="cartItem">
                            <a class="nav-link" href="ShopCart.php">
                                <i class="fas fa-shopping-cart icons"></i>
                                <?php
                                if (session_status() == PHP_SESSION_NONE) {

                                    session_start();
                                }
                                $totalItemsInCart = isset($_SESSION['cart']) ? count($_SESSION['cart']) : 0;

                                if ($totalItemsInCart > 0) {
                                    echo '<span class="badge badge-pill badge-danger cart-badge">' . $totalItemsInCart . '</span>';
                                }
                                ?>
                            </a>
                        </li>

                    </div>
                </div>
            </div>
        </div>
        <script src="https://kit.fontawesome.com/d3f4e54f8d.js" crossorigin="anonymous"></script>
    </div>

    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            var role = localStorage.getItem('role');

            if (role === 'KH') {
                var userIcon = document.querySelector('.fa-regular.fa-user');
                var userDropdown = userIcon.parentNode.querySelector('.dropdown-menu');
                userIcon.classList.add('dropdown-toggle');
                userIcon.setAttribute('data-bs-toggle', 'dropdown');
                userDropdown.innerHTML = `
                <li><a class="dropdown-item">
                    <form action="ThongTinCaNhanKH.php" method="GET">
                        <input type="hidden" name="email" value="${localStorage.getItem('email')}">
                        <button type="submit" class="NoBtn">Thông Tin Cá Nhân</button>
                    </form>
                </a></li>
                <li><a class="dropdown-item" href="DonHangKH.php">Đơn Hàng</a></li>
                <li><a class="dropdown-item">
                    <form action="DoiMatKhauKH.php" method="GET">
                        <input type="hidden" name="email" value="${localStorage.getItem('email')}">
                        <button type="submit" class="NoBtn">Đổi Mật Khẩu</button>
                    </form>
                </a></li>

                <li><a class="dropdown-item logout">Đăng Xuất</a></li>
                `;
            } else if (role === 'NV') {
                var userIcon = document.querySelector('.fa-solid.fa-user');
                var userDropdown = userIcon.parentNode.querySelector('.dropdown-menu');
                userIcon.classList.add('dropdown-toggle');
                userIcon.setAttribute('data-bs-toggle', 'dropdown');
                userDropdown.innerHTML = `
                <li><a class="dropdown-item" href="QLNhanVien.php">Quản Lý Nhân Viên</a></li>
                <li><a class="dropdown-item" href="QLKhachHang.php">Thông Tin Khách Hàng</a></li>
                <li><a class="dropdown-item" href="QL_SanPham.php">Quản Lý Sản Phẩm</a></li>
                <li><a class="dropdown-item" href="QLDonHang.php">Quản Lý Đơn hàng</a></li>
                <li><a class="dropdown-item logout">Đăng Xuất</a></li>
                `;
            } else {
                var authLinkContainer = document.querySelector('.Icon');
                authLinkContainer.innerHTML = `
                <a href="DangNhap.php" class="auth_link">Đăng Nhập</a>
                <span style="margin: 0 10px;">|</span>
                <a href="DangKy.php" class="auth_link">Đăng Ký</a>

                <li class="nav-item nav-link active giohang" id="cartItem">
                    <a class="nav-link" href="ShopCart.php">
                        <i class="fas fa-shopping-cart icons"></i>
                        <?php
                        if (session_status() == PHP_SESSION_NONE) {

                            session_start();
                        }
                        $totalItemsInCart = isset($_SESSION['cart']) ? count($_SESSION['cart']) : 0;

                        if ($totalItemsInCart > 0) {
                            echo '<span class="badge badge-pill badge-danger cart-badge">' . $totalItemsInCart . '</span>';
                        }
                        ?>
                    </a>
                </li>
                `;
            }

            document.querySelector('.logout').addEventListener('click', function () {
                logout();
            });
        });

        function logout() {
            localStorage.removeItem('email');
            localStorage.removeItem('role');
            location.reload();
        }
    </script>
</body>

</html>