<?php
session_start();
// Tạo một kết nối PDO duy nhất
$pdo = new PDO("mysql:host=localhost;dbname=ql_vanphongpham", "root", "");
$pdo->exec("set names utf8");

//Truy vấn bảng Khách Hàng
function SelectNV($pdo, $selectNV)
{
    // Thực thi truy vấn
    $result = $pdo->query($selectNV);

    // Kiểm tra kết quả truy vấn
    if ($result) {
        // Nếu có dữ liệu
        if ($result->rowCount() > 0) {
            return $result; // Trả về kết quả truy vấn
        } else {
            echo "<h2>Không có dữ liệu nhân viên</h2>";
            return false;
        }
    } else {
        echo "Lỗi khi truy vấn cơ sở dữ liệu.";
        return false;
    }
}

// Thực thi hàm để kiểm tra kết quả truy vấn
$selectNV = "SELECT NV.HoTen_NV, NV.GioiTinh, NV.SDT_NV, NV.DiaChi_NV, NV.Email_NV, CV.MaCV, NV.TenDangNhap, NV.MatKhau 
             FROM NhanVien NV INNER JOIN ChucVu CV ON NV.MaCV = CV.MaCV";

$selectCV = "SELECT MaCV, TenCV FROM ChucVu";

if (!SelectNV($pdo, $selectNV)) {
    // Đóng kết nối PDO nếu có lỗi xảy ra
    $pdo = NULL;
} else {
    // Lấy dữ liệu khách hàng nếu truy vấn thành công
    $NhanVien = SelectNV($pdo, $selectNV);
}

// Hàm xóa khách hàng
function XoaNV($pdo)
{
    if (isset($_POST["btn_Delete"])) {
        // Lấy họ tên khách hàng từ form
        $HoTen_NV = $_POST["hoten_NV"];

        // Truy vấn xóa khách hàng dựa trên họ tên
        $sql = "DELETE FROM NhanVien WHERE HoTen_NV = :HoTen_NV";
        $sta = $pdo->prepare($sql);

        // Truyền tham số vào câu truy vấn
        $kq = $sta->execute(array(':HoTen_NV' => $HoTen_NV));

        if ($kq) {
            header("Location: QLNhanVien.php");
            echo "Xóa thành công !";
        } else {
            echo "Xóa thất bại !";
        }
    }
}

// Xử lý hàm
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST["btn_Delete"])) {
        XoaNV($pdo);
    }
}
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
    <div class="container KhachHang">
        <h1 class="text-center">DANH SÁCH NHÂN VIÊN</h1>
        <div class='row'>
            <table class="table table-bordered" align="center">
                <thead class="thead-dark">
                    <tr>
                        <th scope="col">Họ và tên</th>
                        <th scope="col">Giới tính</th>
                        <th scope="col">Số điện thoại</th>
                        <th scope="col">Địa chỉ</th>
                        <th scope="col">Email</th>
                        <th scope="col">Chức vụ</th>
                        <th scope="col">Tên đăng nhập</th>
                        <th scope="col">Mật khẩu</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($NhanVien as $NV): ?>
                        <tr>
                            <td><?php echo $NV['HoTen_NV']; ?></td>
                            <td><?php echo $NV['GioiTinh']; ?></td>
                            <td><?php echo $NV['SDT_NV']; ?></td>
                            <td><?php echo $NV['DiaChi_NV']; ?></td>
                            <td><?php echo $NV['Email_NV']; ?></td>
                            <td><?php echo $NV['MaCV']; ?></td>
                            <td><?php echo $NV['TenDangNhap']; ?></td>
                            <td><?php echo $NV['MatKhau']; ?></td>
                            <td>
                                <form method="POST" action="QLSuaNV.php">
                                    <input type="hidden" name="hoten_NV" value="<?php echo $NV['HoTen_NV']; ?>">
                                    <button type="submit" class="btn btn-primary" name="btn_Edit">Sửa</button>
                                </form>

                                <form method="POST">
                                    <input type="hidden" name="hoten_NV" value="<?php echo $NV['HoTen_NV']; ?>">
                                    <button type="submit" class="btn btn-danger" name="btn_Delete">Xóa</button>
                                </form>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
    <?php include "Footer.php"; ?>
    <!-- JavaScript code giữ nguyên -->
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