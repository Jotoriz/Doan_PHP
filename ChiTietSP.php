<!DOCTYPE html>
<html lang="en">
<?php
$pdo = new PDO("mysql:host=localhost;dbname=ql_vanphongpham", "root", "");
$pdo->exec("set names utf8");

$id = $_GET['id'];
$imagePath = "image/SanPham/" . $id . ".jpg";

$imageFolder = "image/SanPham/" . $id . "/";
$imageFiles = glob($imageFolder . "*.jpg");

// Truy vấn dữ liệu từ bảng SanPham
$sql = "SELECT TenSP, Gia FROM SanPham WHERE MaSP = $id";
$stmt = $pdo->prepare($sql);
$stmt->execute();
$row = $stmt->fetch(PDO::FETCH_ASSOC);
$tenSP = $row["TenSP"];
$gia = $row["Gia"];
?>

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="Bootstrap/bootstrap.min.css">
    <link rel="stylesheet" href="stylec.css">
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



            <?php

            if ($stmt->rowCount() > 0) {


                // Hiển thị thông tin sản phẩm
                echo "       <div class='col'>";
                echo "           <div class='row'>";
                echo "               <div class='col'>";
                echo "                   <img class='mainImg' src='$imagePath' />";
                echo "               </div>";
                echo "           </div>";
                echo "    <div class='row'>";
                foreach ($imageFiles as $imageFile) {
                    echo "      <div class='col-2'>";
                    echo "        <img class='Imgcon' src='$imageFile' />";
                    echo "      </div>";
                }
                echo "    </div>";

                echo "       </div>";
            }

            ?>
            <div class='col'>
                <h2><?php echo $tenSP; ?></h2>
                <p>Giá: <?php echo $gia; ?></p>
                <div class="quantity">
                    <button class="decrement">-</button>
                    <input type="text" id="quantity" name="quantity" min="1" value="1">
                    <button class="increment">+</button>
                </div>
                <div class="buttons">
                    <button class="add-to-cart btn btn-primary">Thêm vào giỏ hàng</button>
                    <button class="buy-now btn btn-primary">Mua ngay</button>
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
</body>

</html>