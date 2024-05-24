<?php
session_start();

$pdo = new PDO("mysql:host=localhost; dbname=ql_vanphongpham", "root", "");
$pdo->exec("set names utf8");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['email']) && !empty($_POST['email'])) {
        $email = $_POST['email'];

        // Truy vấn thông tin khách hàng bao gồm MaKH
        $sql = "SELECT MaKH, HoTen_KH, DiaChi_KH, SDT_KH, Email_KH FROM KhachHang WHERE Email_KH = :Email_KH";
        $stmt = $pdo->prepare($sql);
        $stmt->execute(array(':Email_KH' => $email));
        $khachHang = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($khachHang) {
            $maKH = $_SESSION['maKH'] = $khachHang['MaKH']; // Sử dụng MaKH thay vì Email_KH 
        }
    }
} elseif (isset($_SESSION['maKH'])) {
    $maKH = $_SESSION['maKH'];
}

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['delete_order'])) {
    $maDH = $_POST['MaDH'];

    // Xóa ChiTietDonDatHang trước
    $stmtChiTiet = $pdo->prepare("DELETE FROM ChiTietDonDatHang WHERE MaDH = :MaDH");
    $stmtChiTiet->execute(array(':MaDH' => $maDH));

    // Sau đó xóa DonDatHang
    $stmtDonDatHang = $pdo->prepare("DELETE FROM DonDatHang WHERE MaDDH = :MaDH");
    $stmtDonDatHang->execute(array(':MaDH' => $maDH));

    header("Location: DonHangKh.php");
    exit();
}

function HienThiDonDatHang($pdo, $maKH)
{
    $trangThai = isset($_GET['trangThai']) ? $_GET['trangThai'] : '';

    // Tạo câu truy vấn dựa trên trạng thái đơn hàng
    $sql = "SELECT MaDDH, NgayDatHang, TrangThaiDonHang, TongGiaTriDonHang FROM DonDatHang WHERE MaKH = :MaKH";
    if ($trangThai != '' && $trangThai != 'Tất cả') {
        $sql .= " AND TrangThaiDonHang = :TrangThai";
    }
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(':MaKH', $maKH, PDO::PARAM_STR);
    if ($trangThai != '' && $trangThai != 'Tất cả') {
        $stmt->bindParam(':TrangThai', $trangThai, PDO::PARAM_STR);
    }
    $stmt->execute();
    $donDatHang = $stmt->fetchAll(PDO::FETCH_ASSOC);

    echo '<h2>Thông tin đơn đặt hàng</h2>';
    echo '<form method="GET" action="">';
    echo '<select class="timkiem" name="trangThai">';
    echo '<option value="Tất cả"' . ($trangThai == 'Tất cả' ? ' selected' : '') . '>Tất cả</option>';
    echo '<option value="Đã xử lý"' . ($trangThai == 'Đã xử lý' ? ' selected' : '') . '>Đã xử lý</option>';
    echo '<option value="Đang xử lý"' . ($trangThai == 'Đang xử lý' ? ' selected' : '') . '>Đang xử lý</option>';
    echo '</select>';
    echo '<button class="btn btn-primary timkiem" type="submit">Tìm kiếm</button>';
    echo '</form>';

    if ($donDatHang) {
        echo '<table class="table">';
        echo '<thead><tr><th>Ngày đặt hàng</th><th style="text-align:center;">Trạng thái đơn hàng</th><th>Tổng giá trị đơn hàng</th><th style="text-align:right;">Thao tác</th></tr></thead>';
        echo '<tbody>';
        foreach ($donDatHang as $order) {
            echo '<tr>';
            echo '<td>' . htmlspecialchars($order['NgayDatHang']) . '</td>';
            echo '<td style="text-align:center;">' . htmlspecialchars($order['TrangThaiDonHang']) . '</td>';
            echo '<td>' . number_format($order['TongGiaTriDonHang'], 0, ',', '.') . ' VNĐ</td>';
            echo '<td style="text-align:right;">';
            echo '<a href="ChiTietDonHangKH.php?MaDH=' . $order['MaDDH'] . '">Xem chi tiết</a> ';
            echo '<form method="POST" action="DonHangKH.php" style="display:inline;">';
            echo '<input type="hidden" name="MaDH" value="' . $order['MaDDH'] . '">';
            echo '<button type="submit" name="delete_order" class="btn btn-danger huydon" onclick="return confirm(\'Bạn có chắc chắn muốn hủy đơn hàng này không?\');">Hủy đơn</button>';
            echo '</form>';
            echo '</td>';
            echo '</tr>';
        }
        echo '</tbody></table>';
    } else {
        echo '<p>Không có đơn hàng nào.</p>';
    }
}
?>

<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Thông tin đơn hàng</title>
    <link rel="stylesheet" href="Bootstrap/bootstrap.min.css">
    <link rel="stylesheet" href="styles.css">
</head>
<style>
    .huydon {
        margin-left: 20px;
    }

    h2 {
        text-align: center;
    }

    .QLDonHang {
        margin-top: 50px;
        min-height: 482px;
    }

    .timkiem {
        height: 35px;
        float: right;
        margin-right: 30px;
        margin-bottom: 20px;
    }
</style>

<body>
    <?php
    include "Header.php";
    include "SubHeader.php";
    ?>

    <div class="container QLDonHang">
        <div class="row">
            <div class="col-md-12">
                <!-- Thông tin đơn đặt hàng -->
                <?php
                if (isset($maKH)) {
                    HienThiDonDatHang($pdo, $maKH);
                } else {
                    echo "<p>Không tìm thấy khách hàng.</p>";
                }
                ?>
            </div>
        </div>
    </div>

    <?php
    include "Footer.php";
    ?>
</body>

</html>


<script>
    document.addEventListener('DOMContentLoaded', function () {
        if (!localStorage.getItem('emailSubmitted')) {
            setEmailFromLocalStorage();
        }
    });

    function setEmailFromLocalStorage() {
        var email = localStorage.getItem('email');
        if (email) {
            var form = document.createElement('form');
            form.method = 'POST';
            form.action = '';

            var input = document.createElement('input');
            input.type = 'hidden';
            input.name = 'email';
            input.value = email;

            form.appendChild(input);
            document.body.appendChild(form);
            localStorage.setItem('emailSubmitted', 'true');
            form.submit();
        } else {
            console.log("Không có thông tin khách hàng trong Local Storage");
        }
    }
</script>
<script src="https://kit.fontawesome.com/d3f4e54f8d.js" crossorigin="anonymous"></script>
<script src="Bootstrap/bootstrap.bundle.min.js" crossorigin="anonymous"></script>