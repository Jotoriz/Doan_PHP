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

textarea {
    width: 100%;
    height: 100px;
    margin-bottom: 20px;
    padding: 10px;
    border: 1px solid #ccc;
    border-radius: 5px;
    resize: none;
}

button {
    background-color: #007bff;
    color: #fff;
    padding: 10px 20px;
    border: none;
    border-radius: 5px;
    cursor: pointer;
    transition: background-color 0.3s;
}

button:hover {
    background-color: #0056b3;
}
textarea {
    width: 100%;
    height: 300px; 
    margin-bottom: 20px;
    padding: 10px;
    border: 1px solid #ccc;
    border-radius: 5px;
    resize: none;
}
</style>
<body>
<?php
    include "Header.php";

    include "SubHeader.php";
    ?>
    <div class="container">
        <h1>Đánh giá sản phẩm</h1>
        <form action="submit_review.php" method="POST">
            <div class="rating">
            <input type="radio" name="rating" id="star1" value="1">
            <label for="star1">&#9733;</label>
            <input type="radio" name="rating" id="star2" value="2">
            <label for="star2">&#9733;</label>
            <input type="radio" name="rating" id="star3" value="3">
            <label for="star3">&#9733;</label>
            <input type="radio" name="rating" id="star4" value="4">
            <label for="star4">&#9733;</label>
            <input type="radio" name="rating" id="star5" value="5">
            <label for="star5">&#9733;</label>

            </div>
            <textarea name="review" id="review" placeholder="Nhận xét của bạn"></textarea>
            <button type="submit">Gửi đánh giá</button>
        </form>
    </div>
    <?php
    include "Footer.php";
    ?>
    <script src="https://kit.fontawesome.com/d3f4e54f8d.js" crossorigin="anonymous"></script>
    
</body>
</html>
