<?php
include_once "./model/DBUtils.php";
include_once('./model/cart-services.php');

// Khởi tạo giỏ hàng
$carts = new Cart();
$dbHelper = new DBUtils();


// Khởi tạo giá trị giảm giá (discount)
$discount = 0; // Giá trị mặc định là 0, có thể thay đổi tùy vào logic của bạn

// Kiểm tra nếu có mã giảm giá được nhập
if (isset($_POST['code']) && !empty($_POST['code'])) {
    // Xử lý mã giảm giá tại đây (ví dụ: kiểm tra mã giảm giá từ cơ sở dữ liệu)
    $discountCode = $_POST['code'];

    // Ví dụ: giả sử mã giảm giá có giá trị giảm 10%
    if ($discountCode == 'DISCOUNT10') {
        $discount = 10;
    }
}

// Xác định nếu giỏ hàng trống
$isCartEmpty = empty($carts->getCart());
?>

<div class="container padding-bottom-3x mb-1">
    <!-- Alert-->
    <!-- Shopping Cart-->
    <div class="table-responsive shopping-cart">
        <table class="table">
            <h1>Giỏ Hàng</h1>
            <thead>
                <tr>
                    <th>Tên Sản Phẩm</th>
                    <th class="text-center">Số Lượng</th>
                    <th class="text-center">Tổng Phụ</th>
                    <th class="text-center">Hành Động</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($carts->getCart() as $item) { ?>
                    <tr>
                        <td>
                            <div class="product-item">
                                <img src="<?php echo htmlspecialchars($item['image1']); ?>" alt="Product" style="width: 100px; height: auto;">
                                <div class="product-info">
                                    <h4 class="product-title">
                                        Tên: <?php echo htmlspecialchars($item['name']); ?><br>
                                        Giá: <?php echo number_format($item['price'], 3, '.', '.'); ?>đ
                                    </h4>
                                </div>
                        </td>
                        <td class="text-center">
                            <form method="post" action="./model/cart-handle.php" style="display: inline;">
                                <input type="hidden" name="action" value="update">
                                <input type="hidden" name="id" value="<?php echo htmlspecialchars($item['id']); ?>">

                                <?php
                                // Lấy số lượng tồn kho từ cơ sở dữ liệu
                                $productId = $item['id'];
                                $product = $dbHelper->selectOne("SELECT quantity FROM products WHERE id = ?", [$productId]);
                                $quantityInStock = $product['quantity'];

                                // Giới hạn số lượng sản phẩm trong giỏ hàng không vượt quá số lượng tồn kho
                                $newQuantity = min($item['quantity'] + 1, $quantityInStock);
                                ?>

                                <div class="quantity-control">
                                    <button type="submit" name="quantity" value="<?php echo max($item['quantity'] - 1, 1); ?>" class="btn btn-secondary btn-sm">-</button>
                                    <input type="text" value="<?php echo $item['quantity']; ?>" class="form-control form-control-sm text-center" readonly>
                                    <button type="submit" name="quantity" value="<?php echo $newQuantity; ?>" class="btn btn-secondary btn-sm" <?php if ($item['quantity'] >= $quantityInStock) echo 'disabled'; ?>>+</button>
                                </div>
                            </form>
                        </td>
                        <td class="text-center text-lg text-medium"><?php echo number_format($item['price'] * $item['quantity'], 3, ',', '.'); ?>đ</td>
                        <td class="text-center">
                            <!-- Form xóa từng sản phẩm -->
                            <form method="post" action="./model/cart-handle.php">
                                <input type="hidden" name="action" value="remove">
                                <input type="hidden" name="productId" value="<?php echo htmlspecialchars($item['id']); ?>">
                                <button type="submit" class="btn btn-danger btn-sm">Xóa</button>
                            </form>
                        </td>
                    </tr>
                <?php } ?>
            </tbody>
        </table>
    </div>
    <div class="shopping-cart-footer">
        <div class="column text-lg">Tổng: <span class="text-medium"><?php echo number_format($carts->getTotal() - ($discount * $carts->getTotal()) / 100, 3, '.', '.'); ?>đ</span>
        </div>
    </div>
    <div class="shopping-cart-footer">
        <div class="column"><a class="btn btn-primary mt-5" href="index.php"><i class="icon-arrow-left"></i>&nbsp;Quay Lại Mua Sắm</a></div>
        <div class="column">
            <a id="checkout-button" class="btn btn-success" href="index.php?view=checkout" <?php echo $isCartEmpty ? 'onclick="return false;" style="pointer-events: none; opacity: 0.5;"' : ''; ?>>
                Checkout
            </a>
        </div>
    </div>
</div>