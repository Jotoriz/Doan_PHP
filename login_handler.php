<?php
// login_handler.php

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST["email"];
    $password = $_POST["password"];


    $pdo = new PDO("mysql:host=localhost;dbname=ql_vanphongpham", "root", "");
    $pdo->exec("set names utf8");

    $customerQuery = $pdo->prepare("SELECT * FROM khachhang WHERE Email_KH = :email AND Password_KH = :password");
    $customerQuery->bindParam(":email", $email);
    $customerQuery->bindParam(":password", $password);
    $customerQuery->execute();
    $customer = $customerQuery->fetch(PDO::FETCH_ASSOC);


    $employeeQuery = $pdo->prepare("SELECT * FROM nhanvien WHERE Email_NV = :email AND MatKhau = :password");
    $employeeQuery->bindParam(":email", $email);
    $employeeQuery->bindParam(":password", $password);
    $employeeQuery->execute();
    $employee = $employeeQuery->fetch(PDO::FETCH_ASSOC);

    if ($customer) {
        session_start();
        $_SESSION["email"] = $email;
        $_SESSION["role"] = "KH";

        $localStorageScript = "<script>
        window.localStorage.setItem('email', '$email');
        window.localStorage.setItem('role', 'KH');
        window.location.href = 'index.php';
    </script>";
        echo $localStorageScript;
        exit();
    } elseif ($employee) {

        session_start();
        $_SESSION["email"] = $email;
        $_SESSION["role"] = "NV";

        $localStorageScript = "<script>
        window.localStorage.setItem('email', '$email');
        window.localStorage.setItem('role', 'NV');
        window.location.href = 'index.php';
    </script>";
        echo $localStorageScript;
        exit();
    } else {
        header("Location: DangNhap.php?error=1");
        exit();
    }
}
?>