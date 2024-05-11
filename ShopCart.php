<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tất cả</title>
    <link rel="stylesheet" href="Bootstrap/bootstrap.min.css">
    <link rel="stylesheet" href="stylec.css">
</head>
<?php
    $pdo = new PDO("mysql:host=localhost;dbname=ql_nha_hang", "root", "");
    $pdo->query("set names utf8");

    $sqlLoaiMon = "select * from loai_mon_an";
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
    if (isset($_GET['updateId']) && ($_GET['updateId'] >= 0)) {
        $index = $_GET['updateId'];
        if (isset($_SESSION['cart'][$index])) {
            $new_quantity = $_GET['sl'];
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

        // Kiểm tra nếu giỏ hàng không tồn tại, tạo mới
        if (!isset($_SESSION['cart'])) {
            $_SESSION['cart'] = array();
        }

        // Kiểm tra xem sản phẩm đã có trong giỏ hàng chưa, nếu có thì tăng số lượng
        $found = false;
        foreach ($_SESSION['cart'] as $key => $item) {
            if ($item['MaSP'] == $maSP) {
                $_SESSION['cart'][$key]['SoLuong'] += $sl;
                $found = true;
                break;
            }
        }
        if (!$found) {
            $product = array(
                'MaSP' => $maSP,
                'TenSP' => $tenSP,
                'Gia' => $gia,
                'SoLuong' => $sl
            );
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
                            style="max-width: 200px; display: block; margin: 0 auto;"> <!-- Thu nhỏ hình ảnh và căn giữa -->
                    </div>
                    <p style="font-size: 20px;">Đơn hàng của bạn đang trống. Hãy chọn mua sản phẩm nhé!</p>
                </td>
            </table>
        <?php } ?>

        <?php if (isset($_SESSION['cart']) && count($_SESSION['cart']) > 0) { ?>
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
                                    <input type="checkbox" name="deleteItem[]" value="<?php echo $i;?>" class="item-checkbox" onchange="updateTotal()"> <!-- Thêm onchange -->
                                    <img src="<?php echo $imgUrl; ?>" class="rounded img-thumbnail mr-2" style="width:60px;"><?php echo $item['TenSP'];?>
                                    
                                </td>
                                <td id="price_<?php echo $i; ?>"> <!-- Thêm id cho mỗi giá -->
                                    <?php echo number_format($item['Gia'], 0, ',', '.'); ?> VNĐ
                                </td>
                                <td>
                                    <form action="ShopCart.php" method="get">
                                        <input type="hidden" name="updateId" value="<?php echo $i;?>">
                                        <input type="number" name="sl" class="cart-qty-single" data-item="<?php echo $key;?>" value="<?php echo $item['SoLuong'];?>" min="1" max="1000">
                                        <button type="submit" class="text-primary">Cập nhật</button>
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
                <form action="ShopCart.php" method="post">
                    <input type="hidden" name="delId" value="<?php echo $i; ?>">
                    <button type="submit" name="deleteItem" class="btn btn-danger btn-custom-size">Thanh toán</button>
                </form>
            </td>
        </tr>


                </tbody>
            </table>
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
            var totalItem = parseFloat(document.querySelector('#total_' + rowIndex).innerText.replace('$', ''));
            total += totalItem;
            countChecked++;
        }
    });

    total = total.toFixed(3).replace(/\d(?=(\d{3})+\.)/g, '$&,');

    if (total.endsWith('.00')) {
        total = total.slice(0, -3); 
    }

    if (countChecked > 0) {
        document.querySelector('#totalPrice').innerText = total + '.000 VNĐ';
    } else {
        document.querySelector('#totalPrice').innerText = '0 VNĐ';
    }
}
</script>


