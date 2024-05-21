<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Menu with Cart Icon</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">

    <style>
        .subHeader {
            background-color: #FFB0BD;

        }

        .col-1_5 {
            flex: 0 0 10%;
            max-width: 14%;
        }

        .item {
            text-align: center;
            margin-left: 20px;
        }

        .hinhsubHeader {

            width: 70px;
            height: 70px;
            display: block;
            margin: 10px;
        }

        .item p {
            margin-top: 2px;
        }

        a {
            text-decoration: none;
            color: inherit;
            display: inline-block;
            cursor: pointer;
        }

        a:hover {
            text-decoration: none;
            color: inherit;
        }


        .item:hover .hinhsubHeader {
            transform: scale(1.1);
            transition: transform 0.3s ease-in-out;
        }
    </style>
</head>

<body>

    <?php
    $pdo = new PDO("mysql:host=localhost;dbname=ql_vanphongpham", "root", "");
    $pdo->query("set names utf8");
    $sql = "SELECT * FROM loaisp";
    $loaiSPs = $pdo->query($sql);
    ?>
    <div class="subHeader">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-1 item">
                    <a href="index.php">
                        <img class="hinhsubHeader" src="image/LoaiSP/All.png" />
                        <p>Tất Cả</p>
                    </a>
                </div>
                <?php foreach ($loaiSPs as $loaiSP): ?>
                    <div class="col-1 item">
                        <a href="index.php?loaiSP=<?php echo $loaiSP['MaLoai']; ?>">
                            <img class="hinhsubHeader" src="image/LoaiSP/<?php echo $loaiSP['hinh']; ?>" />
                            <p><?php echo $loaiSP['TenLoai']; ?></p>
                        </a>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
    </div>
    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>
</body>

</html>