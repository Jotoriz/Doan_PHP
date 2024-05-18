<?php

    session_start();
    if ($_SERVER["REQUEST_METHOD"] == "POST") {

        if(isset($_POST['email']) && !empty($_POST['email'])) {

            $pdo = new PDO("mysql:host=localhost; port=3307; dbname=ql_vanphongpham", "root", "");
            $pdo->exec("set names utf8");
            
            $email = $_POST['email'];

            $sql = "SELECT HoTen_KH, DiaChi_KH, SDT_KH, Email_KH FROM KhachHang WHERE Email_KH = :Email_KH";
            $stmt = $pdo->prepare($sql);
            $stmt->execute(array(':Email_KH' => $email));
            $khachHang = $stmt->fetch(PDO::FETCH_ASSOC);
        }
    }

    function HienThiThongTinSanPham($selected_products, $pdo)
    {
        $tongTien = 0;

        if (is_array($selected_products)) {
            foreach ($selected_products as $product) {

                $stmt = $pdo->prepare("SELECT TenSP, Gia FROM SanPham WHERE MaSP = :MaSP");
                $stmt->execute(array(':MaSP' => $product['maSP']));
                $product_info = $stmt->fetch(PDO::FETCH_ASSOC);

                if ($product_info) {
                    echo '<tr>';

                    $image = isset($product['image']) ? $product['image'] : 'default.jpg';
                    echo '<td><img src="' . htmlspecialchars($image) . '" alt="Product Image" style="width: 50px; height: 50px;"></td>';

                    echo '<td>' . htmlspecialchars($product_info['TenSP']) . '</td>';
                    
                    echo '<td>' . number_format($product_info['Gia'], 0, ',', '.') . ' VNĐ</td>';

                    echo '<td>' . htmlspecialchars($product['soLuong']) . '</td>';

                    echo '<td>' . number_format($product_info['Gia'] * $product['soLuong'], 0, ',', '.') . ' VNĐ</td>';
                    echo '</tr>';

                    $tongTien += $product_info['Gia'] * $product['soLuong'];
                }
            }
        } else {
            echo "Dữ liệu không hợp lệ";
        }

        echo '<tr>';
        echo '<td colspan="5" class="text-right"><strong>Tổng tiền:</strong></td>';
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
        <form method="POST" action="XacNhan.php">
            <div class="row">
                <div class="col-md-6">
                    <!-- Thông tin khách hàng -->
                    <h2>Thông tin khách hàng:</h2>
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
                </div>
                <div class="col-md-6">
                    <!-- Giỏ hàng -->
                    <h2>Giỏ hàng:</h2>
                    <table class="table">
                        <thead>
                            <tr>
                                <th scope="col">Hình ảnh</th>
                                <th scope="col">Sản phẩm</th>
                                <th scope="col">Giá</th>
                                <th scope="col">Số lượng</th>
                                <th scope="col">Thành tiền</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                                if (isset($_POST['selected_products']) && is_array($_POST['selected_products'])) {
                                    HienThiThongTinSanPham($_POST['selected_products'], $pdo);
                                } else {
                                    echo "<tr><td colspan='5'>Không có sản phẩm nào được chọn.</td></tr>";
                                }
                            ?>
                        </tbody>
                    </table>
                </div>
            </div>
            <!-- Nút Xác nhận đơn hàng -->
            <div class="row">
                <div class="col-md-6 offset-md-6">
                    <input type="hidden" name="selected_products" value='<?php echo json_encode($_POST['selected_products']); ?>'>
                    <button type="submit" class="btn btn-success float-right">Xác nhận đơn hàng</button>
                </div>
            </div>
        </form>
    </div>

    <?php
    include "Footer.php";
    ?>
</body>
</html>
<script src="https://kit.fontawesome.com/d3f4e54f8d.js" crossorigin="anonymous"></script>


