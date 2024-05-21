<?php
    session_start();

    $pdo = new PDO("mysql:host=localhost; port=3307; dbname=ql_vanphongpham", "root", "");
    $pdo->exec("set names utf8");

    if (isset($_GET['MaDH']) && !empty($_GET['MaDH'])) {
        $maDH = $_GET['MaDH'];

        function HienThiChiTietDonHang($pdo, $maDH) {
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
        
            echo '<h2>Chi tiết đơn hàng</h2>';
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
        }

    } else {
        echo '<p>Không có mã đơn hàng.</p>';
        exit();
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
