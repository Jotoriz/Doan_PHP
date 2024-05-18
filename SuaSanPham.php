<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sửa Sản phẩm</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="styles.css">
</head>
<style>
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
        transition: color .15s ease-in-out, background-color .15s ease-in-out, border-color .15s ease-in-out, box-shadow .15s ease-in-out;
    }

    .btn:hover {
        background-color: #0056b3;
    }

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

    .btn-add {
        background-color: #28a745;
    }

    .btn-add:hover {
        background-color: #218838;
    }
</style>
<?php
    session_start();
    $pdo = new PDO("mysql:host=localhost;dbname=ql_vanphongpham", "root", "");
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $pdo->query("set names utf8");

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $maSanPham = $_POST['maSanPham'];
        $maLoai = $_POST['maLoai'];
        $maNCC = $_POST['maNCC'];
        $tenSanPham = $_POST['tenSanPham'];
        $gia = $_POST['gia'];
        $donViTinh = $_POST['donViTinh'];
        $soLuongTonKho = $_POST['soLuongTonKho'];
        $moTa = $_POST['moTa'];

        $sql = "UPDATE sanpham SET MaLoai = :maLoai, MaNCC = :maNCC, TenSP = :tenSanPham, Gia = :gia, DVT = :donViTinh, SoLuongTonKho = :soLuongTonKho, MoTaSP = :moTa WHERE MaSP = :maSanPham";
        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(':maSanPham', $maSanPham);
        $stmt->bindParam(':maLoai', $maLoai);
        $stmt->bindParam(':maNCC', $maNCC);
        $stmt->bindParam(':tenSanPham', $tenSanPham);
        $stmt->bindParam(':gia', $gia);
        $stmt->bindParam(':donViTinh', $donViTinh);
        $stmt->bindParam(':soLuongTonKho', $soLuongTonKho);
        $stmt->bindParam(':moTa', $moTa);

        if ($stmt->execute()) {
            $_SESSION['success_message'] = 'Cập nhật sản phẩm thành công!';
            header("Location: SuaSanPham.php?id=$maSanPham");
            exit();
        } else {
            echo '<div class="alert alert-danger" role="alert">Cập nhật sản phẩm thất bại. Vui lòng thử lại!</div>';
        }
    }

    if (isset($_SESSION['success_message'])) {
        echo '<div class="alert alert-success" role="alert">' . $_SESSION['success_message'] . '</div>';
        unset($_SESSION['success_message']);
    }

    $maSanPham = $_GET['id'];
    $sql = "SELECT * FROM sanpham WHERE MaSP = :maSanPham";
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(':maSanPham', $maSanPham);
    $stmt->execute();
    $product = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($product === false) {
        echo '<div class="alert alert-danger" role="alert">Không tìm thấy sản phẩm với mã này.</div>';
        die();
    }

    $sqlNCC = "SELECT MaNCC, TenNCC FROM nhacungcap";
    $ncc = $pdo->query($sqlNCC);

    $sqlLoai = "SELECT MaLoai, TenLoai FROM loaisp";
    $loai = $pdo->query($sqlLoai);
?>


<body>
    <?php
    include "Header.php";

    include "SubHeader.php";
    ?>
    <div class="container mt-5">
        <h2 align="center" style="color:#900;">SỬA SẢN PHẨM</h2>
        <form action="SuaSanPham.php" method="POST">
            <input type="hidden" name="maSanPham" value="<?php echo $product['MaSP']; ?>">
            <div class="form-group">
                <label for="tenSanPham">Tên Sản phẩm:</label>
                <input type="text" class="form-control" id="tenSanPham" name="tenSanPham" value="<?php echo $product['TenSP']; ?>">
            </div>
            <div class="form-group">
                <label for="gia">Giá:</label>
                <input type="text" class="form-control" id="gia" name="gia" value="<?php echo $product['Gia']; ?>">
            </div>
            <div class="form-group">
                <label for="donViTinh">Đơn vị tính:</label>
                <input type="text" class="form-control" id="donViTinh" name="donViTinh" value="<?php echo $product['DVT']; ?>">
            </div>
            <div class="form-group">
                <label for="soLuongTonKho">Số lượng:</label>
                <input type="text" class="form-control" id="soLuongTonKho" name="soLuongTonKho" value="<?php echo $product['SoLuongTonKho']; ?>">
            </div>
            <div class="form-group">
                <label for="moTa">Mô tả:</label>
                <textarea class="form-control" id="moTa" name="moTa"><?php echo $product['MoTaSP']; ?></textarea>
            </div>
            <div class="form-group">
                <label for="maLoai">Loại:</label>
                <select class="form-control" id="maLoai" name="maLoai">
                    <?php foreach ($loai as $category): ?>
                        <option value="<?php echo $category['MaLoai']; ?>" <?php if ($category['MaLoai'] == $product['MaLoai']) echo 'selected'; ?>><?php echo $category['TenLoai']; ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div class="form-group">
                <label for="maNCC">Nhà cung cấp:</label>
                <select class="form-control" id="maNCC" name="maNCC">
                    <?php foreach ($ncc as $supplier): ?>
                        <option value="<?php echo $supplier['MaNCC']; ?>" <?php if ($supplier['MaNCC'] == $product['MaNCC']) echo 'selected'; ?>><?php echo $supplier['TenNCC']; ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
            <button type="submit" class="btn btn-primary">Lưu</button>
        </form>
    </div>
    <?php
    include "Footer.php";
    ?>    
</body>

</html>