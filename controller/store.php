<?php
include_once "./model/DBUtils.php";
$dbHelper = new DBUtils();

// Lấy ID danh mục từ URL
$category_id = isset($_GET['category_id']) ? intval($_GET['category_id']) : 0;

// Lấy giá trị sắp xếp từ URL
$sort_order = isset($_GET['sort']) ? $_GET['sort'] : 'price_asc'; // Giá trị mặc định là sắp xếp theo giá tăng dần

// Lấy giá trị thương hiệu và giá từ URL (nếu có)
$brand_filter = isset($_GET['brand']) ? $_GET['brand'] : ''; // Mặc định không có lọc theo thương hiệu
$price_filter = isset($_GET['price']) ? $_GET['price'] : ''; // Mặc định không có lọc theo giá

// Xác định điều kiện sắp xếp
$sort_sql = "ORDER BY price ASC";
if ($sort_order === 'price_desc') {
    $sort_sql = "ORDER BY price DESC";
}

// Truy vấn lấy danh sách thương hiệu (distinct) theo danh mục
$sql = "SELECT DISTINCT hanglaptop FROM products WHERE hanglaptop IS NOT NULL";
if ($category_id > 0) {
    $sql .= " AND category_id = :category_id"; // Thêm điều kiện lọc theo danh mục
}
$brands = $dbHelper->select($sql, ['category_id' => $category_id]);

// Truy vấn sản phẩm cho phần "Top selling"
$topSellingProducts = [];
if ($category_id > 0) {
    $sql = "SELECT * FROM products WHERE category_id = :category_id AND quantity > 0 ORDER BY sale DESC LIMIT 3";
    $topSellingProducts = $dbHelper->select($sql, ['category_id' => $category_id]);
} else {
    $sql = "SELECT * FROM products WHERE quantity > 0 ORDER BY sale DESC LIMIT 3";
    $topSellingProducts = $dbHelper->select($sql);
}

// Phân trang
$page = isset($_GET['page']) ? intval($_GET['page']) : 1;
$limit = 9; // Số sản phẩm mỗi trang
$offset = ($page - 1) * $limit; // Vị trí bắt đầu lấy sản phẩm từ database

// Truy vấn tổng số sản phẩm
$params = [];
$sql = "SELECT * FROM products WHERE quantity > 0"; // Chỉ lấy sản phẩm có số lượng > 0
if ($category_id > 0) {
    $sql .= " AND category_id = :category_id";
    $params['category_id'] = $category_id;
}

// Nếu có chọn thương hiệu, thêm điều kiện lọc theo thương hiệu
if ($brand_filter) {
    $sql .= " AND hanglaptop = :brand_filter";
    $params['brand_filter'] = $brand_filter;
}

// Nếu có lọc theo giá, thêm điều kiện lọc giá
if ($price_filter) {
    if ($price_filter === '10_20') {
        $sql .= " AND price BETWEEN 10000 AND 20000";  // 10 triệu đến 20 triệu
    } elseif ($price_filter === '20_30') {
        $sql .= " AND price BETWEEN 20000 AND 30000";  // 20 triệu đến 30 triệu
    } elseif ($price_filter === '30_40') {
        $sql .= " AND price BETWEEN 30000 AND 40000";  // 30 triệu đến 40 triệu
    } elseif ($price_filter === '40_50') {
        $sql .= " AND price BETWEEN 40000 AND 50000";  // 40 triệu đến 50 triệu
    } elseif ($price_filter === '50_up') {
        $sql .= " AND price > 50000";  // Trên 50 triệu
    }
}

// Thêm điều kiện sắp xếp
$sql .= " " . $sort_sql . " LIMIT $limit OFFSET $offset";
$storeProducts = $dbHelper->select($sql, $params);

// Truy vấn tổng số sản phẩm để tính số trang
$countSql = "SELECT COUNT(*) as total FROM products WHERE quantity > 0";
if ($category_id > 0) {
    $countSql .= " AND category_id = :category_id";
    $params['category_id'] = $category_id;
}
if ($brand_filter) {
    $countSql .= " AND hanglaptop = :brand_filter";
}
if ($price_filter) {
    if ($price_filter === '10_20') {
        $countSql .= " AND price BETWEEN 10000 AND 20000";  // 10 triệu đến 20 triệu
    } elseif ($price_filter === '20_30') {
        $countSql .= " AND price BETWEEN 20000 AND 30000";  // 20 triệu đến 30 triệu
    } elseif ($price_filter === '30_40') {
        $countSql .= " AND price BETWEEN 30000 AND 40000";  // 30 triệu đến 40 triệu
    } elseif ($price_filter === '40_50') {
        $countSql .= " AND price BETWEEN 40000 AND 50000";  // 40 triệu đến 50 triệu
    } elseif ($price_filter === '50_up') {
        $countSql .= " AND price > 50000";  // Trên 50 triệu
    }
}
$totalProducts = $dbHelper->selectOne($countSql, $params);
$totalPages = ceil($totalProducts['total'] / $limit); // Số trang cần thiết
?>

<!-- SECTION -->
<div class="section">
    <div class="container">
        <div class="row">
            <div id="aside" class="col-md-3">
                <div class="aside">
                    <h3 class="aside-title">Lọc theo giá</h3>
                    <form action="index.php" method="get">
                        <input type="hidden" name="view" value="store">
                        <input type="hidden" name="category_id" value="<?php echo htmlspecialchars($category_id); ?>">
                        <input type="hidden" name="sort" value="<?php echo htmlspecialchars($sort_order); ?>"> <!-- Giữ giá trị sort hiện tại -->
                        <input type="hidden" name="brand" value="<?php echo htmlspecialchars($brand_filter); ?>"> <!-- Giữ giá trị thương hiệu hiện tại -->
                        <select name="price" onchange="this.form.submit()">
                            <option value="">Chọn Mức Giá</option>
                            <option value="10_20" <?php echo ($price_filter === '10_20') ? 'selected' : ''; ?>>10 triệu > 20 triệu</option>
                            <option value="20_30" <?php echo ($price_filter === '20_30') ? 'selected' : ''; ?>>20 triệu > 30 triệu</option>
                            <option value="30_40" <?php echo ($price_filter === '30_40') ? 'selected' : ''; ?>>30 triệu > 40 triệu</option>
                            <option value="40_50" <?php echo ($price_filter === '40_50') ? 'selected' : ''; ?>>40 triệu > 50 triệu</option>
                            <option value="50_up" <?php echo ($price_filter === '50_up') ? 'selected' : ''; ?>>Trên 50 triệu</option>
                        </select>
                    </form>
                </div>

                <div class="aside">
                    <h3 class="aside-title">Lọc theo Hãng</h3>
                    <form action="index.php" method="get">
                        <input type="hidden" name="view" value="store">
                        <input type="hidden" name="category_id" value="<?php echo htmlspecialchars($category_id); ?>">
                        <input type="hidden" name="sort" value="<?php echo htmlspecialchars($sort_order); ?>"> <!-- Giữ giá trị sort hiện tại -->
                        <input type="hidden" name="price" value="<?php echo htmlspecialchars($price_filter); ?>"> <!-- Giữ giá trị giá hiện tại -->
                        <select name="brand" onchange="this.form.submit()">
                            <option value="">Chọn Hãng</option>
                            <?php foreach ($brands as $brand) : ?>
                                <option value="<?php echo htmlspecialchars($brand['hanglaptop']); ?>" <?php echo ($brand_filter === $brand['hanglaptop']) ? 'selected' : ''; ?>>
                                    <?php echo htmlspecialchars($brand['hanglaptop']); ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </form>
                </div>

                <div class="aside">
                    <h3 class="aside-title">Nổi Bật Nhất</h3>
                    <?php foreach ($topSellingProducts as $product) : ?>
                        <div class="product-widget">
                            <div class="product-img">
                                <img src="<?php echo $product['image1'] ?>" alt="">
                            </div>
                            <div class="product-body">
                                <h3 class="product-name"><a href="index.php?view=shop_detail&id=<?php echo $product['id']; ?>"><?php echo $product['name']; ?></a></h3>
                                <h4 class="product-price"><?= number_format($product['price'], 3, '.', '.'); ?>đ <del class="product-old-price"><?= number_format($product['sale'], 3, '.', '.') ?>đ</del></h4>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>

            <div id="store" class="col-md-9">
                <div class="row">
                    <?php foreach ($storeProducts as $product) : ?>
                        <div class="col-md-4 col-xs-6">
                            <div class="product" onclick="window.location.href='index.php?view=shop_detail&id=<?php echo $product['id']; ?>'">
                                <div class="product-img">
                                    <img src="<?php echo $product['image1'] ?>" alt="">
                                </div>
                                <div class="product-body">
                                    <h3 class="product-name"><?php echo $product['name'] ?></h3>
                                    <h4 class="product-price"><?= number_format($product['price'], 3, '.', '.'); ?>đ <del class="product-old-price"><?= number_format($product['sale'], 3, '.', '.') ?>đ</del></h4>
                                    <form method="get" action="./model/love-handle.php">
                                        <div class="product-btns">
                                            <input type="hidden" name="id" value="<?php echo $product['id']; ?>" />
                                            <input type="hidden" name="name" value="<?= htmlspecialchars($product['name']); ?>" />
                                            <input type="hidden" name="price" value="<?= htmlspecialchars($product['price']); ?>" />
                                            <input type="hidden" name="sale" value="<?= htmlspecialchars($product['sale']); ?>" />
                                            <input type="hidden" name="image" value="<?= htmlspecialchars($product['image1']); ?>" />
                                            <button type="submit" name="actionn" value="addd" class="add-to-wishlist"><i class="fa fa-heart-o"></i><span class="tooltipp">Yêu Thích</span></button>
                                        </div>
                                    </form>
                                </div>
                                <div class="add-to-cart">
                                    <form method="post" action="./model/cart-handle.php">
                                        <input type="hidden" name="id" value="<?php echo $product['id']; ?>" />
                                        <input type="hidden" name="name" value="<?= htmlspecialchars($product['name']); ?>" />
                                        <input type="hidden" name="price" value="<?= htmlspecialchars($product['price']); ?>" />
                                        <input type="hidden" name="image" value="<?= htmlspecialchars($product['image1']); ?>" />
                                        <button type="submit" name="action" value="add" class="add-to-cart-btn"><i class="fa fa-shopping-cart"></i>Thêm Vào Giỏ Hàng</button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>

                <div class="store-filter clearfix">
                    <ul class="store-pagination">
                        <?php
                        if ($page > 1) {
                            echo "<li><a href='index.php?view=store&category_id=$category_id&sort=$sort_order&brand=$brand_filter&price=$price_filter&page=" . ($page - 1) . "'><i class='fa fa-angle-left'></i></a></li>";
                        }

                        for ($i = 1; $i <= $totalPages; $i++) {
                            $activeClass = ($i == $page) ? 'active' : '';
                            echo "<li class='$activeClass'><a href='index.php?view=store&category_id=$category_id&sort=$sort_order&brand=$brand_filter&price=$price_filter&page=$i'>$i</a></li>";
                        }

                        if ($page < $totalPages) {
                            echo "<li><a href='index.php?view=store&category_id=$category_id&sort=$sort_order&brand=$brand_filter&price=$price_filter&page=" . ($page + 1) . "'><i class='fa fa-angle-right'></i></a></li>";
                        }
                        ?>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>
<br><br>