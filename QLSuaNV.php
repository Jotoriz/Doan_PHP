<?php
    // Kết nối đến cơ sở dữ liệu
    $pdo = new PDO("mysql:host=localhost;port=3307;dbname=ql_vanphongpham", "root", "");
    $pdo->exec("set names utf8");

    // Hàm sửa thông tin nhân viên
    function SuaNV($pdo)
    {
        if (isset($_POST["btn_Update"])) {
            // Lấy thông tin mới từ form
            $New_HoTen = $_POST["new_name"];
            $New_GioiTinh = $_POST["new_gender"];
            $New_SDT = $_POST["new_phone"];
            $New_DiaChi = $_POST["new_address"];
            $New_Email = $_POST["new_email"];
            $New_ChucVu = $_POST["new_position"];
            $Old_HoTen = $_POST["hoten_NV"]; // Thêm dòng này để lấy giá trị của trường cũ

            // Cập nhật thông tin vào cơ sở dữ liệu
            $sql = "UPDATE NhanVien SET HoTen_NV = :New_HoTen, GioiTinh = :New_GioiTinh, SDT_NV = :New_SDT, DiaChi_NV = :New_DiaChi, Email_NV = :New_Email, MaCV = :New_CV WHERE HoTen_NV = :Old_HoTen";
            $stmt = $pdo->prepare($sql);
            $stmt->execute(array(':New_HoTen' => $New_HoTen, ':New_GioiTinh' => $New_GioiTinh, ':New_SDT' => $New_SDT, ':New_DiaChi' => $New_DiaChi, ':New_Email' => $New_Email, ':New_CV' => $New_ChucVu, ':Old_HoTen' => $Old_HoTen));

            // Kiểm tra và thông báo kết quả
            if ($stmt->rowCount() > 0) {
                header("Location: QLNhanVien.php");
                exit(); // Chắc chắn dừng việc thực thi mã PHP sau khi chuyển hướng
            } else {
                echo "Không có thông tin nào được cập nhật!";
            }
        }
    }

    // Hàm lấy thông tin của nhân viên
    function LayThongTinNV($pdo, $maNV)
    {
        $sql = "SELECT HoTen_NV, GioiTinh, SDT_NV, DiaChi_NV, Email_NV, MaCV FROM NhanVien WHERE MaNV = :MaNV";
        $stmt = $pdo->prepare($sql);
        $stmt->execute(array(':MaNV' => $maNV));
        $nhanvien = $stmt->fetch(PDO::FETCH_ASSOC);
        return $nhanvien ? $nhanvien : [];
    }

    // Hàm lấy danh sách chức vụ
    function LayDanhSachChucVu($pdo)
    {
        $sql = "SELECT MaCV, TenCV FROM ChucVu";
        $stmt = $pdo->query($sql);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Xử lý hàm sửa thông tin
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        // Lấy MaNV từ form
        $maNV = $_POST['ma_NV'];
        SuaNV($pdo, $maNV);
    }

    // Lấy thông tin của nhân viên cần sửa
    $maNV = isset($_POST['ma_NV']) ? $_POST['ma_NV'] : "";
    $nhanvien = LayThongTinNV($pdo, $maNV);
    $chucvu = LayDanhSachChucVu($pdo);
?>

<!DOCTYPE html>
<html lang="en">

    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" href="Bootstrap/bootstrap.min.css">
        <link rel="stylesheet" href="stylec.css">
        <link rel="stylesheet" href="ChiTietSP.css">
        
    </head>

    <body>
        <?php include "Header.php"; ?>
        <?php include "SubHeader.php"; ?>
        <h1 class="text-center">SỬA THÔNG TIN NHÂN VIÊN</h1>
        <form method="POST" class="text-center">
            <!-- Hiển thị thông tin nhân viên trong các trường nhập của form -->
            <input type="text" name="new_name" placeholder="Họ và tên mới" value="<?php echo $nhanvien['HoTen_NV']; ?>">
            <input type="text" name="new_address" placeholder="Địa chỉ mới" value="<?php echo $nhanvien['DiaChi_NV']; ?>">
            <input type="text" name="new_phone" placeholder="Số điện thoại mới" value="<?php echo $nhanvien['SDT_NV']; ?>">
            <input type="text" name="new_email" placeholder="Email mới" value="<?php echo $nhanvien['Email_NV']; ?>">

            <!-- ComboBox Giới tính -->
            <select name="new_gender">
                <option value="">-- Chọn giới tính --</option>
                <option value="Nam" <?php if ($nhanvien['GioiTinh'] == 'Nam') echo 'selected'; ?>>Nam</option>
                <option value="Nữ" <?php if ($nhanvien['GioiTinh'] == 'Nữ') echo 'selected'; ?>>Nữ</option>
            </select>

            <!-- ComboBox Chức vụ -->
            <select name="new_position">
                <option value="">-- Chọn chức vụ --</option>
                <?php foreach ($chucvu as $cv): ?>
                    <option value="<?php echo $cv['MaCV']; ?>" <?php if ($nhanvien['MaCV'] == $cv['MaCV']) echo 'selected'; ?>>
                        <?php echo $cv['TenCV']; ?>
                    </option>
                <?php endforeach; ?>
            </select>

            <!-- Thêm hidden input để chứa thông tin của nhân viên -->
            <input type="hidden" name="hoten_NV" value="<?php echo $nhanvien['HoTen_NV']; ?>">
            <button type="submit" class="btn btn-primary" name="btn_Update">Cập nhật</button>
            <a href="QLNhanVien.php" class="btn btn-danger">Hủy</a>
        </form>
        <?php include "Footer.php"; ?>
    </body>

</html>
