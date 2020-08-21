-- phpMyAdmin SQL Dump
-- version 4.9.0.1
-- https://www.phpmyadmin.net/
--
-- Хост: localhost:3306
-- Время создания: Авг 21 2020 г., 20:06
-- Версия сервера: 10.2.31-MariaDB-cll-lve
-- Версия PHP: 7.3.15

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- База данных: `p-18701_beejee`
--

-- --------------------------------------------------------

--
-- Структура таблицы `routes`
--

CREATE TABLE `routes` (
  `id` int(11) NOT NULL,
  `route` varchar(350) DEFAULT NULL,
  `controller` varchar(200) NOT NULL,
  `action` varchar(200) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `routes`
--

INSERT INTO `routes` (`id`, `route`, `controller`, `action`) VALUES
(1, '', 'main', 'index'),
(2, '{page:[\\d]+}', 'main', 'index'),
(3, 'add', 'main', 'addtask'),
(4, 'login', 'account', 'login'),
(5, 'signup', 'account', 'signup'),
(6, 'logout', 'account', 'logout'),
(7, 'changesortby/{sortby:[\\w]+}', 'main', 'changeSortBy'),
(8, 'changesortdirection/{sortdirection:[\\w]+}', 'main', 'changeSortDirection'),
(9, 'changetaskstatus/{taskstatus:[\\d]+}', 'main', 'changeTaskStatus'),
(10, 'deleteparams', 'main', 'deleteParams'),
(11, 'reloadpage', 'main', 'reloadPage'),
(12, 'switchstatus/{taskid:[\\d]+}', 'main', 'switchTaskStatus'),
(13, 'delete/{taskid:[\\d]+}', 'main', 'deleteTask'),
(14, 'edit/{taskid:[\\d]+}', 'main', 'editTask');

-- --------------------------------------------------------

--
-- Структура таблицы `tasks`
--

CREATE TABLE `tasks` (
  `id` int(11) NOT NULL,
  `user` varchar(150) NOT NULL,
  `email` varchar(350) NOT NULL,
  `text` text NOT NULL,
  `status` int(11) NOT NULL,
  `edited` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `tasks`
--

INSERT INTO `tasks` (`id`, `user`, `email`, `text`, `status`, `edited`) VALUES
(1, 'test', 'test@test.com', 'test job', 1, NULL),
(2, 'test', 'test@test.com', '&lt;script&gt;alert(&quot;test&quot;);&lt;/script&gt;', 1, NULL),
(3, 'Адик', 'celovek.dobra7@gmail.com', 'Первая задача (изменено)', 0, 1),
(4, 'Адик', 'celovek.dobra7@gmail.com', 'Вторая задача', 0, NULL),
(5, 'Лев Толстой', 'lev@old.org', 'Все счастливые семьи похожи друг на друга, каждая несчастливая семья несчастлива по-своему. Все счастливые семьи похожи друг на друга, каждая несчастливая семья несчастлива по-своему. Если добро имеет причину, оно уже не добро; если оно имеет последствие – награду, оно тоже не добро.', 0, NULL),
(6, 'Илон Маск', 'living@on.mars', 'Существует лишь один шанс из миллиарда, что наша реальность подлинная.', 0, NULL);

-- --------------------------------------------------------

--
-- Структура таблицы `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `username` varchar(150) NOT NULL,
  `email` varchar(350) NOT NULL,
  `pass` varchar(320) NOT NULL,
  `token` varchar(500) NOT NULL,
  `status` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `users`
--

INSERT INTO `users` (`id`, `username`, `email`, `pass`, `token`, `status`) VALUES
(8, 'Администратор', 'admin', '40bd001563085fc35165329ea1ff5c5ecbdbbeef', '54933164acdae27e45691ccafdfdae6af52b8ace9e8fff11f0459439d07d79afd9fd18478d37fe1998', 1);

--
-- Индексы сохранённых таблиц
--

--
-- Индексы таблицы `routes`
--
ALTER TABLE `routes`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `route` (`route`);

--
-- Индексы таблицы `tasks`
--
ALTER TABLE `tasks`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT для сохранённых таблиц
--

--
-- AUTO_INCREMENT для таблицы `routes`
--
ALTER TABLE `routes`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT для таблицы `tasks`
--
ALTER TABLE `tasks`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT для таблицы `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
