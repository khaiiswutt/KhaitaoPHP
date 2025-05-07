<?php
session_start();

// Xử lý thêm sản phẩm vào giỏ
if (isset($_POST['add_to_cart'])) {
    $id = $_POST['id'];
    $product = [
        'id' => $id,
        'name' => $_POST['name'],
        'price' => (int)$_POST['price'],
        'quantity' => (int)$_POST['quantity']
    ];

    // Nếu sản phẩm đã tồn tại thì cộng thêm số lượng
    if (isset($_SESSION['cart'][$id])) {
        $_SESSION['cart'][$id]['quantity'] += $product['quantity'];
    } else {
        $_SESSION['cart'][$id] = $product;
    }
}

// Xử lý xóa sản phẩm
if (isset($_GET['remove'])) {
    unset($_SESSION['cart'][$_GET['remove']]);
}

// Xóa toàn bộ giỏ hàng
if (isset($_GET['clear'])) {
    unset($_SESSION['cart']);
}

function calculateTotal() {
    $total = 0;
    if (!empty($_SESSION['cart'])) {
        foreach ($_SESSION['cart'] as $item) {
            $total += $item['price'] * $item['quantity'];
        }
    }
    return $total;
}

// Danh sách sản phẩm demo
$demo_products = [
    ['id' => 'p1', 'name' => 'Áo thun GenZ', 'price' => 150000],
    ['id' => 'p2', 'name' => 'Mũ lưỡi trai vibe cool ngầu', 'price' => 95000],
    ['id' => 'p3', 'name' => 'Giày sneaker trắng', 'price' => 420000],
];
?>

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Giỏ hàng PHP đơn giản</title>
    <style>
        body { font-family: Arial; padding: 20px; background: #f7f7f7; }
        h1, h2 { text-align: center; }
        table { width: 90%; margin: 20px auto; border-collapse: collapse; background: white; }
        th, td { padding: 10px; border: 1px solid #ccc; text-align: center; }
        form { text-align: center; margin: 10px 0; }
        .btn { padding: 8px 14px; background: #4CAF50; color: white; border: none; cursor: pointer; }
        .btn:hover { background: #388e3c; }
        .btn-danger { background: tomato; }
        .btn-danger:hover { background: red; }
    </style>
</head>
<body>

<div class="logo-container">
    <a href="shop.php">
        <img src="khai.png" alt="Shop Logo" class="logo" style="width: 100px; height: auto;">
    </a>

<h1>🛍️ Demo Giỏ hàng PHP</h1>

<h2>🛒 Thêm sản phẩm vào giỏ</h2>
<?php foreach ($demo_products as $product): ?>
    <form method="post">
        <input type="hidden" name="id" value="<?= $product['id'] ?>">
        <input type="hidden" name="name" value="<?= $product['name'] ?>">
        <input type="hidden" name="price" value="<?= $product['price'] ?>">
        <label><strong><?= $product['name'] ?></strong> - <?= number_format($product['price'], 0, ',', '.') ?>đ</label>
        <input type="number" name="quantity" value="1" min="1" style="width:60px;">
        <button type="submit" name="add_to_cart" class="btn">Thêm vào giỏ</button>
    </form>
<?php endforeach; ?>

<hr>

<h2>📦 Giỏ hàng của bạn</h2>
<?php if (!empty($_SESSION['cart'])): ?>
    <table>
        <tr>
            <th>Sản phẩm</th>
            <th>Đơn giá</th>
            <th>Số lượng</th>
            <th>Thành tiền</th>
            <th>Xử lý</th>
        </tr>
        <?php foreach ($_SESSION['cart'] as $item): ?>
            <tr>
                <td><?= htmlspecialchars($item['name']) ?></td>
                <td><?= number_format($item['price'], 0, ',', '.') ?>đ</td>
                <td><?= $item['quantity'] ?></td>
                <td><?= number_format($item['price'] * $item['quantity'], 0, ',', '.') ?>đ</td>
                <td><a href="?remove=<?= $item['id'] ?>" class="btn btn-danger">Xóa</a></td>
            </tr>
        <?php endforeach; ?>
        <tr>
            <td colspan="3"><strong>Tổng cộng:</strong></td>
            <td colspan="2"><strong><?= number_format(calculateTotal(), 0, ',', '.') ?>đ</strong></td>
        </tr>
    </table>
    <div style="text-align: right; margin-top: 20px;">
        <a href="checkout.php" class="btn-checkout">✅ Xác nhận đơn hàng</a>
    </div>
<?php else: ?>
    <p style="text-align:center;">🚫 Chưa có sản phẩm nào trong giỏ hàng!</p>
<?php endif; ?>

</body>
</html>
<?php