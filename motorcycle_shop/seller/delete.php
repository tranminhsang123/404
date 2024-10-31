<?php
// seller/delete.php
include '../config/db.php';

$seller_id = $_GET['id'];
$sql = "DELETE FROM seller WHERE seller_id = ?";
$stmt = $conn->prepare($sql);
$stmt->execute([$seller_id]);

header("Location: index.php");
?>
