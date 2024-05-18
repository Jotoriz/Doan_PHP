<?php

    session_start();
    // Kiểm tra yêu cầu là POST
    if ($_SERVER["REQUEST_METHOD"] == "POST") {

        // Kiểm tra xem email được gửi từ form và không rỗng
        if(isset($_POST['email']) && !empty($_POST['email'])) {

            // Kết nối đến cơ sở dữ liệu
            $pdo = new PDO("mysql:host=localhost;dbname=ql_vanphongpham", "root", "");
            $pdo->exec("set names utf8");
            
            // Lấy email từ form
            $email = $_POST['email'];

            // Truy vấn để lấy thông tin khách hàng từ cơ sở dữ liệu
            $sql = "SELECT HoTen_KH, DiaChi_KH, SDT_KH, Email_KH FROM KhachHang WHERE Email_KH = :Email_KH";
            $stmt = $pdo->prepare($sql);
            $stmt->execute(array(':Email_KH' => $email));
            // Lấy thông tin khách hàng từ kết quả của truy vấn
            $khachHang = $stmt->fetch(PDO::FETCH_ASSOC);
        }
    }

    function HienThiThongTinSanPham($selected_products)
    {
        $tongTien = 0;

        // Kiểm tra xem $selected_products có phải là một mảng hay không
        if (is_array($selected_products)) {
            // Lặp qua mỗi sản phẩm trong giỏ hàng
            foreach ($selected_products as $product) {
                // Lấy thông tin sản phẩm từ mảng dựa trên mã sản phẩm
                $product_info = LayThongTinSanPhamTuMang($product['MaSP']);

                // Hiển thị thông tin sản phẩm
                if ($product_info) {
                    echo '<tr>';
                    echo '<td>' . htmlspecialchars($product_info['TenSP']) . '</td>';
                    echo '<td>' . number_format($product_info['Gia'], 0, ',', '.') . ' VNĐ</td>';
                    echo '<td>' . $product['SoLuong'] . '</td>'; // Số lượng sản phẩm từ giỏ hàng
                    echo '<td>' . number_format($product_info['Gia'] * $product['SoLuong'], 0, ',', '.') . ' VNĐ</td>'; // Thành tiền của từng sản phẩm
                    echo '</tr>';

                    // Cập nhật tổng tiền
                    $tongTien += $product_info['Gia'] * $product['SoLuong'];
                }
            }
        } else {
            // Nếu $selected_products không phải là mảng, hiển thị thông báo lỗi
            echo "Dữ liệu không hợp lệ";
        }

        // Hiển thị tổng tiền
        echo '<tr>';
        echo '<td colspan="3" class="text-right"><strong>Tổng tiền:</strong></td>';
        echo '<td><strong>' . number_format($tongTien, 0, ',', '.') . ' VNĐ</strong></td>';
        echo '</tr>';
    }
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tất cả</title>
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
                <h2>Thông tin khách hàng:</h2>
                <form method="POST" action=""> <!-- Thêm method và action để gửi dữ liệu form qua POST -->
                    <div class="form-group">
                        <label for="hoTen">Họ và tên:</label>
                        <input type="text" class="form-control" id="hoTen" name="hoTen" value="<?php echo htmlspecialchars($khachHang['HoTen_KH']); ?>" readonly>
                    </div>
                    <div class="form-group">
                        <label for="diaChi">Địa chỉ:</label>
                        <input type="text" class="form-control" id="diaChi" name="diaChi" value="<?php echo htmlspecialchars($khachHang['DiaChi_KH']); ?>">
                    </div>
                    <div class="form-group">
                        <label for="sdt">Số điện thoại:</label>
                        <input type="text" class="form-control" id="sdt" name="sdt" value="<?php echo htmlspecialchars($khachHang['SDT_KH']); ?>">
                    </div>
                    <div class="form-group">
                        <label for="email">Email:</label>
                        <input type="email" class="form-control" id="email" name="email" value="<?php echo htmlspecialchars($khachHang['Email_KH']); ?>"  readonly>
                    </div>
                    <div class="form-group">
                        <h2>Hình thức thanh toán:</h2><br>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="radio" name="thanhToan" id="COD" value="COD" checked disabled>
                            <label class="form-check-label" for="COD">Thanh toán khi giao hàng (COD)</label>
                        </div>
                    </div>
                </form>
            </div>
            <div class="col-md-6">
                <h2>Giỏ hàng</h2>
                <table class="table">
                    <thead>
                        <tr>
                            <th scope="col">Sản phẩm</th>
                            <th scope="col">Giá</th>
                            <th scope="col">Số lượng</th>
                            <th scope="col">Thành tiền</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                            $tongTien = 0;

                            // Kiểm tra xem form đã được gửi đi chưa
                            if (isset($_POST['selected_products'])) {
                                // Giải mã chuỗi JSON thành mảng
                                $selected_products = json_decode($_POST['selected_products'], true);

                                // Gọi hàm hiển thị thông tin sản phẩm đã chọn
                                HienThiThongTinSanPham($selected_products, $pdo);
                            } else {
                                echo "<tr><td colspan='4'>Không có sản phẩm nào được chọn.</td></tr>";
                            }
                        ?>
                    </tbody>


                </table>
            </div>
        </div>
    </div>

    <?php
    include "Footer.php";
    ?>
</body>
</html>
<script src="https://kit.fontawesome.com/d3f4e54f8d.js" crossorigin="anonymous"></script>


