-- phpMyAdmin SQL Dump
-- version 3.3.9.2
-- http://www.phpmyadmin.net
--
-- Host: mysql1
-- Czas wygenerowania: 14 Lut 2023, 01:52
-- Wersja serwera: 5.5.30
-- Wersja PHP: 5.6.40-60+0~20220627.67+debian10~1.gbp1f7ffd

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Baza danych: `db700444`
--

-- --------------------------------------------------------

--
-- Struktura tabeli dla  `user`
--

CREATE TABLE IF NOT EXISTS `user` (
  `user_id` int(11) NOT NULL AUTO_INCREMENT,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  PRIMARY KEY (`user_id`),
  UNIQUE KEY `user_id` (`user_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=3 ;

--
-- Zrzut danych tabeli `user`
--

INSERT INTO `user` (`user_id`, `email`, `password`) VALUES
(1, 'kapcerix272@wp.pl', '9ce5124287e575a2808d2a769b672b0d959e7753');

-- --------------------------------------------------------

--
-- Struktura tabeli dla  `user_hash`
--

CREATE TABLE IF NOT EXISTS `user_hash` (
  `user_id` int(11) NOT NULL,
  `hash` varchar(255) NOT NULL,
  `crated_at` datetime NOT NULL,
  KEY `user_id` (`user_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Zrzut danych tabeli `user_hash`
--

INSERT INTO `user_hash` (`user_id`, `hash`, `crated_at`) VALUES
(1, '6ab447b5019eed9399ee2a22e60b85e62f7660de', '2023-02-14 01:51:33');

--
-- Ograniczenia dla zrzutów tabel
--

--
-- Ograniczenia dla tabeli `user_hash`
--
ALTER TABLE `user_hash`
  ADD CONSTRAINT `user_hash` FOREIGN KEY (`user_id`) REFERENCES `user` (`user_id`);
