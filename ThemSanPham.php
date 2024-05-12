<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Quản lý Sản phẩm</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="stylec.css">
</head>

<?php
    $pdo = new PDO("mysql:host=localhost;dbname=ql_vanphongpham", "root", "");
    $pdo->query("set names utf8");

    $sqlNCC = "select MaNCC,TenNCC from nhacungcap";
    $ncc = $pdo->query($sqlNCC);

    $sqlLoai = "select MaLoai,TenLoai from loaisp";
    $loai = $pdo->query($sqlLoai);

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $pdo1 = new PDO("mysql:host=localhost;dbname=ql_vanphongpham", "root", "");
        $pdo1->query("set names utf8");
        // Lấy dữ liệu từ form
            $maLoai = $_POST['maLoai'];
            $maNCC = $_POST['maNCC'];
            $tenSanPham = $_POST['tenSanPham'];
            $gia = $_POST['gia'];
            $donViTinh = $_POST['donViTinh'];
            $soLuongTonKho = $_POST['soLuongTonKho'];
            $moTa = $_POST['moTa'];            
            
            // Chuẩn bị câu lệnh SQL INSERT
            $sql = "INSERT INTO sanpham (MaLoai, MaNCC,TenSP, Gia, DVT, SoLuongTonKho, MoTaSP) 
                    VALUES ('$maLoai', '$maNCC','$tenSanPham', '$gia', '$donViTinh', '$soLuongTonKho', '$moTa')";
            if ($pdo1->exec($sql)) { // Nếu thêm thành công
                echo '<div class="alert alert-success" role="alert">Thêm sản phẩm thành công!</div>';
            } else {
                echo '<div class="alert alert-danger" role="alert">Thêm sản phẩm thất bại. Vui lòng thử lại!</div>';
            }

    }
?>
<body>
    <?php include "Header.php"; ?>
    <?php include "SubHeader.php"; ?>
    <div class="container mt-5">
        <h1>Thêm Sản phẩm mới</h1>
        <form action="ThemSanPham.php" method="POST">
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

            <button type="submit" class="btn btn-primary">Thêm</button>
        </form>
    </div>
    <?php include "Footer.php"; ?>
</body>
</html>
