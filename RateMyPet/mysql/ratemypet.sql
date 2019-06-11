-- phpMyAdmin SQL Dump
-- version 4.8.5
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 19-05-2019 a las 20:03:54
-- Versión del servidor: 10.1.38-MariaDB
-- Versión de PHP: 7.3.2

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `ratemypet`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `comments`
--

CREATE TABLE `comments` (
  `idcomment` int(11) NOT NULL,
  `idPost` int(11) NOT NULL,
  `idUser` int(11) NOT NULL,
  `content` text NOT NULL,
  `likes` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `followedpets`
--

CREATE TABLE `followedpets` (
  `userId` int(11) NOT NULL,
  `petId` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `followedpets`
--

INSERT INTO `followedpets` (`userId`, `petId`) VALUES
(6, 37),
(6, 41),
(6, 45),
(7, 29),
(7, 45),
(9, 29),
(9, 38),
(10, 29),
(10, 37),
(10, 38),
(10, 41);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `likedcomments`
--

CREATE TABLE `likedcomments` (
  `idComment` int(11) NOT NULL,
  `idUser` int(11) NOT NULL,
  `idPost` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `likedposts`
--

CREATE TABLE `likedposts` (
  `idUser` int(11) NOT NULL,
  `idPost` int(11) NOT NULL,
  `time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `likedposts`
--

INSERT INTO `likedposts` (`idUser`, `idPost`, `time`) VALUES
(6, 44, '2019-05-18 20:03:31');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `messages`
--

CREATE TABLE `messages` (
  `idmes` varchar(9) NOT NULL,
  `content` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `pets`
--

CREATE TABLE `pets` (
  `idPet` int(11) NOT NULL,
  `name` text NOT NULL,
  `description` text NOT NULL,
  `type` text NOT NULL,
  `breed` text NOT NULL,
  `treats` int(11) NOT NULL,
  `topTreats` int(10) DEFAULT '0',
  `owner_id` int(11) NOT NULL,
  `verified` tinyint(1) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `pets`
--

INSERT INTO `pets` (`idPet`, `name`, `description`, `type`, `breed`, `treats`, `topTreats`, `owner_id`, `verified`) VALUES
(29, 'Kiwi', '              ', 'Cat', 'Siamesse', 0, 34, 6, 1),
(37, 'Josh', '                        ', 'Dog', 'Corgie', 0, 73, 7, 1),
(38, 'Teresa', '                                    ', 'Rabbit', 'Liebre', 0, 37, 6, 0),
(40, 'Nathan', '                                    ', 'Hamster', 'White', 0, 15, 6, 0),
(41, 'Sergio', '                                    ', 'Rabbit', 'Auditor', 0, 98, 9, 1),
(45, 'Tony', 'Hey there! My name is Tony the Parrot. Yes, I like to repeat everyhting I hear, so be careful what you say about my owner...', 'Bird', 'Parrot', 0, 15, 10, 1),
(46, 'George', '                                    ', 'Cat', 'Bengal', 0, 1, 10, 1),
(51, 'Ken', 'Woof!                                ', 'Dog', 'Labrador Retriever', 0, 0, 10, 1),
(52, 'Carlos', '                                        ', 'Rabbit', 'Dutch Rabbit', 0, 0, 10, 0),
(54, 'Toby', '                                        ', 'Hamster', 'Winter White', 0, 0, 10, 0),
(55, 'Bonnie', '                                        ', 'Dog', 'Beagle', 0, 0, 10, 1),
(56, 'Hoshi', 'Hoshi = Star (Japanese)                                    ', 'Dog', 'Yorkshire Terrier', 0, 0, 17, 0);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `petvalidation`
--

CREATE TABLE `petvalidation` (
  `petId` int(11) NOT NULL,
  `userIdA` int(11) DEFAULT NULL,
  `userIdB` int(11) DEFAULT NULL,
  `userIdC` int(11) DEFAULT NULL,
  `modId` int(11) DEFAULT NULL,
  `notAId` int(11) DEFAULT NULL,
  `notBId` int(11) DEFAULT NULL,
  `notCId` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `petvalidation`
--

INSERT INTO `petvalidation` (`petId`, `userIdA`, `userIdB`, `userIdC`, `modId`, `notAId`, `notBId`, `notCId`) VALUES
(56, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(38, 7, NULL, NULL, NULL, NULL, NULL, NULL),
(40, 7, NULL, NULL, NULL, NULL, NULL, NULL),
(54, 7, NULL, NULL, NULL, NULL, NULL, NULL),
(45, 7, NULL, NULL, NULL, 7, 7, NULL);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `posts`
--

CREATE TABLE `posts` (
  `idpost` int(11) NOT NULL,
  `title` varchar(80) NOT NULL,
  `time` datetime DEFAULT NULL,
  `likes` int(11) NOT NULL,
  `repets` int(11) NOT NULL,
  `petid` int(11) NOT NULL,
  `description` varchar(140) DEFAULT NULL,
  `pending` tinyint(1) NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `posts`
--

INSERT INTO `posts` (`idpost`, `title`, `time`, `likes`, `repets`, `petid`, `description`, `pending`) VALUES
(43, 'Madrid', '2019-05-18 00:00:00', 0, 0, 45, '                                    ', 1),
(44, 'Hello!', '2019-05-18 00:00:00', 0, 0, 45, '                                    ', 0),
(45, 'Hello There!', '2019-05-18 00:00:00', 0, 0, 37, '                                    ', 1),
(46, 'Little Bonnie', '2019-05-19 00:00:00', 0, 0, 55, 'This was Bonnie just 2 years ago...                            ', 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `postvalidation`
--

CREATE TABLE `postvalidation` (
  `idPost` int(11) NOT NULL,
  `userIdA` int(11) DEFAULT NULL,
  `userIdB` int(11) DEFAULT NULL,
  `userIdC` int(11) DEFAULT NULL,
  `modId` int(11) DEFAULT NULL,
  `notAId` int(11) DEFAULT NULL,
  `notBId` int(11) DEFAULT NULL,
  `notCId` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `postvalidation`
--

INSERT INTO `postvalidation` (`idPost`, `userIdA`, `userIdB`, `userIdC`, `modId`, `notAId`, `notBId`, `notCId`) VALUES
(45, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(46, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(43, 7, NULL, NULL, NULL, NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `seguimientos`
--

CREATE TABLE `seguimientos` (
  `userId` int(11) NOT NULL,
  `seguidorId` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `seguimientos`
--

INSERT INTO `seguimientos` (`userId`, `seguidorId`) VALUES
(6, 7),
(7, 6),
(10, 6),
(10, 7);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `username` varchar(20) NOT NULL,
  `fullname` varchar(20) NOT NULL,
  `password` varchar(80) NOT NULL,
  `email` varchar(20) NOT NULL,
  `rol` varchar(10) NOT NULL,
  `moderator` tinyint(1) NOT NULL DEFAULT '0',
  `numFollowers` int(5) NOT NULL,
  `numFollowing` int(5) NOT NULL,
  `treats` tinyint(1) NOT NULL DEFAULT '3'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `users`
--

INSERT INTO `users` (`id`, `username`, `fullname`, `password`, `email`, `rol`, `moderator`, `numFollowers`, `numFollowing`, `treats`) VALUES
(6, 'aaaaa', 'aaaaa', '$2y$10$NPVudwkP4mD5Eai4vzwDIudVI3nDpSEB3ccZq2RiLYrQAOtlTxJSW', 'adruiz01@ucm.es', 'user', 1, 0, 0, 3),
(7, 'Nanuk', 'Adrián Ruiz', '$2y$10$1X4kam12YUORObXQAF3JFOa1ahYjCfYNf9XxsBN92MZh5REwFsfJK', 'adruiz01@ucm.es', 'user', 1, 0, 0, 3),
(8, 'Houghton', 'Miguel Houghton', '$2y$10$Oi8MvxWuZM88JYVV41fpP./yipnXijnxihmm33c/xZJTfIW3c.zs2', 'miguelho@ucm.es', 'user', 1, 0, 0, 3),
(9, 'bbbbb', 'bbbbb', '$2y$10$ZH.5pzHeQQn6P/JR5Rhu0eMuas8PaTtTualPyTG8EYS1qFX8pURAC', 'leyendarhu@gmail.com', 'user', 1, 0, 0, 3),
(10, 'admin', 'admin', '$2y$10$FlxvitpTVzOU.jh2nWCpe.Ki623KzAiGG20UJEZbsGndQ6/sfGkJy', 'admin@ucm.es', 'admin', 0, 0, 0, 3),
(11, 'Carlos', 'Carlos', '$2y$10$aZZXCkrrQgAEIvjqFIdjGeFDs0XLgbkfuxaSUxatFD4JTGrOpsqyu', 'carl@ucm.es', 'user', 0, 0, 0, 3),
(12, 'Teresa', 'Teresa', '$2y$10$LXmJw74vMTjWU1j0imnREeW4G5NFTMjo5zrm4H2tFgt.TgNAvuhFm', 'teresa@gmail.com', 'user', 0, 0, 0, 3),
(13, 'LuisVi', 'LuisVi', '$2y$10$DBFzZ5k0jTDBZfiBPWx.CeYQh0.yy6Jm495u/fDC3xfaUlfAHN1RO', 'LuisVi@ucm.es', 'user', 0, 0, 0, 3),
(14, 'ccccc', 'ccccc', '$2y$10$OPp10eH2dpsXu15EPZ84C.V99AftyhWQp00ivujTb.R3Yr0NP2K9C', 'ccccc@ucm.es', 'user', 0, 0, 0, 3),
(15, 'ddddd', 'ddddd', '$2y$10$vJQu1OVcY97jIrx1KXN7puFmxeVH4E98W1X6KxEgKnVoUjYdAS9mm', 'ddddd@ucm.es', 'user', 0, 0, 0, 3),
(16, 'eeeee', 'eeeee', '$2y$10$A.livmSA9x2MiHk7nHw.DuM9GZPtx9RmfaSRNBE5SuTp.KtdD6.xy', 'eeeee@ucm.es', 'user', 0, 0, 0, 3),
(17, 'ffffff', 'ffffff', '$2y$10$xPXsJoOQU/S2h/PR55G77.deTHvnXd1sB5wQ/kuM4iOqmizzLBjTG', 'ffffff@ucm.es', 'user', 0, 0, 0, 3);

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `comments`
--
ALTER TABLE `comments`
  ADD PRIMARY KEY (`idcomment`,`idPost`,`idUser`),
  ADD UNIQUE KEY `idx` (`idcomment`,`idPost`),
  ADD KEY `idcomment` (`idcomment`,`idPost`),
  ADD KEY `idPost` (`idPost`),
  ADD KEY `idUser` (`idUser`),
  ADD KEY `idcomment_2` (`idcomment`),
  ADD KEY `idcomment_3` (`idcomment`,`idPost`,`idUser`);

--
-- Indices de la tabla `followedpets`
--
ALTER TABLE `followedpets`
  ADD PRIMARY KEY (`userId`,`petId`),
  ADD KEY `petId` (`petId`);

--
-- Indices de la tabla `likedcomments`
--
ALTER TABLE `likedcomments`
  ADD PRIMARY KEY (`idComment`,`idUser`,`idPost`),
  ADD KEY `idUser` (`idUser`);

--
-- Indices de la tabla `likedposts`
--
ALTER TABLE `likedposts`
  ADD PRIMARY KEY (`idUser`,`idPost`),
  ADD KEY `idPost` (`idPost`);

--
-- Indices de la tabla `messages`
--
ALTER TABLE `messages`
  ADD PRIMARY KEY (`idmes`);

--
-- Indices de la tabla `pets`
--
ALTER TABLE `pets`
  ADD PRIMARY KEY (`idPet`,`owner_id`),
  ADD KEY `owner_id` (`owner_id`);

--
-- Indices de la tabla `petvalidation`
--
ALTER TABLE `petvalidation`
  ADD PRIMARY KEY (`petId`),
  ADD KEY `userIdA` (`userIdA`,`userIdB`,`userIdC`,`modId`,`notAId`,`notBId`,`notCId`),
  ADD KEY `petvalidation_ibfk_3` (`userIdB`),
  ADD KEY `petvalidation_ibfk_4` (`userIdC`),
  ADD KEY `petvalidation_ibfk_5` (`modId`),
  ADD KEY `petvalidation_ibfk_6` (`notAId`),
  ADD KEY `petvalidation_ibfk_7` (`notBId`),
  ADD KEY `petvalidation_ibfk_8` (`notCId`);

--
-- Indices de la tabla `posts`
--
ALTER TABLE `posts`
  ADD PRIMARY KEY (`idpost`,`petid`),
  ADD KEY `petid` (`petid`);

--
-- Indices de la tabla `postvalidation`
--
ALTER TABLE `postvalidation`
  ADD PRIMARY KEY (`idPost`),
  ADD KEY `userIdA` (`userIdA`,`userIdB`,`userIdC`,`modId`,`notAId`,`notBId`,`notCId`),
  ADD KEY `postvalidation_ibfk_3` (`userIdB`),
  ADD KEY `postvalidation_ibfk_4` (`userIdC`),
  ADD KEY `postvalidation_ibfk_5` (`modId`),
  ADD KEY `postvalidation_ibfk_6` (`notAId`),
  ADD KEY `postvalidation_ibfk_7` (`notBId`),
  ADD KEY `postvalidation_ibfk_8` (`notCId`);

--
-- Indices de la tabla `seguimientos`
--
ALTER TABLE `seguimientos`
  ADD PRIMARY KEY (`userId`,`seguidorId`),
  ADD KEY `userId` (`userId`,`seguidorId`),
  ADD KEY `seguidorId` (`seguidorId`);

--
-- Indices de la tabla `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id` (`id`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `comments`
--
ALTER TABLE `comments`
  MODIFY `idcomment` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT de la tabla `pets`
--
ALTER TABLE `pets`
  MODIFY `idPet` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=57;

--
-- AUTO_INCREMENT de la tabla `posts`
--
ALTER TABLE `posts`
  MODIFY `idpost` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=47;

--
-- AUTO_INCREMENT de la tabla `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `comments`
--
ALTER TABLE `comments`
  ADD CONSTRAINT `comments_ibfk_1` FOREIGN KEY (`idPost`) REFERENCES `posts` (`idpost`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `comments_ibfk_2` FOREIGN KEY (`idUser`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `followedpets`
--
ALTER TABLE `followedpets`
  ADD CONSTRAINT `followedpets_ibfk_1` FOREIGN KEY (`userId`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `followedpets_ibfk_2` FOREIGN KEY (`petId`) REFERENCES `pets` (`idPet`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `likedcomments`
--
ALTER TABLE `likedcomments`
  ADD CONSTRAINT `likedcomments_ibfk_1` FOREIGN KEY (`idUser`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `likedcomments_ibfk_2` FOREIGN KEY (`idComment`) REFERENCES `comments` (`idcomment`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `likedposts`
--
ALTER TABLE `likedposts`
  ADD CONSTRAINT `likedposts_ibfk_1` FOREIGN KEY (`idUser`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `likedposts_ibfk_2` FOREIGN KEY (`idPost`) REFERENCES `posts` (`idpost`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `petvalidation`
--
ALTER TABLE `petvalidation`
  ADD CONSTRAINT `petvalidation_ibfk_1` FOREIGN KEY (`petId`) REFERENCES `pets` (`idPet`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `petvalidation_ibfk_2` FOREIGN KEY (`userIdA`) REFERENCES `users` (`id`) ON DELETE SET NULL ON UPDATE CASCADE,
  ADD CONSTRAINT `petvalidation_ibfk_3` FOREIGN KEY (`userIdB`) REFERENCES `users` (`id`) ON DELETE SET NULL ON UPDATE CASCADE,
  ADD CONSTRAINT `petvalidation_ibfk_4` FOREIGN KEY (`userIdC`) REFERENCES `users` (`id`) ON DELETE SET NULL ON UPDATE CASCADE,
  ADD CONSTRAINT `petvalidation_ibfk_5` FOREIGN KEY (`modId`) REFERENCES `users` (`id`) ON DELETE SET NULL ON UPDATE CASCADE,
  ADD CONSTRAINT `petvalidation_ibfk_6` FOREIGN KEY (`notAId`) REFERENCES `users` (`id`) ON DELETE SET NULL ON UPDATE CASCADE,
  ADD CONSTRAINT `petvalidation_ibfk_7` FOREIGN KEY (`notBId`) REFERENCES `users` (`id`) ON DELETE SET NULL ON UPDATE CASCADE,
  ADD CONSTRAINT `petvalidation_ibfk_8` FOREIGN KEY (`notCId`) REFERENCES `users` (`id`) ON DELETE SET NULL ON UPDATE CASCADE;

--
-- Filtros para la tabla `posts`
--
ALTER TABLE `posts`
  ADD CONSTRAINT `posts_ibfk_1` FOREIGN KEY (`petid`) REFERENCES `pets` (`idPet`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `postvalidation`
--
ALTER TABLE `postvalidation`
  ADD CONSTRAINT `postvalidation_ibfk_1` FOREIGN KEY (`idPost`) REFERENCES `posts` (`idpost`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `postvalidation_ibfk_2` FOREIGN KEY (`userIdA`) REFERENCES `users` (`id`) ON DELETE SET NULL ON UPDATE CASCADE,
  ADD CONSTRAINT `postvalidation_ibfk_3` FOREIGN KEY (`userIdB`) REFERENCES `users` (`id`) ON DELETE SET NULL ON UPDATE CASCADE,
  ADD CONSTRAINT `postvalidation_ibfk_4` FOREIGN KEY (`userIdC`) REFERENCES `users` (`id`) ON DELETE SET NULL ON UPDATE CASCADE,
  ADD CONSTRAINT `postvalidation_ibfk_5` FOREIGN KEY (`modId`) REFERENCES `users` (`id`) ON DELETE SET NULL ON UPDATE CASCADE,
  ADD CONSTRAINT `postvalidation_ibfk_6` FOREIGN KEY (`notAId`) REFERENCES `users` (`id`) ON DELETE SET NULL ON UPDATE CASCADE,
  ADD CONSTRAINT `postvalidation_ibfk_7` FOREIGN KEY (`notBId`) REFERENCES `users` (`id`) ON DELETE SET NULL ON UPDATE CASCADE,
  ADD CONSTRAINT `postvalidation_ibfk_8` FOREIGN KEY (`notCId`) REFERENCES `users` (`id`) ON DELETE SET NULL ON UPDATE CASCADE;

--
-- Filtros para la tabla `seguimientos`
--
ALTER TABLE `seguimientos`
  ADD CONSTRAINT `seguimientos_ibfk_1` FOREIGN KEY (`userId`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `seguimientos_ibfk_2` FOREIGN KEY (`seguidorId`) REFERENCES `users` (`id`);

DELIMITER $$
--
-- Eventos
--
CREATE DEFINER=`root`@`localhost` EVENT `reset_treats_users` ON SCHEDULE EVERY 1 MINUTE STARTS '2019-05-14 00:00:00' ON COMPLETION PRESERVE ENABLE DO UPDATE users SET treats = 3$$

CREATE DEFINER=`root`@`localhost` EVENT `reset_treats_rank` ON SCHEDULE EVERY 10 MINUTE STARTS '2019-05-14 00:00:00' ON COMPLETION PRESERVE ENABLE DO BEGIN 
    UPDATE pets p1, (SELECT treats, idPet FROM pets ) p2
    SET p1.topTreats = p2.treats
    WHERE p1.topTreats < p2.treats &&
    p1.idPet = p2.idPet;

    UPDATE pets p1
    SET treats = 0;
END$$

DELIMITER ;

SET GLOBAL event_scheduler = ON;

COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
