<?php
$email = $_GET['email'];
$pdo = new PDO("mysql:host=localhost;dbname=ql_vanphongpham", "root", "");
$pdo->query("set names utf8");

// Retrieve the updated information from the form
$hoTen = $_POST['HoTen_KH'];
$diaChi = $_POST['DiaChi_KH'];
$sdt = $_POST['SDT_KH'];
$email = $_POST['Email_KH'];

// Update the database record
$query = $pdo->prepare("UPDATE KhachHang SET HoTen_KH = :hoTen, DiaChi_KH = :diaChi, SDT_KH = :sdt WHERE Email_KH = :email");
$query->execute(['hoTen' => $hoTen, 'diaChi' => $diaChi, 'sdt' => $sdt, 'email' => $email]);

// Redirect back to the page
header("Location: ThongTinCaNhanKH.php?email=$email");
exit;
?>