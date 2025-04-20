-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Хост: 127.0.0.1:3307
-- Время создания: Апр 05 2025 г., 07:56
-- Версия сервера: 5.7.39-log
-- Версия PHP: 8.0.22

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- База данных: `CRM`
--

-- --------------------------------------------------------

--
-- Структура таблицы `archive`
--

CREATE TABLE `archive` (
  `id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Структура таблицы `contacts`
--

CREATE TABLE `contacts` (
  `id` int(11) NOT NULL,
  `surname` varchar(255) NOT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `phone` varchar(255) NOT NULL,
  `firm` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Дамп данных таблицы `contacts`
--

INSERT INTO `contacts` (`id`, `surname`, `name`, `email`, `phone`, `firm`) VALUES
(2, 'Васильев', 'Григорий', 'aaa@tt', '890128567948', ''),
(3, 'Антонов', 'Антон', 'anton@tt', '84629573847', ''),
(4, 'Федоров', 'Федор', 'fedya@tt', '73947285483', ''),
(6, 'Иванов', 'Иван', 'ivan3984@tt', '+7(373)-987-39-83', 'ИП Иванов'),
(7, 'Сергеев', 'Иван', 'ivan4444@tt', '4444444', 'ввв'),
(10, 'Пользователев', 'Пользователь', 'user@tt', '+7(039)-894-84-98', 'ООО \"User\"');

-- --------------------------------------------------------

--
-- Структура таблицы `deals`
--

CREATE TABLE `deals` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `client_id` int(11) NOT NULL,
  `subject` varchar(255) NOT NULL,
  `end_date` date NOT NULL,
  `end_time` time NOT NULL,
  `sum` int(11) NOT NULL,
  `phase_id` int(11) NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Дамп данных таблицы `deals`
--

INSERT INTO `deals` (`id`, `user_id`, `client_id`, `subject`, `end_date`, `end_time`, `sum`, `phase_id`) VALUES
(3, 6, 2, 'Продажа товара', '2025-04-18', '13:20:00', 150000, 4),
(4, 6, 6, 'Подписание бумаг', '2025-04-23', '19:25:00', 150005, 1),
(5, 6, 4, 'Продажа', '2025-04-12', '09:41:00', 150000, 4);

-- --------------------------------------------------------

--
-- Структура таблицы `deal_phases`
--

CREATE TABLE `deal_phases` (
  `id` int(11) NOT NULL,
  `phase` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Дамп данных таблицы `deal_phases`
--

INSERT INTO `deal_phases` (`id`, `phase`) VALUES
(1, 'Новое'),
(2, 'Уточнение деталей'),
(3, 'Подтверждена'),
(4, 'Совершена'),
(5, 'Отменена');

-- --------------------------------------------------------

--
-- Структура таблицы `priorities`
--

CREATE TABLE `priorities` (
  `id` int(11) NOT NULL,
  `priority` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Дамп данных таблицы `priorities`
--

INSERT INTO `priorities` (`id`, `priority`) VALUES
(1, 'Высокий'),
(2, 'Средний'),
(3, 'Низкий');

-- --------------------------------------------------------

--
-- Структура таблицы `roles`
--

CREATE TABLE `roles` (
  `id` int(11) NOT NULL,
  `role` varchar(255) NOT NULL DEFAULT 'user'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Дамп данных таблицы `roles`
--

INSERT INTO `roles` (`id`, `role`) VALUES
(1, 'user'),
(2, 'admin'),
(3, 'moderator');

-- --------------------------------------------------------

--
-- Структура таблицы `statuses`
--

CREATE TABLE `statuses` (
  `id` int(11) NOT NULL,
  `status` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Дамп данных таблицы `statuses`
--

INSERT INTO `statuses` (`id`, `status`) VALUES
(1, 'Активно'),
(2, 'Выполнено');

-- --------------------------------------------------------

--
-- Структура таблицы `tasks`
--

CREATE TABLE `tasks` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `contact_id` int(11) DEFAULT '0',
  `subject` varchar(255) NOT NULL,
  `description` text NOT NULL,
  `date` date DEFAULT NULL,
  `time` time DEFAULT NULL,
  `priority_id` int(11) NOT NULL,
  `status_id` int(11) NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Дамп данных таблицы `tasks`
--

INSERT INTO `tasks` (`id`, `user_id`, `contact_id`, `subject`, `description`, `date`, `time`, `priority_id`, `status_id`) VALUES
(1, 3, 2, 'тест', 'тест', '2025-03-25', '00:00:00', 1, 1),
(29, 3, 4, 'Деловая встреча', 'Встреча с заказчиком', '2025-03-31', '00:00:00', 1, 1),
(33, 3, 3, '12', '12', '2025-03-28', '17:24:00', 1, 1),
(34, 6, NULL, 'd', 'd', NULL, NULL, 1, 1),
(35, 6, NULL, 'в', 'в', NULL, NULL, 1, 1),
(36, 6, NULL, 'к', 'к', NULL, NULL, 1, 1),
(37, 6, 2, 'в', 'в', '2025-04-10', '00:24:00', 1, 2),
(38, 6, 2, 'tgg', 'gjh', '2222-03-31', '03:59:00', 1, 2),
(39, 6, NULL, 'd', 'd', '2025-04-09', '04:15:00', 1, 1),
(41, 6, 2, 'Работа над проектом', 'Работа', '2025-04-24', '22:07:00', 1, 1),
(42, 5, 4, 'dd', 'dd', '2025-04-24', '08:37:00', 1, 1),
(43, 6, 2, 'Встреча с клиентом', 'Встреча', '2025-04-29', '10:32:00', 3, 1),
(44, 6, 2, 'Работа над проектом', 'Работа', '2025-04-17', '11:58:00', 2, 1),
(45, 6, 6, 'Разработка компонента', 'Разработка', '2025-04-23', NULL, 3, 2),
(46, 6, 3, 'Разработка', 'Разработка', '2025-04-29', '12:02:00', 3, 2),
(47, 6, 2, 'Встреча с клиентом', 'Встреча', '2025-04-18', NULL, 1, 1),
(49, 6, 4, 'Обсуждение деталей сделки', 'Обсуждение', '2025-04-24', '13:05:00', 1, 1),
(50, 6, 2, 'Обсуждение деталей сделки', 'Обсуждение деталей сделки', '2025-04-19', '09:05:00', 1, 1);

-- --------------------------------------------------------

--
-- Структура таблицы `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `surname` varchar(255) NOT NULL,
  `name` varchar(255) NOT NULL,
  `post` varchar(255) NOT NULL,
  `phone` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `login` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `role_id` int(11) NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Дамп данных таблицы `users`
--

INSERT INTO `users` (`id`, `surname`, `name`, `post`, `phone`, `email`, `login`, `password`, `role_id`) VALUES
(3, 'Иванов', 'Иван', 'Директор', '398749847948', 'ivan@tt', 'ivan123', 'ivan', 1),
(4, 'Сергеев', 'Сергей', 'Ген. директор', '838798749487', 'SERGEY@TT', 'user123', 'user123', 1),
(5, 'Аленова', 'Алена', '333', '9749847847', 'alena@tt', 'alena', '333', 1),
(6, 'Сидоров', 'Алексей', 'Менеджер', '39749874974', 'alex@mail.ru', 'user', 'user', 1);

--
-- Индексы сохранённых таблиц
--

--
-- Индексы таблицы `archive`
--
ALTER TABLE `archive`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `contacts`
--
ALTER TABLE `contacts`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `deals`
--
ALTER TABLE `deals`
  ADD PRIMARY KEY (`id`),
  ADD KEY `client_id` (`client_id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `phase_id` (`phase_id`);

--
-- Индексы таблицы `deal_phases`
--
ALTER TABLE `deal_phases`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `priorities`
--
ALTER TABLE `priorities`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `roles`
--
ALTER TABLE `roles`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `statuses`
--
ALTER TABLE `statuses`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `tasks`
--
ALTER TABLE `tasks`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `contact_id` (`contact_id`),
  ADD KEY `priority_id` (`priority_id`),
  ADD KEY `status_id` (`status_id`);

--
-- Индексы таблицы `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD KEY `role_id` (`role_id`);

--
-- AUTO_INCREMENT для сохранённых таблиц
--

--
-- AUTO_INCREMENT для таблицы `archive`
--
ALTER TABLE `archive`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT для таблицы `contacts`
--
ALTER TABLE `contacts`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT для таблицы `deals`
--
ALTER TABLE `deals`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT для таблицы `deal_phases`
--
ALTER TABLE `deal_phases`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT для таблицы `priorities`
--
ALTER TABLE `priorities`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT для таблицы `roles`
--
ALTER TABLE `roles`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT для таблицы `statuses`
--
ALTER TABLE `statuses`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT для таблицы `tasks`
--
ALTER TABLE `tasks`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=51;

--
-- AUTO_INCREMENT для таблицы `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- Ограничения внешнего ключа сохраненных таблиц
--

--
-- Ограничения внешнего ключа таблицы `deals`
--
ALTER TABLE `deals`
  ADD CONSTRAINT `deals_ibfk_1` FOREIGN KEY (`client_id`) REFERENCES `contacts` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `deals_ibfk_2` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `deals_ibfk_3` FOREIGN KEY (`phase_id`) REFERENCES `deal_phases` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Ограничения внешнего ключа таблицы `tasks`
--
ALTER TABLE `tasks`
  ADD CONSTRAINT `tasks_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `tasks_ibfk_2` FOREIGN KEY (`contact_id`) REFERENCES `contacts` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `tasks_ibfk_3` FOREIGN KEY (`priority_id`) REFERENCES `priorities` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `tasks_ibfk_4` FOREIGN KEY (`status_id`) REFERENCES `statuses` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Ограничения внешнего ключа таблицы `users`
--
ALTER TABLE `users`
  ADD CONSTRAINT `users_ibfk_1` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
