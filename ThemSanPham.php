<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Quản lý Sản phẩm</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="stylec.css">
</head>
<style>
    /* Tùy chỉnh button */
.btn {
    display: inline-block;
    font-weight: 400;
    color: #fff;
    text-align: center;
    vertical-align: middle;
    cursor: pointer;
    background-color: #007bff;
    border: 1px solid transparent;
    padding: .375rem .75rem;
    font-size: 1rem;
    line-height: 1.5;
    border-radius: .25rem;
    transition: color .15s ease-in-out,background-color .15s ease-in-out,border-color .15s ease-in-out,box-shadow .15s ease-in-out;
}

.btn:hover {
    background-color: #0056b3;
}

/* Tùy chỉnh button Chọn tệp */
.btn-file {
    position: relative;
    overflow: hidden;
}

.btn-file input[type="file"] {
    position: absolute;
    top: 0;
    right: 0;
    min-width: 100%;
    min-height: 100%;
    font-size: 100px;
    text-align: right;
    filter: alpha(opacity=0);
    opacity: 0;
    outline: none;
    background: white;
    cursor: inherit;
    display: block;
}

/* Tùy chỉnh button Thêm */
.btn-add {
    background-color: #28a745;
}

.btn-add:hover {
    background-color: #218838;
}

</style>
<?php
session_start(); // Bắt đầu session

$pdo = new PDO("mysql:host=localhost;dbname=ql_vanphongpham", "root", "");
$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
$pdo->query("set names utf8");

$sqlNCC = "SELECT MaNCC, TenNCC FROM nhacungcap";
$ncc = $pdo->query($sqlNCC);

$sqlLoai = "SELECT MaLoai, TenLoai FROM loaisp";
$loai = $pdo->query($sqlLoai);

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['submitted'])) {
    try {
        // Tạo kết nối CSDL
        $pdo1 = new PDO("mysql:host=localhost;dbname=ql_vanphongpham", "root", "");
        $pdo1->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $pdo1->query("set names utf8");

        // Tạo thư mục uploads nếu chưa tồn tại
        $uploads_dir = 'uploads';
        if (!is_dir($uploads_dir)) {
            mkdir($uploads_dir, 0777, true);
        }

        // Lấy dữ liệu từ form
        $maLoai = $_POST['maLoai'];
        $maNCC = $_POST['maNCC'];
        $tenSanPham = $_POST['tenSanPham'];
        $gia = $_POST['gia'];
        $donViTinh = $_POST['donViTinh'];
        $soLuongTonKho = $_POST['soLuongTonKho'];
        $moTa = $_POST['moTa'];

        // Kiểm tra dữ liệu đầu vào
        if (empty($maLoai) || empty($maNCC) || empty($tenSanPham) || empty($gia) || empty($donViTinh) || empty($soLuongTonKho)) {
            echo '<div class="alert alert-danger" role="alert">Vui lòng điền đầy đủ thông tin!</div>';
        } else {
            // Chuẩn bị câu lệnh SQL INSERT cho sản phẩm
            $sql = "INSERT INTO sanpham (MaLoai, MaNCC, TenSP, Gia, DVT, SoLuongTonKho, MoTaSP) 
                    VALUES (:maLoai, :maNCC, :tenSanPham, :gia, :donViTinh, :soLuongTonKho, :moTa)";
            $stmt = $pdo1->prepare($sql);

            // Gán giá trị và thực thi câu lệnh
            $stmt->bindParam(':maLoai', $maLoai);
            $stmt->bindParam(':maNCC', $maNCC);
            $stmt->bindParam(':tenSanPham', $tenSanPham);
            $stmt->bindParam(':gia', $gia);
            $stmt->bindParam(':donViTinh', $donViTinh);
            $stmt->bindParam(':soLuongTonKho', $soLuongTonKho);
            $stmt->bindParam(':moTa', $moTa);

            if ($stmt->execute()) {
                // Lấy mã sản phẩm vừa chèn
                $maSanPham = $pdo1->lastInsertId();

                // Xử lý các hình ảnh tải lên
                $hinhAnhFields = ['hinhAnh1', 'hinhAnh2', 'hinhAnh3'];
                foreach ($hinhAnhFields as $field) {
                    if (!empty($_FILES[$field]['name'])) {
                        $tmp_name = $_FILES[$field]['tmp_name'];
                        $name = basename($_FILES[$field]['name']);
                        $filePath = "$uploads_dir/$name";

                        if (move_uploaded_file($tmp_name, $filePath)) {
                            // Chuẩn bị câu lệnh SQL INSERT cho hình ảnh
                            $sqlHinhAnh = "INSERT INTO hinhanh (MaSP, Hinh) VALUES (:maSanPham, :hinhAnh)";
                            $stmtHinhAnh = $pdo1->prepare($sqlHinhAnh);
                            $stmtHinhAnh->bindParam(':maSanPham', $maSanPham);
                            $stmtHinhAnh->bindParam(':hinhAnh', $filePath);
                            $stmtHinhAnh->execute();
                        }
                    }
                }

                echo '<div class="alert alert-success" role="alert">Thêm sản phẩm và hình ảnh thành công!</div>';
            } else {
                echo '<div class="alert alert-danger" role="alert">Thêm sản phẩm thất bại. Vui lòng thử lại!</div>';
            }
        }
    } catch (PDOException $e) {
        echo '<div class="alert alert-danger" role="alert">Lỗi: ' . $e->getMessage() . '</div>';
    }
}
?>

<body>
    <?php
    include "Header.php";
    include "SubHeader.php";
    ?>
    <div class="container mt-5">
        <h1>Thêm Sản phẩm mới</h1>
        <form action="ThemSanPham.php" method="POST" enctype="multipart/form-data">
            <div class="form-group">
                <label for="tenSanPham">Tên Sản phẩm:</label>
                <input type="text" class="form-control" id="tenSanPham" name="tenSanPham">
            </div>
            <div class="form-group">
                <label for="gia">Giá:</label>
                <input type="text" class="form-control" id="gia" name="gia">
            </div>
            <div class="form-group">
                <label for="donViTinh">Đơn vị tính:</label>
                <input type="text" class="form-control" id="donViTinh" name="donViTinh">
            </div>
            <div class="form-group">
                <label for="soLuongTonKho">Số lượng tồn kho:</label>
                <input type="text" class="form-control" id="soLuongTonKho" name="soLuongTonKho">
            </div>
            <div class="form-group">
                <label for="moTa">Mô tả:</label>
                <textarea class="form-control" id="moTa" name="moTa"></textarea>
            </div>
            <div class="form-group">
                <label for="maLoai">Loại:</label>
                <select class="form-control" id="maLoai" name="maLoai">
                    <?php foreach ($loai as $category): ?>
                        <option value="<?php echo $category['MaLoai']; ?>"><?php echo $category['TenLoai']; ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div class="form-group">
                <label for="maNCC">Nhà cung cấp:</label>
                <select class="form-control" id="maNCC" name="maNCC">
                    <?php foreach ($ncc as $supplier): ?>
                        <option value="<?php echo $supplier['MaNCC']; ?>"><?php echo $supplier['TenNCC']; ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div class="form-group">
                <label for="hinhAnh1">Hình ảnh 1:</label>
                <div class="custom-file">
                    <input type="file" class="custom-file-input" id="hinhAnh1" name="hinhAnh1">
                    <label class="custom-file-label" for="hinhAnh1">Chọn tệp</label>
                </div>
            </div>
            <div class="form-group">
                <label for="hinhAnh2">Hình ảnh 2:</label>
                <div class="custom-file">
                    <input type="file" class="custom-file-input" id="hinhAnh2" name="hinhAnh2">
                    <label class="custom-file-label" for="hinhAnh2">Chọn tệp</label>
                </div>
            </div>
            <div class="form-group">
                <label for="hinhAnh3">Hình ảnh 3:</label>
                <div class="custom-file">
                    <input type="file" class="custom-file-input" id="hinhAnh3" name="hinhAnh3">
                    <label class="custom-file-label" for="hinhAnh3">Chọn tệp</label>
                </div>
            </div>
            <button type="submit" class="btn btn-add">Thêm</button>
            <?php if (!isset($_POST['submitted'])): ?> <!-- Chỉ hiển thị trường ẩn khi form chưa được gửi đi -->
                <input type="hidden" name="submitted" value="1">
            <?php endif; ?>
        </form>
    </div>
    <?php include "Footer.php"; ?>
</body>
</html>
