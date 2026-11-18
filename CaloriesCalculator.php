<?php
session_start();
require_once('db.php');

if (empty($_SESSION['cart'])) {
    $message = "لا توجد أصناف في السلة.";
    $totalCalories = 0;
} else {
    $totalCalories = 0;
    foreach ($_SESSION['cart'] as $cartItem) {
        $itemQuery = "SELECT * FROM menu_items WHERE id = :id";
        $stmtItem = $pdo->prepare($itemQuery);
        $stmtItem->execute(['id' => $cartItem['id']]);
        $item = $stmtItem->fetch(PDO::FETCH_ASSOC);
        $totalCalories += $item['calories'];
    }

    if ($totalCalories > 1000) {
        $message = "السعرات كثيرة! حاول تقليل الكميات.";
    } elseif ($totalCalories < 500) {
        $message = "السعرات قليلة! قد تحتاج إلى تناول المزيد.";
    } else {
        $message = "السعرات معتدلة. استمر على هذا النحو!";
    }
}
?>

<!DOCTYPE html>
<html lang="ar">
<head>
    <meta charset="UTF-8">
    <title>حاسبة السعرات الغذائية</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <header>
        <h1>حاسبة السعرات الغذائية</h1>
    </header>

    <section class="calculator-section">
        <h2>الأصناف في السلة لحساب السعرات:</h2>
        
        <div class="calories-items">
            <?php
            if (!empty($_SESSION['cart'])) {
                foreach ($_SESSION['cart'] as $cartItem) {
                    $itemQuery = "SELECT * FROM menu_items WHERE id = :id";
                    $stmtItem = $pdo->prepare($itemQuery);
                    $stmtItem->execute(['id' => $cartItem['id']]);
                    $item = $stmtItem->fetch(PDO::FETCH_ASSOC);
                    ?>
                    <div class="calories-item">
                        <img src="images/<?= htmlspecialchars($item['image']) ?>" alt="<?= htmlspecialchars($item['name']) ?>">
                        <h3><?= htmlspecialchars($item['name']) ?></h3>
                        <p>السعرات: <?= $item['calories'] ?> سعرة حرارية</p>
                        <p>السعر: <?= $item['price'] ?> ريال</p>
                    </div>
                    <?php
                }
            } else {
                echo "<p>لا توجد أصناف في السلة.</p>";
            }
            ?>
        </div>

        <?php if (isset($totalCalories)): ?>
            <div class="total-summary">
                <p><strong>إجمالي السعرات:</strong> <?= $totalCalories ?> سعرة حرارية</p>
                <p><?= $message ?></p>
            </div>
        <?php endif; ?>
        
        <button class="calculate-btn" onclick="window.location.href='cart.php'">العودة إلى السلة</button>
    </section>
</body>
</html>
