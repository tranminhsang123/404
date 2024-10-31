<?php
// seller/edit.php
include '../config/db.php';

$seller_id = $_GET['id'];
$sql = "SELECT * FROM seller WHERE seller_id = ?";
$stmt = $conn->prepare($sql);
$stmt->execute([$seller_id]);
$seller = $stmt->fetch(PDO::FETCH_ASSOC);

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = $_POST['username'];
    $email = $_POST['email'];
    $phone_number = $_POST['phone_number'];
    $shop_name = $_POST['shop_name'];
    $shop_description = $_POST['shop_description'];
    $address = $_POST['address'];
    $status = $_POST['status'];

    $sql = "UPDATE seller SET username = ?, email = ?, phone_number = ?, shop_name = ?, shop_description = ?, address = ?, status = ?
            WHERE seller_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->execute([$username, $email, $phone_number, $shop_name, $shop_description, $address, $status, $seller_id]);

    header("Location: index.php");
}
?>

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Sửa Người Bán</title>
</head>
<body>
    <h1>Sửa Người Bán</h1>
    <form method="POST" action="">
        <label for="username">Tên Người Dùng:</label>
        <input type="text" name="username" value="<?php echo $seller['username']; ?>" required><br>
        <label for="email">Email:</label>
        <input type="email" name="email" value="<?php echo $seller['email']; ?>" required><br>
        <label for="phone_number">Số Điện Thoại:</label>
        <input type="text" name="phone_number" value="<?php echo $seller['phone_number']; ?>"><br>
        <label for="shop_name">Tên Cửa Hàng:</label>
        <input type="text" name="shop_name" value="<?php echo $seller['shop_name']; ?>" required><br>
        <label for="shop_description">Mô Tả Cửa Hàng:</label>
        <textarea name="shop_description"><?php echo $seller['shop_description']; ?></textarea><br>
        <label for="address">Địa Chỉ:</label>
        <input type="text" name="address" value="<?php echo $seller['address']; ?>"><br>
        <label for="status">Trạng Thái:</label>
        <select name="status">
            <option value="active" <?php if($seller['status'] == 'active') echo 'selected'; ?>>Hoạt Động</option>
            <option value="inactive" <?php if($seller['status'] == 'inactive') echo 'selected'; ?>>Ngừng Hoạt Động</option>
        </select><br>
        <input type="submit" value="Cập Nhật">
    </form>
    <a href="index.php">Quay lại</a>
</body>
</html>
