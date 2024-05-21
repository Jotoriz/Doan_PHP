<?php
// register_handler.php

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $hoTen = $_POST["hoTen"];
    $diaChi = $_POST["diaChi"];
    $sdt = $_POST["soDienThoai"];
    $email = $_POST["email"];
    $password = $_POST["matKhau"];
    $confirmPassword = $_POST["nhapLaiMatKhau"];

    // Connect to the database
    $pdo = new PDO("mysql:host=localhost; port=3307; dbname=ql_vanphongpham", "root", "");
    $pdo->exec("set names utf8");

    // Check if the email already exists
    $emailQuery = $pdo->prepare("SELECT * FROM khachhang WHERE Email_KH = :email");
    $emailQuery->bindParam(":email", $email);
    $emailQuery->execute();
    $existingUser = $emailQuery->fetch(PDO::FETCH_ASSOC);

    if ($existingUser) {
        header("Location: DangKy.php?error=3");
        exit();
    } elseif ($password !== $confirmPassword) {
        header("Location: DangKy.php?error=2");
        exit();
    } elseif ($hoTen == "" || $diaChi == "" || $sdt == "" || $email == "" || $password == "" || $confirmPassword == "") {
        header("Location: DangKy.php?error=1");
        exit();
    } else {
        // Insert the new user into the database
        $insertQuery = $pdo->prepare("INSERT INTO khachhang (HoTen_KH, DiaChi_KH, SDT_KH, Email_KH, Password_KH) VALUES (:hoTen, :diaChi, :sdt, :email, :password)");
        $insertQuery->bindParam(":hoTen", $hoTen);
        $insertQuery->bindParam(":diaChi", $diaChi);
        $insertQuery->bindParam(":sdt", $sdt);
        $insertQuery->bindParam(":email", $email);
        $insertQuery->bindParam(":password", $password);
        $insertQuery->execute();

        header("Location: DangNhap.php");
        exit();
    }
}
?>