<?php
$email = $_GET['email'];
$pdo = new PDO("mysql:host=localhost;dbname=ql_vanphongpham", "root", "");
$pdo->query("set names utf8");
$query = $pdo->prepare("SELECT HoTen_KH, DiaChi_KH, SDT_KH, Email_KH FROM KhachHang WHERE Email_KH = :email");
$query->execute(['email' => $email]);
$result = $query->fetch(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Thông Tin Cá Nhân</title>
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
                            <div class="au DangNhap">Chỉnh Sửa Thông Tin</div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <form method="POST" action="UpdateTTKH.php">
                <div class="row form">
                    <div class="row">
                        <div class="col">
                            <label>Họ Tên </label>
                            <input type="text" name="HoTen_KH" class="HoTen_KH in"
                                value="<?php echo $result['HoTen_KH']; ?>">
                        </div>
                        <div class="col">
                            <label>Địa Chỉ </label>
                            <input type="text" name="DiaChi_KH" class="DiaChi_KH in"
                                value="<?php echo $result['DiaChi_KH']; ?>">
                        </div>
                    </div>
                    <div class="row">
                        <div class="col">
                            <label>Số Điện Thoại </label>
                            <input type="tel" name="SDT_KH" class="SDT_KH in" value="<?php echo $result['SDT_KH']; ?>">
                        </div>
                        <div class="col">
                            <label>Email (Không được chỉnh sửa)</label>
                            <input type="text" name="Email_KH" class="Email_KH in"
                                value="<?php echo $result['Email_KH']; ?>" readonly>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col">
                            <button class="submit" type="submit">Cập Nhật</button>
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