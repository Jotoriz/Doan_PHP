<!DOCTYPE html>
<html lang="en">

    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Tất cả</title>
        <link rel="stylesheet" href="Bootstrap/bootstrap.min.css">
        <link rel="stylesheet" href="styles.css">
    </head>
    <?php
        $pdo = new PDO("mysql:host=localhost;port=3307;dbname=ql_vanphongpham", "root", "");
        $pdo->query("set names utf8");

        $sqlLoaiMon = "select * from loaisp";
        $loai_mon = $pdo->query($sqlLoaiMon);
        //Giỏ hàng
        session_start();
        if(!isset($_SESSION['cart']))
        {
            $_SESSION['cart']=[];
        }
        //Xóa ALL giỏ hàng
        if (isset($_POST['emptyCart']) && ($_POST['emptyCart'] == 1)) {
            unset($_SESSION['cart']);
        }
        //Xóa item trong giỏ
        if (isset($_POST['delId']) && ($_POST['delId'] >= 0)) {
            array_splice($_SESSION['cart'], $_POST['delId'], 1);
        }
        //Update item trong giỏ
        if (isset($_POST['updateItem'])) { // Sử dụng tên nút submit đã thay đổi
            $index = $_POST['updateId'];
            $new_quantity = $_POST['sl_'.$index]; // Lấy giá trị số lượng từ trường số lượng tương ứng
            if (isset($_SESSION['cart'][$index])) {
                $_SESSION['cart'][$index]['SoLuong'] = $new_quantity;
            }
        }
        

        if(isset($_POST['add_to_cart'])) {
            $maSP = $_POST['MaSP'];
            $tenSP = $_POST['TenSP'];
            $gia = $_POST['Gia'];
            $sl = $_POST['sl'];

            $product = array(
                'MaSP' => $maSP,
                'TenSP' => $tenSP,
                'Gia' => $gia,
                'SoLuong' => $sl
            );

            $flag=0;
            $count = count($_SESSION['cart']);
            for($i=0;$i<$count;$i++)
            {
                $item=$_SESSION['cart'][$i];
                if($item["MaSP"]==$maSP)
                {
                    $flag=1;
                    $sl_new=$sl+$item["SoLuong"];
                    $item["SoLuong"]=$sl_new;
                    $_SESSION['cart'][$i]=$item;
                    break;
                }
            }
            if($flag == 0)
            {
                $sp=array(
                    'MaSP' => $maSP,
                    'TenSP' => $tenSP,
                    'Gia' => $gia,
                    'SoLuong' => $sl
                );
                $_SESSION['cart'][]=$sp;
            }
        }

        $maSP = isset($_GET['id']) ? $_GET['id'] : null;

        if ($maSP) {
            $pdo1 = new PDO("mysql:host=localhost;port=3307;dbname=ql_vanphongpham", "root", "");
            $pdo1->query("set names utf8");

            $sqlHinh = "SELECT Hinh FROM hinhanh WHERE masp = '$maSP'";
            $hinh = $pdo1->query($sqlHinh)->fetch(PDO::FETCH_ASSOC);
            $imgUrl = $hinh['Hinh'];
        }       
    ?>

<body>
    <?php
    include "HeaderNhanVienKhachHang.php";

    include "SubHeader.php";
    ?>
    <div class="product mt-5">
        <h2 align="center" style="color:#900;">THÔNG TIN GIỎ HÀNG CỦA BẠN</h2>
        <?php if (empty($_SESSION['cart'])) { ?>
            <table class="table">
                <td class="text-center mx-auto">
                    <div style="margin-bottom: 20px;">
                        <img src="image/GioHang.png" alt="Cute message"
                            style="max-width: 200px; display: block; margin: 0 auto;"> <!-- Thu nhỏ hình ảnh và căn giữa -->
                    </div>
                    <p style="font-size: 20px;">Đơn hàng của bạn đang trống. Hãy chọn mua sản phẩm nhé!</p>
                </td>
            </table>
        <?php } ?>

        <?php if (isset($_SESSION['cart']) && count($_SESSION['cart']) > 0) { ?>
            <form action="ShopCart.php" method="post">
                <table class="table">
                    <thead>
                        <tr>
                            <th style="padding-left: 30px;">Sản phẩm</th>
                            <th>Giá bán</th>
                            <th>Số lượng</th>
                            <th>Tổng tiền</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                            $totalCounter = 0;
                            $itemCounter = 0;
                            foreach($_SESSION['cart'] as $i => $item) {
                                $maSP = $item["MaSP"];
                                $imgUrl = "image/SanPham/" . $maSP . ".jpg";
                                
                                $total = (float)$item["Gia"] * (int)$item["SoLuong"];

                                $totalCounter += $total;
                                $itemCounter += $item["SoLuong"];
                            ?>
                            <tr>
                                <td>
                                    <form action="ShopCart.php" method="post">                                        
                                        <input type="checkbox" name="<?php echo $MaSP ?>" value="<?php echo $i;?>" class="item-checkbox" onchange="updateTotal()">
                                        <img src="<?php echo $imgUrl; ?>" class="rounded img-thumbnail mr-2" style="width:60px;"><?php echo $item['TenSP'];?>
                                    </form>
                                </td>
                                <td id="price_<?php echo $i; ?>"> <!-- Thêm id cho mỗi giá -->
                                    <?php echo number_format($item['Gia'], 0, ',', '.'); ?> VNĐ
                                </td>
                                <td>
                                    <form action="ShopCart.php" method="post"> <!-- Thay đổi phương thức thành POST -->
                                        <input type="hidden" name="updateId" value="<?php echo $i;?>">
                                        <input type="number" name="sl_<?php echo $i;?>" class="cart-qty-single" value="<?php echo $item['SoLuong'];?>" min="1" max="1000"> <!-- Sử dụng tên trường số lượng khác nhau -->
                                        <button type="submit" name="updateItem" class="text-primary">Cập nhật</button> <!-- Đổi tên nút submit để phân biệt -->
                                    </form>
                                </td>

                                <td id="total_<?php echo $i; ?>">
                                    <?php echo number_format($total, 0, ',', '.'); ?> VNĐ
                                </td>
                                <td>
                                <form action="ShopCart.php" method="post">
                                    <input type="hidden" name="delId" value="<?php echo $i;?>">
                                    <button type="submit" name="deleteItem" class="btn btn-danger btn-custom-size" >Xóa</button>
                                </form>

                                </td>
                            </tr>
                            <?php } ?>
                            <tr class="border-top border-bottom">
                                <td>
                                    <form action="ShopCart.php" method="post">
                                        <input type="hidden" name="emptyCart" value="1">
                                        <button type="submit" class="btn btn-danger btn-custom-size">Xóa tất cả</button>
                                    </form>
                                </td>
                                <td></td>
                                <td></td>
                                <td><strong id="totalPrice">0</strong></td>
                                <td>
                                    <form action="ThanhToan.php" method="post" id="checkoutForm">
                                        <input type="hidden" name="email" id="email">
                                        <input type="hidden" id="selected_products" name="selected_products" value="">                              
                                        <button type="submit" class="btn btn-danger btn-custom-size">Thanh toán</button>
                                    </form>
                                </td>
                            </tr>
                    </tbody>
                </table>
            </form>
        <?php } ?>
    </div>
    <?php
    include "Footer.php";
    ?>
    <script src="https://kit.fontawesome.com/d3f4e54f8d.js" crossorigin="anonymous"></script>
</body>

</html>
<script>
    function updateTotal() {
        var total = 0;
        var countChecked = 0;
        var checkboxes = document.querySelectorAll('.item-checkbox:checked');

        checkboxes.forEach(function(checkbox) {
            var rowIndex = checkbox.value;
            var isChecked = checkbox.checked;
            if (isChecked) {
                var totalItem = parseFloat(document.querySelector('#total_' + rowIndex).innerText.replace(/\./g, '').replace(' VNĐ', ''));
                total += totalItem;
                countChecked++;
            }
        });

        total = total.toLocaleString('vi-VN', { minimumFractionDigits: 0 });

        if (countChecked > 0) {
            document.querySelector('#totalPrice').innerText = total + ' VNĐ';
        } else {
            document.querySelector('#totalPrice').innerText = '0 VNĐ';
        }
    }
</script>



<script>
    var email = window.localStorage.getItem('email');
        document.getElementById('email').value = email;

        var email = window.localStorage.getItem('email');
        document.getElementById('email').value = email;

        function getCustomerInfo() {
        var email = document.getElementById('email').value;
        var xhr = new XMLHttpRequest();
        xhr.open('POST', 'ThanhToan.php', true);
        xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
        xhr.onreadystatechange = function() {
            if(xhr.readyState == XMLHttpRequest.DONE && xhr.status == 200) {
                // Xử lý kết quả trả về từ server (nếu có)
                console.log(xhr.responseText);
            }
        };
        xhr.send('email=' + encodeURIComponent(email));
    }
</script>

<script>
    document.addEventListener('DOMContentLoaded', function() {
    // Lắng nghe sự kiện click trên nút thanh toán
    document.getElementById('checkoutForm').addEventListener('submit', function(event) {
        // Lấy danh sách checkbox
        var checkboxes = document.querySelectorAll('.item-checkbox');

        // Biến kiểm tra xem có checkbox nào được chọn không
        var isChecked = false;

        // Lặp qua từng checkbox để kiểm tra xem có checkbox nào được chọn không
        checkboxes.forEach(function(checkbox) {
            if (checkbox.checked) {
                isChecked = true;
            }
        });

        // Nếu không có checkbox nào được chọn, ngăn chặn việc submit form và hiển thị thông báo
        if (!isChecked) {
            event.preventDefault(); // Ngăn chặn form submit
            var warningMessage = document.createElement('p');
            warningMessage.textContent = 'Chọn sản phẩm để thanh toán.';
            warningMessage.style.color = 'red';
            var form = document.getElementById('checkoutForm');
            form.appendChild(warningMessage);
        }
    });
});
</script>

<script>
    // Hàm này được gọi khi người dùng chọn hoặc hủy chọn một sản phẩm
    function updateSelectedProducts() {
        var selectedProducts = [];
        var checkboxes = document.querySelectorAll('.item-checkbox:checked');
        checkboxes.forEach(function(checkbox) {
            var rowIndex = checkbox.value;
            var quantity = document.querySelector('input[name="sl_' + rowIndex + '"]').value; // Lấy số lượng sản phẩm
            selectedProducts.push({ MaSP: rowIndex, SoLuong: quantity });
        });
        document.getElementById('selected_products').value = JSON.stringify(selectedProducts);
    }

    // Thêm sự kiện onchange cho tất cả các ô checkbox
    var checkboxes = document.querySelectorAll('.item-checkbox');
    checkboxes.forEach(function(checkbox) {
        checkbox.addEventListener('change', function() {
            updateSelectedProducts();
        });
    });

    // Cập nhật số lượng khi người dùng thay đổi số lượng sản phẩm
    var qtyInputs = document.querySelectorAll('.cart-qty-single');
    qtyInputs.forEach(function(input) {
        input.addEventListener('change', function() {
            updateSelectedProducts();
        });
    });
</script>
