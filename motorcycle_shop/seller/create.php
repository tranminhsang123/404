<?php
// seller/create.php
include '../config/db.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = $_POST['username'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
    $email = $_POST['email'];
    $phone_number = $_POST['phone_number'];
    $shop_name = $_POST['shop_name'];
    $shop_description = $_POST['shop_description'];
    $address = $_POST['address'];
    $status = $_POST['status'];

    $sql = "INSERT INTO seller (username, password, email, phone_number, shop_name, shop_description, address, status)
            VALUES (?, ?, ?, ?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->execute([$username, $password, $email, $phone_number, $shop_name, $shop_description, $address, $status]);

    header("Location: index.php");
}
?>

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Thêm Người Bán Mới</title>
</head>
<body>
    <h1>Thêm Người Bán Mới</h1>
    <form method="POST" action="">
        <label for="username">Tên Người Dùng:</label>
        <input type="text" name="username" required><br>
        <label for="password">Mật Khẩu:</label>
        <input type="password" name="password" required><br>
        <label for="email">Email:</label>
        <input type="email" name="email" required><br>
        <label for="phone_number">Số Điện Thoại:</label>
        <input type="text" name="phone_number"><br>
        <label for="shop_name">Tên Cửa Hàng:</label>
        <input type="text" name="shop_name" required><br>
        <label for="shop_description">Mô Tả Cửa Hàng:</label>
        <textarea name="shop_description"></textarea><br>
        <label for="address">Địa Chỉ:</label>
        <input type="text" name="address"><br>
        <label for="status">Trạng Thái:</label>
        <select name="status">
            <option value="active">Hoạt Động</option>
            <option value="inactive">Ngừng Hoạt Động</option>
        </select><br>
        <input type="submit" value="Thêm Người Bán">
    </form>
    <a href="index.php">Quay lại</a>
</body>
</html>
