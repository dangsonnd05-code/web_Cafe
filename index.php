<?php
session_start();

/* =========================
   DANH SÁCH ĐỒ UỐNG GIẢ LẬP
   ========================= */
$products = [
    1 => ["name" => "Cà phê đen", "price" => 20000, "qty" => 10],
    2 => ["name" => "Cà phê sữa", "price" => 25000, "qty" => 8],
    3 => ["name" => "Trà đào", "price" => 30000, "qty" => 6],
    4 => ["name" => "Trà sữa trân châu", "price" => 35000, "qty" => 5],
    5 => ["name" => "Sinh tố xoài", "price" => 40000, "qty" => 0],
];

/* =========================
   GIỎ HÀNG
   ========================= */
if (!isset($_SESSION['cart'])) {
    $_SESSION['cart'] = [];
}

/* =========================
   ĐẶT ĐỒ UỐNG
   ========================= */
if (isset($_GET['buy'])) {
    $id = (int) $_GET['buy'];
    if (isset($products[$id]) && $products[$id]['qty'] > 0) {
        $_SESSION['cart'][$id] = ($_SESSION['cart'][$id] ?? 0) + 1;
        $products[$id]['qty']--;
    }
}

/* =========================
   THANH TOÁN
   ========================= */
if (isset($_POST['checkout'])) {
    $_SESSION['cart'] = [];
    echo "<script>alert('Thanh toán thành công! Cảm ơn quý khách ☕');</script>";
}
?>

<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <title>QUÁN CAFE</title>

    <style>
        body {
            margin: 0;
            font-family: Arial, sans-serif;
            background: #f4f6f8;
        }

        /* HEADER */
        header {
            position: fixed;
            top: 0;
            width: 100%;
            background: #6f4e37;
            color: white;
            padding: 15px;
            text-align: center;
            font-size: 24px;
            z-index: 1000;
        }

        /* NỘI DUNG */
        .container {
            width: 1000px;
            margin: 120px auto 60px;
            background: white;
            padding: 20px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        th,
        td {
            border: 1px solid #ccc;
            padding: 10px;
            text-align: center;
        }

        th {
            background: #8b5a2b;
            color: white;
        }

        .buy {
            background: #28a745;
            color: white;
            padding: 6px 10px;
            text-decoration: none;
            border-radius: 4px;
        }

        .soldout {
            color: red;
            font-weight: bold;
        }

        /* GIỎ HÀNG */
        .cart {
            margin-top: 30px;
            background: #f8f9fa;
            padding: 15px;
        }

        /* FOOTER */
        footer {
            background: #6f4e37;
            color: white;
            text-align: center;
            padding: 15px;
            position: fixed;
            bottom: 0;
            width: 100%;
        }
    </style>
</head>

<body>

    <header>
        ☕ QUÁN CAFE – ĐẶT ĐỒ UỐNG TRỰC TUYẾN
    </header>

    <div class="container">
        <h2>🍹 MENU ĐỒ UỐNG</h2>

        <table>
            <tr>
                <th>Tên đồ uống</th>
                <th>Giá</th>
                <th>Số lượng</th>
                <th>Trạng thái</th>
            </tr>

            <?php foreach ($products as $id => $p): ?>
                <tr>
                    <td><?= $p['name'] ?></td>
                    <td><?= number_format($p['price']) ?> VNĐ</td>
                    <td><?= $p['qty'] ?></td>
                    <td>
                        <?php if ($p['qty'] > 0): ?>
                            <a class="buy" href="?buy=<?= $id ?>">☕ Đặt</a>
                        <?php else: ?>
                            <span class="soldout">HẾT HÀNG</span>
                        <?php endif; ?>
                    </td>
                </tr>
            <?php endforeach; ?>
        </table>

        <div class="cart">
            <h3>🛒 Đơn hàng của bạn</h3>

            <?php
            $total = 0;
            foreach ($_SESSION['cart'] as $id => $qty):
                $subtotal = $products[$id]['price'] * $qty;
                $total += $subtotal;
                ?>
                <p><?= $products[$id]['name'] ?> × <?= $qty ?> = <?= number_format($subtotal) ?> VNĐ</p>
            <?php endforeach; ?>

            <h4>💰 Tổng tiền: <?= number_format($total) ?> VNĐ</h4>

            <?php if ($total > 0): ?>
                <form method="post">
                    <button name="checkout">✅ Thanh toán</button>
                </form>
            <?php endif; ?>
        </div>

    </div>

    <footer>
        © 2026 – QUÁN CAFE | Môn Điện Toán Đám Mây
    </footer>

</body>

</html>