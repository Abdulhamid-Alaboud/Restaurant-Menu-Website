<?php
session_start();

if (!isset($_SESSION['cart']) || empty($_SESSION['cart'])) {
    echo "سلة التسوق فارغة. لا يمكن تأكيد الطلب.";
    exit();
}

$totalPrice = 0;
foreach ($_SESSION['cart'] as $item) {
    $quantity = isset($item['quantity']) ? $item['quantity'] : 1;
    $price = isset($item['price']) ? $item['price'] : 0;
    $totalPrice += $price * $quantity;
}

$tax = $totalPrice * 0.15;
$totalWithTax = $totalPrice + $tax;
?>
<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>تأكيد الطلب</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>

<div class="container order-confirmation">
    <img src="images/logo.png" alt="شعار المطعم" class="logo">

    <h1>تأكيد الطلب</h1>

    <form id="order-form">
        <div class="customer-info">
            <div class="info-section">
                <label for="name">اسم العميل:</label>
                <input type="text" id="name" name="name" required>
            </div>
            
            <div class="info-section">
                <label for="phone">رقم الهاتف:</label>
                <input type="text" id="phone" name="phone" required>
            </div>
            
            <div class="info-section">
                <p>طريقة الاستلام:</p>
                <label>
                    <input type="radio" name="delivery_option" value="استلام" onclick="toggleAddressFields(false);" checked>
                    استلام
                </label>
                <label>
                    <input type="radio" name="delivery_option" value="توصيل" onclick="toggleAddressFields(true);">
                    توصيل
                </label>
            </div>

            <div id="address-fields" style="display: none;">
                <label for="address">العنوان:</label>
                <input type="text" id="address" name="address" placeholder="أدخل العنوان الكامل">
            </div>
        </div>

        <h2>تفاصيل الطلب</h2>
        <table>
            <thead>
                <tr>
                    <th>المنتج</th>
                    <th>الكمية</th>
                    <th>السعر</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($_SESSION['cart'] as $item): 
                    $name = isset($item['name']) ? $item['name'] : "اسم غير متوفر";
                    $quantity = isset($item['quantity']) ? $item['quantity'] : 1;
                    $price = isset($item['price']) ? $item['price'] : 0;
                ?>
                    <tr>
                        <td><?= htmlspecialchars($name) ?></td>
                        <td><?= $quantity ?></td>
                        <td><?= $price ?> ريال</td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>

        <div class="total">
            <p><strong>الإجمالي:</strong> <?= $totalPrice ?> ريال</p>
            <p><strong>الضريبة (15%):</strong> <?= number_format($tax, 2) ?> ريال</p>
            <p><strong>الإجمالي مع الضريبة:</strong> <?= number_format($totalWithTax, 2) ?> ريال</p>
        </div>

        <button type="button" class="confirm-btn" onclick="if(validateForm()) submitOrder();">إتمام الطلب</button>
        <a href="cart.php" class="back-to-cart-btn">الرجوع إلى السلة</a>
        <p>شارع التراث، المدينة القديمة، المملكة العربية السعودية</p>

    </form>
</div>

<script>
    function toggleAddressFields(show) {
        const addressFields = document.getElementById('address-fields');
        addressFields.style.display = show ? 'block' : 'none';
    }

    function validateForm() {
        const name = document.getElementById('name').value;
        const phone = document.getElementById('phone').value;

        if (!name || !phone) {
            alert('يرجى ملء جميع الحقول');
            return false;
        }
        return true;
    }

    function submitOrder() {
        alert('شكراً لاتمام طلبك!');
        window.print();
        <?php unset($_SESSION['cart']); ?>
        setTimeout(() => {
            window.location.href = 'index.html';
        }, 5000);
    }
</script>
</body>
</html>
