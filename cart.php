<?php
session_start();

if (!isset($_SESSION['cart'])) {
    $_SESSION['cart'] = [];
}

if (isset($_GET['add_to_cart'])) {
    $_SESSION['cart'][] = [
        'name' => $_GET['add_to_cart'],
        'price' => $_GET['price']
    ];
    header("Location: cart.php");
    exit();
}
if (isset($_GET['add_to_cart'])) {
    $quantity = isset($_GET['quantity']) ? (int)$_GET['quantity'] : 1; 
    $_SESSION['cart'][] = [
        'name' => $_GET['add_to_cart'],
        'price' => (float)$_GET['price'],
        'quantity' => $quantity
    ];
    header("Location: cart.php");
    exit();
}


if (isset($_GET['remove_from_cart'])) {
    unset($_SESSION['cart'][$_GET['remove_from_cart']]);
    $_SESSION['cart'] = array_values($_SESSION['cart']);
}

$totalPrice = 0;
if (count($_SESSION['cart']) > 0) {
    foreach ($_SESSION['cart'] as $item) {
        $totalPrice += $item['price'];
    }
}
?>
<!DOCTYPE html>
<html lang="ar">
<head>
    <meta charset="UTF-8">
    <title>السلة</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <header><h1>سلة المشتريات</h1></header>
    <section class="cart-section">
        <h2>الأصناف المختارة</h2>
        <ul id="cart-items">
            <?php if (count($_SESSION['cart']) > 0): ?>
                <?php foreach ($_SESSION['cart'] as $index => $item): ?>
                    <li>
                        <?= htmlspecialchars($item['name']) ?>
                        <a href="?remove_from_cart=<?= $index ?>"><button>حذف</button></a>
                    </li>
                <?php endforeach; ?>
            <?php else: ?>
                <li>لا توجد أصناف في السلة.</li>
            <?php endif; ?>
        </ul>
        <p id="total-price">المجموع: <?= $totalPrice ?> ريال</p>

        <div class="cart-buttons">
            <?php if (count($_SESSION['cart']) > 0): ?>
                <a href="CaloriesCalculator.php"><button>حاسبة السعرات</button></a>
                <a href="OrderConfirmation.php"><button>إتمام الطلب</button></a>
            <?php endif; ?>
            <button onclick="window.location.href='menu.php'">العودة</button>
        </div>
    </section>
</body>
</html>
