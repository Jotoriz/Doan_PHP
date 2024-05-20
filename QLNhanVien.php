<?php
// Tạo một kết nối PDO duy nhất
$pdo = new PDO("mysql:host=localhost;dbname=ql_vanphongpham", "root", "");
$pdo->exec("set names utf8");

// Truy vấn bảng Nhân Viên
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
$selectNV = "SELECT NV.MaNV, NV.HoTen_NV, NV.GioiTinh, NV.SDT_NV, NV.DiaChi_NV, NV.Email_NV, CV.TenCV, NV.TenDangNhap, NV.MatKhau 
                FROM NhanVien NV 
                INNER JOIN ChucVu CV ON NV.MaCV = CV.MaCV";

if (!SelectNV($pdo, $selectNV)) {
    // Đóng kết nối PDO nếu có lỗi xảy ra
    $pdo = NULL;
} else {
    // Lấy dữ liệu nhân viên nếu truy vấn thành công
    $NhanVien = SelectNV($pdo, $selectNV);
}

// Hàm xóa nhân viên
function XoaNV($pdo)
{
    if (isset($_POST["btn_Delete"])) {
        // Lấy mã nhân viên từ form
        $MaNV = $_POST["ma_NV"];

        try {
            // Bắt đầu transaction
            $pdo->beginTransaction();

            // Lấy các mã hóa đơn liên quan đến nhân viên
            $sql = "SELECT MaHD FROM HoaDon WHERE MaNV = :MaNV";
            $sta = $pdo->prepare($sql);
            $sta->execute(array(':MaNV' => $MaNV));
            $hoaDonList = $sta->fetchAll(PDO::FETCH_ASSOC);

            // Xóa các dòng liên quan trong ChiTietHoaDon
            foreach ($hoaDonList as $hoaDon) {
                $sql = "DELETE FROM ChiTietHoaDon WHERE MaHD = :MaHD";
                $sta = $pdo->prepare($sql);
                $sta->execute(array(':MaHD' => $hoaDon['MaHD']));
            }

            // Xóa các hóa đơn liên quan đến nhân viên
            $sql = "DELETE FROM HoaDon WHERE MaNV = :MaNV";
            $sta = $pdo->prepare($sql);
            $sta->execute(array(':MaNV' => $MaNV));

            // Xóa nhân viên
            $sql = "DELETE FROM NhanVien WHERE MaNV = :MaNV";
            $sta = $pdo->prepare($sql);
            $sta->execute(array(':MaNV' => $MaNV));

            // Commit transaction
            $pdo->commit();

            header("Location: QLNhanVien.php");
            exit(); // Dừng script sau khi chuyển hướng
        } catch (Exception $e) {
            // Rollback transaction nếu có lỗi
            $pdo->rollBack();
            echo "Xóa thất bại: " . $e->getMessage();
        }
    }
}

// Hàm tìm kiếm nhân viên
function TimKiemNV($pdo, $keyword)
{
    $searchQuery = "%$keyword%";

    // Truy vấn tìm kiếm nhân viên theo họ tên và email
    $sql = "SELECT NV.MaNV, NV.HoTen_NV, NV.GioiTinh, NV.SDT_NV, NV.DiaChi_NV, NV.Email_NV, CV.TenCV, NV.TenDangNhap, NV.MatKhau 
                FROM NhanVien NV 
                INNER JOIN ChucVu CV ON NV.MaCV = CV.MaCV
                WHERE NV.HoTen_NV LIKE :keyword OR NV.Email_NV LIKE :keyword";

    // Chuẩn bị và thực thi truy vấn
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(':keyword', $searchQuery, PDO::PARAM_STR);
    $stmt->execute();

    // Kiểm tra kết quả
    if ($stmt->rowCount() > 0) {
        return $stmt->fetchAll(PDO::FETCH_ASSOC); // Trả về kết quả nếu có
    } else {
        return false; // Trả về false nếu không tìm thấy kết quả
    }
}

// Lấy từ khóa tìm kiếm từ biến GET (hoặc POST)
$keyword = isset($_GET['keyword']) ? $_GET['keyword'] : '';

// Gọi hàm tìm kiếm nhân viên với từ khóa vừa lấy được
$NhanVien = TimKiemNV($pdo, $keyword);

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
    <link rel="stylesheet" href="styles.css">
    <link rel="stylesheet" href="ChiTietSP.css">
    <style>
        .row.mb-6.align-items-center {
            display: flex;
            align-items: center;
        }

        .col-md-6.text-md-right.mt-3.mt-md-0 {
            margin-top: auto;
        }
    </style>
</head>

<body>
    <?php include "Header.php"; ?>
    <?php include "SubHeaderNhanVIen.php"; ?>
    <div class="container KhachHang">
        <h1 class="text-center">DANH SÁCH NHÂN VIÊN</h1>

        <div class="row mb-6">
            <div class="col-md-6 offset-md-6">
                <form method="GET" action="" class="d-flex justify-content-end">
                    <input type="text" class="form-control mr-2" id="searchInput" name="keyword"
                        placeholder="Tìm kiếm..." value="<?php echo htmlspecialchars($keyword); ?>"
                        style="margin-right: 10px;">
                    <button type="submit" class="btn btn-primary" style="margin-right: 20px;">Tìm kiếm</button>
                    <a href="QLThemNV.php" class="btn btn-success">Thêm</a>
                </form>
            </div>
        </div>


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
                        <th scope="col">Thao tác</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if ($NhanVien): ?>
                        <?php foreach ($NhanVien as $NV): ?>
                            <tr>
                                <td><?php echo $NV['HoTen_NV']; ?></td>
                                <td><?php echo $NV['GioiTinh']; ?></td>
                                <td><?php echo $NV['SDT_NV']; ?></td>
                                <td><?php echo $NV['DiaChi_NV']; ?></td>
                                <td><?php echo $NV['Email_NV']; ?></td>
                                <td><?php echo $NV['TenCV']; ?></td>
                                <td><?php echo $NV['TenDangNhap']; ?></td>
                                <td><?php echo $NV['MatKhau']; ?></td>
                                <td>
                                    <form method="POST" action="QLSuaNV.php">
                                        <input type="hidden" name="ma_NV" value="<?php echo $NV['MaNV']; ?>">
                                        <button type="submit" class="btn btn-primary" name="btn_Edit">Sửa</button>
                                    </form>

                                    <form method="POST">
                                        <input type="hidden" name="ma_NV" value="<?php echo $NV['MaNV']; ?>">
                                        <button type="submit" class="btn btn-danger" name="btn_Delete">Xóa</button>
                                    </form>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>

    </div>
    <?php include "Footer.php"; ?>
    <script src="https://kit.fontawesome.com/d3f4e54f8d.js" crossorigin="anonymous"></script>
    <script src="Bootstrap/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
</body>

</html>