<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tất cả</title>
    <link rel="stylesheet" href="Bootstrap/bootstrap.min.css">
    <link rel="stylesheet" href="./stylea.css">
</head>

<body>
    <?php
        include "Header.php";

        include "SubHeader.php";
    ?>    
    <div class="product">
        <div class="container">
            <div class="row" id="product-grid" style="padding: 40px 70px">
                <?php

                $pdo = new PDO("mysql:host=localhost;dbname=ql_vanphongpham", "root", "");
                $pdo->query("set names utf8");

                $productsPerPage = 8;
                $currentPage = isset($_GET['page']) ? max(1, intval($_GET['page'])) : 1;
                $startIndex = ($currentPage - 1) * $productsPerPage;

                $sql = "SELECT MaSP, TenSP, Gia
                        FROM sanpham
                        LIMIT :startIndex, :productsPerPage";
                $stmt = $pdo->prepare($sql);
                $stmt->bindValue(':startIndex', $startIndex, PDO::PARAM_INT);
                $stmt->bindValue(':productsPerPage', $productsPerPage, PDO::PARAM_INT);
                $stmt->execute();
                $products = $stmt->fetchAll(PDO::FETCH_ASSOC);


                foreach ($products as $product) {
                    $productId = $product['MaSP'];
                    $productName = $product['TenSP'];
                    $productPrice = $product['Gia'];

                    echo '<div class="col-3">';
                    echo '<div class="card">';
                    echo '<img class="card-img-top" src="./image/SanPham/' . $productId . '.jpg" alt="' . $productName . '">';
                    echo '<div class="card-body">';
                    echo '<h5 class="card-title">' . $productName . '</h5>';
                    echo '<p class="card-text">' . $productPrice . '</p>';
                    echo '</div>';
                    echo '</div>';
                    echo '</div>';
                }
                ?>
            </div>
            <div class="pagination">
                <?php
                $sql = "SELECT COUNT(*) AS totalCount FROM sanpham";
                $stmt = $pdo->query($sql);
                $result = $stmt->fetch(PDO::FETCH_ASSOC);
                $totalCount = $result['totalCount'];
                $totalPages = ceil($totalCount / $productsPerPage);
                ?>
                <nav aria-label="Page navigation example" class="mt-3">
                    <ul class="pagination justify-content-center" id="pagination">
                        <?php for ($page = 1; $page <= $totalPages; $page++) { ?>
                            <li class="page-item <?php echo ($page == $currentPage) ? 'active' : ''; ?>">
                                <a class="page-link" href="ShopCart.php?page=<?php echo $page; ?>"><?php echo $page; ?></a>
                            </li>
                        <?php } ?>
                    </ul>
                </nav>
            </div>
        </div>
        <?php
            include "Footer.php";
        ?>    
    </div>

    <script src="https://kit.fontawesome.com/d3f4e54f8d.js" crossorigin="anonymous"></script>
</body>

</html>