-- Adminer 4.8.1 MySQL 8.0.32 dump

SET NAMES utf8;
SET time_zone = '+00:00';
SET foreign_key_checks = 0;
SET sql_mode = 'NO_AUTO_VALUE_ON_ZERO';

SET NAMES utf8mb4;

DROP TABLE IF EXISTS `yetis`;
CREATE TABLE `yetis` (
`id` int NOT NULL AUTO_INCREMENT,
`nickname` varchar(50) NOT NULL,
`height` int NOT NULL,
`weight` int NOT NULL,
`address` varchar(255) NOT NULL,
`gender` int NOT NULL,
`roll_dice` int NOT NULL DEFAULT '1',
`rate` int NOT NULL DEFAULT '0',
`born_at` date NOT NULL,
`created_at` date NOT NULL,
PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;


DROP TABLE IF EXISTS `yetis_rating`;
CREATE TABLE `yetis_rating` (
`id` int NOT NULL AUTO_INCREMENT,
`yeti_id` int NOT NULL,
`address` varchar(15) NOT NULL,
`is_positive` tinyint NOT NULL,
`rated_at` date NOT NULL,
PRIMARY KEY (`id`),
KEY `yeti_id` (`yeti_id`),
CONSTRAINT `yetis_rating_ibfk_1` FOREIGN KEY (`yeti_id`) REFERENCES `yetis` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;


-- 2023-07-26 15:58:25
