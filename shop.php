<?php
// Danh sách sản phẩm demo (có thể thay bằng dữ liệu từ DB sau này)
$products = [
    ['id' => 'p1', 'name' => 'Áo thun GenZ', 'price' => 150000],
    ['id' => 'p2', 'name' => 'Mũ lưỡi trai vibe cool ngầu', 'price' => 95000],
    ['id' => 'p3', 'name' => 'Giày sneaker trắng', 'price' => 420000],
    ['id' => 'p4', 'name' => 'Túi tote học sinh nghệ sĩ', 'price' => 115000],
    ['id' => 'p5', 'name' => 'Kính râm chất chơi', 'price' => 135000],
];
?>

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Cửa hàng GenZ</title>
    <style>
        body { font-family: Arial; background: #f4f4f4; padding: 20px; }
        h1 { text-align: center; }
        .product-grid {
            display: flex;
            flex-wrap: wrap;
            justify-content: center;
            gap: 20px;
        }
        .product {
            background: white;
            padding: 15px;
            border: 1px solid #ddd;
            width: 200px;
            border-radius: 8px;
            box-shadow: 0 0 6px rgba(0,0,0,0.1);
            text-align: center;
        }
        .product h3 {
            margin-bottom: 10px;
        }
        .product form {
            display: flex;
            flex-direction: column;
            gap: 10px;
        }
        input[type="number"] {
            width: 60px;
            margin: 0 auto;
        }
        .btn {
            padding: 6px 10px;
            background: #007bff;
            color: white;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }
        .btn:hover {
            background: #0056b3;
        }
        .cart-link {
            display: block;
            text-align: center;
            margin-top: 30px;
        }
    </style>
</head>
<body>
<div class="logo-container">
    <a href="shop.php">
        <img src="khai.png" alt="Shop Logo" class="logo" style="width: 100px; height: auto;">
    </a>


<h1>🛒 Shop 365 - Mua sắm cùng chúng tôi</h1>

<div class="product-grid">
    <?php foreach ($products as $product): ?>
        <div class="product">
            <h3><?= htmlspecialchars($product['name']) ?></h3>
            <p><strong><?= number_format($product['price'], 0, ',', '.') ?>đ</strong></p>
            <form action="cart.php" method="post">
                <input type="hidden" name="id" value="<?= $product['id'] ?>">
                <input type="hidden" name="name" value="<?= $product['name'] ?>">
                <input type="hidden" name="price" value="<?= $product['price'] ?>">
                <label>Số lượng:</label>
                <input type="number" name="quantity" value="1" min="1">
                <button type="submit" name="add_to_cart" class="btn">Thêm vào giỏ</button>
            </form>
        </div>
    <?php endforeach; ?>
</div>

<div class="cart-link">
    <a href="cart.php" class="btn">🧺 Xem giỏ hàng</a>
</div>

</body>
</html>
