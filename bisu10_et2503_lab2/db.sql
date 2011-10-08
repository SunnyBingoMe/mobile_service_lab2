
CREATE DATABASE  `mobile_lab` DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci;
USE mobile;

CREATE TABLE IF NOT EXISTS `lab2` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL,
  `text` varchar(500) COLLATE utf8_unicode_ci DEFAULT NULL,
  `time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `priority` int(20) unsigned NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;
