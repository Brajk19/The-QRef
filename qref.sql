-- phpMyAdmin SQL Dump
-- version 5.0.4
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: May 16, 2021 at 11:44 PM
-- Server version: 10.4.17-MariaDB
-- PHP Version: 8.0.2

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `qref`
--

-- --------------------------------------------------------

--
-- Table structure for table `avatar`
--

CREATE TABLE `avatar` (
  `email` varchar(50) NOT NULL,
  `avatar` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `avatar`
--

INSERT INTO `avatar` (`email`, `avatar`) VALUES
('admin', '14'),
('d.b@gmail.com', 'avatar2'),
('q.q@gmail.com', 'avatar9'),
('q.q@gmail.com', 'avatar8'),
('qwe.qwe@gmaill.com', 'avatar3'),
('zhdfg.fdgub@gmail.com', 'avatar4'),
('brajkovic.adrian@gmail.com', 'avatar10'),
('darth.maul@gmail.com', 'avatar9'),
('obi-wan.kenobi@gmail.com', 'avatar16'),
('general.grievous@gmail.com', 'avatar15'),
('peter.parker@gmail.com', 'avatar18'),
('groot@gmail.com', 'avatar17');

-- --------------------------------------------------------

--
-- Table structure for table `comment`
--

CREATE TABLE `comment` (
  `quizID` varchar(50) NOT NULL,
  `email` varchar(50) NOT NULL,
  `comment` mediumtext NOT NULL,
  `time` int(11) NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `comment`
--

INSERT INTO `comment` (`quizID`, `email`, `comment`, `time`) VALUES
('1', 'general.grievous@gmail.com', 'You are a bold one.', 1621107849),
('1', 'general.grievous@gmail.com', 'General Kenobi!', 1621107882),
('1', 'obi-wan.kenobi@gmail.com', 'Hello there.', 1621107921),
('14', 'brajkovic.adrian@gmail.com', 'brate *nitko* ti ovo nece znati', 1621112051),
('14', 'brajkovic.adrian@gmail.com', '*ostavi se* kvizova, *ne* ide ti', 1621112124),
('14', 'brajkovic.adrian@gmail.com', 'uzas', 1621112313),
('14', 'brajkovic.adrian@gmail.com', '*_PODRCTRANO I BOLDANO_*', 1621112388),
('14', 'brajkovic.adrian@gmail.com', 'kolega, jeo sam jogurte koji su bili zanimljiviji od ovog kviza', 1621112442),
('14', 'darth.maul@gmail.com', 'Uistinu intrigrantan kviz.', 1621169657),
('16', 'peter.parker@gmail.com', 'Mr. Stark, I don\'t feel so good...', 1621185331),
('16', 'groot@gmail.com', 'I am Groot.', 1621185519);

-- --------------------------------------------------------

--
-- Table structure for table `password`
--

CREATE TABLE `password` (
  `email` varchar(50) NOT NULL,
  `passwordHash` varchar(1000) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `password`
--

INSERT INTO `password` (`email`, `passwordHash`) VALUES
('admin', '$2y$10$9o9DW7UDp60nx0BlPU1CvugKVa8ji/AzqMxMGfG5Bqo7K9I/y/vB6'),
('brajkovic.adrian@gmail.com', '$2y$10$ePhNoSS3lZdx64dyh1EExOJqB/gpMmT.bhQlczfGBXvSAmlCiyGLO'),
('d.b@gmail.com', '$2y$10$3nnJtaTyR6/tnn9PseI1gu4UQKnBJ9zJLRTjYRcA0Z6Qa8fRbc90y'),
('darth.maul@gmail.com', '$2y$10$sVIpLILo.N31j3cP/7jOeuD3rWfkMZxZBV8RS95SoivlSyO8LA/AK'),
('general.grievous@gmail.com', '$2y$10$Q3kJy1GSPAKrLJr6aWn5HeKt774NmCnHQ8Bx6yyxOp14NiPZxevT6'),
('groot@gmail.com', '$2y$10$BEvGr6mW60Q4plPXCGEoH.lPpDqeLktuMmeEV7c30xtskzUY6oxPK'),
('obi-wan.kenobi@gmail.com', '$2y$10$iz/3zImSnX950nP2/ukVQuSOrqx6wCO6IA4q22mBguT3xGyQ772G6'),
('peter.parker@gmail.com', '$2y$10$9N9dZiYbT2EtXPrOd.P9YOA5pHwfZVkcsJoEi7I7STZ3K3azmZ0yS'),
('q.q@gmail.com', '$2y$10$JHS0FWNEd8MrsAMIbII5kenmfNVEYPds83HDJISFPcA9rmFkKzcMa'),
('qwe.qwe@gmaill.com', '$2y$10$fUxtmMdm.yNLGmQlm.LXaO74eic0uSnrh.XQWbWYa4nd8WQ/EnRBa'),
('zhdfg.fdgub@gmail.com', '$2y$10$xpcuK2Oux2Rn2nK2d9dQ8e7icZsku8Q3W9i4xcfE61J0vTpfFQQJG');

-- --------------------------------------------------------

--
-- Table structure for table `quiz`
--

CREATE TABLE `quiz` (
  `id` int(11) NOT NULL,
  `email` varchar(50) NOT NULL,
  `name` varchar(50) NOT NULL,
  `description` mediumtext NOT NULL,
  `public` tinyint(1) NOT NULL,
  `comments` tinyint(1) NOT NULL,
  `qref` mediumtext NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `quiz`
--

INSERT INTO `quiz` (`id`, `email`, `name`, `description`, `public`, `comments`, `qref`) VALUES
(1, 'general.grievous@gmail.com', 'Star Wars', 'Just a couple of questions from Star Wars universe.', 1, 1, 'Who killed Jabba?{1}:Han Solo,Luke Skywalker,Princess Leia,Darth Vader,Princess Leia;\r\nWhere did the Clone Wars begin?{1}:Tatooine,Geonosis,Naboo,Coruscant,Geonosis;\r\nWho freed Princess Leia from her chains at Jabba\'s palace?{1}:C-3PO,Luke Skywalker,R2-D2,Han Solo,R2-D2;\r\nHow many lightsabers does General Grievous wield in his fight with Obi-Wan on Utapau?{1}:one,two,three,four,four;\r\nChoose the Jedi.{2}:Ahsoka Tano,Yoda,Han SOlo, Obi-Wan Kenobi,Ahsoka Tano,Yoda,Obi-Wan Kenobi;\r\n\r\n'),
(14, 'brajkovic.adrian@gmail.com', 'General knowledge', 'Test your knowledge.', 1, 1, 'In the Lego Island trilogy, who taught Pepper Roni how to read?{1}:Papa Brickolini,Officer Laura Brick,Mama Brickolini,Officer Nick Brick,Officer Laura Brick;\r\nIn which city did American rap producer DJ Khaled originate from?{1}:New York,Miami,Detroit,Atlanta,Miami;\r\nIn Terraria, which debuff does the ankh charm not provide immunity to?{1}:Venom,Slow,Bleeding,Cursed,Venom;\r\nWhich of the following cellular device companies is NOT headquartered in Asia?{1}:Nokia,LG Electronics,HTC,Samsung,Nokia;\r\nWhat year was the Mona Lisa finished?{1}:1504,1487,1523,1511,1504;\r\nHow many sovereign states are members of the United Nations?{1}:153,178,201,195,195;\r\nHow many sonatas did Ludwig van Beethoven write?{1}:31,50,32,21,32;\r\nWhat was the wifi password given to Stephen Strange in Doctor Strange?{1}:Ancient,Chakra,Shambala,Peace,Shambala;\r\nThe largest consumer market in 2015 was...{1}:Germany,The United States of America,United Kingdom,Japan,The United States of America;\r\nWhich of the following Call of Duty games was a PS3 launch title?{1}:Call of Duty 4: Modern Warfare,Call of Duty: World at War,Call of Duty 3,Call of Duty: Roads to Victory,Call of Duty 3;\r\nIn past times, what would a gentleman keep in his fob pocket?{1}:Notebook,Money,Keys,Watch,Watch;\r\nIn what year was the original Sonic the Hedgehog game released?{1}:1995,1991,1993,1989,1991;\r\nWhich member of the Wu-Tang Clan had only one verse in their debut album Enter the Wu-Tang (36 Chambers)?{1}:GZA,Inspectah Deck,Method Man,Masta Killa,Masta Killa;\r\nWhat book series published by Jim Butcher follows a wizard in modern day Chicago?{1}:My Life as a Teenage Wizard,The Cinder Spires,The Dresden Files,A Hat in Time,The Dresden Files;\r\nBilly Herrington is from which US state?{1}:California,New York,Georgia,Arizona,New York;\r\nWhich of 2 Valve Games are set in the same universe?{1}:Half-life and Left 4 Dead,Half-life and Counter Strike,Half-life and Portal,Portal and Left 4 Dead,Half-life and Portal;\r\nWho won the 2015 College Football Playoff (CFP) National Championship? {1}:Ohio State Buckeyes,Wisconsin Badgers,Clemson Tigers,Alabama Crimson Tide,Ohio State Buckeyes;\r\nWhich of the following famous mathematicians died in a duel at the age of 20?{1}:Euler,Abel,Gauss,Galois,Galois;\r\nBefore the American colonies switched to the Gregorian calendar in 1752, on what date did their new year start?{1}:September 25th,March 25th,June 1st,December 1st,March 25th;\r\nWhich of these plays was famously first performed posthumously after the playwright committed suicide?{1}:4.48 Psychosis,Much Ado About Nothing,The Birthday Party,Hamilton,4.48 Psychosis;\r\nWhat nationality was sultan Saladin?{1}:Kurdish,Arab,Egyptian,Syrian,Kurdish;\r\nFive dollars is worth how many nickles?{1}:25,50,100,69,100;\r\nWhat is the name given to Indian food cooked over charcoal in a clay oven?{1}:Tandoori,Pani puri,Tiki masala,Biryani,Tandoori;\r\nWhich of these names was an actual codename for a cancelled Microsoft project?{1}:Saturn,Pollux,Enceladus,Neptune,Neptune;\r\nWhat is the name of the Canadian national anthem?{1}:O Red Maple,Leaf-Spangled Banner,March of the Puck Drop,O Canada,O Canada;\r\nBefore Super Smash Bros. contained Nintendo characters, what was it known as internally?{1}:Dragon King: The Fighting Game,Fighter of the Ages: Conquest,Smash and Pummel,Contest of Champions,Dragon King: The Fighting Game;\r\nBir Tawil, an uninhabited track of land claimed by no country, is located along the border of which two countries?{1}:Israel and Jordan,Chad and Libya,Egypt and Sudan,Iraq and Saudi Arabia,Egypt and Sudan;\r\nHow many rivers are in Saudi Arabia?{1}:1,3,0,2,0;\r\nWhat is the capital of India?{1}:Montreal,Tithi,New Delhi,Bejing,New Delhi;\r\nThe creeper in Minecraft was the result of a bug while implementing which creature?{1}:Pig,Cow,Zombie,Chicken,Pig;\r\nWhich of the following Pokemon Types was present in the original games, Red and Blue?{1}:Steel,Fairy,Ice,Dark,Ice;\r\nWhich dictator killed the most people?{1}:Joseph Stalin,Kim Il Sung,Mao Zedong,Adolf Hitler,Mao Zedong;\r\n'),
(16, 'brajkovic.adrian@gmail.com', 'Marvel', 'Test your knowledge of famous movies/comics.', 1, 1, 'What is Captain America\'s shield made out of?{1}:Gravitonium,Vibranium,Adamantium,Scabrite,Vibranium;\r\nWhat country are Scarlet Witch and Quicksilver from?{1}:Wakanda,Sokovia,Krakoa,Symkaria,Sokovia;\r\nSelect members of Black Order (The Children of Thanos){2}:Ultron,Corvus Glaive,Cull Obsidian,Dormammu,Corvus Glaive,Cull Obsidian;\r\nWhat does the \'E\' in S.H.I.E.L.D. stand for?{3}:enforcement;\r\nWhat is the first Marvel Cinematic Universe movie?{3}:Iron Man;\r\n');

-- --------------------------------------------------------

--
-- Table structure for table `result`
--

CREATE TABLE `result` (
  `quizID` varchar(50) NOT NULL,
  `email` varchar(50) NOT NULL,
  `score` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `result`
--

INSERT INTO `result` (`quizID`, `email`, `score`) VALUES
('1', 'brajkovic.adrian@gmail.com', 2),
('1', 'brajkovic.adrian@gmail.com', 7),
('14', 'brajkovic.adrian@gmail.com', 11),
('14', 'brajkovic.adrian@gmail.com', 8),
('14', 'brajkovic.adrian@gmail.com', 1),
('15', 'brajkovic.adrian@gmail.com', 1),
('15', 'brajkovic.adrian@gmail.com', 2),
('14', 'general.grievous@gmail.com', 8),
('1', 'brajkovic.adrian@gmail.com', 7),
('15', 'brajkovic.adrian@gmail.com', 0),
('15', 'brajkovic.adrian@gmail.com', 1),
('15', 'general.grievous@gmail.com', 1),
('15', 'general.grievous@gmail.com', 0),
('15', 'general.grievous@gmail.com', 0),
('15', 'general.grievous@gmail.com', 0),
('14', 'general.grievous@gmail.com', 10),
('1', 'general.grievous@gmail.com', 3),
('1', 'general.grievous@gmail.com', 4),
('15', 'general.grievous@gmail.com', 0),
('15', 'general.grievous@gmail.com', 0),
('15', 'general.grievous@gmail.com', 3),
('14', 'darth.maul@gmail.com', 10),
('15', 'darth.maul@gmail.com', 3),
('1', 'darth.maul@gmail.com', 4),
('1', 'darth.maul@gmail.com', 0),
('1', 'darth.maul@gmail.com', 3),
('1', 'darth.maul@gmail.com', 2),
('1', 'darth.maul@gmail.com', 1),
('1', 'darth.maul@gmail.com', 0),
('1', 'darth.maul@gmail.com', 0),
('1', 'darth.maul@gmail.com', 0),
('14', 'darth.maul@gmail.com', 5),
('1', 'darth.maul@gmail.com', 3),
('15', 'darth.maul@gmail.com', 0),
('16', 'peter.parker@gmail.com', 4),
('16', 'groot@gmail.com', 4),
('16', 'brajkovic.adrian@gmail.com', 4),
('16', 'brajkovic.adrian@gmail.com', 3),
('1', 'general.grievous@gmail.com', 5);

-- --------------------------------------------------------

--
-- Table structure for table `session`
--

CREATE TABLE `session` (
  `sessionID` varchar(250) NOT NULL,
  `email` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `session`
--

INSERT INTO `session` (`sessionID`, `email`) VALUES
('20284299660a18d1c094d84.150475306860604760a18d1c094e17.69372022192097748760a18d1c094e30.825870564274805260a18d1c094e57.7412486118882573860a18d1c094e66.11264540', 'general.grievous@gmail.com');

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `firstName` varchar(50) NOT NULL,
  `lastName` varchar(50) NOT NULL,
  `dateOfBirth` date NOT NULL,
  `email` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`firstName`, `lastName`, `dateOfBirth`, `email`) VALUES
('asd', 'asd', '2021-04-30', 'd.b@gmail.com'),
('asd', 'fgh', '2021-04-06', 'q.q@gmail.com'),
('asd', 'asd', '2021-04-27', 'q.q@gmail.com'),
('we', 'wer', '2021-04-28', 'qwe.qwe@gmaill.com'),
('46ztfgh', '56uth', '2021-04-29', 'zhdfg.fdgub@gmail.com'),
('Adrian', 'Brajkovic', '2000-06-19', 'brajkovic.adrian@gmail.com'),
('Darth', 'Maul', '2008-07-15', 'darth.maul@gmail.com'),
('Obi-Wan', 'Kenobi', '1974-11-19', 'obi-wan.kenobi@gmail.com'),
('General', 'Grievous', '2021-05-04', 'general.grievous@gmail.com'),
('Peter', 'Parker', '2001-08-10', 'peter.parker@gmail.com'),
('Groot', ' ', '2014-08-13', 'groot@gmail.com');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `password`
--
ALTER TABLE `password`
  ADD UNIQUE KEY `username` (`email`);

--
-- Indexes for table `quiz`
--
ALTER TABLE `quiz`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `session`
--
ALTER TABLE `session`
  ADD UNIQUE KEY `sessionID` (`sessionID`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `quiz`
--
ALTER TABLE `quiz`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
