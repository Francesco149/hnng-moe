SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

CREATE TABLE IF NOT EXISTS `hnng_urls` (
  `id` char(16) character set utf8 collate utf8_bin NOT NULL,
  `url` text character set utf8 collate utf8_bin NOT NULL,
  `ip` char(45) character set utf8 collate utf8_bin NOT NULL,
  `time` timestamp NOT NULL default CURRENT_TIMESTAMP,
  `hash` char(32) character set utf8 collate utf8_bin NOT NULL,
  `deletekey` char(32) character set utf8 collate utf8_bin NOT NULL, 
  `number` INT NOT NULL, 
  PRIMARY KEY  (`id`),
  UNIQUE KEY `hash` (`hash`),
  UNIQUE KEY `time` (`time`), 
  UNIQUE KEY `deletekey` (`deletekey`), 
  UNIQUE KEY `number` (`number`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

CREATE TABLE IF NOT EXISTS `hnng_deleted_urls` (
  `id` char(16) character set utf8 collate utf8_bin NOT NULL,
  `url` text character set utf8 collate utf8_bin NOT NULL,
  `ip` char(45) character set utf8 collate utf8_bin NOT NULL,
  `time` timestamp NOT NULL default CURRENT_TIMESTAMP,
  `hash` char(32) character set utf8 collate utf8_bin NOT NULL, 
  `number` INT NOT NULL AUTO_INCREMENT, 
  `deletedbyip` char(45) character set utf8 collate utf8_bin NOT NULL,
  PRIMARY KEY  (`id`),
  UNIQUE KEY `hash` (`hash`),
  UNIQUE KEY `time` (`time`), 
  UNIQUE KEY `number` (`number`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
