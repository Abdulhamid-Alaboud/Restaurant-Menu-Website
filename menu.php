<?php
session_start();
include 'db.php';

if (isset($_GET['add_to_cart'])) {
    $item_id = $_GET['add_to_cart'];
    $query = $pdo->prepare("SELECT id, name, price FROM menu_items WHERE id = :id");
    $query->execute(['id' => $item_id]);
    if ($item = $query->fetch()) {
        $_SESSION['cart'][] = $item;
    }
}
?>
<!DOCTYPE html>
<html lang="ar">
<head>
    <meta charset="UTF-8">
    <title>تراثنا حاضرنا | مأكولات شعبية</title>
    <link rel="stylesheet" href="styles.css">
    <script>
        window.onload = () => document.getElementById('cart-count').innerText = <?php echo count($_SESSION['cart'] ?? []); ?>;
    </script>
</head>
<body>
<header>
    <div class="header-container">
        <img src="images/logo.png" alt="شعار المطعم" class="menu-logo">
        <h1>قائمة الطعام</h1>
    </div>
</header>

<nav class="menu-navigation">
    <a href="#main">الأطباق الرئيسية</a>
    <a href="#dessert">الحلويات</a>
    <a href="#drink">المشروبات</a>
</nav>

<a href="cart.php" class="cart-icon">🛒 (<span id="cart-count"><?php echo count($_SESSION['cart'] ?? []); ?></span>)</a>

<?php
$categories = ['main' => 'الأطباق الرئيسية', 'dessert' => 'الحلويات', 'drink' => 'المشروبات'];
foreach ($categories as $category => $title) {
    echo "<section id='$category' class='menu-section'>
            <h2>$title</h2>
            <div class='menu-category'>";
    $query = $pdo->prepare("SELECT id, name, description, price, image FROM menu_items WHERE category = :category");
    $query->execute(['category' => $category]);
    while ($item = $query->fetch()) {
        echo "<div class='menu-item'>
                <img src='images/{$item['image']}' alt='{$item['name']}'>
                <h3>{$item['name']}</h3>
                <p>{$item['description']}</p>
                <p>السعر: {$item['price']} ريال</p>
                <a href='?add_to_cart={$item['id']}' class='btn'>اختر الصنف</a>
              </div>";
    }
    
    echo "</div></section>";
}
?>

<div class="back-to-home-btn-container">
    <a href="index.html" class="btn">العودة إلى الصفحة الرئيسية</a>
</div>

</body>
</html>