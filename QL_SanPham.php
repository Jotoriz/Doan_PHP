<?php
    session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="Bootstrap/bootstrap.min.css">
    <link rel="stylesheet" href="stylec.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <title>Quản lý Sản phẩm</title>
</head>
<style>
table {
    width: 100%;
    border-collapse: collapse;
}

table th, table td {
    padding: 8px;
    border: 1px solid #ddd;
    text-align: center;
}

table th {
    background-color: #f2f2f2;
}

table tbody tr:nth-child(even) {
    background-color: #f2f2f2;
}

table tbody tr:hover {
    background-color: #ddd;
}

button {
    padding: 6px 10px;
    border: none;
    background-color: #007bff;
    color: white;
    cursor: pointer;
    border-radius: 4px;
    font-size: 14px;
}

button:hover {
    background-color: #0056b3;
}
.btn-edit,.btn-add,
.btn-delete {
    background-color: #4CAF50; /* Màu xanh */
    color: white; /* Màu chữ trắng */
    padding: 8px 12px; /* Khoảng cách giữa nút và văn bản */
    border: none; /* Xóa viền */
    border-radius: 4px; /* Bo tròn các góc */
    cursor: pointer; /* Biến con trỏ thành dấu nhấp chuột */
    margin-right: 5px; /* Khoảng cách giữa các nút */
}

.btn-delete {
    background-color: #f44336; /* Màu đỏ cho nút xóa */
}
.btn-add {
    background-color: #007bff;
}
/* Khi nút được hover */
.btn-edit:hover,
.btn-delete:hover,
.btn-add:hover {
    opacity: 0.8; /* Giảm độ trong khi hover */
}


/* Thiết lập độ rộng cho từng cột */
table td:nth-child(1), table th:nth-child(1) { width: 7%; }
table td:nth-child(2), table th:nth-child(2) { width: 5%; }
table td:nth-child(3), table th:nth-child(3) { width: 5%; }
table td:nth-child(4), table th:nth-child(4) { width: 25%; }
table td:nth-child(5), table th:nth-child(5) { width: 5%; }
table td:nth-child(6), table th:nth-child(6) { width: 5%; }
table td:nth-child(7), table th:nth-child(7) { width: 6%; }
table td:nth-child(8), table th:nth-child(8) { width: 30%; }

</style>
<?php
    $pdo = new PDO("mysql:host=localhost;dbname=ql_vanphongpham", "root", "");
    $pdo->query("set names utf8");

    $sqlSanPham = "select * from sanpham";
    $sanpham = $pdo->query($sqlSanPham);

    if(isset($_GET['id']) && !empty($_GET['id'])) {
        $id = $_GET['id'];

        $sqlDelete = "DELETE FROM sanpham WHERE MaSP = $id";
        $pdo->query($sqlDelete);
    }
?>
<body>
<?php
    include "Header.php";

    include "SubHeader.php";
    ?>
    <div class="product mt-5">
        <h2 align="center" style="color:#900;">DANH SÁCH SẢN PHẨM</h2>
        <!-- Hiển thị danh sách sản phẩm -->
        <table>
            <thead>
                <tr>
                    <th>Mã sản phẩm</th>
                    <th>Mã loại</th>
                    <th>Mã NCC</th>
                    <th>Tên sản phẩm</th>
                    <th>Giá</th>
                    <th>DVT</th>
                    <th>Số lượng tồn kho</th>
                    <th>Mô tả</th>
                    <th>Thao tác</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($sanpham as $product): ?>
                    <tr>
                        <td><?php echo $product['MaSP']; ?></td>
                        <td><?php echo $product['MaLoai']; ?></td>
                        <td><?php echo $product['MaNCC']; ?></td>
                        <td><?php echo $product['TenSP']; ?></td>
                        <td><?php echo $product['Gia']; ?></td>
                        <td><?php echo $product['DVT']; ?></td>
                        <td><?php echo $product['SoLuongTonKho']; ?></td>
                        <td><?php echo $product['MoTaSP']; ?></td>
                        <td>
                            <form action="SuaSanPham.php" method="get" style="display: inline;">
                                <input type="hidden" name="id" value="<?php echo $product['MaSP'];?>">
                                <button type="submit" class="btn-edit">Sửa</button>
                            </form>

                            <form action="XoaSanPham.php" method="post" style="display: inline;">
                                <input type="hidden" name="id" value="<?php echo $product['MaSP'];?>">
                                <button type="submit" class="btn-delete" onclick="return confirm('Bạn chắc chắn muốn xóa sản phẩm này?')">Xóa</button>
                            </form>
                        </td>


                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
        <form action="ThemSanPham.php" method="get">
            <button type="submit" class="btn-add">Thêm sản phẩm</button>
        </form>
    </div>
    <?php
    include "Footer.php";
    ?>
</body>
</html>
<script>
    function confirmDelete(id) {
        if (confirm('Bạn có chắc chắn muốn xóa sản phẩm này không?')) {
            $.post('XoaSanPham.php', { id: id }, function(data) {
                // Sau khi xóa thành công, reload lại trang
                window.location.reload();
            });
        }
    }
</script>
