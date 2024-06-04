<?php
// Kết nối đến cơ sở dữ liệu
$pdo = new PDO("mysql:host=localhost;dbname=ql_vanphongpham", "root", "");
$pdo->exec("set names utf8");

// Hàm thêm mới nhân viên
function ThemNV($pdo)
{
    if (isset($_POST["btn_Add"])) {

        // Kiểm tra các khóa mảng trước khi sử dụng
        if (isset($_POST["new_name"]) && isset($_POST["new_gender"]) && isset($_POST["new_phone"]) && isset($_POST["new_address"]) && isset($_POST["new_email"]) && isset($_POST["new_position"]) && isset($_POST["new_password"])) {
            // Lấy thông tin từ form
            $New_HoTen = $_POST["new_name"];
            $New_GioiTinh = $_POST["new_gender"];
            $New_SDT = $_POST["new_phone"];
            $New_DiaChi = $_POST["new_address"];
            $New_Email = $_POST["new_email"];
            $New_ChucVu = $_POST["new_position"];
            $New_MatKhau = $_POST["new_password"];

            // Thực hiện truy vấn để thêm mới nhân viên
            $sql = "INSERT INTO NhanVien (HoTen_NV, GioiTinh, SDT_NV, DiaChi_NV, Email_NV, MaCV, MatKhau) VALUES (:New_HoTen, :New_GioiTinh, :New_SDT, :New_DiaChi, :New_Email, :New_ChucVu, :New_MatKhau)";
            $stmt = $pdo->prepare($sql);
            $stmt->execute(
                array(
                    ':New_HoTen' => $New_HoTen,
                    ':New_GioiTinh' => $New_GioiTinh,
                    ':New_SDT' => $New_SDT,
                    ':New_DiaChi' => $New_DiaChi,
                    ':New_Email' => $New_Email,
                    ':New_ChucVu' => $New_ChucVu,
                    ':New_MatKhau' => $New_MatKhau
                )
            );

            // Kiểm tra và thông báo kết quả
            if ($stmt->rowCount() > 0) {
                header("Location: QLNhanVien.php");
                exit(); // Chắc chắn dừng việc thực thi mã PHP sau khi chuyển hướng
            }
        }
    }
}

// Hàm lấy danh sách chức vụ
function LayDanhSachChucVu($pdo)
{
    $sql = "SELECT MaCV, TenCV FROM ChucVu";
    $stmt = $pdo->query($sql);
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

// Xử lý hàm thêm mới nhân viên
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    ThemNV($pdo);
}

// Lấy danh sách chức vụ để hiển thị trong combobox
$chucvu = LayDanhSachChucVu($pdo);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="Bootstrap/bootstrap.min.css">
    <link rel="stylesheet" href="styles.css">
    <link rel="stylesheet" href="ChiTietSP.css">
</head>

<body>
    <?php include "Header.php"; ?>
    <?php include "SubHeader.php"; ?>
    <h1 class="text-center">THÊM MỚI NHÂN VIÊN</h1>
    <form method="POST" class="text-center">
       
        <input type="text" name="new_name" placeholder="Họ và tên mới">
        <input type="text" name="new_address" placeholder="Địa chỉ mới">
        <input type="text" name="new_phone" placeholder="Số điện thoại mới">
        <input type="text" name="new_email" placeholder="Email mới">

        <select name="new_gender">
            <option value="" selected disabled>-- Chọn giới tính --</option>
            <option value="Nam">Nam</option>
            <option value="Nữ">Nữ</option>
        </select>

 
        <select name="new_position">
            <option value="" selected disabled>-- Chọn chức vụ --</option>
            <?php foreach ($chucvu as $cv): ?>
                <option value="<?php echo $cv['MaCV']; ?>"><?php echo $cv['TenCV']; ?></option>
            <?php endforeach; ?>
        </select>

       
        <input type="password" name="new_password" placeholder="Mật khẩu">


        <button type="submit" class="btn btn-primary" name="btn_Add">Thêm</button>
        <a href="QLNhanVien.php" class="btn btn-danger">Hủy</a>
    </form>
    <?php include "Footer.php"; ?>
</body>

</html>