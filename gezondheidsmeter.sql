-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Gegenereerd op: 12 apr 2024 om 07:14
-- Serverversie: 10.4.28-MariaDB
-- PHP-versie: 8.2.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `gezondheidsmeter`
--

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `health_pillars`
--

CREATE TABLE `health_pillars` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `description` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Gegevens worden geëxporteerd voor tabel `health_pillars`
--

INSERT INTO `health_pillars` (`id`, `name`, `description`) VALUES
(1, 'Arbeidsomstandigheden', 'Details over arbeidsomstandigheden'),
(2, 'Lichamelijke Activiteit', 'Details over lichamelijke activiteit'),
(3, 'Voeding', 'Details over voeding'),
(4, 'Alcohol', 'Details over alcoholconsumptie'),
(5, 'Drugs', 'Details over drugsgebruik'),
(6, 'Slaap', 'Details over slaappatronen');

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `options`
--

CREATE TABLE `options` (
  `id` int(11) NOT NULL,
  `question_id` int(11) NOT NULL,
  `text` varchar(255) NOT NULL,
  `points` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Gegevens worden geëxporteerd voor tabel `options`
--

INSERT INTO `options` (`id`, `question_id`, `text`, `points`) VALUES
(1, 1, 'Groente en fruit', 2),
(2, 1, 'Brood, graanproducten en aardappelen', 2),
(3, 1, 'Zuivel, vlees(vervangers), vis, peulvruchten, noten', 2),
(4, 1, 'Smeersels en kookvetten', 1),
(5, 1, 'Dranken', 1),
(6, 2, 'Zeer comfortabel', 3),
(7, 2, 'Comfortabel', 2),
(8, 2, 'Oncomfortabel', 1),
(9, 2, 'Zeer oncomfortabel', 0),
(10, 3, 'Zeer tevreden', 3),
(11, 3, 'Tevreden', 2),
(12, 3, 'Ontevreden', 1),
(13, 3, 'Zeer ontevreden', 0),
(14, 4, 'Beheersbaar', 3),
(15, 4, 'Uitdagend maar beheersbaar', 2),
(16, 4, 'Hoog', 1),
(17, 4, 'Te hoog', 0),
(18, 5, 'Ja', 2),
(19, 5, 'Nee', 0),
(20, 6, '1 uur of minder', 1),
(21, 6, 'Tussen 1 en 2 uur', 2),
(22, 6, 'Meer dan 2 uur', 3),
(23, 7, 'Gewandeld', 1),
(24, 7, 'Gefietst', 1),
(25, 7, 'Beide', 2),
(26, 7, 'Geen van beide', 0),
(27, 8, 'Water', 0),
(28, 8, 'Suikerhoudende dranken', 0),
(29, 8, 'Cafeïne houdende dranken', 0),
(30, 8, 'Alcoholische drankjes', 0),
(34, 11, 'Ja', 0),
(35, 11, 'Nee', 3),
(41, 15, 'Minder dan 5 uur', 0),
(42, 15, '5-7 uur', 1),
(43, 15, 'Meer dan 7 uur', 3);

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `questions`
--

CREATE TABLE `questions` (
  `id` int(11) NOT NULL,
  `pillar_id` int(11) NOT NULL,
  `text` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Gegevens worden geëxporteerd voor tabel `questions`
--

INSERT INTO `questions` (`id`, `pillar_id`, `text`) VALUES
(1, 3, 'Heb je vandaag iets gegeten uit de volgende categorieën van de Schijf van Vijf?'),
(2, 1, 'Hoe beoordeel je jouw werkplek qua comfort?'),
(3, 1, 'Ben je tevreden met je werktijden?'),
(4, 1, 'Hoe ervaar je de werkdruk?'),
(5, 2, 'Heb je vandaag gesport?'),
(6, 2, 'Welke sport heb je beoefend en hoeveel uur?'),
(7, 2, 'Heb je vandaag gewandeld of gefietst?'),
(8, 4, 'Hoeveel drankjes uit de volgende categorieën heb je vandaag gedronken?'),
(11, 5, 'Heb je in de afgelopen week drugs gebruikt?'),
(15, 6, 'Hoeveel uur heb je geslapen?');

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `username` varchar(30) NOT NULL,
  `pwd` varchar(255) NOT NULL,
  `email` varchar(100) NOT NULL,
  `created_at` datetime NOT NULL DEFAULT curtime(),
  `start_date` date DEFAULT NULL,
  `receive_notifications` tinyint(1) NOT NULL DEFAULT 1,
  `is_admin` tinyint(4) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Gegevens worden geëxporteerd voor tabel `users`
--

INSERT INTO `users` (`id`, `username`, `pwd`, `email`, `created_at`, `start_date`, `receive_notifications`, `is_admin`) VALUES
(1, '1234', '$2y$12$jb.FqMOtNFzRx6zj0F3.w.aKDtxR0qOR9N1nZ/mA4kJLadv.mjFOe', '123', '2024-04-08 00:05:20', '2024-04-07', 1, 1),
(2, 'MIKE', '$2y$12$AX/urfyepapnnfixRDo8L.rpX1FyHEN2t.lgJTMrSlwL26cnkjhYK', 'mike@mike.com', '2024-04-12 02:49:45', NULL, 1, 0),
(3, 'MARC', '$2y$12$OPMf6uK6nAxFWxxFuQSlBeU.6QJJLKooZ9JrOB0MeFBFYGou6XUSK', 'MARC@GMAIL.COM', '2024-04-12 02:50:06', NULL, 1, 0);

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `user_responses`
--

CREATE TABLE `user_responses` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `question_id` int(11) NOT NULL,
  `option_id` int(11) NOT NULL,
  `date` date NOT NULL,
  `response_date` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Indexen voor geëxporteerde tabellen
--

--
-- Indexen voor tabel `health_pillars`
--
ALTER TABLE `health_pillars`
  ADD PRIMARY KEY (`id`);

--
-- Indexen voor tabel `options`
--
ALTER TABLE `options`
  ADD PRIMARY KEY (`id`),
  ADD KEY `question_id` (`question_id`);

--
-- Indexen voor tabel `questions`
--
ALTER TABLE `questions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `pillar_id` (`pillar_id`);

--
-- Indexen voor tabel `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- Indexen voor tabel `user_responses`
--
ALTER TABLE `user_responses`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `question_id` (`question_id`),
  ADD KEY `option_id` (`option_id`);

--
-- AUTO_INCREMENT voor geëxporteerde tabellen
--

--
-- AUTO_INCREMENT voor een tabel `health_pillars`
--
ALTER TABLE `health_pillars`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT voor een tabel `options`
--
ALTER TABLE `options`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=44;

--
-- AUTO_INCREMENT voor een tabel `questions`
--
ALTER TABLE `questions`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT voor een tabel `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT voor een tabel `user_responses`
--
ALTER TABLE `user_responses`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=239;

--
-- Beperkingen voor geëxporteerde tabellen
--

--
-- Beperkingen voor tabel `options`
--
ALTER TABLE `options`
  ADD CONSTRAINT `options_ibfk_1` FOREIGN KEY (`question_id`) REFERENCES `questions` (`id`);

--
-- Beperkingen voor tabel `questions`
--
ALTER TABLE `questions`
  ADD CONSTRAINT `questions_ibfk_1` FOREIGN KEY (`pillar_id`) REFERENCES `health_pillars` (`id`);

--
-- Beperkingen voor tabel `user_responses`
--
ALTER TABLE `user_responses`
  ADD CONSTRAINT `user_responses_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `user_responses_ibfk_2` FOREIGN KEY (`question_id`) REFERENCES `questions` (`id`),
  ADD CONSTRAINT `user_responses_ibfk_3` FOREIGN KEY (`option_id`) REFERENCES `options` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
