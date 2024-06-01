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
$pdo = new PDO("mysql:host=localhost;dbname=ql_vanphongpham", "root", "");
$pdo->query("set names utf8");

session_start();
if (!isset($_SESSION['cart'])) {
    $_SESSION['cart'] = [];
}

if (isset($_POST['emptyCart']) && ($_POST['emptyCart'] == 1)) {
    unset($_SESSION['cart']);
}

if (isset($_POST['delId']) && ($_POST['delId'] >= 0)) {
    array_splice($_SESSION['cart'], $_POST['delId'], 1);
}

if (isset($_POST['updateItem'])) {
    $index = $_POST['updateId'];
    $new_quantity = $_POST['sl_' . $index];
    if (isset($_SESSION['cart'][$index])) {
        $_SESSION['cart'][$index]['SoLuong'] = $new_quantity;
    }
}

if (isset($_POST['add_to_cart'])) {
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

    $flag = false;
    foreach ($_SESSION['cart'] as &$item) {
        if ($item["MaSP"] == $maSP) {
            $item["SoLuong"] += $sl;
            $flag = true;
            break;
        }
    }
    unset($item);

    if (!$flag) {
        $_SESSION['cart'][] = $product;
    }
}

$maSP = isset($_GET['id']) ? $_GET['id'] : null;

if ($maSP) {
    $pdo1 = new PDO("mysql:host=localhost;dbname=ql_vanphongpham", "root", "");
    $pdo1->query("set names utf8");

    $sqlHinh = "SELECT Hinh FROM hinhanh WHERE masp = '$maSP'";
    $hinh = $pdo1->query($sqlHinh)->fetch(PDO::FETCH_ASSOC);
    $imgUrl = $hinh['Hinh'];
}
?>

<body>
    <?php
    include "Header.php";
    include "SubHeader.php";
    ?>
    <div class="product mt-5">
        <h2 align="center" style="color:#900;">THÔNG TIN GIỎ HÀNG CỦA BẠN</h2>
        <?php if (empty($_SESSION['cart'])) { ?>
            <table class="table">
                <td class="text-center mx-auto">
                    <div style="margin-bottom: 20px;">
                        <img src="image/GioHang.png" alt="Cute message"
                            style="max-width: 200px; display: block; margin: 0 auto;">
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
                            <th>Thao tác</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $totalCounter = 0;
                        $itemCounter = 0;
                        foreach ($_SESSION['cart'] as $i => $item) {
                            $maSP = $item["MaSP"];
                            $imgUrl = "image/SanPham/" . $maSP . ".jpg";

                            $total = (float) $item["Gia"] * (int) $item["SoLuong"];
                            $totalCounter += $total;
                            $itemCounter += $item["SoLuong"];

                            ?>
                            <tr>
                                <td>
                                    <img src="<?php echo $imgUrl; ?>" class="rounded img-thumbnail mr-2" style="width:60px;">
                                    <?php echo $item['TenSP'];?>
                                </td>

                                <td id="price_<?php echo $i; ?>">
                                    <?php echo $item['Gia']; ?> VNĐ
                                </td>
                                <td>
                                    <form action="ShopCart.php" method="post">
                                        <input type="hidden" name="updateId" value="<?php echo $i; ?>">
                                        <input type="number" name="sl_<?php echo $i; ?>" class="cart-qty-single"
                                            value="<?php echo $item['SoLuong']; ?>" min="1" max="1000">
                                        <button type="submit" name="updateItem" class="text-primary">Cập nhật</button>
                                    </form>
                                </td>

                                <td id="total_<?php echo $i; ?>">
                                    <?php echo $total; ?>.000 VNĐ
                                </td>
                                <td>
                                    <form action="ShopCart.php" method="post">
                                        <input type="hidden" name="delId" value="<?php echo $i; ?>">
                                        <button type="submit" name="deleteItem"
                                            class="btn btn-danger btn-custom-size">Xóa</button>
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
                                <td><strong id="totalPrice"><?php echo $totalCounter; ?>.000 VNĐ</strong></td>s

                                <td>
                                    <form action="ThanhToan.php" method="post" onsubmit="setEmailFromLocalStorage()">
                                        <input type="hidden" name="email" id="email">
                                        <input type="hidden" name="selected_products" id="selected_products">
                                        <?php
                                            foreach ($_SESSION['cart'] as $i => $item) {
                                                $maSP = htmlspecialchars($item['MaSP']);
                                                $imgUrl = "image/SanPham/" . $maSP . ".jpg";

                                                echo '<input type="hidden" name="selected_products[' . $maSP . '][image]" value="' . htmlspecialchars($imgUrl) . '">';
                                                echo '<input type="hidden" name="selected_products[' . $maSP . '][maSP]" value="' . $maSP . '">';
                                                echo '<input type="hidden" name="selected_products[' . $maSP . '][soLuong]" value="' . htmlspecialchars($item['SoLuong']) . '">';
                                            }
                                        ?>
                                        <button type="submit" id="buyButton" class="btn btn-success btn-custom-size">Mua Hàng</button>
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
    <script src="Bootstrap/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
    <script src="https://kit.fontawesome.com/d3f4e54f8d.js" crossorigin="anonymous"></script>
</body>
</html>

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

        total = total.toLocaleString('vi-VN', {minimumFractionDigits: 0});

        if (countChecked > 0) {
            document.querySelector('#totalPrice').innerText = total + ' VNĐ';
        } else {
            document.querySelector('#totalPrice').innerText = '0 VNĐ';
        }
    }

    function setEmailFromLocalStorage() {
        if(localStorage.getItem('email')) {
            
            var email = localStorage.getItem('email');
            
            document.getElementById('email').value = email;
        }
    }

    document.addEventListener('DOMContentLoaded', function() {
        const buyButton = document.getElementById('buyButton');
        
        if (buyButton) {
            buyButton.addEventListener('click', function(event) {
                const email = localStorage.getItem('email');
                if (!email) {
                    event.preventDefault(); // Ngăn chặn hành động mặc định của nút
                    const userConfirmed = confirm('Bạn chưa đăng nhập. Bạn có muốn đăng nhập không?');
                    if (userConfirmed) {
                        window.location.href = 'DangNhap.php'; // Chuyển hướng đến trang đăng nhập
                    }
                }
            });
        }
    });
</script>