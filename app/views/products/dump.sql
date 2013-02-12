-- Adminer 3.5.1 MySQL dump

SET NAMES utf8;
SET foreign_key_checks = 0;
SET time_zone = 'SYSTEM';
SET sql_mode = 'NO_AUTO_VALUE_ON_ZERO';

DROP TABLE IF EXISTS `products`;
CREATE TABLE `products` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `nome` varchar(200) NOT NULL,
  `preco` double(17,8) NOT NULL,
  `qtd` int(11) NOT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL,
  `deleted_at` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

INSERT INTO `products` (`id`, `nome`, `preco`, `qtd`, `created_at`, `updated_at`, `deleted_at`) VALUES
(2,	'Produto1000',	23.45000000,	10,	'2013-01-23 19:13:54',	'2013-01-23 20:06:27',	'0000-00-00 00:00:00'),
(3,	'Produto01',	23.45000000,	10,	'2013-01-23 19:16:39',	'0000-00-00 00:00:00',	'0000-00-00 00:00:00'),
(4,	'Produto01',	23.45000000,	10,	'2013-01-23 19:17:17',	'0000-00-00 00:00:00',	'0000-00-00 00:00:00'),
(5,	'Produto 02',	45.90000000,	30,	'2013-01-23 19:26:02',	'0000-00-00 00:00:00',	'0000-00-00 00:00:00'),
(6,	'Tenis Adidas BFH',	23.50000000,	23,	'2013-01-23 19:41:25',	'0000-00-00 00:00:00',	'0000-00-00 00:00:00');

-- 2013-01-23 20:10:49