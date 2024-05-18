<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Đánh giá sản phẩm</title>
    <link rel="stylesheet" href="stylec.css">
</head>
<style>
h1 {
    text-align: center;
    margin-bottom: 20px;
}

.rating {
    display: flex;
    justify-content: center;
    flex-direction: row-reverse;
    margin-bottom: 20px;
}

.rating input {
    display: none;
}

.rating label {
    font-size: 30px;
    color: #ccc;
    cursor: pointer;
}

.rating input:checked ~ label {
    color: #ffcc00;
}

.rating label:hover,
.rating label:hover ~ label,
.rating input:checked ~ label:hover,
.rating input:checked ~ label:hover ~ label,
.rating input:checked ~ label:hover ~ input ~ label {
    color: #ffcc00;
}

.container {
    width: 80%;
    margin: 0 auto;
    max-width: 800px;
    text-align: center;
}

textarea {
    width: 100%;
    height: 150px;
    padding: 15px;
    font-size: 16px;
    border: 1px solid #ccc;
    border-radius: 8px;
    margin-bottom: 20px;
    resize: vertical;
    box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
    transition: border-color 0.3s, box-shadow 0.3s;
}

textarea:focus {
    border-color: #007BFF;
    box-shadow: 0 0 8px rgba(0, 123, 255, 0.25);
    outline: none;
}

button {
    padding: 10px 20px;
    font-size: 16px;
    color: #fff;
    background-color: #007BFF;
    border: none;
    border-radius: 8px;
    cursor: pointer;
    transition: background-color 0.3s;
}

button:hover {
    background-color: #0056b3;
}

</style>

<?php
    $pdo = new PDO("mysql:host=localhost;dbname=ql_vanphongpham", "root", "");
    $pdo->query("set names utf8");
    
    $successMessage = '';
    
    // Kiểm tra xem có tham số MaSP được truyền trong URL hay không
    if(isset($_GET['MaSP']) && !empty($_GET['MaSP'])) {
        $maSP = $_GET['MaSP'];
        
        // Truy vấn để lấy thông tin sản phẩm từ MaSP
        $sql = "SELECT * FROM sanpham WHERE MaSP = :maSP";
        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(':maSP', $maSP);
        $stmt->execute();
        $product = $stmt->fetch(PDO::FETCH_ASSOC);
    }
    
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $maSP = $_GET['MaSP'];
        $sao = $_POST['rating'];
        $loidanhgia = $_POST['review'];
    
        try {
            $sql = "INSERT INTO danhgia (maSP, sao, loidanhgia) VALUES (:maSP, :sao, :loidanhgia)";
            $stmt = $pdo->prepare($sql);
    
            $stmt->bindParam(':maSP', $maSP);
            $stmt->bindParam(':sao', $sao);
            $stmt->bindParam(':loidanhgia', $loidanhgia);
    
            if ($stmt->execute()) {
                $successMessage = "Đánh giá của bạn đã được gửi thành công.";
            } else {
                $successMessage = "Có lỗi xảy ra. Vui lòng thử lại.";
            }
        } catch (PDOException $e) {
            $successMessage = "Lỗi: " . $e->getMessage();
        }
    }
    
?>

<body>
<?php
    include "Header.php";
    include "SubHeader.php";
?>
<div class="container">
    <h1>Đánh giá sản phẩm</h1>
    <?php if ($successMessage): ?>
        <div class="alert alert-success">
            <?php echo $successMessage; ?>
        </div>
    <?php endif; ?>
    <form method="POST">
        <div class="rating">
            <input type="radio" name="rating" id="star5" value="5">
            <label for="star5">&#9733;</label>
            <input type="radio" name="rating" id="star4" value="4">
            <label for="star4">&#9733;</label>
            <input type="radio" name="rating" id="star3" value="3">
            <label for="star3">&#9733;</label>
            <input type="radio" name="rating" id="star2" value="2">
            <label for="star2">&#9733;</label>
            <input type="radio" name="rating" id="star1" value="1">
            <label for="star1">&#9733;</label>
        </div>
        <textarea name="review" id="review" placeholder="Nhận xét của bạn"></textarea>
        <input type="hidden" name="product_id" value="<?php echo htmlspecialchars($id); ?>">
        <button type="submit">Gửi đánh giá</button>
    </form>
</div>
<?php
    include "Footer.php";
?>
<script src="https://kit.fontawesome.com/d3f4e54f8d.js" crossorigin="anonymous"></script>
</body>
</html>
