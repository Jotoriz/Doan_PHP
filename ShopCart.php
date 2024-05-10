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
    if(isset($_GET['emptyCart']) && ($_GET['emptyCart'] == 1))
    {
        unset($_SESSION['cart']);
    }
    //Xóa item trong giỏ
    if(isset($_GET['delId']) && ($_GET['delId'] >= 0))
    {
        array_splice($_SESSION['cart'], $_GET['delId'], 1);
    }
    //Update item trong giỏ
    if(isset ($_GET['updateId'])&&($_GET['updateId']>=0))
    {
        $index= $_GET['updateId'];
        if(isset($_SESSION['cart'][$index]))
        {
            $new_quantily=$_GET['num_sl'];
            $_SESSION['cart'][$index]['sl']=$new_quantily;
        }
    }
    //Lấy dữ liệu từ form Xem Chi tiết
    if(isset($_POST['add_to_cart'])&&($_POST['add_to_cart']))
    {
        $maMon=$_POST['maMon'];
        $tenMon=$_POST['tenMon'];
        $hinh=$_POST['hinh'];
        $donGia=$_POST['donGia'];
        $sl=$_POST['sl'];

        $flag=0;
        $count = count($_SESSION['cart']);
        for($i=0;$i<$count;$i++)
        {
            $item=$_SESSION['cart'][$i];
            if($item["maMon"]==$maMon)
            {
                $flag=1;
                $sl_new=$sl+$item["sl"];
                $item["sl"]=$sl_new;
                $_SESSION['cart'][$i]=$item;
                break;
            }
        }
        if($flag == 0)
        {
            $sp=array(
                'maMon'=>$maMon,
                'tenMon'=>$tenMon,
                'hinh'=>$hinh,
                'donGia'=>$donGia,
                'sl'=>$sl
            );
            $_SESSION['cart'][]=$sp;
        }
    }
    if (isset($_POST['add_to_cart'])) {
        if (isset($_SESSION['maKH'])) {
            $maMon = $_POST['maMon'];
            $tenMon = $_POST['tenMon'];
            $hinh = $_POST['hinh'];
            $donGia = $_POST['donGia'];
            $sl = $_POST['sl'];
    
            $maKH = $_SESSION['maKH'];
    
            $sql = "INSERT INTO gio_hang (maMon, tenMon, hinh, donGia, sl, maKH) VALUES ('$maMon', '$tenMon', '$hinh', '$donGia', '$sl', '$maKH')";
    
            $pdo->query($sql);
        } else {
            header("Location: login.php");
            exit;
        }
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
                        <th>Tên sản phẩm</th>
                        <th>Giá bán</th>
                        <th>Số lượng</th>
                        <th>Tổng tiền</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $totalCounter = 0;
                    $itemCounter = 0;
                    foreach ($_SESSION['cart'] as $i => $item) {
                        $imgUrl = "image/" . $item["hinh"];
                        $total = (float) $item["donGia"] * (int) $item["sl"];
                        $totalCounter += $total;
                        $itemCounter += $item["sl"];
                        ?>
                        <tr>
                            <td>
                                <input type="checkbox" name="deleteItem[]" value="<?php echo $i; ?>" class="item-checkbox"
                                    onchange="updateTotal()">
                                <img src="<?php echo $imgUrl; ?>" class="rounded img-thumbnail mr-2"
                                    style="width:60px;"><?php echo $item['tenMon']; ?>

                            </td>
                            <td id="price_<?php echo $i; ?>">
                                <?php echo $item['donGia']; ?> VNĐ
                            </td>
                            <td>
                                <form action="ShopCart.php" method="get">
                                    <input type="hidden" name="updateId" value="<?php echo $i; ?>">
                                    <input type="number" name="num_sl" class="cart-qty-single" data-item="<?php echo $key; ?>"
                                        value="<?php echo $item['sl']; ?>" min="1" max="1000">
                                    <button type="submit" class="text-primary">Cập nhật</button>
                                </form>
                            </td>
                            <td id="total_<?php echo $i; ?>">
                                <?php echo $total; ?> VNĐ
                            </td>
                            <td>
                                <form action="ShopCart.php" method="get">
                                    <input type="hidden" name="delId" value="<?php echo $i; ?>">
                                    <button type="submit" name="deleteItem" class="btn btn-danger btn-custom-size">Xóa</button>
                                </form>

                            </td>
                        </tr>
                    <?php } ?>
                    <tr class="border-top border-bottom">
                        <td><a class="btn btn-danger btn-custom-size" href="ShopCart.php?emptyCart=1">Xóa tất cả</a></td>
                        <td></td>
                        <td></td>
                        <td><strong id="totalPrice">0</strong></td>
                        <td>
                            <form action="ShopCart.php" method="get">
                                <input type="hidden" name="delId" value="<?php echo $i; ?>">
                                <button type="submit" name="deleteItem" class="btn btn-danger btn-custom-size">Thanh
                                    toán</button>
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

    total = total.toFixed(2);

    if (total.endsWith('.00')) {
        total = total.slice(0, -3); 
    }

    if (countChecked > 0) {
        document.querySelector('#totalPrice').innerText = total + ' VNĐ';
    } else {
        document.querySelector('#totalPrice').innerText = '0 VNĐ';
    }
}
</script>
