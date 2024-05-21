<?php
    // Tạo một kết nối PDO duy nhất
    $pdo = new PDO("mysql:host=localhost; port= 3307; dbname=ql_vanphongpham", "root", "");
    $pdo->exec("set names utf8");

//Truy vấn bảng Khách Hàng
function SelectKH($pdo, $selectKH)
{
    // Thực thi truy vấn
    $result = $pdo->query($selectKH);

    // Kiểm tra kết quả truy vấn
    if ($result) {
        // Nếu có dữ liệu
        if ($result->rowCount() > 0) {
            return $result; // Trả về kết quả truy vấn
        } else {
            echo "<h2>Không có dữ liệu khách hàng</h2>";
            return false;
        }
    } else {
        echo "Lỗi khi truy vấn cơ sở dữ liệu.";
        return false;
    }
}

// Thực thi hàm để kiểm tra kết quả truy vấn
$selectKH = "SELECT HoTen_KH, DiaChi_KH, SDT_KH, Email_KH FROM KhachHang";

if (!SelectKH($pdo, $selectKH)) {
    // Đóng kết nối PDO nếu có lỗi xảy ra
    $pdo = NULL;
} else {
    // Lấy dữ liệu khách hàng nếu truy vấn thành công
    $KhachHang = SelectKH($pdo, $selectKH);
}

// Hàm xóa khách hàng
// function XoaKH($pdo)
// {
//     if(isset($_POST["btn_Delete"])){
//         // Lấy họ tên khách hàng từ form
//         $HoTen_KH = $_POST["hoten_KH"];

//         // Truy vấn xóa khách hàng dựa trên họ tên
//         $sql = "DELETE FROM KhachHang WHERE HoTen_KH = :HoTen_KH";
//         $sta = $pdo->prepare($sql);

//         // Truyền tham số vào câu truy vấn
//         $kq = $sta->execute(array(':HoTen_KH' => $HoTen_KH)); 

//         if($kq){
//             header("Location: QLKhachHang.php");
//             echo "Xóa thành công !";
//         } else{
//             echo "Xóa thất bại !";
//         }
//     }    
// }

// Hàm tìm kiếm khách hàng
function TimKiemKH($pdo, $keyword)
{
    $searchQuery = "%$keyword%";

    // Truy vấn tìm kiếm khách hàng theo họ tên và email
    $sql = "SELECT * FROM KhachHang WHERE HoTen_KH LIKE :keyword OR Email_KH LIKE :keyword";

    // Chuẩn bị và thực thi truy vấn
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(':keyword', $searchQuery, PDO::PARAM_STR);
    $stmt->execute();

    // Kiểm tra kết quả
    if ($stmt->rowCount() > 0) {
        return $stmt->fetchAll(PDO::FETCH_ASSOC); // Trả về kết quả nếu có
    } else {
        return false; // Trả về false nếu không tìm thấy kết quả
    }
}

// Lấy từ khóa tìm kiếm từ biến GET (hoặc POST)
$keyword = isset($_GET['keyword']) ? $_GET['keyword'] : '';

// Gọi hàm tìm kiếm khách hàng với từ khóa vừa lấy được
$KhachHang = TimKiemKH($pdo, $keyword);


// Xử lý hàm
// if($_SERVER["REQUEST_METHOD"] == "POST"){
//     if(isset($_POST["btn_Delete"])){
//         XoaKH($pdo);
//     }
// }
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="Bootstrap/bootstrap.min.css">
    <link rel="stylesheet" href="styles.css">
    <link rel="stylesheet" href="ChiTietSP.css">

</head>

<body>
    <?php include "Header.php"; ?>
    <?php include "SubHeaderNhanVIen.php"; ?>
    <div class="container KhachHang">
        <h1 class="text-center">DANH SÁCH KHÁCH HÀNG</h1>

        <div class="row mb-6">
            <div class="col-md-6 offset-md-6">
                <form method="GET" action="" class="d-flex justify-content-end">
                    <input type="text" class="form-control mr-2" id="searchInput" name="keyword"
                        placeholder="Tìm kiếm..." value="<?php echo htmlspecialchars($keyword); ?>">
                    <button type="submit" class="btn btn-primary">Tìm kiếm</button>
                </form>
            </div>
        </div>


        <div class='row'>
            <table class="table table-bordered" align="center">
                <thead class="thead-dark">
                    <tr>
                        <th scope="col">Họ và tên</th>
                        <th scope="col">Địa chỉ</th>
                        <th scope="col">Số điện thoại</th>
                        <th scope="col">Email</th>
                        <!-- <th scope="col">Thao tác</th> -->
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($KhachHang as $KH): ?>
                        <tr>
                            <td><?php echo $KH['HoTen_KH']; ?></td>
                            <td><?php echo $KH['DiaChi_KH']; ?></td>
                            <td><?php echo $KH['SDT_KH']; ?></td>
                            <td><?php echo $KH['Email_KH']; ?></td>
                            <!-- <td>
                            <form method="POST" action="QLSuaKH.php">
                                <input type="hidden" name="hoten_KH" value="<?php echo $KH['HoTen_KH']; ?>">
                                <button type="submit" class="btn btn-primary" name="btn_Edit">Sửa</button>
                            </form>

                            <form method="POST">
                                <input type="hidden" name="hoten_KH" value="<?php echo $KH['HoTen_KH']; ?>">
                                <button type="submit" class="btn btn-danger" name="btn_Delete">Xóa</button>
                            </form>              
                        </td> -->
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
    <?php include "Footer.php"; ?>
    <!-- JavaScript code giữ nguyên -->
    <script>
        document.addEventListener("DOMContentLoaded", function () {
            var decrementBtn = document.querySelector(".decrement");
            var incrementBtn = document.querySelector(".increment");
            var quantityInput = document.querySelector("#quantity");

            decrementBtn.addEventListener("click", function () {
                var currentValue = parseInt(quantityInput.value);
                if (currentValue > 1) {
                    quantityInput.value = currentValue - 1;
                }
            });

            incrementBtn.addEventListener("click", function () {
                var currentValue = parseInt(quantityInput.value);
                quantityInput.value = currentValue + 1;
            });
        });

        document.addEventListener("DOMContentLoaded", function () {
            var thumbnailImages = document.querySelectorAll(".Imgcon");
            var mainImage = document.querySelector(".mainImg");

            thumbnailImages.forEach(function (thumbnail) {
                thumbnail.addEventListener("click", function () {
                    var newImageSrc = thumbnail.getAttribute("src");
                    mainImage.setAttribute("src", newImageSrc);
                });
            });
        });
    </script>
</body>

</html>
<script src="https://kit.fontawesome.com/d3f4e54f8d.js" crossorigin="anonymous"></script>
<script src="Bootstrap/bootstrap.bundle.min.js" crossorigin="anonymous"></script>