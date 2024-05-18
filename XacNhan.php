<?php
    session_start();

    // Kiểm tra nếu là phương thức POST và các dữ liệu cần thiết được gửi đi
    if (isset($_POST['hoTen']) && isset($_POST['diaChi']) && isset($_POST['sdt']) && isset($_POST['email'])){

        // Kết nối đến cơ sở dữ liệu
        $pdo = new PDO("mysql:host=localhost; port=3307; dbname=ql_vanphongpham", "root", "");
        $pdo->exec("set names utf8");

        // Lấy thông tin khách hàng từ dữ liệu POST
        $hoTen = $_POST['hoTen'];
        $diaChi = $_POST['diaChi'];
        $sdt = $_POST['sdt'];
        $email = $_POST['email'];

        function HienThiThongTinSanPham($selected_products, $pdo, $maKH)
        {
            // Thêm thông tin giỏ hàng vào bảng ChiTietDonDatHang
            foreach ($selected_products as $product) {
                $maSP = $product['maSP'];
                $soLuong = $product['soLuong'];
                $stmt = $pdo->prepare("INSERT INTO ChiTietDonDatHang (MaDH, MaSP, SoLuong) VALUES (:maDH, :maSP, :soLuong)");
                $stmt->execute(array(':maDH' => $maKH, ':maSP' => $maSP, ':soLuong' => $soLuong));
            }

            // Tính tổng tiền của đơn hàng
            $tongTien = 0;
            foreach ($selected_products as $product) {
                $maSP = $product['maSP'];
                $soLuong = $product['soLuong'];
                $stmt = $pdo->prepare("SELECT Gia FROM SanPham WHERE MaSP = :maSP");
                $stmt->execute(array(':maSP' => $maSP));
                $gia = $stmt->fetch(PDO::FETCH_ASSOC)['Gia'];
                $tongTien += $gia * $soLuong;
            }

            // Thêm thông tin đơn hàng vào bảng DonDatHang
            $trangThai = "Đang xử lý";
            $stmt = $pdo->prepare("INSERT INTO DonDatHang (MaKH, TrangThai, TongTien) VALUES (:maKH, :trangThai, :tongTien)");
            $stmt->execute(array(':maKH' => $maKH, ':trangThai' => $trangThai, ':tongTien' => $tongTien));

            // Hiển thị thông báo đơn hàng đã được xác nhận
            echo '<div class="alert alert-success" role="alert">';
            echo '<h4 class="alert-heading">Đơn hàng của bạn đã được xác nhận!</h4>';
            echo '<p>Cảm ơn bạn đã đặt hàng. Chúng tôi sẽ liên hệ với bạn sớm nhất có thể.</p>';
            echo '</div>';
        }
    }
    
?>


<!DOCTYPE html>
<html lang="en">

    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Xác nhận đơn hàng</title>
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
                <div class="col-md-6">
                    <?php
                    // Kiểm tra xem có lỗi không trước khi hiển thị thông tin khách hàng
                    if (isset($hoTen) && isset($diaChi) && isset($sdt) && isset($email)) {
                        // Hiển thị thông tin khách hàng
                        echo '<h2>Thông tin khách hàng:</h2>';
                        echo '<p><strong>Họ và tên:</strong> ' . htmlspecialchars($hoTen) . '</p>';
                        echo '<p><strong>Địa chỉ:</strong> ' . htmlspecialchars($diaChi) . '</p>';
                        echo '<p><strong>Số điện thoại:</strong> ' . htmlspecialchars($sdt) . '</p>';
                        echo '<p><strong>Email:</strong> ' . htmlspecialchars($email) . '</p>';
                    }
                    ?>
                </div>

                <div class="col-md-6">
                    <?php
                    // Hiển thị chi tiết đơn hàng
                    echo '<h2>Chi tiết đơn hàng:</h2>';
                    echo '<table class="table">';
                    echo '<thead>';
                    echo '<tr>';
                    echo '<th scope="col">Hình ảnh</th>';
                    echo '<th scope="col">Sản phẩm</th>';
                    echo '<th scope="col">Giá</th>';
                    echo '<th scope="col">Số lượng</th>';
                    echo '<th scope="col">Thành tiền</th>';
                    echo '</tr>';
                    echo '</thead>';
                    echo '<tbody>';
                    if (isset($_POST['selected_products']) && is_array($_POST['selected_products'])) {
                        // Gọi hàm HienThiThongTinSanPham để hiển thị thông tin sản phẩm và cập nhật vào cơ sở dữ liệu
                        HienThiThongTinSanPham($_POST['selected_products'], $pdo, $maKH);
                    } else {
                        echo "<tr><td colspan='5'>Không có sản phẩm nào được chọn.</td></tr>";
                    }

                    echo '</tbody>';
                    echo '</table>';

                    // Thông báo đơn hàng đã được xác nhận
                    echo '<div class="alert alert-success" role="alert">';
                    echo '<h4 class="alert-heading">Đơn hàng của bạn đã được xác nhận!</h4>';
                    echo '<p>Cảm ơn bạn đã đặt hàng. Chúng tôi sẽ liên hệ với bạn sớm nhất có thể.</p>';
                    echo '</div>';
                    ?>
                </div>
            </div>
        </div>


        <?php
        include "Footer.php";
        ?>
    </body>

</html>
<script src="https://kit.fontawesome.com/d3f4e54f8d.js" crossorigin="anonymous"></script>
