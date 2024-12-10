-- phpMyAdmin SQL Dump
-- version 4.8.3
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Creato il: Dic 10, 2019 alle 23:57
-- Versione del server: 8.0.13
-- Versione PHP: 7.1.23

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

-- --------------------------------------------------------

--
-- Struttura della tabella `giocatrici`
--
USE gaggi;

DROP TABLE IF EXISTS giocatrici;

CREATE TABLE giocatrici (
  `ID` int(11) NOT NULL,
  `nome` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `capitano` int(11) NOT NULL,
  `dataNascita` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `luogo` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `squadra` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `ruolo` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `altezza` int(11) NOT NULL,
  `maglia` int(11) NOT NULL,
  `magliaNazionale` int(11) NOT NULL,
  `punti` int(11) NOT NULL,
  `riconoscimenti` longtext COLLATE utf8_unicode_ci DEFAULT NULL,
  `note` longtext COLLATE utf8_unicode_ci DEFAULT NULL,
  `immagine` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;



INSERT INTO `giocatrici` (`ID`, `nome`, `capitano`,`dataNascita`, `luogo`, `squadra`, `ruolo`, `altezza`, `maglia`, `magliaNazionale`, `punti`, `riconoscimenti`, `note`, `immagine`) VALUES
(1, 'Anna Danesi', 1, '20/04/1996', 'Brescia', 'Pro Victoria', 'Centrale', 196, 11, 11, 43, '<ul>
						<li>Miglior centrale nel Campionato mondiale femminile under 20 di pallavolo femminile del 2015.</li>
						<li>Miglior centrale nel Campionato europeo femminile di pallavolo 2021.</li>
						<li>Miglior centrale nel Campionato mondiale femminile di pallavolo 2022.</li>
						<li>Miglior centrale di Pallavolo ai Giochi della XXXIII Olimpiade - Torneo femminile, 2024.</li>
					</ul>', '', '../images/danesi.jpg'),
(2, 'Carlotta Cambi', 0,'28/05/1996', 'San Miniato', 'Pinerolo', 'Palleggiatrice', 176, 3, 3, 12, '', 'Ha fatto parte della squadra "AGIL" durante la stagione 2016/17 e 2022/2023. Dalla stagione 2023/2024 fa parte della squadra "Pinerolo".', '../images/cambi.jpg'),
(3, 'Alessia Orro', 0,'18/07/1998', 'Oristano', 'Pro Victoria', 'Pallegiatrice', 180, 8, 8, 105, '<ul>
						<li><abbr title="Most Valuable Player" lang="en">MVP</abbr> coppa CEV, 2021</li>
						<li>Miglior palleggiatrice, <span lang="en">Volleyball Nations League</span>, 2022.</li>
						<li>Miglior palleggiatrice, <span lang="en">Volleyball Nations League</span>, 2024.</li>
						<li>Miglior palleggiatrice di Pallavolo, Giochi della XXXIII Olimpiade - Torneo femminile, 2024.</li>
					</ul>', '', '../images/orro.jpg'),
(4, 'Caterina Bosetti', 0,'02/02/1994', 'Busto Arsizio', '<span lang="tr">VakıfBank.</span>', 'Schiacciatrice', 180, 9, 9, 33, '<ul>
						<li>Miglior Schiacciatrice, Campionato Mondiale di pallavolo femminile Under-20, 2011.</li>
						<li><abbr title="Most Valuable Player" lang="en">MVP</abbr>, Campionato Mondiale di Pallavolo femminile Under-20, 2011.</li>
						<li><abbr title="Most Valuable Player" lang="en">MVP</abbr>, Supercoppa Italiana di Pallavolo femminile, 2012.</li>
						<li>Miglior Schiacciatrice, <span lang="en">Volleyball Nations League</span>, 2022.</li>
					</ul>', '', '../images/bosetti.jpg'),
(5, 'Gaia Giovannini', 0,'17/12/2001', 'Bologna', '<span lang="en">Megavolley</span>', 'Schiacciatrice', 182, 17, 27, 10, '', '', '../images/giovannini.jpeg'),
(6, 'Myriam Sylla', 0,'08/01/1995', 'Palermo', 'Pro Victoria', 'Schiacciatrice', 184, 17, 17, 60, '<ul>
						<li>Miglior schiacciatrice, Campionato Europeo di pallavolo femminile, 2021.</li>
						<li>Miglior schiacciatrice, Campionato Mondiale di pallavolo femminile, 2022.</li>
						<li>Miglior schiacciatrice, <span lang="en">Volleyball Nations League</span>, 2024.</li>
						<li>Miglior schiacciatrice di Pallavolo, Giochi della XXXIII Olimpiade - Torneo femminile, 2024.</li>
					</ul>', '', '../images/sylla.jpg'),
(7, 'Marina Lubian', 0,'11/04/2000', 'Moncalieri', 'Imoco', 'Centrale', 192, 9, 1, 1, '<ul>
						<li>Miglior centrale, Campionato Europeo di pallavolo femminile, 2023.</li>
					</ul>', '', '../images/lubian.jpg'),
(8, 'Sarah Fahr', 0,'12/09/2001', 'Kulmbach', 'Imoco', 'Centrale', 192, 19, 19, 36, '<ul>
						<li>Miglior centrale, Campionato Europeo di pallavolo femminile Under-19, 2018.</li>
						<li>Miglior centrale, <span lang="fr">Montreux</span> <span lang="en">Volley Master</span>, 2019.</li>
						<li>Miglior centrale, <span lang="en">Volleyball Nations League</span>, 2024.</li>
						<li><abbr title="Most Valuable Player" lang="en">MVP</abbr>, Supercoppa Italiana di Pallavolo femminile, 2024.</li>
					</ul>', '', '../images/fahr.jpg'),
(9, 'Paola Ogechi Egonu', 0,'10/12/1998', 'Cittadella', 'Pro Victoria', 'Opposto', 190, 18, 18, 110, '<ul>
						<li><abbr title="Most Valuable Player" lang="en">MVP</abbr>,Serie A1, 2022.</li>
						<li>Miglior opposto e <abbr title="Most Valuable Player" lang="en">MVP</abbr>, <span lang="en">Volleyball Nations League</span>, 2024.</li>
						<li><abbr title="Most Valuable Player" lang="en">MVP</abbr>, <span lang="en">Champions League</span>, 2024.</li>
						<li>Miglior opposto e <abbr title="Most Valuable Player" lang="en">MVP</abbr>, <span lang="en">Volleyball Nations League</span>, 2024.</li>
						<li>Miglior opposto e <abbr title="Most Valuable Player" lang="en">MVP</abbr>, di Pallavolo, Giochi della XXXIII Olimpiade - Torneo femminile, 2024.</li>
					</ul>', '', '../images/Egonu.jpg'),
(10, 'Ekaterina Antropova', 0,'19/09/2003', 'Akureyri', 'Savino Del Bene', 'Opposto', 202, 24, 24, 54, '', '', '../images/Antropova.jpg'),
(11, 'Monica De Gennaro', 0,'08/01/1987', 'Piano di Sorrento', 'Imoboco', 'Libero', 173, 10, 10, 64, '', '', '../images/DeGennaro.jpg'),
(12, 'Ilaria Spirito', 0,'20/02/1994', 'Albisola Superiore', 'Chieri'' 76', 'Tredicesima', 174, 5, 5, 0, '', '', '../images/spirito.jpg');


ALTER TABLE `giocatrici`
  ADD PRIMARY KEY (`ID`);

--
-- AUTO_INCREMENT per le tabelle scaricate
--

--
-- AUTO_INCREMENT per la tabella `personaggi`
--
ALTER TABLE `giocatrici`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;
COMMIT;

ALTER TABLE `giocatrici` ADD INDEX ( `ID` ) ;