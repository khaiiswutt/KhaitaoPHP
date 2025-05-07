<?php
session_start();

// Nếu giỏ hàng trống, quay về shop
if (!isset($_SESSION['cart']) || empty($_SESSION['cart'])) {
    header("Location: shop.php");
    exit;
}

function calculateTotal() {
    $total = 0;
    foreach ($_SESSION['cart'] as $item) {
        $total += $item['price'] * $item['quantity'];
    }
    return $total;
}

// Xử lý khi submit đơn hàng
$order_success = false;
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Thu thập dữ liệu
    $name = htmlspecialchars($_POST['name']);
    $email = htmlspecialchars($_POST['email']);
    $address = htmlspecialchars($_POST['address']);
    $payment = $_POST['payment'];

    // (Ở mức độ demo) giả sử lưu đơn hàng vào DB tại đây...

    // Xóa giỏ hàng sau khi đặt
    unset($_SESSION['cart']);
    $order_success = true;
}
?>

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Thanh toán đơn hàng</title>
    <style>
        body { font-family: Arial; background: #f4f4f4; padding: 30px; }
        .container { background: white; padding: 20px; max-width: 700px; margin: auto; border-radius: 8px; box-shadow: 0 0 8px rgba(0,0,0,0.1); }
        h1 { text-align: center; }
        table { width: 100%; margin-top: 20px; border-collapse: collapse; }
        th, td { padding: 10px; border: 1px solid #ccc; text-align: center; }
        .form-group { margin-bottom: 15px; }
        label { display: block; font-weight: bold; }
        input, textarea, select { width: 100%; padding: 8px; border-radius: 4px; border: 1px solid #ccc; }
        .btn { padding: 10px 15px; background: #28a745; color: white; border: none; border-radius: 4px; cursor: pointer; }
        .btn:hover { background: #218838; }
        .success { background: #d4edda; padding: 15px; color: #155724; border-radius: 5px; margin-top: 20px; }
    </style>
</head>
<body>

<div class="container">
    <h1>💳 Thanh toán đơn hàng</h1>

    <?php if ($order_success): ?>
        <div class="success">
            ✅ Đơn hàng của bạn đã được gửi thành công! Cảm ơn bạn đã mua sắm cùng chúng tôi.
        </div>
    <?php else: ?>
        <h2>🛒 Tóm tắt đơn hàng</h2>
        <table>
            <tr>
                <th>Sản phẩm</th>
                <th>Số lượng</th>
                <th>Đơn giá</th>
                <th>Thành tiền</th>
            </tr>
            <?php foreach ($_SESSION['cart'] as $item): ?>
                <tr>
                    <td><?= htmlspecialchars($item['name']) ?></td>
                    <td><?= $item['quantity'] ?></td>
                    <td><?= number_format($item['price'], 0, ',', '.') ?>đ</td>
                    <td><?= number_format($item['price'] * $item['quantity'], 0, ',', '.') ?>đ</td>
                </tr>
            <?php endforeach; ?>
            <tr>
                <td colspan="3"><strong>Tổng cộng:</strong></td>
                <td><strong><?= number_format(calculateTotal(), 0, ',', '.') ?>đ</strong></td>
            </tr>
        </table>

        <h2>📋 Thông tin người nhận</h2>
        <form method="post">
            <div class="form-group">
                <label>Họ tên</label>
                <input type="text" name="name" required>
            </div>

            <div class="form-group">
                <label>Email</label>
                <input type="email" name="email" required>
            </div>

            <div class="form-group">
                <label>Địa chỉ giao hàng</label>
                <textarea name="address" rows="3" required></textarea>
            </div>

            <div class="form-group">
                <label>Phương thức thanh toán</label>
                <select name="payment" required>
                    <option value="cod">Thanh toán khi nhận hàng (COD)</option>
                    <option value="bank">Chuyển khoản ngân hàng</option>
                    <option value="momo">Momo / Ví điện tử</option>
                </select>
            </div>

            <button type="submit" class="btn">🚀 Xác nhận đặt hàng</button>
        </form>
    <?php endif; ?>
</div>

</body>
</html>
