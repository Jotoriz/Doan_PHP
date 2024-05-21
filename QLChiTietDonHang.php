<?php
    session_start();

    if (isset($_GET['MaDH']) && !empty($_GET['MaDH']) && isset($_GET['Email_KH']) && !empty($_GET['Email_KH'])) {
        $pdo = new PDO("mysql:host=localhost; port=3307; dbname=ql_vanphongpham", "root", "");
        $pdo->exec("set names utf8");

        $maDH = $_GET['MaDH'];
        $emailKH = $_GET['Email_KH'];

        // Kiểm tra xem $emailKH đã được khởi tạo không
        if (isset($emailKH) && !empty($emailKH)) {
            // Gọi hàm HienThiChiTietDonHang với các tham số cần thiết
            HienThiChiTietDonHang($pdo, $maDH, $emailKH);
        } else {
            echo '<p>Email khách hàng không hợp lệ.</p>';
            exit();
        }
    } else {
        echo '<p>Không có mã đơn hàng hoặc email khách hàng.</p>';
        exit();
    }

    // Định nghĩa hàm HienThiChiTietDonHang
    function HienThiChiTietDonHang($pdo, $maDH, $emailKH) {
        // Lấy thông tin khách hàng từ email
        $stmt = $pdo->prepare("SELECT * FROM KhachHang WHERE Email_KH = :Email_KH");
        $stmt->execute(array(':Email_KH' => $emailKH));
        $khachHang = $stmt->fetch(PDO::FETCH_ASSOC);

        // Kiểm tra xem khách hàng có tồn tại không
        if (!$khachHang) {
            echo '<p>Không tìm thấy thông tin khách hàng.</p>';
            return;
        }

        // Hiển thị thông tin khách hàng bên trái
        echo '<div style="float: left; width: 50%;">';
        echo '<h2>Thông tin khách hàng</h2>';
        echo '<p>Họ và tên: ' . $khachHang['HoTen_KH'] . '</p>';
        echo '<p>Địa chỉ: ' . $khachHang['DiaChi_KH'] . '</p>';
        echo '<p>Số điện thoại: ' . $khachHang['SDT_KH'] . '</p>';
        echo '<p>Email: ' . $khachHang['Email_KH'] . '</p>';
        echo '</div>';

        // Hiển thị chi tiết đơn hàng bên phải
        echo '<div style="float: right; width: 50%;">';
        echo '<h2>Chi tiết đơn hàng</h2>';
        // Tiếp tục hiển thị chi tiết đơn hàng như cũ
        $tenSP = isset($_GET['tenSP']) ? $_GET['tenSP'] : '';
        $totalPrice = 0; // Khởi tạo biến tổng tiền
        
        // Tạo câu truy vấn dựa trên tên sản phẩm
        $sql = "SELECT sp.MaSP, sp.TenSP, sp.Gia, ct.SoLuong 
                FROM ChiTietDonDatHang ct 
                JOIN SanPham sp ON ct.MaSP = sp.MaSP 
                WHERE ct.MaDH = :MaDH";
        if ($tenSP != '') {
            $sql .= " AND sp.TenSP LIKE :TenSP";
        }
        
        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(':MaDH', $maDH, PDO::PARAM_STR);
        if ($tenSP != '') {
            $stmt->bindValue(':TenSP', '%' . $tenSP . '%', PDO::PARAM_STR);
        }
        $stmt->execute();
        $chiTietDonHang = $stmt->fetchAll(PDO::FETCH_ASSOC);
        
        echo '<form method="GET" action="">';
        echo '<input type="hidden" name="MaDH" value="' . htmlspecialchars($maDH) . '">';
        echo 'Tên sản phẩm: <input type="text" name="tenSP" value="' . htmlspecialchars($tenSP) . '">';
        echo '<button type="submit">Tìm kiếm</button>';
        echo '</form>';
        
        if ($chiTietDonHang) {
            echo '<div class="table-responsive">';
            echo '<table class="table">';
            echo '<thead><tr><th>Hình ảnh</th><th>Tên sản phẩm</th><th>Đơn giá</th><th>Số lượng</th><th>Thành tiền</th></tr></thead>';
            echo '<tbody>';
            foreach ($chiTietDonHang as $detail) {
                echo '<tr>';
                $imagePath = 'image/SanPham/' . $detail['MaSP'] . '.jpg'; // Tạo tên file hình ảnh từ mã sản phẩm
                echo '<td><img src="' . $imagePath . '" alt="Product Image" style="width: 50px; height: 50px;"></td>';
                echo '<td>' . htmlspecialchars($detail['TenSP']) . '</td>';
                echo '<td>' . number_format($detail['Gia'], 0, ',', '.') . ' VNĐ</td>';
                echo '<td>' . htmlspecialchars($detail['SoLuong']) . '</td>';
                $thanhTien = $detail['Gia'] * $detail['SoLuong'];
                $totalPrice += $thanhTien; // Cộng dồn vào biến tổng tiền
                echo '<td>' . number_format($thanhTien, 0, ',', '.') . ' VNĐ</td>';
                echo '</tr>';
            }
            echo '</tbody>';
            // Hiển thị tổng tiền ở cuối table
            echo '<tfoot><tr><td colspan="4" style="text-align:right;"><strong>Tổng tiền:</strong></td><td>' . number_format($totalPrice, 0, ',', '.') . ' VNĐ</td></tr></tfoot>';
            echo '</table>';
            echo '</div>';
        } else {
            echo '<p>Không có chi tiết đơn hàng nào.</p>';
        }
        echo '</div>'; // Kết thúc phần hiển thị chi tiết đơn hàng bên phải
    }
?>





<!DOCTYPE html>
    <html lang="vi">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Chi tiết đơn hàng</title>
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
                    <!-- Chi tiết đơn đặt hàng -->
                    <?php
                    if (isset($maDH)) {
                        HienThiChiTietDonHang($pdo, $maDH);
                    } else {
                        echo "<p>Không tìm thấy đơn hàng.</p>";
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
