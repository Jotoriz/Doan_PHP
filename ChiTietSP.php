<!DOCTYPE html>
<html lang="en">
    <?php
        $pdo = new PDO("mysql:host=localhost;port=3307;dbname=ql_vanphongpham", "root", "");
        $pdo->exec("set names utf8");

        $id = $_GET['id'];
        $imagePath = "image/SanPham/" . $id . ".jpg";

        $imageFolder = "image/SanPham/" . $id . "/";
        $imageFiles = glob($imageFolder . "*.jpg");

        $sql = "SELECT TenSP, Gia FROM SanPham WHERE MaSP = :id";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([':id' => $id]);
        $row = $stmt->fetch(PDO::FETCH_ASSOC);

        $tenSP = $row["TenSP"];
        $gia = $row["Gia"];


        $pdo2 = new PDO("mysql:host=localhost;port=3307;dbname=ql_vanphongpham", "root", "");
        $pdo2->exec("set names utf8");

        if (isset($_GET["id"])) {
        $maSP = $_GET["id"];
        $sql5 = "SELECT * FROM SanPham WHERE MaSP = :maSP";
        $sp = $pdo2->prepare($sql5);
        $sp->execute([':maSP' => $maSP]);
        $product = $sp->fetch(PDO::FETCH_ASSOC);
    }
    ?>

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="Bootstrap/bootstrap.min.css">
    <link rel="stylesheet" href="styles.css">
    <link rel="stylesheet" href="ChiTietSP.css">
    <title><?php echo $tenSP; ?></title>
</head>

<body>
    <?php
    include "Header.php";
    include "SubHeader.php";
    ?>

    <div class='container SanPham'>
        <div class='row'>
            <div class="col-md-6">
                <?php
                if ($stmt->rowCount() > 0) {
                    // Hiển thị thông tin sản phẩm
                    echo "<div class='col'>";
                    echo "<div class='row'>";
                    echo "<div class='col'>";
                    echo "<img class='mainImg' src='$imagePath' />";
                    echo "</div>";
                    echo "<div class='col'>";
                    foreach ($imageFiles as $imageFile) {
                        echo "<img class='Imgcon' src='$imageFile' />";
                    }
                    echo "</div>";
                    echo "</div>";
                    echo "</div>";
                }
                ?>
            </div>
            <div class="col-md-6 d-flex align-items-center justify-content-center">
                <div class="buttons">
                    <form id="addToCartForm" action="ShopCart.php" method="POST">
                        <input type="hidden" name="MaSP" value="<?php echo htmlspecialchars($id); ?>">
                        <input type="hidden" name="TenSP" value="<?php echo htmlspecialchars($tenSP); ?>">
                        <input type="hidden" name="Gia" value="<?php echo htmlspecialchars($gia); ?>">
                        <input type="number" name="sl" id="sl" value="1" min="1">
                        <br><br>
                        <button type="submit" name="add_to_cart" class="add-to-cart btn btn-primary">Thêm vào giỏ hàng</button>
                    </form>
                    <form id="buyNowForm" action="ThanhToan.php" method="post" onsubmit="setDataFromLocalStorage()">
                        <input type="hidden" name="email" id="email">
                        <input type="hidden" name="selected_products[0][maSP]" value="<?php echo htmlspecialchars($id); ?>">
                        <input type="hidden" name="selected_products[0][tenSP]" value="<?php echo htmlspecialchars($tenSP); ?>">
                        <input type="hidden" name="selected_products[0][gia]" value="<?php echo htmlspecialchars($gia); ?>">
                        <input type="hidden" name="selected_products[0][image]" value="<?php echo htmlspecialchars($imagePath); ?>">
                        <input type="hidden" name="selected_products[0][soLuong]" id="selected_products[0][soLuong]" value="1" min="1">
                        <button type="submit" class="buy-now btn btn-primary">Mua ngay</button>
                    </form>
                    <form action="DanhGia.php" method="GET">
                        <input type="hidden" name="MaSP" value="<?php echo htmlspecialchars($id); ?>">
                        <button type="submit" class="rate-now btn btn-secondary">Đánh giá</button>
                    </form>
                </div>
            </div>
        </div>

    </div>

    <?php

    include "Footer.php";
    ?>

    <script>
        document.addEventListener("DOMContentLoaded", function () {
            var decrementBtn = document.querySelector(".decrement");
            var incrementBtn = document.querySelector(".increment");
            var quantityInput = document.querySelector("#quantity");

            decrementBtn.addEventListener("click", function () {
                var currentValue = parseInt(quantityInput.value);
                if (currentValue > 1) {
                    quantityInput.value = currentValue - 1;
                }
            });

            incrementBtn.addEventListener("click", function () {
                var currentValue = parseInt(quantityInput.value);
                quantityInput.value = currentValue + 1;
            });
        });
        document.addEventListener("DOMContentLoaded", function () {
            var thumbnailImages = document.querySelectorAll(".Imgcon");
            var mainImage = document.querySelector(".mainImg");

            thumbnailImages.forEach(function (thumbnail) {
                thumbnail.addEventListener("click", function () {
                    var newImageSrc = thumbnail.getAttribute("src");
                    mainImage.setAttribute("src", newImageSrc);
                });
            });
        });
    </script>
    <script src="https://kit.fontawesome.com/d3f4e54f8d.js" crossorigin="anonymous"></script>
    <script src="Bootstrap/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
</body>

</html>
<script>
    function setEmailFromLocalStorage() {
            if(localStorage.getItem('email')) {
                
                var email = localStorage.getItem('email');
                
                document.getElementById('email').value = email;
            }
        }

    function setDataFromLocalStorage() {
        if(localStorage.getItem('email')) {
            var email = localStorage.getItem('email');
            document.getElementById('email').value = email;
        }
    }

    document.getElementById('sl').addEventListener('input', function () {
        var slValue = this.value;
        document.getElementById('addToCartForm').querySelector('input[name="sl"]').value = slValue;
        document.getElementById('buyNowForm').querySelector('input[name="selected_products[0][soLuong]"]').value = slValue;
    });
</script>