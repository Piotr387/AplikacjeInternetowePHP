-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Czas generowania: 19 Sty 2022, 16:13
-- Wersja serwera: 10.4.22-MariaDB
-- Wersja PHP: 8.0.13

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Baza danych: `projektphp`
--

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `adresy`
--

CREATE TABLE `adresy` (
  `id` int(11) NOT NULL,
  `miejscowosc` varchar(100) NOT NULL,
  `ulica` varchar(100) DEFAULT NULL,
  `numer` varchar(7) NOT NULL,
  `kodpocztowy` varchar(6) DEFAULT NULL,
  `zgloszenie` char(1) DEFAULT '0',
  `daneklientow_idk` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Zrzut danych tabeli `adresy`
--

INSERT INTO `adresy` (`id`, `miejscowosc`, `ulica`, `numer`, `kodpocztowy`, `zgloszenie`, `daneklientow_idk`) VALUES
(4, 'Lublin', 'Nadbystrzycka', '13', '20-400', '1', 10000041),
(7, 'Lublin', 'Nadbystrzycka', '11', '24-100', '1', 10000042),
(14, 'Lublin', 'Nadbystrzycka', '7', '20-400', '0', NULL),
(24, 'Lublin', 'Nadbystrzycka', '8', '20-501', '0', NULL),
(25, 'Lublin', 'Nadbystrzycka', '1', '20-501', '0', NULL),
(26, 'Lublin', 'Nadbystrzycka', '2', '20-501', '0', NULL),
(27, 'Lublin', 'Nadbystrzycka', '3', '20-501', '1', 10000044);

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `daneformularza`
--

CREATE TABLE `daneformularza` (
  `nrzamowienia` varchar(16) NOT NULL,
  `daneklientow_idk` int(11) DEFAULT NULL,
  `status` varchar(100) DEFAULT 'W trakcie realizacji'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Zrzut danych tabeli `daneformularza`
--

INSERT INTO `daneformularza` (`nrzamowienia`, `daneklientow_idk`, `status`) VALUES
('2022118/20356/88', 10000041, 'W trakcie realizacji'),
('2022118/205459/2', 10000042, 'W trakcie realizacji'),
('2022118/21855/99', 10000044, 'W trakcie realizacji');

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `daneklientow`
--

CREATE TABLE `daneklientow` (
  `idk` int(11) NOT NULL,
  `imie` varchar(100) NOT NULL,
  `nazwisko` varchar(100) NOT NULL,
  `pesel` varchar(11) NOT NULL,
  `nrtelefonu` int(11) NOT NULL,
  `email` varchar(150) NOT NULL,
  `dataurodzenia` date NOT NULL,
  `users_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Zrzut danych tabeli `daneklientow`
--

INSERT INTO `daneklientow` (`idk`, `imie`, `nazwisko`, `pesel`, `nrtelefonu`, `email`, `dataurodzenia`, `users_id`) VALUES
(10000041, 'Jan', 'Kowalski', '12345678901', 123456789, 'eia51567@qopow.com', '2004-01-18', 21),
(10000042, 'Jan', 'Nowak', '47011435113', 123456789, 'gsd87026@boofx.com', '2004-01-18', 22),
(10000044, 'Andrii', 'Szulc', '32145698789', 123456789, 'eia51567@qopow.com', '2004-01-18', 24);

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `danepracownikow`
--

CREATE TABLE `danepracownikow` (
  `idpracownika` int(11) NOT NULL,
  `imie` varchar(100) NOT NULL,
  `nazwisko` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `internet`
--

CREATE TABLE `internet` (
  `idinternet` int(11) NOT NULL,
  `nazwa` varchar(100) NOT NULL,
  `cena` double NOT NULL,
  `predkosc` int(11) NOT NULL,
  `czywofercie` char(1) NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Zrzut danych tabeli `internet`
--

INSERT INTO `internet` (`idinternet`, `nazwa`, `cena`, `predkosc`, `czywofercie`) VALUES
(1, 'Prędkość internetu 300 MB/s', 60, 300, '1'),
(2, 'Prędkość internetu 600 MB/s', 70, 600, '1'),
(3, 'Prędkość internetu 1 GB/s', 80, 1000, '1');

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `logged_in_users`
--

CREATE TABLE `logged_in_users` (
  `sessionid` varchar(100) NOT NULL,
  `userid` int(11) NOT NULL,
  `lastupdate` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Zrzut danych tabeli `logged_in_users`
--

INSERT INTO `logged_in_users` (`sessionid`, `userid`, `lastupdate`) VALUES
('f33ubcvj9al5lo0j3mv9k8r5u1', 1, '2022-01-18 21:05:00');

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `tv`
--

CREATE TABLE `tv` (
  `idtv` int(11) NOT NULL,
  `nazwa` varchar(100) NOT NULL,
  `cena` double NOT NULL,
  `ilekanalow` int(11) NOT NULL,
  `czywofercie` char(1) NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Zrzut danych tabeli `tv`
--

INSERT INTO `tv` (`idtv`, `nazwa`, `cena`, `ilekanalow`, `czywofercie`) VALUES
(0, 'Brak telewizji', 0, 0, '1'),
(1, 'Telewizja internetowa 12', 10, 12, '1'),
(2, 'Telewizja internetowa 36', 15, 36, '1'),
(3, 'Telewizja internetowa 90', 20, 90, '1');

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `umowa`
--

CREATE TABLE `umowa` (
  `nrumowy` varchar(16) NOT NULL,
  `datazawarcia` datetime DEFAULT NULL,
  `dlugoscumowy` int(11) NOT NULL,
  `internet_idinternet` int(11) NOT NULL,
  `tv_idtv` int(11) DEFAULT NULL,
  `daneklientow_idk` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Zrzut danych tabeli `umowa`
--

INSERT INTO `umowa` (`nrumowy`, `datazawarcia`, `dlugoscumowy`, `internet_idinternet`, `tv_idtv`, `daneklientow_idk`) VALUES
('2022/1/1', NULL, 36, 1, 0, 10000041),
('2022/1/2', NULL, 36, 1, 0, 10000042),
('2022/1/3', NULL, 24, 1, 3, 10000042),
('2022/1/4', NULL, 36, 1, 3, 10000044);

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `username` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `passwd` varchar(255) NOT NULL,
  `status` int(11) DEFAULT 1,
  `datarejestracji` datetime NOT NULL,
  `firstlog` char(1) DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Zrzut danych tabeli `users`
--

INSERT INTO `users` (`id`, `username`, `email`, `passwd`, `status`, `datarejestracji`, `firstlog`) VALUES
(1, 'root', 'ppiwoski@gmail.com', '$2y$10$9ZyJcok8uHBY8zvb33vKM.nQQq8InnKbWQ4wkDa.0VJd5ZtHGqh2W', 2, '2022-01-13 21:23:23', '1'),
(16, '10000036', 'eia51567@qopow.com', '$2y$10$MzTXRXuCaFN8VFixvEPEi.TYjuB0Tv3/z7OENVHnHKXrvq9MC.zOq', 1, '2022-01-18 18:47:24', '0'),
(21, '10000041', 'eia51567@qopow.com', '$2y$10$qXfcwK3qM2W18Awu2QxgVOFdWPxFoJOrvUcic7KqEJLLl4ot0h5fy', 1, '2022-01-18 20:35:06', '0'),
(22, '10000042', 'gsd87026@boofx.com', '$2y$10$JfNoIpV5wEuwCyebLmKw6O8/gVzoPl/Z5z0L4dd1kJVQGrTzLsfBa', 1, '2022-01-18 20:54:59', '1'),
(24, '10000044', 'eia51567@qopow.com', '$2y$10$nXhilMDxafrq27QQBq8zm.kj9duHvJepSbnvUOdouRzgFN1DTTQCG', 1, '2022-01-18 21:08:56', '1');

--
-- Indeksy dla zrzutów tabel
--

--
-- Indeksy dla tabeli `adresy`
--
ALTER TABLE `adresy`
  ADD PRIMARY KEY (`id`),
  ADD KEY `adresy_daneklientow_fk` (`daneklientow_idk`);

--
-- Indeksy dla tabeli `daneformularza`
--
ALTER TABLE `daneformularza`
  ADD PRIMARY KEY (`nrzamowienia`),
  ADD KEY `daneformularza_daneklientow_fk` (`daneklientow_idk`);

--
-- Indeksy dla tabeli `daneklientow`
--
ALTER TABLE `daneklientow`
  ADD PRIMARY KEY (`idk`),
  ADD UNIQUE KEY `daneklientow__un` (`pesel`),
  ADD KEY `daneklientow_users_fk` (`users_id`);

--
-- Indeksy dla tabeli `danepracownikow`
--
ALTER TABLE `danepracownikow`
  ADD PRIMARY KEY (`idpracownika`);

--
-- Indeksy dla tabeli `internet`
--
ALTER TABLE `internet`
  ADD PRIMARY KEY (`idinternet`);

--
-- Indeksy dla tabeli `logged_in_users`
--
ALTER TABLE `logged_in_users`
  ADD PRIMARY KEY (`sessionid`),
  ADD KEY `logged_in_users_users_fk` (`userid`);

--
-- Indeksy dla tabeli `tv`
--
ALTER TABLE `tv`
  ADD PRIMARY KEY (`idtv`);

--
-- Indeksy dla tabeli `umowa`
--
ALTER TABLE `umowa`
  ADD PRIMARY KEY (`nrumowy`),
  ADD KEY `umowa_daneklientow_fk` (`daneklientow_idk`),
  ADD KEY `umowa_internet_fk` (`internet_idinternet`),
  ADD KEY `umowa_tv_fk` (`tv_idtv`);

--
-- Indeksy dla tabeli `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users__un` (`username`);

--
-- AUTO_INCREMENT dla zrzuconych tabel
--

--
-- AUTO_INCREMENT dla tabeli `adresy`
--
ALTER TABLE `adresy`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=28;

--
-- AUTO_INCREMENT dla tabeli `daneklientow`
--
ALTER TABLE `daneklientow`
  MODIFY `idk` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10000045;

--
-- AUTO_INCREMENT dla tabeli `danepracownikow`
--
ALTER TABLE `danepracownikow`
  MODIFY `idpracownika` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT dla tabeli `internet`
--
ALTER TABLE `internet`
  MODIFY `idinternet` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT dla tabeli `tv`
--
ALTER TABLE `tv`
  MODIFY `idtv` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT dla tabeli `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=25;

--
-- Ograniczenia dla zrzutów tabel
--

--
-- Ograniczenia dla tabeli `adresy`
--
ALTER TABLE `adresy`
  ADD CONSTRAINT `adresy_daneklientow_fk` FOREIGN KEY (`daneklientow_idk`) REFERENCES `daneklientow` (`idk`);

--
-- Ograniczenia dla tabeli `daneformularza`
--
ALTER TABLE `daneformularza`
  ADD CONSTRAINT `daneformularza_daneklientow_fk` FOREIGN KEY (`daneklientow_idk`) REFERENCES `daneklientow` (`idk`);

--
-- Ograniczenia dla tabeli `daneklientow`
--
ALTER TABLE `daneklientow`
  ADD CONSTRAINT `daneklientow_users_fk` FOREIGN KEY (`users_id`) REFERENCES `users` (`id`);

--
-- Ograniczenia dla tabeli `danepracownikow`
--
ALTER TABLE `danepracownikow`
  ADD CONSTRAINT `danepracownikow_users_fk` FOREIGN KEY (`idpracownika`) REFERENCES `users` (`id`);

--
-- Ograniczenia dla tabeli `logged_in_users`
--
ALTER TABLE `logged_in_users`
  ADD CONSTRAINT `logged_in_users_users_fk` FOREIGN KEY (`userid`) REFERENCES `users` (`id`);

--
-- Ograniczenia dla tabeli `umowa`
--
ALTER TABLE `umowa`
  ADD CONSTRAINT `umowa_daneklientow_fk` FOREIGN KEY (`daneklientow_idk`) REFERENCES `daneklientow` (`idk`),
  ADD CONSTRAINT `umowa_internet_fk` FOREIGN KEY (`internet_idinternet`) REFERENCES `internet` (`idinternet`),
  ADD CONSTRAINT `umowa_tv_fk` FOREIGN KEY (`tv_idtv`) REFERENCES `tv` (`idtv`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
