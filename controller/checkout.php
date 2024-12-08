<?php
include_once('./model/cart-services.php');
include_once "./model/DBUtils.php";

$carts = new Cart();
$dbHelper = new DBUtils();

if (!isset($_SESSION['user'])) {
    echo '<meta http-equiv="refresh" content="0;url=login.php">';
    exit(); // Dừng thực thi tiếp mã để đảm bảo người dùng được chuyển hướng
}

// Fetch cart items
$cartItems = $carts->getCart();
$total = $carts->getTotal();
$userInfo = isset($_SESSION['user']) ? $_SESSION['user'] : null;

// Lấy thông tin người dùng từ cơ sở dữ liệu nếu đã đăng nhập
if ($userInfo) {
    $userId = $userInfo['id'];
    $userDetails = $dbHelper->select("SELECT name, email, phone, address FROM admins WHERE id = :id", ['id' => $userId]);
    if ($userDetails) {
        $userInfo = $userDetails[0]; // Lấy thông tin người dùng
    }
}
?>
<!-- SECTION -->
<div class="section">
    <!-- container -->
    <div class="container">
        <!-- row -->
        <div class="row">
            <div class="col-md-7">
                <!-- Billing Details -->
                <div class="billing-details">
                    <div class="section-title">
                        <h3 class="title">Checkout</h3>
                    </div>
                    <form action="./model/cart-handle.php" method="POST">
                        <div class="form-group">
                            <input class="input" type="text" name="name" placeholder="Name" required value="<?php echo isset($userInfo['name']) ? htmlspecialchars($userInfo['name']) : ''; ?>">
                        </div>
                        <div class="form-group">
                            <input class="input" type="email" name="email" placeholder="Email" required value="<?php echo isset($userInfo['email']) ? htmlspecialchars($userInfo['email']) : ''; ?>">
                        </div>
                        <div class="form-group">
                            <input class="input" type="text" name="address" placeholder="Địa Chỉ" required value="<?php echo isset($userInfo['address']) ? htmlspecialchars($userInfo['address']) : ''; ?>">
                        </div>
                        <div class="form-group">
                            <input class="input" type="tel" name="phone" placeholder="Số Điện Thoại" value="<?php echo isset($userInfo['phone']) ? htmlspecialchars($userInfo['phone']) : ''; ?>">
                        </div>
                        <!-- Order notes -->
                        <div class="order-notes">
                            <textarea class="input" name="note" placeholder="Ghi Chú"></textarea>
                        </div>
                        <!-- /Order notes -->
                        <div class="input-checkbox">
                            <input type="checkbox" id="terms" name="terms" required>
                            <label for="terms">
                                <span></span>
                                Tôi đã đọc và chấp nhận các điều khoản và điều kiện
                            </label>
                        </div>
                        <button type="submit" name="action" value="save_order" class="primary-btn order-submit">Đặt Hàng</button>
                    </form>
                </div>
                <!-- /Billing Details -->
            </div>

            <!-- Order Details -->
            <div class="col-md-5 order-details">
                <div class="section-title text-center">
                    <h3 class="title">Đơn Hàng Của Bạn</h3>
                </div>
                <div class="order-summary">
                    <div class="order-col">
                        <div><strong>Sản Phẩm</strong></div>
                        <div><strong>Giá</strong></div>
                    </div>
                    <div class="order-products">
                        <?php foreach ($cartItems as $item): ?>
                            <div class="order-col">
                                <div><?php echo htmlspecialchars($item['name']); ?> x <?php echo $item['quantity']; ?></div>
                                <div>
                                    <p><?= number_format($item['price'] * $item['quantity'], 3, '.', '.'); ?>đ</p>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div>
                    <div class="order-col">
                        <div><strong>Tổng</strong></div>
                        <div>
                            <h3 class="order-total"><?= number_format($total, 3, '.', '.') ?>đ</h3>
                        </div>
                    </div>
                </div>
            </div>
            <!-- /Order Details -->
        </div>
        <!-- /row -->
    </div>
    <!-- /container -->
</div>
<!-- /SECTION -->