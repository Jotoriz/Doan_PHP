<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tất cả</title>
    <link rel="stylesheet" href="Bootstrap/bootstrap.min.css">
    <link rel="stylesheet" href="styles.css">
</head>
<style>
    .card {
        height: 450px;
    }
</style>

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

                if (isset($_GET['search'])) {
                    $search = $_GET['search'];
                    $sql = "SELECT MaSP, TenSP, Gia
                        FROM sanpham
                        WHERE TenSP LIKE :search
                        LIMIT :startIndex, :productsPerPage";
                    $stmt = $pdo->prepare($sql);
                    $stmt->bindValue(':search', '%' . $search . '%', PDO::PARAM_STR);

                    $countSql = "SELECT COUNT(*) as total
                        FROM sanpham
                        WHERE TenSP LIKE :search";
                    $countStmt = $pdo->prepare($countSql);
                    $countStmt->bindValue(':search', '%' . $search . '%', PDO::PARAM_STR);
                } else if (isset($_GET['loaiSP'])) {
                    $loaiSP = $_GET['loaiSP'];
                    $sql = "SELECT MaSP, TenSP, Gia
                        FROM sanpham
                        WHERE MaLoai = :loaiSP
                        LIMIT :startIndex, :productsPerPage";
                    $stmt = $pdo->prepare($sql);
                    $stmt->bindValue(':loaiSP', $loaiSP, PDO::PARAM_INT);

                    $countSql = "SELECT COUNT(*) as total
                             FROM sanpham
                             WHERE MaLoai = :loaiSP";
                    $countStmt = $pdo->prepare($countSql);
                    $countStmt->bindValue(':loaiSP', $loaiSP, PDO::PARAM_INT);
                } else {
                    $sql = "SELECT MaSP, TenSP, Gia
                        FROM sanpham
                        LIMIT :startIndex, :productsPerPage";
                    $stmt = $pdo->prepare($sql);

                    $countSql = "SELECT COUNT(*) as total
                             FROM sanpham";
                    $countStmt = $pdo->prepare($countSql);
                }

                $stmt->bindValue(':startIndex', $startIndex, PDO::PARAM_INT);
                $stmt->bindValue(':productsPerPage', $productsPerPage, PDO::PARAM_INT);
                $stmt->execute();
                $products = $stmt->fetchAll(PDO::FETCH_ASSOC);

                $countStmt->execute();
                $totalProducts = $countStmt->fetch(PDO::FETCH_ASSOC)['total'];
                $totalPages = ceil($totalProducts / $productsPerPage);

                foreach ($products as $product) {
                    $productId = $product['MaSP'];
                    $productName = $product['TenSP'];
                    $productPrice = $product['Gia'];

                    echo '<div class="col-3">';
                    echo '<a href="ChiTietSP.php?id=' . $productId . '">';
                    echo '<div class="card">';
                    echo '<img class="card-img-top" src="./image/SanPham/' . $productId . '.jpg" alt="' . $productName . '">';
                    echo '<div class="card-body">';
                    echo '<h5 class="card-title">' . $productName . '</h5>';
                    echo '<p class="card-text">' . number_format($productPrice, 0, ',', '.') . ' ₫</p>';
                    echo '</div>';
                    echo '</div>';
                    echo '</a>';
                    echo '</div>';
                }
                ?>
            </div>

            <?php if (!isset($_GET['loaiSP']) && !isset($_GET['search'])) { ?>
                <?php if (!isset($_GET['loaiSP']) || !isset($_GET['search'])) { ?>
                    <div class="row">
                        <div class="pagination col">
                            <?php
                            $sql = "SELECT COUNT(*) AS totalCount FROM sanpham";
                            $stmt = $pdo->query($sql);
                            $result = $stmt->fetch(PDO::FETCH_ASSOC);
                            $totalCount = $result['totalCount'];
                            $totalPages = ceil($totalCount / $productsPerPage);
                            ?>
                            <nav aria-label="Page navigation example">
                                <ul class="pagination justify-content-center" id="pagination">
                                    <?php for ($page = 1; $page <= $totalPages; $page++) { ?>
                                        <li class="page-item <?php echo ($page == $currentPage) ? 'active' : ''; ?>">
                                            <a class="page-link" href="?page=<?php echo $page; ?>"><?php echo $page; ?></a>
                                        </li>
                                    <?php } ?>
                                </ul>
                            </nav>
                        </div>
                    </div>
                <?php } ?>
            <?php } ?>
        </div>

    </div>
    <?php
    include "Footer.php";
    ?>
    <script src="https://kit.fontawesome.com/d3f4e54f8d.js" crossorigin="anonymous"></script>
    <script src="Bootstrap/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
</body>

</html>