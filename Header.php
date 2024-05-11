<?php
define('BASE_PATH', __DIR__);
?>
<div class="header">
    <div class="container">
        <div class="row">
            <div class="col-3">
                <a href="index.php"><img class="logo" src="image/logo.png" /></a>
            </div>
            <div class="col-5">
                <div class="search-container">
                    <input type="text" id="search-input" class="search-input" placeholder="Tìm kiếm sản phẩm">
                    <span class="search-icon"><i class="fas fa-search"></i></span>
                </div>
            </div>
            <div class="col-4">
                <div class="Icon">
                    <a href="DangNhap.php" class="auth_link"> Đăng Nhập</a>
                    <span> | </span>
                    <a href="DangKy.php" class="auth_link"> Đăng Ký</a>

                    <li class="nav-item nav-link active giohang">
                        <a class="nav-link" href="ShopCart.php">
                            <i class="fas fa-shopping-cart"></i>
                            <?php
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
