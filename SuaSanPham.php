<?php
    // Kết nối đến cơ sở dữ liệu
    $pdo = new PDO("mysql:host=localhost;dbname=ql_vanphongpham", "root", "");
    $pdo->exec("set names utf8");

    function SuaSanPham($pdo)
    {
        if(isset($_POST["btn_Update"])){
            $New_HoTen = $_POST["new_name"];
            $New_DiaChi = $_POST["new_address"];
            $New_SDT = $_POST["new_phone"];
            $New_Email = $_POST["new_email"];
            $Old_HoTen = $_POST["hoten_KH"];

            $sql = "UPDATE KhachHang SET HoTen_KH = :New_HoTen, DiaChi_KH = :New_DiaChi, SDT_KH = :New_SDT, Email_KH = :New_Email WHERE HoTen_KH = :Old_HoTen";
            $stmt = $pdo->prepare($sql);
            $stmt->execute(array(':New_HoTen' => $New_HoTen, ':New_DiaChi' => $New_DiaChi, ':New_SDT' => $New_SDT, ':New_Email' => $New_Email, ':Old_HoTen' => $Old_HoTen));

            // Kiểm tra và thông báo kết quả
            if($stmt->rowCount() > 0){
                header("Location: KhachHang.php");
                exit(); // Chắc chắn dừng việc thực thi mã PHP sau khi chuyển hướng
            } else {
                echo "Không có thông tin nào được cập nhật !";
            }
        }
    }

    // Hàm lấy thông tin của khách hàng
    function LayThongTinKH($pdo, $hoTenKH) {
        $sql = "SELECT HoTen_KH, DiaChi_KH, SDT_KH, Email_KH FROM KhachHang WHERE HoTen_KH = :HoTen_KH";
        $stmt = $pdo->prepare($sql);
        $stmt->execute(array(':HoTen_KH' => $hoTenKH));
        $khachHang = $stmt->fetch(PDO::FETCH_ASSOC);
        return $khachHang;
    }

    // Xử lý hàm sửa thông tin
    if($_SERVER["REQUEST_METHOD"] == "POST"){
        SuaKH($pdo);
    }

    // Lấy thông tin của khách hàng cần sửa
    $hoTenKH = isset($_POST['hoten_KH']) ? $_POST['hoten_KH'] : "";
    $khachHang = LayThongTinKH($pdo, $hoTenKH);
?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" href="Bootstrap/bootstrap.min.css">
        <link rel="stylesheet" href="stylec.css">
    </head>
    <body>
        <?php include "Header.php"; ?>
        <?php include "SubHeader.php"; ?>
            <h1 class="text-center">SỬA THÔNG TIN KHÁCH HÀNG</h1>
            <form method="POST" class="text-center">
                <!-- Hiển thị thông tin khách hàng trong các trường nhập của form -->
                <input type="text" name="new_name" placeholder="Họ và tên mới" value="<?php echo $khachHang['HoTen_KH']; ?>">
                <input type="text" name="new_address" placeholder="Địa chỉ mới" value="<?php echo $khachHang['DiaChi_KH']; ?>">
                <input type="text" name="new_phone" placeholder="Số điện thoại mới" value="<?php echo $khachHang['SDT_KH']; ?>">
                <input type="text" name="new_email" placeholder="Email mới" value="<?php echo $khachHang['Email_KH']; ?>">

                <!-- Thêm hidden input để chứa thông tin của khách hàng -->
                <input type="hidden" name="hoten_KH" value="<?php echo $khachHang['HoTen_KH']; ?>">
                <button type="submit" class="btn btn-primary" name="btn_Update">Cập nhật</button>
                <a href="KhachHang.php" class="btn btn-danger">Hủy</a>
            </form>
            <?php include "Footer.php"; ?>
    </body>
</html>
