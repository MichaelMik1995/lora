-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Počítač: localhost
-- Vytvořeno: Pon 02. kvě 2022, 10:06
-- Verze serveru: 10.4.22-MariaDB
-- Verze PHP: 8.1.1

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Databáze: `lora`
--

-- --------------------------------------------------------

--
-- Struktura tabulky `mshop-archive`
--

CREATE TABLE `mshop-archive` (
  `id` int(11) NOT NULL,
  `product_name` varchar(256) COLLATE utf8_czech_ci NOT NULL,
  `type` int(11) DEFAULT 0 COMMENT '0-base product,\r\n1-virtual product',
  `price` float NOT NULL,
  `quantity` int(11) NOT NULL,
  `grouping` int(11) NOT NULL DEFAULT 0,
  `visibility` int(11) NOT NULL DEFAULT 0,
  `status` int(11) NOT NULL DEFAULT 1,
  `evaluation` float NOT NULL DEFAULT 0,
  `is_action` int(11) DEFAULT 0,
  `action_prize` float DEFAULT 0,
  `stock_code` tinytext COLLATE utf8_czech_ci NOT NULL,
  `recommended` int(1) NOT NULL DEFAULT 0,
  `in_stock` int(11) DEFAULT 1,
  `short_description` varchar(256) COLLATE utf8_czech_ci DEFAULT NULL,
  `description` varchar(9999) COLLATE utf8_czech_ci DEFAULT NULL,
  `subcategory` tinytext COLLATE utf8_czech_ci NOT NULL,
  `tags` varchar(5120) COLLATE utf8_czech_ci DEFAULT NULL,
  `buyed` int(11) NOT NULL DEFAULT 0,
  `visited` int(11) NOT NULL DEFAULT 0,
  `created_at` int(11) NOT NULL,
  `updated_at` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_czech_ci;

-- --------------------------------------------------------

--
-- Struktura tabulky `mshop-basket`
--

CREATE TABLE `mshop-basket` (
  `id` int(11) NOT NULL,
  `orderer` tinytext COLLATE utf8_czech_ci NOT NULL,
  `product_code` varchar(64) COLLATE utf8_czech_ci NOT NULL,
  `quantity` int(11) NOT NULL,
  `created_at` int(11) NOT NULL,
  `updated_at` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_czech_ci;

-- --------------------------------------------------------

--
-- Struktura tabulky `mshop-branch`
--

CREATE TABLE `mshop-branch` (
  `id` int(11) NOT NULL,
  `name` varchar(65) COLLATE utf8_czech_ci NOT NULL,
  `address` varchar(128) COLLATE utf8_czech_ci NOT NULL,
  `slug` varchar(65) COLLATE utf8_czech_ci NOT NULL,
  `url` varchar(256) COLLATE utf8_czech_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_czech_ci;

-- --------------------------------------------------------

--
-- Struktura tabulky `mshop-category`
--

CREATE TABLE `mshop-category` (
  `id` int(11) NOT NULL,
  `category_name` text COLLATE utf8_czech_ci NOT NULL,
  `category_slug` tinytext COLLATE utf8_czech_ci NOT NULL,
  `created_at` int(11) NOT NULL,
  `updated_at` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_czech_ci;

-- --------------------------------------------------------

--
-- Struktura tabulky `mshop-customers`
--

CREATE TABLE `mshop-customers` (
  `id` int(11) NOT NULL,
  `uid` int(11) NOT NULL,
  `name` varchar(65) COLLATE utf8_czech_ci NOT NULL,
  `email` varchar(65) COLLATE utf8_czech_ci NOT NULL,
  `email_verified_at` int(11) NOT NULL DEFAULT 0,
  `password` varchar(61) COLLATE utf8_czech_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_czech_ci;

-- --------------------------------------------------------

--
-- Struktura tabulky `mshop-members`
--

CREATE TABLE `mshop-members` (
  `id` int(11) NOT NULL,
  `uid` int(11) NOT NULL,
  `name` varchar(65) COLLATE utf8_czech_ci NOT NULL,
  `email` varchar(65) COLLATE utf8_czech_ci NOT NULL,
  `email_verified_at` int(11) NOT NULL DEFAULT 0,
  `password` varchar(61) COLLATE utf8_czech_ci NOT NULL,
  `registration_date` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_czech_ci;

-- --------------------------------------------------------

--
-- Struktura tabulky `mshop-options`
--

CREATE TABLE `mshop-options` (
  `id` int(11) NOT NULL,
  `param` tinytext COLLATE utf8_czech_ci NOT NULL,
  `value` varchar(512) COLLATE utf8_czech_ci NOT NULL,
  `description` varchar(2048) COLLATE utf8_czech_ci NOT NULL,
  `created_at` int(11) NOT NULL,
  `updated_at` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_czech_ci;

-- --------------------------------------------------------

--
-- Struktura tabulky `mshop-order-products`
--

CREATE TABLE `mshop-order-products` (
  `id` int(11) NOT NULL,
  `order_id` int(11) NOT NULL,
  `product_code` varchar(64) COLLATE utf8_czech_ci NOT NULL,
  `quantity` int(11) NOT NULL,
  `created_at` int(11) NOT NULL,
  `updated_at` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_czech_ci;

-- --------------------------------------------------------

--
-- Struktura tabulky `mshop-orders`
--

CREATE TABLE `mshop-orders` (
  `id` int(11) NOT NULL,
  `order_id` int(11) NOT NULL,
  `ip_orderer` varchar(32) COLLATE utf8_czech_ci NOT NULL,
  `name` varchar(65) COLLATE utf8_czech_ci DEFAULT NULL,
  `surname` varchar(65) COLLATE utf8_czech_ci DEFAULT NULL,
  `city` varchar(128) COLLATE utf8_czech_ci DEFAULT NULL,
  `address` varchar(512) COLLATE utf8_czech_ci DEFAULT NULL,
  `country` varchar(10) COLLATE utf8_czech_ci DEFAULT NULL,
  `post_code` varchar(9) COLLATE utf8_czech_ci DEFAULT NULL,
  `phone` varchar(26) COLLATE utf8_czech_ci DEFAULT NULL,
  `email` varchar(128) COLLATE utf8_czech_ci DEFAULT NULL,
  `delivery_type` varchar(65) COLLATE utf8_czech_ci DEFAULT NULL,
  `delivery_param` varchar(128) COLLATE utf8_czech_ci DEFAULT NULL,
  `note` text COLLATE utf8_czech_ci DEFAULT NULL,
  `created_at` int(11) NOT NULL,
  `expirated_at` int(11) NOT NULL,
  `solved` int(11) NOT NULL DEFAULT 0,
  `status` int(2) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_czech_ci;

-- --------------------------------------------------------

--
-- Struktura tabulky `mshop-product-discussion`
--

CREATE TABLE `mshop-product-discussion` (
  `id` int(11) NOT NULL,
  `url` varchar(64) COLLATE utf8_czech_ci NOT NULL,
  `title` varchar(128) COLLATE utf8_czech_ci NOT NULL,
  `author` varchar(128) COLLATE utf8_czech_ci NOT NULL,
  `content` varchar(2048) COLLATE utf8_czech_ci NOT NULL,
  `for_company` int(1) NOT NULL,
  `reported` int(11) NOT NULL DEFAULT 0,
  `solved` int(1) NOT NULL DEFAULT 0,
  `created_at` int(11) NOT NULL,
  `updated_at` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_czech_ci;

-- --------------------------------------------------------

--
-- Struktura tabulky `mshop-product-discussion-comments`
--

CREATE TABLE `mshop-product-discussion-comments` (
  `id` int(11) NOT NULL,
  `disscussion_id` int(11) NOT NULL,
  `author` varchar(65) COLLATE utf8_czech_ci NOT NULL,
  `content` varchar(2048) COLLATE utf8_czech_ci NOT NULL,
  `reported` int(11) NOT NULL,
  `created_at` int(11) NOT NULL,
  `updated_at` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_czech_ci;

-- --------------------------------------------------------

--
-- Struktura tabulky `mshop-products`
--

CREATE TABLE `mshop-products` (
  `id` int(11) NOT NULL,
  `product_name` varchar(256) COLLATE utf8_czech_ci NOT NULL,
  `type` int(11) DEFAULT 0 COMMENT '0-base product,\r\n1-virtual product',
  `price` float NOT NULL,
  `quantity` int(11) NOT NULL,
  `grouping` int(11) NOT NULL DEFAULT 0,
  `visibility` int(11) NOT NULL DEFAULT 0,
  `status` int(11) NOT NULL DEFAULT 1,
  `evaluation` float NOT NULL DEFAULT 0,
  `is_action` int(11) DEFAULT 0,
  `action_prize` float DEFAULT 0,
  `stock_code` tinytext COLLATE utf8_czech_ci NOT NULL,
  `recommended` int(1) NOT NULL DEFAULT 0,
  `in_stock` int(11) DEFAULT 1,
  `short_description` varchar(256) COLLATE utf8_czech_ci DEFAULT NULL,
  `description` varchar(9999) COLLATE utf8_czech_ci DEFAULT NULL,
  `subcategory` tinytext COLLATE utf8_czech_ci NOT NULL,
  `tags` varchar(5120) COLLATE utf8_czech_ci DEFAULT NULL,
  `buyed` int(11) NOT NULL DEFAULT 0,
  `visited` int(11) NOT NULL DEFAULT 0,
  `created_at` int(11) NOT NULL,
  `updated_at` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_czech_ci;

-- --------------------------------------------------------

--
-- Struktura tabulky `mshop-roles`
--

CREATE TABLE `mshop-roles` (
  `id` int(11) NOT NULL,
  `name` tinytext COLLATE utf8_czech_ci NOT NULL,
  `slug` varchar(65) COLLATE utf8_czech_ci NOT NULL,
  `description` varchar(512) COLLATE utf8_czech_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_czech_ci;

-- --------------------------------------------------------

--
-- Struktura tabulky `mshop-state`
--

CREATE TABLE `mshop-state` (
  `id` int(11) NOT NULL,
  `name` varchar(128) COLLATE utf8_czech_ci NOT NULL,
  `slug` varchar(32) COLLATE utf8_czech_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_czech_ci;

-- --------------------------------------------------------

--
-- Struktura tabulky `mshop-statistic`
--

CREATE TABLE `mshop-statistic` (
  `id` int(11) NOT NULL,
  `param` tinytext COLLATE utf8_czech_ci NOT NULL,
  `value` varchar(512) COLLATE utf8_czech_ci NOT NULL,
  `description` varchar(2048) COLLATE utf8_czech_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_czech_ci;

--
-- Vypisuji data pro tabulku `mshop-statistic`
--

INSERT INTO `mshop-statistic` (`id`, `param`, `value`, `description`) VALUES
(1, 'total_price', '0', 'Celkově prodaná suma'),
(2, 'total_buyed_products', '0', 'Celkově prodaných produktů'),
(3, 'products_created', '0', 'Založeno produktů'),
(4, 'products_validated', '0', 'Zvalidovaných produktů'),
(5, 'count_orders', '0', 'Celkový počet objednávek'),
(6, 'removed_products', '0', 'Smazáno produktů');

-- --------------------------------------------------------

--
-- Struktura tabulky `mshop-subcategory`
--

CREATE TABLE `mshop-subcategory` (
  `id` int(11) NOT NULL,
  `subcategory_name` varchar(256) COLLATE utf8_czech_ci NOT NULL,
  `subcategory_slug` varchar(65) COLLATE utf8_czech_ci NOT NULL,
  `category_id` tinytext COLLATE utf8_czech_ci NOT NULL,
  `buyed_in_category` int(11) NOT NULL DEFAULT 0,
  `created_at` int(11) NOT NULL,
  `updated_at` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_czech_ci;

-- --------------------------------------------------------

--
-- Struktura tabulky `mshop-tags`
--

CREATE TABLE `mshop-tags` (
  `id` int(11) NOT NULL,
  `tagname` varchar(65) COLLATE utf8_czech_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_czech_ci;

-- --------------------------------------------------------

--
-- Struktura tabulky `mshop-transport`
--

CREATE TABLE `mshop-transport` (
  `id` int(11) NOT NULL,
  `type` varchar(65) COLLATE utf8_unicode_ci NOT NULL,
  `slug` varchar(65) COLLATE utf8_unicode_ci NOT NULL,
  `cost` int(11) DEFAULT NULL,
  `description` varchar(2048) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Vypisuji data pro tabulku `mshop-transport`
--

INSERT INTO `mshop-transport` (`id`, `type`, `slug`, `cost`, `description`) VALUES
(1, 'Platba při převzetí', 'platba-pri-prevzeti', 60, 'Zboží Vám zašleme na Vámi zadanou adresu a vy jej zaplatíte při převzetí. Transport zajišťuje firma Česká Pošta'),
(2, 'Platba předem', 'platba-predem', 60, 'Zaplaťte předem na účet: XXXXXXXXXXXX/0100. Po úspěšném obdržení platby Vám zboší zašleme na Vámi uvedenou adresu'),
(3, 'Vyzvednutí na pobočce', 'vyzvednuti-na-pobocce', 0, 'Zboží si můžete převzít osobně na nejbližší pobočce. Při zvolení této možnosti za dopravu nic nemusíte platit');

-- --------------------------------------------------------

--
-- Struktura tabulky `mshop-user-orders`
--

CREATE TABLE `mshop-user-orders` (
  `id` int(11) NOT NULL,
  `order_id` int(11) NOT NULL,
  `name` varchar(65) COLLATE utf8_czech_ci DEFAULT NULL,
  `surname` varchar(65) COLLATE utf8_czech_ci DEFAULT NULL,
  `city` varchar(128) COLLATE utf8_czech_ci DEFAULT NULL,
  `address` varchar(512) COLLATE utf8_czech_ci DEFAULT NULL,
  `country` varchar(10) COLLATE utf8_czech_ci DEFAULT NULL,
  `post_code` varchar(9) COLLATE utf8_czech_ci DEFAULT NULL,
  `phone` varchar(26) COLLATE utf8_czech_ci DEFAULT NULL,
  `email` varchar(128) COLLATE utf8_czech_ci DEFAULT NULL,
  `delivery_type` varchar(65) COLLATE utf8_czech_ci DEFAULT NULL,
  `delivery_param` varchar(128) COLLATE utf8_czech_ci DEFAULT NULL,
  `note` text COLLATE utf8_czech_ci DEFAULT NULL,
  `created_at` int(11) NOT NULL,
  `status` int(2) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_czech_ci;

--
-- Indexy pro exportované tabulky
--

--
-- Indexy pro tabulku `mshop-archive`
--
ALTER TABLE `mshop-archive`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `stock_code` (`stock_code`) USING HASH;

--
-- Indexy pro tabulku `mshop-branch`
--
ALTER TABLE `mshop-branch`
  ADD PRIMARY KEY (`id`);

--
-- Indexy pro tabulku `mshop-category`
--
ALTER TABLE `mshop-category`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `category_name` (`category_name`,`category_slug`) USING HASH;

--
-- Indexy pro tabulku `mshop-order-products`
--
ALTER TABLE `mshop-order-products`
  ADD PRIMARY KEY (`id`);

--
-- Indexy pro tabulku `mshop-orders`
--
ALTER TABLE `mshop-orders`
  ADD PRIMARY KEY (`id`);

--
-- Indexy pro tabulku `mshop-product-discussion`
--
ALTER TABLE `mshop-product-discussion`
  ADD PRIMARY KEY (`id`);

--
-- Indexy pro tabulku `mshop-products`
--
ALTER TABLE `mshop-products`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `stock_code` (`stock_code`) USING HASH;

--
-- Indexy pro tabulku `mshop-roles`
--
ALTER TABLE `mshop-roles`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `slug` (`slug`);

--
-- Indexy pro tabulku `mshop-state`
--
ALTER TABLE `mshop-state`
  ADD PRIMARY KEY (`id`);

--
-- Indexy pro tabulku `mshop-statistic`
--
ALTER TABLE `mshop-statistic`
  ADD PRIMARY KEY (`id`);

--
-- Indexy pro tabulku `mshop-subcategory`
--
ALTER TABLE `mshop-subcategory`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `subcategory_slug` (`subcategory_slug`),
  ADD UNIQUE KEY `subcategory_slug_2` (`subcategory_slug`),
  ADD UNIQUE KEY `subcategory_name` (`subcategory_name`);

--
-- Indexy pro tabulku `mshop-tags`
--
ALTER TABLE `mshop-tags`
  ADD PRIMARY KEY (`id`);

--
-- Indexy pro tabulku `mshop-transport`
--
ALTER TABLE `mshop-transport`
  ADD PRIMARY KEY (`id`);

--
-- Indexy pro tabulku `mshop-user-orders`
--
ALTER TABLE `mshop-user-orders`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT pro tabulky
--

--
-- AUTO_INCREMENT pro tabulku `mshop-archive`
--
ALTER TABLE `mshop-archive`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pro tabulku `mshop-branch`
--
ALTER TABLE `mshop-branch`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pro tabulku `mshop-category`
--
ALTER TABLE `mshop-category`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pro tabulku `mshop-order-products`
--
ALTER TABLE `mshop-order-products`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pro tabulku `mshop-orders`
--
ALTER TABLE `mshop-orders`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pro tabulku `mshop-product-discussion`
--
ALTER TABLE `mshop-product-discussion`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pro tabulku `mshop-products`
--
ALTER TABLE `mshop-products`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pro tabulku `mshop-roles`
--
ALTER TABLE `mshop-roles`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pro tabulku `mshop-state`
--
ALTER TABLE `mshop-state`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pro tabulku `mshop-statistic`
--
ALTER TABLE `mshop-statistic`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT pro tabulku `mshop-subcategory`
--
ALTER TABLE `mshop-subcategory`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pro tabulku `mshop-tags`
--
ALTER TABLE `mshop-tags`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pro tabulku `mshop-transport`
--
ALTER TABLE `mshop-transport`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT pro tabulku `mshop-user-orders`
--
ALTER TABLE `mshop-user-orders`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
