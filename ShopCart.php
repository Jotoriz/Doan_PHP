<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tất cả</title>
    <link rel="stylesheet" href="Bootstrap/bootstrap.min.css">
    <link rel="stylesheet" href="stylec.css">
</head>

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
                                    onchange="updateTotal()"> <!-- Thêm onchange -->
                                <img src="<?php echo $imgUrl; ?>" class="rounded img-thumbnail mr-2"
                                    style="width:60px;"><?php echo $item['tenMon']; ?>

                            </td>
                            <td id="price_<?php echo $i; ?>"> <!-- Thêm id cho mỗi giá -->
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