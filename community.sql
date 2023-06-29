-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Počítač: localhost
-- Vytvořeno: Ned 20. lis 2022, 16:52
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
-- Struktura tabulky `community`
--

CREATE TABLE `community` (
  `id` int(11) NOT NULL,
  `author` int(11) NOT NULL,
  `url` int(11) DEFAULT NULL,
  `content` varchar(9999) COLLATE utf8_czech_ci NOT NULL,
  `like_ids` varchar(1024) COLLATE utf8_czech_ci DEFAULT '',
  `dislike_ids` varchar(1024) COLLATE utf8_czech_ci DEFAULT '',
  `created_at` int(11) NOT NULL,
  `updated_at` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_czech_ci;

--
-- Vypisuji data pro tabulku `community`
--

INSERT INTO `community` (`id`, `author`, `url`, `content`, `like_ids`, `dislike_ids`, `created_at`, `updated_at`) VALUES
(1, 952988803, 77234, '[H4]Supermarkety hledají způsoby, jak si udržet zákazníky. Ve Francii stropují ceny[/H4]\r\n\r\nRůst spotřebitelských cen sužuje celou Evropu. Kromě energií citelně zdražují také potraviny, a to od kávy, oleje, mouky přes pečivo až po kečup. Maloobchody s potravinami tak v obavě, aby nepřišly o zákazníky, zvažují zastropování cen na základní potraviny. Na podobná opatření ale budou mít do jisté míry vliv také složitá jednání s velkými výrobci balených potravin. Informovala o tom agentura Reuters.\r\n\r\n[Img]https://d15-a.sdn.cz/d_15/c_img_QM_r/4x2DiM.jpeg?fl=cro,0,70,1280,720%7Cres,2560,,1%7Cwebp,75[/Img]\r\n\r\nŠéf největšího francouzského maloobchodního řetězce E.Leclerc v úterý uvedl, že firma identifikuje 120 výrobků, které spotřebitelé nejčastěji kupují, včetně toaletního papíru, mýdla, rýže nebo těstovin, a vytvoří cenový „štít“, který bude garantovat stejné ceny od 4. května až do července.\r\n\r\nVe Velké Británii zase snížily ceny u několika základních potravin dva řetězce Asda a Morrisons, uvedla Reuters.\r\n\r\n[Qt]Vzhledem k velmi konkurenční povaze trhu s potravinami uvidíte, jak se další řetězce supermarketů budou snažit držet ceny tak nízko, jak jen to půjde[/Qt]', '', '', 1651867074, 1651867074),
(2, 952988803, 87041, '[content-center][Img]../../../../public/img/user/952988803/images/5824494.jpg[/Img][/content-center]\r\n[Style-orange]Nějaký obrázek ;)[/Style]', '8,3', '', 1651867667, 1652228319),
(8, 952988803, 12302, 'Včelstva v Česku přečkala letošní zimu bez větších ztrát a včelaři odhadují, že letošní včelařský rok bude dobrý. Loni i předloni bylo hůř: v zimě tehdy uhynula až polovina českých včel.\r\n\r\n', '', '', 1652233148, 1652233148);

--
-- Indexy pro exportované tabulky
--

--
-- Indexy pro tabulku `community`
--
ALTER TABLE `community`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT pro tabulky
--

--
-- AUTO_INCREMENT pro tabulku `community`
--
ALTER TABLE `community`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
