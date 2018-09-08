-- phpMyAdmin SQL Dump
-- version 4.8.2
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Czas generowania: 08 Wrz 2018, 12:07
-- Wersja serwera: 10.1.34-MariaDB
-- Wersja PHP: 7.2.7

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Baza danych: `finances`
--

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `default_expenses_categories`
--

CREATE TABLE `default_expenses_categories` (
  `expense_category_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_polish_ci;

--
-- Zrzut danych tabeli `default_expenses_categories`
--

INSERT INTO `default_expenses_categories` (`expense_category_id`) VALUES
(1),
(2),
(3),
(4),
(5),
(6);

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `default_incomes_categories`
--

CREATE TABLE `default_incomes_categories` (
  `income_category_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_polish_ci;

--
-- Zrzut danych tabeli `default_incomes_categories`
--

INSERT INTO `default_incomes_categories` (`income_category_id`) VALUES
(1),
(2),
(3);

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `expenses`
--

CREATE TABLE `expenses` (
  `expense_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `category_id` int(11) NOT NULL,
  `date` date NOT NULL,
  `value` decimal(10,2) NOT NULL,
  `comment` text COLLATE utf8_polish_ci
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_polish_ci;

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `expenses_categories`
--

CREATE TABLE `expenses_categories` (
  `expense_category_id` int(11) NOT NULL,
  `expense_category` varchar(50) COLLATE utf8_polish_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_polish_ci;

--
-- Zrzut danych tabeli `expenses_categories`
--

INSERT INTO `expenses_categories` (`expense_category_id`, `expense_category`) VALUES
(2, 'abonamenty'),
(3, 'czynsz i media'),
(4, 'odzież i obuwie'),
(5, 'paliwo'),
(6, 'środki czystości'),
(1, 'żywność');

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `incomes`
--

CREATE TABLE `incomes` (
  `income_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `category_id` int(11) NOT NULL,
  `date` date NOT NULL,
  `value` decimal(10,2) NOT NULL,
  `comment` text COLLATE utf8_polish_ci
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_polish_ci;

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `incomes_categories`
--

CREATE TABLE `incomes_categories` (
  `income_category_id` int(11) NOT NULL,
  `income_category` varchar(50) COLLATE utf8_polish_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_polish_ci;

--
-- Zrzut danych tabeli `incomes_categories`
--

INSERT INTO `incomes_categories` (`income_category_id`, `income_category`) VALUES
(2, 'odsetki od lokaty'),
(3, 'pensja'),
(1, 'prezent');

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `users`
--

CREATE TABLE `users` (
  `user_id` int(11) NOT NULL,
  `login` varchar(20) COLLATE utf8_polish_ci NOT NULL,
  `email` varchar(100) COLLATE utf8_polish_ci NOT NULL,
  `password` varchar(300) COLLATE utf8_polish_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_polish_ci;

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `users_expenses_categories`
--

CREATE TABLE `users_expenses_categories` (
  `user_id` int(11) NOT NULL,
  `expense_category_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_polish_ci;

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `users_incomes_categories`
--

CREATE TABLE `users_incomes_categories` (
  `user_id` int(11) NOT NULL,
  `income_category_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_polish_ci;

--
-- Indeksy dla zrzutów tabel
--

--
-- Indeksy dla tabeli `default_expenses_categories`
--
ALTER TABLE `default_expenses_categories`
  ADD PRIMARY KEY (`expense_category_id`);

--
-- Indeksy dla tabeli `default_incomes_categories`
--
ALTER TABLE `default_incomes_categories`
  ADD PRIMARY KEY (`income_category_id`);

--
-- Indeksy dla tabeli `expenses`
--
ALTER TABLE `expenses`
  ADD PRIMARY KEY (`expense_id`),
  ADD KEY `expenses_categories_expense_category_id_fk2` (`category_id`),
  ADD KEY `users_user_id_fk3` (`user_id`);

--
-- Indeksy dla tabeli `expenses_categories`
--
ALTER TABLE `expenses_categories`
  ADD PRIMARY KEY (`expense_category_id`),
  ADD UNIQUE KEY `expense_catogory` (`expense_category`);

--
-- Indeksy dla tabeli `incomes`
--
ALTER TABLE `incomes`
  ADD PRIMARY KEY (`income_id`),
  ADD KEY `incomeses_categories_income_category_id_fk2` (`category_id`),
  ADD KEY `users_user_id_fk4` (`user_id`);

--
-- Indeksy dla tabeli `incomes_categories`
--
ALTER TABLE `incomes_categories`
  ADD PRIMARY KEY (`income_category_id`),
  ADD UNIQUE KEY `income_category` (`income_category`);

--
-- Indeksy dla tabeli `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`user_id`),
  ADD UNIQUE KEY `login` (`login`),
  ADD UNIQUE KEY `email` (`email`);

--
-- Indeksy dla tabeli `users_expenses_categories`
--
ALTER TABLE `users_expenses_categories`
  ADD KEY `users_user_id_fk` (`user_id`),
  ADD KEY `expenses_categories_expense_category_id_fk` (`expense_category_id`);

--
-- Indeksy dla tabeli `users_incomes_categories`
--
ALTER TABLE `users_incomes_categories`
  ADD KEY `users_user_id_fk2` (`user_id`),
  ADD KEY `incomes_categories_income_category_id_fk` (`income_category_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT dla tabeli `default_expenses_categories`
--
ALTER TABLE `default_expenses_categories`
  MODIFY `expense_category_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT dla tabeli `default_incomes_categories`
--
ALTER TABLE `default_incomes_categories`
  MODIFY `income_category_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT dla tabeli `expenses`
--
ALTER TABLE `expenses`
  MODIFY `expense_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT dla tabeli `expenses_categories`
--
ALTER TABLE `expenses_categories`
  MODIFY `expense_category_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT dla tabeli `incomes`
--
ALTER TABLE `incomes`
  MODIFY `income_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT dla tabeli `incomes_categories`
--
ALTER TABLE `incomes_categories`
  MODIFY `income_category_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT dla tabeli `users`
--
ALTER TABLE `users`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- Ograniczenia dla zrzutów tabel
--

--
-- Ograniczenia dla tabeli `expenses`
--
ALTER TABLE `expenses`
  ADD CONSTRAINT `expenses_categories_expense_category_id_fk2` FOREIGN KEY (`category_id`) REFERENCES `expenses_categories` (`expense_category_id`),
  ADD CONSTRAINT `users_user_id_fk3` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`);

--
-- Ograniczenia dla tabeli `incomes`
--
ALTER TABLE `incomes`
  ADD CONSTRAINT `incomes_categories_income_category_id_fk2` FOREIGN KEY (`category_id`) REFERENCES `incomes_categories` (`income_category_id`),
  ADD CONSTRAINT `users_user_id_fk4` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`);

--
-- Ograniczenia dla tabeli `users_expenses_categories`
--
ALTER TABLE `users_expenses_categories`
  ADD CONSTRAINT `expenses_categories_expense_category_id_fk` FOREIGN KEY (`expense_category_id`) REFERENCES `expenses_categories` (`expense_category_id`),
  ADD CONSTRAINT `users_user_id_fk` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`);

--
-- Ograniczenia dla tabeli `users_incomes_categories`
--
ALTER TABLE `users_incomes_categories`
  ADD CONSTRAINT `incomes_categories_income_category_id_fk` FOREIGN KEY (`income_category_id`) REFERENCES `incomes_categories` (`income_category_id`),
  ADD CONSTRAINT `users_user_id_fk2` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
