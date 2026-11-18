-- Database schema and sample seed data for Restaurant Menu & Ordering System
-- Compatible with MySQL 8.0+ / MariaDB (XAMPP)

CREATE DATABASE IF NOT EXISTS `restaurant`
  CHARACTER SET utf8mb4
  COLLATE utf8mb4_unicode_ci;

USE `restaurant`;

DROP TABLE IF EXISTS `menu_items`;

CREATE TABLE `menu_items` (
  `id` INT AUTO_INCREMENT PRIMARY KEY,
  `name` VARCHAR(255) NOT NULL,
  `description` TEXT,
  `price` DECIMAL(10,2) NOT NULL,
  `image` VARCHAR(255) NOT NULL,
  `category` ENUM('main', 'dessert', 'drink') NOT NULL,
  `calories` INT NOT NULL DEFAULT 0,
  INDEX `idx_category` (`category`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Sample traditional menu items matching assets in ./images/
INSERT INTO `menu_items` (`name`, `description`, `price`, `image`, `category`, `calories`) VALUES
('مغش لحم', 'لحم طازج مطهو على الطريقة الجنوبية التقليدية مع الخضار والتوابل.', 55.00, 'مغش.jpg', 'main', 620),
('جريش', 'جريش سعودي تقليدي مطهو باللبن والزبدة مع الكشنة.', 32.00, 'جريش.jpg', 'main', 410),
('مرقوق', 'رقائق عجين البر المطهوة مع اللحم والخضار الطازجة.', 38.00, 'مرقوق.jpg', 'main', 480),
('سليق', 'أرز أبيض كريمي مطهو بالحليب والسمن البري.', 42.00, 'سليق.jpg', 'main', 540),
('رز حساوي', 'أرز حساوي أحمر فاخر متبل بالبهارات الأصيلة.', 45.00, 'رز حساوي.jpg', 'main', 460),
('ثريد', 'خبز تقليدي مشرب بمرق اللحم والخضار.', 36.00, 'ثريد.jpg', 'main', 430),
('هريسة', 'قمح مهروس ومطهو ببطء مع اللحم والسمن.', 34.00, 'هريسة.jpg', 'main', 450),
('عريكة جنوبية', 'عريكة بالتمر والسمن والعسل الطبيعي.', 28.00, 'عريكة جنوبية.jpg', 'dessert', 520),
('مرسة', 'خبز مفتوت بالموز والعسل والسمن البلدي.', 25.00, 'مرسة.jpg', 'dessert', 470),
('مفالت', 'رقائق تقليدية محلاة بالحليب والعسل.', 22.00, 'مفالت.jpg', 'dessert', 390),
('ممروس', 'حلى شعبي غني بالتمر والدقيق المحمص والسمن.', 24.00, 'ممروس.jpg', 'dessert', 440),
('ساقو', 'حلى الساقو الخليجي بالهيل والزعفران.', 20.00, 'ساقو.jpg', 'dessert', 320),
('لبن طازج', 'لبن بلدي بارد ومنعش.', 8.00, 'لبن.jpg', 'drink', 110),
('شاي لومي', 'شاي الليمون الأسود الساخن المعطر.', 7.00, 'لومي.jpg', 'drink', 45),
('ماء', 'مياه شرب نقية مبردة.', 3.00, 'ماء.jpg', 'drink', 0);
