<?php
include_once "./model/DBUtils.php";
include_once('./model/love-services.php');
$cart = new Carts();

if (!isset($_SESSION['user'])) {
    echo '<meta http-equiv="refresh" content="0;url=login.php">';
    exit(); // Dừng thực thi tiếp mã để đảm bảo người dùng được chuyển hướng
}
?>

<!-- SECTION -->
<div class="section">
    <!-- container -->
    <div class="container">
        <!-- row -->
        <div class="row">

            <!-- section title -->
            <div class="col-md-12">
                <div class="section-title">
                    <h3 class="title">Danh Sách Yêu Thích</h3>
                </div>
            </div>
            <!-- /section title -->

            <!-- Products tab & slick -->
            <div class="col-md-12">
                <div class="row">
                    <div class="products-tabs">
                        <!-- tab -->
                        <div id="tab1" class="tab-pane active">
                            <div class="products-slick" data-nav="#slick-nav-1">
                                <!-- product -->
                                <?php foreach ($cart->getCart() as $item) { ?>
                                    <div class="product">
                                        <div class="product-img">
                                            <img src="<?php echo $item['image1'] ?>" alt="">
                                        </div>
                                        <div class="product-body">
                                            <h3 class="product-name"><a href="#"><?php echo $item['name'] ?></a></h3>
                                            <h4 class="product-price"><?= number_format($item['price'], 3, '.', '.'); ?>đ <del class="product-old-price"><?= number_format($item['sale'], 3, '.', '.');?>đ</del></h4>
                                            <div class="product-btns">
                                                <button type="button" onclick="window.location.href='index.php?view=shop_detail&id=<?php echo $item['id']; ?>'" class="add-to-wishlist">
                                                    <i class="fa fa-eye"></i>
                                                    <span class="tooltipp">Xem</span>
                                                    <form action="./model/love-handle.php" method="get">
                                                        <input type="hidden" name="id" value="<?php echo htmlspecialchars($item['id']); ?>" />
                                                        <button type="submit" name="actionn" value="removee" class="add-to-wishlist"><i class="fa fa-close"></i><span class="tooltipp">Xóa</a></span></button>
                                                    </form>
                                            </div>
                                        </div>
                                        <div class="add-to-cart">
                                            <form method="post" action="./model/cart-handle.php">
                                                <input type="hidden" name="id" value="<?php echo $item['id']; ?>" />
                                                <input type="hidden" name="name" value="<?= htmlspecialchars($item['name']); ?>" />
                                                <input type="hidden" name="price" value="<?= htmlspecialchars($item['price']); ?>" />
                                                <input type="hidden" name="image" value="<?= htmlspecialchars($item['image1']); ?>" />
                                                <button type="submit" name="action" value="add" class="add-to-cart-btn"><i class="fa fa-shopping-cart"></i>Thêm Vào Giỏ Hàng</button>
                                            </form>
                                        </div>
                                    </div>
                                <?php } ?>
                                <!-- /product -->
                            </div>
                            <div id="slick-nav-1" class="products-slick-nav"></div>
                        </div>
                        <!-- /tab -->
                    </div>
                </div>
            </div>
            <!-- Products tab & slick -->
        </div>
        <!-- /row -->
    </div>
    <!-- /container -->
</div>
<!-- /SECTION -->
<br>
<br>