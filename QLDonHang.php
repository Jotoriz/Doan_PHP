<?php
    session_start();

    $pdo = new PDO("mysql:host=localhost; port=3307; dbname=ql_vanphongpham", "root", "");
    $pdo->exec("set names utf8");

    function HienThiDonDatHang($pdo) {
        $trangThai = isset($_GET['trangThai']) ? $_GET['trangThai'] : '';
    
        // Tạo câu truy vấn để lấy tất cả đơn hàng với thông tin Email_KH
        $sql = "SELECT dd.MaDDH, dd.NgayDatHang, dd.TrangThaiDonHang, dd.TongGiaTriDonHang, kh.Email_KH 
                FROM DonDatHang dd 
                JOIN KhachHang kh ON dd.MaKH = kh.MaKH";
        if ($trangThai != '' && $trangThai != 'Tất cả') {
            $sql .= " WHERE dd.TrangThaiDonHang = :TrangThai";
        }
        $stmt = $pdo->prepare($sql);
        if ($trangThai != '' && $trangThai != 'Tất cả') {
            $stmt->bindParam(':TrangThai', $trangThai, PDO::PARAM_STR);
        }
        $stmt->execute();
        $donDatHang = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
        echo '<h2>Thông tin đơn đặt hàng</h2>';
        echo '<form method="GET" action="">';
        echo '<select name="trangThai">';
        echo '<option value="Tất cả"' . ($trangThai == 'Tất cả' ? ' selected' : '') . '>Tất cả</option>';
        echo '<option value="Đã xử lý"' . ($trangThai == 'Đã xử lý' ? ' selected' : '') . '>Đã xử lý</option>';
        echo '<option value="Đang xử lý"' . ($trangThai == 'Đang xử lý' ? ' selected' : '') . '>Đang xử lý</option>';
        echo '</select>';
        echo '<button type="submit">Tìm kiếm</button>';
        echo '</form>';
    
        if ($donDatHang) {
            echo '<table class="table">';
            echo '<thead><tr><th>Email khách hàng</th><th>Ngày đặt hàng</th><th style="text-align:center;">Trạng thái đơn hàng</th><th>Tổng giá trị đơn hàng</th><th style="text-align:right;">Thao tác</th></tr></thead>';
            echo '<tbody>';
            foreach ($donDatHang as $order) {
                echo '<tr>';
                echo '<td>' . htmlspecialchars($order['Email_KH']) . '</td>';
                echo '<td>' . htmlspecialchars($order['NgayDatHang']) . '</td>';
                echo '<td style="text-align:center;">' . htmlspecialchars($order['TrangThaiDonHang']) . '</td>';
                echo '<td>' . number_format($order['TongGiaTriDonHang'], 0, ',', '.') . ' VNĐ</td>';
                echo '<td style="text-align:right;">';
                echo '<a href="QLChiTietDonHang.php?MaDH=' . $order['MaDDH'] . '&Email_KH=' . $order['Email_KH'] . '">Xem chi tiết</a> ';
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
    <link rel="stylesheet" href="./styles.css">
</head>
<body>
    <?php
    include "HeaderNhanVienKhachHang.php";
    include "SubHeader.php";
    ?>
    
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <!-- Thông tin đơn đặt hàng -->
                <?php
                    HienThiDonDatHang($pdo);
                ?>
            </div>
        </div>
    </div>

    <?php
    include "Footer.php";
    ?>
</body>
</html>
