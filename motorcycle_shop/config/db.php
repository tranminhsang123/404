<?php
// config/db.php

$host = "localhost"; // máy chủ
$db_name = "motorcycle_shop"; // tên cơ sở dữ liệu
$username = "root"; // tên người dùng
$password = ""; // mật khẩu

try {
    $conn = new PDO("mysql:host=$host;dbname=$db_name", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    echo "Kết nối không thành công: " . $e->getMessage();
}
?>
