<?php
$pdo = new PDO("mysql:host=localhost; port=3307; dbname=ql_vanphongpham", "root", "");
$pdo->query("set names utf8");

$oldPassword = $_POST['Old_Pasword'];
$newPassword = $_POST['NewPassword'];
$reNewPassword = $_POST['ReNewPassword'];
$email = $_POST['email'];

if (empty($oldPassword) || empty($newPassword) || empty($reNewPassword)) {
    header("Location: DoiMatKhauKH.php?email=$email&error=3");
    exit();
}

$query = $pdo->prepare("SELECT Password_KH FROM khachhang WHERE Email_KH = :email");
$query->execute(['email' => $email]);
$result = $query->fetch(PDO::FETCH_ASSOC);

if (!$result || $oldPassword !== $result['Password_KH']) {
    header("Location: DoiMatKhauKH.php?email=$email&error=1");
    exit();
} elseif ($newPassword !== $reNewPassword) {
    header("Location: DoiMatKhauKH.php?email=$email&error=2");
    exit();
}

$query = $pdo->prepare("UPDATE khachhang SET Password_KH = :newPassword WHERE Email_KH = :email");
$query->execute(['newPassword' => $newPassword, 'email' => $email]);

header("Location: index.php");
exit();
?>