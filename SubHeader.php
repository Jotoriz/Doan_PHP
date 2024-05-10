<?php
$pdo = new PDO("mysql:host=localhost;dbname=ql_vanphongpham", "root", "");
$pdo->query("set names utf8");
// Thực hiện truy vấn để lấy thông tin từ bảng loaisp
$sql = "SELECT * FROM loaisp";
$loaiSPs = $pdo->query($sql);
?>
<div class="subHeader">
    <div class="container">
        <div class="row justify-content-center"> <!-- Đặt lớp justify-content-center để căn giữa các cột -->
            <?php foreach ($loaiSPs as $loaiSP) : ?>
                <div class="col-1 item"> <!-- Chia cột thành 8 phần (1/8 của hàng) -->
                    <img class="hinhsubHeader" src="image/LoaiSP/<?php echo $loaiSP['hinh']; ?>" />
                    <p><?php echo $loaiSP['TenLoai']; ?></p>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
</div>

