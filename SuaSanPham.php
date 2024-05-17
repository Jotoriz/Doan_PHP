<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sửa Sản phẩm</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="stylec.css">
</head>
<style>
    /* Custom styles for form elements */
    form {
        max-width: 400px;
        margin: 0 auto;
        padding: 20px;
        background-color: #f9f9f9;
        border-radius: 8px;
        box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
    }

    label {
        font-weight: bold;
        color: #333;
        margin-bottom: 8px;
        display: block;
    }

    input[type="text"],
    select,
    textarea {
        width: calc(100% - 22px);
        padding: 10px;
        margin: 5px 0 15px;
        border: 1px solid #ccc;
        border-radius: 4px;
        box-sizing: border-box;
    }

    input[type="submit"] {
        background-color: #007bff;
        color: white;
        padding: 14px 20px;
        margin: 8px 0 15px;
        border: none;
        border-radius: 4px;
        cursor: pointer;
        width: 100%;
        transition: background-color 0.3s ease;
    }

    input[type="submit"]:hover {
        background-color: #0056b3;
    }

    /* Additional styles for specific elements */
    select {
        width: 100%;
    }
</style>
<?php
    session_start();

    $pdo = new PDO("mysql:host=localhost;dbname=ql_vanphongpham", "root", "");
    $pdo->query("set names utf8");
    $sqlNCC = "SELECT MaNCC, TenNCC FROM nhacungcap";
    $ncc = $pdo->query($sqlNCC);

    $sqlLoai = "SELECT MaLoai, TenLoai FROM loaisp";
    $loai = $pdo->query($sqlLoai);

    // Kiểm tra xem có ID sản phẩm được truyền từ trang trước không
    if(isset($_GET['id']) && !empty($_GET['id'])) {
        $id = $_GET['id'];
        
        // Truy vấn để lấy thông tin sản phẩm cần sửa từ ID
        $sql = "SELECT * FROM sanpham WHERE MaSP = :id";
        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(':id', $id);
        $stmt->execute();
        $product = $stmt->fetch(PDO::FETCH_ASSOC);

        if(!$product) {
            echo "Không tìm thấy sản phẩm.";
            exit;
        }

        if($_SERVER["REQUEST_METHOD"] == "POST") {
            // Lấy dữ liệu từ biểu mẫu sửa sản phẩm
            $tenSP = $_POST['tenSP'];
            $gia = $_POST['gia'];
            $dvt = $_POST['dvt'];
            $soLuongTonKho = $_POST['soLuongTonKho'];
            $moTaSP = $_POST['moTaSP'];
            $maNCC = $_POST['maNCC'];
            $maLoai = $_POST['maLoai'];

            // Cập nhật thông tin sản phẩm trong cơ sở dữ liệu
            $sqlUpdate = "UPDATE sanpham SET TenSP = :tenSP, Gia = :gia, DVT = :dvt, SoLuongTonKho = :soLuongTonKho, MoTaSP = :moTaSP, MaNCC = :maNCC, MaLoai = :maLoai WHERE MaSP = :id";
            $stmt = $pdo->prepare($sqlUpdate);
            $stmt->bindParam(':tenSP', $tenSP);
            $stmt->bindParam(':gia', $gia);
            $stmt->bindParam(':dvt', $dvt);
            $stmt->bindParam(':soLuongTonKho', $soLuongTonKho);
            $stmt->bindParam(':moTaSP', $moTaSP);
            $stmt->bindParam(':maNCC', $maNCC);
            $stmt->bindParam(':maLoai', $maLoai);
            $stmt->bindParam(':id', $id);
            if($stmt->execute()) {
                echo "Cập nhật sản phẩm thành công.";
            } else {
                echo "Lỗi khi cập nhật sản phẩm.";
            }
        }
    } else {
        echo "Không có ID sản phẩm được cung cấp.";
        exit;
    }
?>
<body>
<?php
    include "Header.php";

    include "SubHeader.php";
    ?>
    <div class="container mt-5">
        <h1 align="center">Sửa sản phẩm</h2>
        <form method="post">
            <input type="hidden" name="id" value="<?php echo $id; ?>">
            <label for="tenSP">Tên sản phẩm:</label><br>
            <input type="text" id="tenSP" name="tenSP" value="<?php echo $product['TenSP']; ?>"><br>
            <label for="gia">Giá:</label><br>
            <input type="text" id="gia" name="gia" value="<?php echo $product['Gia']; ?>"><br>
            <label for="dvt">Đơn vị tính:</label><br>
            <input type="text" id="dvt" name="dvt" value="<?php echo $product['DVT']; ?>"><br>
            <label for="soLuongTonKho">Số lượng tồn kho:</label><br>
            <input type="text" id="soLuongTonKho" name="soLuongTonKho" value="<?php echo $product['SoLuongTonKho']; ?>"><br>
            <label for="moTaSP">Mô tả:</label><br>
            <textarea id="moTaSP" name="moTaSP"><?php echo $product['MoTaSP']; ?></textarea><br><br>

            <label for="maNCC">Mã nhà cung cấp:</label><br>
            <select id="maNCC" name="maNCC">
                <?php foreach ($ncc as $ncc): ?>
                    <option value="<?php echo $ncc['TenNCC']; ?>"<?php if ($ncc['MaNCC'] == $product['MaNCC']) echo " selected"; ?>>
                        <?php echo $ncc['TenNCC']; ?>
                    </option>
                <?php endforeach; ?>
            </select><br>

            <label for="maLoai">Mã loại:</label><br>
            <select id="maLoai" name="maLoai">
                <?php foreach ($loai as $loai): ?>
                    <option value="<?php echo $loai['TenLoai']; ?>"<?php if ($loai['MaLoai'] == $product['MaLoai']) echo " selected"; ?>>
                        <?php echo $loai['TenLoai']; ?>
                    </option>
                <?php endforeach; ?>
            </select><br>

            <input type="submit" value="Cập nhật">
        </form>
    </div>
    <?php
    include "Footer.php";
    ?>
    
</body>
</html>
