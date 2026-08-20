-- --------------------------------------------------------
-- Хост:                     127.0.0.1
-- Версия сервера:              8.4.3 - MySQL Community Server - GPL
-- --------------------------------------------------------

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET NAMES utf8 */;
/*!50503 SET NAMES utf8mb4 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

-- Створення таблиць та вставка даних

DROP TABLE IF EXISTS `clients_yachts`;
CREATE TABLE `clients_yachts` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `full_name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `document_number` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `document_issued_by` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `document_date` date DEFAULT NULL,
  `phone` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `address` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `tax_id` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

REPLACE INTO `clients_yachts` (`id`, `full_name`, `document_number`, `document_issued_by`, `document_date`, `phone`, `email`, `password`, `address`, `tax_id`, `created_at`) VALUES
    (1, 'Іван Іваненко', 'АА 123456', 'Шевченківським РВ УМВС', '2022-11-24', '+380 99 123 4567', 'ivan.ivanenko@example.com', '$2y$12$N12345PlaceholderHashForTestingPurposesOnly00000000000000001', 'м. Київ, вул. Хрещатик, 1', '1234567890', '2026-07-20 11:42:29'),
    (2, 'Шевченко Тарас Григорович', 'АА123456', 'Шевченківським РВ УМВС', '2021-07-22', '+380951234567', 'test@gmail.com', '$2y$12$M12345PlaceholderHashForTestingPurposesOnly00000000000000002', 'м. Київ, вул. Хрещатик, 1', '1234567890', '2026-07-22 16:56:26'),
    (3, 'Шевченко Тарас Григорович', 'АА123456', 'Шевченківським РВ УМВС', '2021-07-22', '+380951234567', 'test2@gmail.com', '$2y$12$M12345PlaceholderHashForTestingPurposesOnly00000000000000002', 'м. Київ, вул. Хрещатик, 1', '1234567890', '2026-07-22 17:00:07');


DROP TABLE IF EXISTS `type_yachts`;
CREATE TABLE `type_yachts` (
  `id_type` bigint unsigned NOT NULL AUTO_INCREMENT,
  `name_type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `short_description` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `full_description` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `image_path` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `max_passengers` int NOT NULL,
  `length` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `width` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `cabins` int NOT NULL,
  `heads` int NOT NULL,
  `engine_power` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `engine_model` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `year` int NOT NULL,
  `condition` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id_type`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

REPLACE INTO `type_yachts` (`id_type`, `name_type`, `short_description`, `full_description`, `image_path`, `max_passengers`, `length`, `width`, `cabins`, `heads`, `engine_power`, `engine_model`, `year`, `condition`, `created_at`, `updated_at`) VALUES
    (1, 'Nordhavn 42', 'Надійна експедиційна яхта для далеких подорожей', 'Повний опис яхти Nordhavn 42: ідеальний вибір для тривалих морських переходів.', 'nordhavn42.jpg', 8, '42 ft', '13 ft', 2, 2, '160 hp', 'Lugger L668D', 2024, 'New', NULL, NULL),
    (2, 'Nordhavn 52', 'Розкішна океанська яхта для тривалих експедицій.', 'Nordhavn 52 — це втілення комфорту та надійності. Вона пропонує більше внутрішнього простору та сучасне обладнання для впевненого переходу через океан.', 'nordhavn52.jpg', 8, '52 ft', '16 ft', 3, 2, '240 hp', 'Lugger L1066T', 2026, 'New', NULL, NULL),
    (3, 'Hallberg-Rassy 370', 'Класична шведська крейсерська яхта для комфортних і безпечних морських подорожей під вітрилами.', 'Hallberg-Rassy 370 поєднує в собі видатну мореплавність, традиційну якість ручної роботи та сучасні технології. Просторий інтер\'єр з червоного дерева забезпечує максимальний затишок у тривалих експедиціях.', 'Hallberg370.jpg', 6, '37 ft', '12 ft', 2, 1, '55 hp', 'Volvo Penta D2-55', 2026, 'New', NULL, NULL),
    (4, 'Beneteau First 30', 'Сучасний легкий гоночний крейсер з акцентом на динаміку та маневреність.', 'Beneteau First 30 — це інноваційна модель, розроблена для тих, хто цінує швидкість, легкість керування та сучасний дизайн у поєднанні з функціональністю.', 'BeneteauFirst30.jpg', 4, '30 ft', '10 ft', 1, 1, '20 hp', 'Yanmar 2YM15', 2026, 'New', NULL, NULL);


DROP TABLE IF EXISTS `yachts`;
CREATE TABLE `yachts` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `year` int NOT NULL,
  `status` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `price_rent` decimal(10,2) NOT NULL,
  `price_buy` decimal(10,2) NOT NULL,
  `last_maintenance` date NOT NULL,
  `type_oper` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `type_id` bigint unsigned NOT NULL,
  `registration_date` date NOT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT '1',
  `comment` text COLLATE utf8mb4_unicode_ci,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

REPLACE INTO `yachts` (`id`, `name`, `year`, `status`, `price_rent`, `price_buy`, `last_maintenance`, `type_oper`, `created_at`, `updated_at`, `type_id`, `registration_date`, `is_active`, `comment`) VALUES
    (1, 'Nordhavn 42 - "Марія"', 2024, 'available', 1200.00, 450000.00, '2026-07-17', 'rent', '2026-07-17 15:26:15', '2026-07-17 15:26:23', 1, '2026-07-17', 1, 'Стандартна комплектація'),
    (2, 'Nordhavn 52 - "Вікторія"', 2025, 'available', 1950.00, 650000.00, '2026-07-17', 'rent', '2026-07-17 15:26:14', '2026-07-17 15:26:24', 2, '2026-07-17', 1, 'Покращена комплектація, Шкіряний салон'),
    (3, 'Nordhavn 42', 2026, 'available', 1200.00, 450000.00, '2026-07-17', 'buy', '2026-07-17 15:24:18', '2026-07-22 14:00:07', 1, '2026-07-17', 1, 'Стандартна комплектація'),
    (4, 'Nordhavn 52', 2026, 'available', 1800.00, 650000.00, '2026-07-17', 'buy', '2026-07-17 15:25:52', '2026-07-17 15:26:25', 2, '2026-07-17', 1, 'Стандартна комплектація'),
    (5, 'Hallberg-Rassy 370', 2026, 'available', 1200.00, 480000.00, '2026-07-23', 'buy', '2026-07-23 09:03:03', '2026-07-23 09:03:05', 3, '2026-07-23', 1, 'Стандартна комплектація'),
    (6, 'Hallberg-Rassy 370 - "G-Start"', 2026, 'available', 1650.00, 480000.00, '2026-07-23', 'rent', '2026-07-23 09:14:32', '2026-07-23 09:14:33', 3, '2026-07-23', 1, 'Покращена комплектація, Салон із водонепроникної тканини, Супутниковий зв\'язок'),
    (7, 'Beneteau First 30', 2026, 'available', 950.00, 195000.00, '2026-07-23', 'buy', '2026-07-23 09:32:18', '2026-07-23 09:32:19', 4, '2026-07-23', 1, 'Стандартна комплектація'),
    (8, 'Beneteau First 30 - "Wind Runner"', 2026, 'available', 950.00, 195000.00, '2026-07-23', 'rent', '2026-07-23 09:35:58', '2026-07-23 09:35:59', 4, '2026-07-23', 1, 'Покращена комплектація, Спортивні вітрила, Карбоновий штурвал'),
    (9, 'Beneteau First 30 - "Sea Breeze"', 2026, 'available', 850.00, 195000.00, '2026-07-23', 'rent', '2026-07-23 09:40:53', '2026-07-23 09:40:54', 4, '2026-07-23', 1, 'Стандартна комплектація');


DROP TABLE IF EXISTS `prodazha_yachts`;
CREATE TABLE `prodazha_yachts` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `yacht_id` bigint unsigned NOT NULL,
  `client_id` bigint unsigned NOT NULL,
  `sale_date` date DEFAULT NULL,
  `amount` decimal(10,2) NOT NULL,
  `status` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

REPLACE INTO `prodazha_yachts` (`id`, `yacht_id`, `client_id`, `sale_date`, `amount`, `status`, `created_at`, `updated_at`) VALUES
    (1, 3, 3, NULL, 450000.00, 'заявка', '2026-07-22 14:00:07', '2026-07-22 14:00:07');


DROP TABLE IF EXISTS `rent_yachts`;
CREATE TABLE `rent_yachts` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `yacht_id` bigint unsigned NOT NULL,
  `client_id` bigint unsigned NOT NULL,
  `start_date` date NOT NULL,
  `end_date` date NOT NULL,
  `operation_date` timestamp NOT NULL,
  `amount` decimal(10,2) NOT NULL,
  `status` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

REPLACE INTO `rent_yachts` (`id`, `yacht_id`, `client_id`, `start_date`, `end_date`, `operation_date`, `amount`, `status`, `created_at`, `updated_at`) VALUES
    (2, 1, 1, '2026-07-21', '2026-07-27', '2026-07-20 11:42:29', 7200.00, 'анульовано', '2025-07-20 08:42:29', '2026-07-21 09:21:02');


DROP TABLE IF EXISTS `yacht_photos`;
CREATE TABLE `yacht_photos` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `type_id` bigint unsigned NOT NULL,
  `image_path` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

REPLACE INTO `yacht_photos` (`id`, `type_id`, `image_path`, `created_at`, `updated_at`) VALUES
    (1, 1, 'KL1.jpg', NULL, NULL),
    (2, 1, 'KL2.jpg', NULL, NULL),
    (3, 1, 'KL3.jpg', NULL, NULL),
    (4, 1, 'KL4.jpg', NULL, NULL),
    (5, 2, 'KLL1.jpg', NULL, NULL),
    (6, 2, 'KLL2.jpg', NULL, NULL),
    (7, 2, 'KLL3.jpg', NULL, NULL),
    (8, 2, 'KLL4.jpg', NULL, NULL),
    (9, 3, 'Hal1.jpg', NULL, NULL),
    (10, 3, 'Hal2.jpg', NULL, NULL),
    (11, 3, 'Hal3.jpg', NULL, NULL),
    (12, 3, 'Hal4.jpg', NULL, NULL),
    (13, 4, 'Ben1.jpg', NULL, NULL),
    (14, 4, 'Ben2.jpg', NULL, NULL),
    (15, 4, 'Ben3.jpg', NULL, NULL),
    (16, 4, 'Ben4.jpg', NULL, NULL);

/*!40103 SET TIME_ZONE=IFNULL(@OLD_TIME_ZONE, 'system') */;
/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IFNULL(@OLD_FOREIGN_KEY_CHECKS, 1) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40111 SET SQL_NOTES=IFNULL(@OLD_SQL_NOTES, 1) */;