-- phpMyAdmin SQL Dump
-- version 5.0.2
-- https://www.phpmyadmin.net/
--
-- Хост: mysql
-- Время создания: Июл 14 2020 г., 06:14
-- Версия сервера: 8.0.20
-- Версия PHP: 7.4.5

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- База данных: `group404`
--
CREATE DATABASE IF NOT EXISTS `group404` DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci;
USE `group404`;

-- --------------------------------------------------------

--
-- Структура таблицы `urls`
--

CREATE TABLE `urls` (
  `id` int NOT NULL,
  `url` varchar(500) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `url_code` varchar(10) CHARACTER SET utf8 COLLATE utf8_general_ci DEFAULT NULL,
  `users_id` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Очистить таблицу перед добавлением данных `urls`
--

TRUNCATE TABLE `urls`;
--
-- Дамп данных таблицы `urls`
--

INSERT INTO `urls` (`id`, `url`, `url_code`, `users_id`) VALUES
(1, 'http://www.test.com/', '1', 1),
(2, 'http://www.abc.com/', '2', 1),
(3, 'http://google.com/', '3', 1),
(4, 'http://aaa.com/', '4', 1),
(5, 'http://test1.com/', '5', 1),
(6, 'http://shortlinks.local/404error', '6', 1),
(7, 'http://test.com/readas', '7', 1),
(8, 'http://test.com/', '8', 1),
(9, 'http://oper.com', '9', 1),
(10, 'https://auto.ru/cars/new/group/lexus/ux/21475035/21475267/1098576348-07a7b139/', 'a', 1),
(11, 'https://yandex.ru/search/?text=%D0%B6%D0%B8%D0%B7%D0%BD%D1%8C%20%D0%B4%D1%8D%D0%B2%D0%B8%D0%B4%D0%B0%20%D0%B3%D0%B5%D0%B9%D0%BB%D0%B0&lr=2', 'b', 1),
(112, 'https://getbootstrap.com/docs/4.0/getting-started/introduction/', '1O', 1),
(113, 'https://wiki.php.net/rfc/throwable_string_param_max_len#backward_incompatible_changes', '1P', 1),
(1114, 'https://gerrit.wikimedia.org/g/mediawiki/tools/phan/SecurityCheckPlugin/#mediawiki-security-check-plugin', 'hY', 1),
(1115, 'https://gerrit.wikimedia.org/r/plugins/gitiles/mediawiki/tools/phan/SecurityCheckPlugin/+/refs/tags/1.5.1', 'hZ', 1),
(11116, 'https://gerrit.wikimedia.org/r/plugins/gitiles/mediawiki/tools/phan/SecurityCheckPlugin/+/refs/tags/3.0.0', '2Ti', 1);

-- --------------------------------------------------------

--
-- Структура таблицы `urls_stats`
--

CREATE TABLE `urls_stats` (
  `id` int NOT NULL,
  `url_id` int NOT NULL,
  `ip_id` int DEFAULT NULL,
  `token_id` int DEFAULT NULL,
  `agent_id` int DEFAULT NULL,
  `referrer_id` int DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Очистить таблицу перед добавлением данных `urls_stats`
--

TRUNCATE TABLE `urls_stats`;
--
-- Дамп данных таблицы `urls_stats`
--

INSERT INTO `urls_stats` (`id`, `url_id`, `ip_id`, `token_id`, `agent_id`, `referrer_id`, `created_at`) VALUES
(3, 1, 2, 0, 9, 2, '2020-07-13 11:37:11'),
(5, 2, 2, 0, 9, 2, '2020-07-13 12:14:57'),
(6, 3, 2, 0, 9, 2, '2020-07-13 12:15:59'),
(9, 5, 2, 0, 10, 2, '2020-07-13 12:33:09'),
(10, 1, 2, 1, 9, 22, '2020-07-13 13:22:16'),
(11, 9, 2, NULL, 9, 2, '2020-07-13 13:31:18'),
(12, 8, 2, NULL, 9, 2, '2020-07-13 13:32:12'),
(13, 9, 2, NULL, 43, 2, '2020-07-13 13:35:27'),
(14, 1, 2, NULL, 9, 2, '2020-07-13 16:33:37'),
(15, 6, 2, NULL, 9, 2, '2020-07-13 16:37:28'),
(16, 6, 2, NULL, 9, 2, '2020-07-13 16:37:31'),
(17, 6, 2, NULL, 9, 2, '2020-07-13 16:37:34'),
(18, 6, 2, NULL, 9, 2, '2020-07-13 16:37:37'),
(19, 6, 2, NULL, 9, 2, '2020-07-13 16:37:40'),
(20, 6, 2, NULL, 9, 2, '2020-07-13 16:38:35'),
(21, 6, 2, NULL, 9, 2, '2020-07-13 16:38:51'),
(22, 6, 2, NULL, 9, 2, '2020-07-13 16:40:12'),
(23, 6, 2, NULL, 9, 2, '2020-07-13 16:40:14'),
(24, 6, 2, NULL, 9, 2, '2020-07-13 16:40:15'),
(25, 6, 2, NULL, 9, 2, '2020-07-13 16:40:16'),
(26, 6, 2, NULL, 9, 2, '2020-07-13 16:40:17'),
(27, 6, 2, NULL, 9, 2, '2020-07-13 16:40:19'),
(28, 6, 0, NULL, 0, 0, '2020-07-13 16:40:19'),
(29, 6, 2, NULL, 9, 2, '2020-07-13 16:40:20'),
(30, 6, 0, NULL, 0, 0, '2020-07-13 16:40:20'),
(31, 6, 2, NULL, 9, 2, '2020-07-13 16:40:59'),
(32, 6, 2, NULL, 9, 2, '2020-07-13 16:41:01'),
(33, 6, 0, NULL, 0, 0, '2020-07-13 16:41:01'),
(34, 6, 2, NULL, 9, 2, '2020-07-13 16:41:02'),
(35, 6, 0, NULL, 0, 0, '2020-07-13 16:41:02'),
(36, 6, 2, NULL, 9, 2, '2020-07-13 16:41:17'),
(37, 6, 2, NULL, 9, 2, '2020-07-13 16:41:18'),
(38, 6, 2, NULL, 9, 2, '2020-07-13 16:42:01'),
(39, 6, 2, NULL, 9, 2, '2020-07-13 16:43:11'),
(40, 6, 2, NULL, 9, 2, '2020-07-13 16:44:03'),
(41, 6, 2, NULL, 9, 2, '2020-07-13 16:44:04'),
(42, 6, 2, NULL, 9, 2, '2020-07-13 16:45:01'),
(43, 6, 2, NULL, 9, 2, '2020-07-13 16:45:23'),
(44, 6, 2, NULL, 9, 2, '2020-07-13 16:47:29'),
(45, 6, 2, NULL, 9, 2, '2020-07-13 16:47:33'),
(46, 6, 2, NULL, 9, 2, '2020-07-13 16:50:57'),
(47, 6, 2, NULL, 9, 2, '2020-07-13 16:51:03'),
(48, 6, 2, NULL, 9, 2, '2020-07-13 16:51:05'),
(49, 6, 2, NULL, 9, 2, '2020-07-13 16:51:07'),
(50, 6, 2, NULL, 9, 2, '2020-07-13 16:51:34'),
(51, 6, 2, NULL, 9, 2, '2020-07-13 16:52:41'),
(52, 6, 2, NULL, 9, 2, '2020-07-13 16:52:42'),
(53, 6, 2, NULL, 9, 2, '2020-07-13 16:52:43'),
(54, 6, 2, NULL, 9, 2, '2020-07-13 16:53:19'),
(55, 6, 2, NULL, 9, 2, '2020-07-13 16:53:24'),
(56, 6, 2, NULL, 9, 2, '2020-07-13 16:53:25'),
(57, 6, 2, NULL, 9, 2, '2020-07-13 16:53:27'),
(58, 6, 2, NULL, 9, 2, '2020-07-13 16:53:28'),
(59, 6, 2, NULL, 9, 2, '2020-07-13 16:53:47'),
(60, 6, 2, NULL, 9, 2, '2020-07-13 16:53:48'),
(61, 6, 2, NULL, 9, 2, '2020-07-13 16:53:49'),
(62, 6, 2, NULL, 9, 2, '2020-07-13 16:53:50'),
(63, 6, 0, NULL, 0, 0, '2020-07-13 16:53:50'),
(64, 6, 2, NULL, 9, 2, '2020-07-13 16:53:58'),
(65, 6, 2, NULL, 9, 2, '2020-07-13 17:03:19'),
(66, 6, 2, NULL, 9, 2, '2020-07-13 17:04:21'),
(67, 6, 2, NULL, 9, 2, '2020-07-13 17:04:42'),
(68, 6, 2, NULL, 9, 2, '2020-07-13 17:06:26'),
(69, 6, 2, NULL, 9, 2, '2020-07-13 17:06:28'),
(70, 6, 2, NULL, 9, 2, '2020-07-13 17:06:39'),
(71, 6, 2, NULL, 9, 2, '2020-07-13 17:06:41'),
(72, 6, 2, NULL, 9, 2, '2020-07-13 17:07:15'),
(73, 6, 2, NULL, 9, 2, '2020-07-13 17:07:31'),
(74, 6, 2, NULL, 9, 2, '2020-07-13 17:07:38'),
(75, 6, 2, NULL, 9, 2, '2020-07-13 17:18:55'),
(76, 6, 2, NULL, 9, 2, '2020-07-13 17:19:19'),
(77, 6, 2, NULL, 9, 2, '2020-07-13 17:19:21'),
(78, 6, 2, NULL, 9, 2, '2020-07-13 17:19:22'),
(79, 6, 2, NULL, 9, 2, '2020-07-13 17:19:23'),
(80, 6, 0, NULL, 0, 0, '2020-07-13 17:19:23'),
(81, 6, 2, NULL, 9, 2, '2020-07-13 17:19:24'),
(82, 11, 2, NULL, 9, 2, '2020-07-13 19:38:31'),
(83, 4, 2, NULL, 9, 2, '2020-07-13 19:59:55'),
(84, 1114, 2, NULL, 9, 2, '2020-07-13 20:20:41'),
(85, 11116, 2, NULL, 9, 2, '2020-07-13 20:22:42');

-- --------------------------------------------------------

--
-- Структура таблицы `urls_stats_agents`
--

CREATE TABLE `urls_stats_agents` (
  `id` int NOT NULL,
  `user_agent` varchar(500) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `inserted_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Очистить таблицу перед добавлением данных `urls_stats_agents`
--

TRUNCATE TABLE `urls_stats_agents`;
--
-- Дамп данных таблицы `urls_stats_agents`
--

INSERT INTO `urls_stats_agents` (`id`, `user_agent`, `inserted_at`) VALUES
(9, 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/83.0.4103.116 Safari/537.36', '2020-07-13 11:07:49'),
(10, 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:76.0) Gecko/20100101 Firefox/76.0', '2020-07-13 11:08:10'),
(43, 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/70.0.3538.102 Safari/537.36 Edge/18.18363', '2020-07-13 13:35:27');

-- --------------------------------------------------------

--
-- Структура таблицы `urls_stats_ips`
--

CREATE TABLE `urls_stats_ips` (
  `id` int NOT NULL,
  `user_ip` varchar(50) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `inserted_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Очистить таблицу перед добавлением данных `urls_stats_ips`
--

TRUNCATE TABLE `urls_stats_ips`;
--
-- Дамп данных таблицы `urls_stats_ips`
--

INSERT INTO `urls_stats_ips` (`id`, `user_ip`, `inserted_at`) VALUES
(2, '172.19.0.1', '2020-07-13 11:08:10');

-- --------------------------------------------------------

--
-- Структура таблицы `urls_stats_referrers`
--

CREATE TABLE `urls_stats_referrers` (
  `id` int NOT NULL,
  `user_referrer` varchar(500) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `inserted_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Очистить таблицу перед добавлением данных `urls_stats_referrers`
--

TRUNCATE TABLE `urls_stats_referrers`;
--
-- Дамп данных таблицы `urls_stats_referrers`
--

INSERT INTO `urls_stats_referrers` (`id`, `user_referrer`, `inserted_at`) VALUES
(2, '', '2020-07-13 11:08:10'),
(22, 'http://shortlinks.local/', '2020-07-13 13:22:16');

-- --------------------------------------------------------

--
-- Структура таблицы `users`
--

CREATE TABLE `users` (
  `id` int NOT NULL,
  `first_name` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `second_name` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Очистить таблицу перед добавлением данных `users`
--

TRUNCATE TABLE `users`;
--
-- Дамп данных таблицы `users`
--

INSERT INTO `users` (`id`, `first_name`, `second_name`) VALUES
(1, 'Invan', 'Ivanov'),
(2, 'Peter', 'Petrov'),
(3, 'John', 'Smith');

-- --------------------------------------------------------

--
-- Структура таблицы `users_tokens`
--

CREATE TABLE `users_tokens` (
  `id` int NOT NULL,
  `user_id` int NOT NULL,
  `token_id` varchar(50) DEFAULT NULL,
  `isActive` tinyint(1) NOT NULL DEFAULT '1' COMMENT 'not active - 0, active - 1',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Очистить таблицу перед добавлением данных `users_tokens`
--

TRUNCATE TABLE `users_tokens`;
--
-- Дамп данных таблицы `users_tokens`
--

INSERT INTO `users_tokens` (`id`, `user_id`, `token_id`, `isActive`, `created_at`) VALUES
(1, 1, 'c11f18a2-c6c7-4850-be15-93f9cbaef3b3', 1, '2020-07-11 21:44:03'),
(2, 2, 'c22f18a2-c6c7-4850-be15-93f9cbaef3b3', 0, '2020-07-11 21:44:03'),
(3, 3, 'c33f18a2-c6c7-4850-be15-93f9cbaef3b3', 1, '2020-07-11 21:44:03');

--
-- Индексы сохранённых таблиц
--

--
-- Индексы таблицы `urls`
--
ALTER TABLE `urls`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `url` (`url`),
  ADD KEY `users_id` (`users_id`),
  ADD KEY `url_code` (`url_code`);

--
-- Индексы таблицы `urls_stats`
--
ALTER TABLE `urls_stats`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `url_id` (`url_id`,`ip_id`,`token_id`,`agent_id`,`referrer_id`);

--
-- Индексы таблицы `urls_stats_agents`
--
ALTER TABLE `urls_stats_agents`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `user_agent` (`user_agent`);

--
-- Индексы таблицы `urls_stats_ips`
--
ALTER TABLE `urls_stats_ips`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `user_ip` (`user_ip`);

--
-- Индексы таблицы `urls_stats_referrers`
--
ALTER TABLE `urls_stats_referrers`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `user_referrer` (`user_referrer`);

--
-- Индексы таблицы `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `users_tokens`
--
ALTER TABLE `users_tokens`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`,`token_id`,`isActive`);

--
-- AUTO_INCREMENT для сохранённых таблиц
--

--
-- AUTO_INCREMENT для таблицы `urls`
--
ALTER TABLE `urls`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11117;

--
-- AUTO_INCREMENT для таблицы `urls_stats`
--
ALTER TABLE `urls_stats`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=86;

--
-- AUTO_INCREMENT для таблицы `urls_stats_agents`
--
ALTER TABLE `urls_stats_agents`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=116;

--
-- AUTO_INCREMENT для таблицы `urls_stats_ips`
--
ALTER TABLE `urls_stats_ips`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=106;

--
-- AUTO_INCREMENT для таблицы `urls_stats_referrers`
--
ALTER TABLE `urls_stats_referrers`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=99;

--
-- AUTO_INCREMENT для таблицы `users`
--
ALTER TABLE `users`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT для таблицы `users_tokens`
--
ALTER TABLE `users_tokens`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
