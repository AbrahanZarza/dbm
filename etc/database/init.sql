DROP DATABASE IF EXISTS test;
CREATE DATABASE `test` CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci;

USE `test`;

DROP TABLE IF EXISTS `categories`;
CREATE TABLE `categories` (
    `id` int NOT NULL AUTO_INCREMENT,
    `name` varchar(255) NOT NULL,
    PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

DROP TABLE IF EXISTS `products`;
CREATE TABLE `products` (
    `id` int NOT NULL AUTO_INCREMENT,
    `name` varchar(255) NOT NULL,
    `description` text NULL,
    `category_id` int NOT NULL,
    PRIMARY KEY (`id`),
    CONSTRAINT `fk_product_categories` FOREIGN KEY (`category_id`) REFERENCES `categories` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

INSERT INTO `categories` (`id`, `name`) VALUES
(1, 'Food'),
(2, 'Home'),
(3, 'Garden');

INSERT INTO `products` (`id`, `name`, `description`, `category_id`) VALUES
(1, 'Pizza', 'A pizza with BBQ sauce.', 1),
(2, 'Rice', 'One kg of rice.', 1),
(3, 'Chart', 'A chart with a boat in the sea.', 2),
(4, 'mower', 'A mower with steel blades.', 3);