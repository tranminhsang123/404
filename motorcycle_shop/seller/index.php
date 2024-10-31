<?php
// seller/index.php
include '../config/db.php';

$sql = "SELECT * FROM seller";
$stmt = $conn->prepare($sql);
$stmt->execute();
$sellers = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Quản lý Người Bán</title>
    <link rel="stylesheet" href="../assets/style.css">
</head>
<body>
    <h1>Danh sách Người Bán</h1>
    <a href="create.php">Thêm Người Bán Mới</a>
    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Tên Người Dùng</th>
                <th>Email</th>
                <th>Số Điện Thoại</th>
                <th>Tên Cửa Hàng</th>
                <th>Trạng Thái</th>
                <th>Thao Tác</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($sellers as $seller): ?>
                <tr>
                    <td><?php echo $seller['seller_id']; ?></td>
                    <td><?php echo $seller['username']; ?></td>
                    <td><?php echo $seller['email']; ?></td>
                    <td><?php echo $seller['phone_number']; ?></td>
                    <td><?php echo $seller['shop_name']; ?></td>
                    <td><?php echo $seller['status']; ?></td>
                    <td>
                        <a href="edit.php?id=<?php echo $seller['seller_id']; ?>">Sửa</a>
                        <a href="delete.php?id=<?php echo $seller['seller_id']; ?>">Xóa</a>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</body>
</html>
