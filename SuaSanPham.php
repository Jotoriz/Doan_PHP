<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sửa Sản phẩm</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="styles.css">
</head>
<?php
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
        echo '<div class="alert alert-success" role="alert">Cập nhật sản phẩm thành công!</div>';
    } else {
        echo '<div class="alert alert-danger" role="alert">Cập nhật sản phẩm thất bại. Vui lòng thử lại!</div>';
    }
} else {
    $maSanPham = $_GET['maSanPham'];
    $sql = "SELECT * FROM sanpham WHERE MaSP = :maSanPham";
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(':maSanPham', $maSanPham);
    $stmt->execute();
    $product = $stmt->fetch(PDO::FETCH_ASSOC); // Fetch as associative array

    if ($product === false) {
        echo '<div class="alert alert-danger" role="alert">Không tìm thấy sản phẩm với mã này.</div>';
        die(); // Stop further processing if product is not found
    }

    $sqlNCC = "SELECT MaNCC, TenNCC FROM nhacungcap";
    $ncc = $pdo->query($sqlNCC);

    $sqlLoai = "SELECT MaLoai, TenLoai FROM loaisp";
    $loai = $pdo->query($sqlLoai);
}
?>

<body>
    <?php
    include "Header.php";

    include "SubHeader.php";
    ?>
    <div class="container mt-5">
        <h1>Sửa Sản phẩm</h1>
        <form action="SuaSanPham.php" method="POST">
            <input type="hidden" name="maSanPham" value="<?php echo $product['MaSP']; ?>">
            <div class="form-group">
                <label for="tenSanPham">Tên Sản phẩm:</label>
                <input type="text" class="form-control" id="tenSanPham" name="tenSanPham"
                    value="<?php echo $product['TenSP']; ?>">
            </div>
            <div class="form-group">
                <label for="gia">Giá:</label>
                <input type="text" class="form-control" id="gia" name="gia" value="<?php echo $product['Gia']; ?>">
            </div>
            <div class="form-group">
                <label for="donViTinh">Đơn vị tính:</label>
                <input type="text" class="form-control" id="donViTinh" name="donViTinh"
                    value="<?php echo $product['DVT']; ?>">
            </div>
            <div class="form-group">
                <label for="soLuongTonKho">Số lượng tồn kho:</label>
                <input type="text" class="form-control" id="soLuongTonKho" name="soLuongTonKho"
                    value="<?php echo $product['SoLuongTonKho']; ?>">
            </div>
            <div class="form-group">
                <label for="moTa">Mô tả:</label>
                <textarea class="form-control" id="moTa" name="moTa"><?php echo $product['MoTaSP']; ?></textarea>
            </div>
            <div class="form-group">
                <label for="maLoai">Loại:</label>
                <select class="form-control" id="maLoai" name="maLoai">
                    <?php foreach ($loai as $category): ?>
                        <option value="<?php echo $category['MaLoai']; ?>" <?php if ($category['MaLoai'] == $product['MaLoai'])
                               echo 'selected'; ?>>
                            <?php echo $category['TenLoai']; ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div class="form-group">
                <label for="maNCC">Nhà cung cấp:</label>
                <select class="form-control" id="maNCC" name="maNCC">
                    <?php foreach ($ncc as $supplier): ?>
                        <option value="<?php echo $supplier['MaNCC']; ?>" <?php if ($supplier['MaNCC'] == $product['MaNCC'])
                               echo 'selected'; ?>><?php echo $supplier['TenNCC']; ?></option>
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