CREATE TABLE IF NOT EXISTS `hnng_deleted_uploads` (
  `id` char(16) character set utf8 collate utf8_bin NOT NULL,
  `mime_type` char(255) character set utf8 collate utf8_bin NOT NULL,
  `original_name` char(255) character set utf8 collate utf8_bin NOT NULL,
  `ip` char(45) character set utf8 collate utf8_bin NOT NULL,
  `time` timestamp NOT NULL default CURRENT_TIMESTAMP,
  `number` INT NOT NULL, 
  `deletedbyip` char(45) character set utf8 collate utf8_bin NOT NULL,
  PRIMARY KEY  (`id`),
  UNIQUE KEY `number` (`number`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

CREATE TABLE IF NOT EXISTS `hnng_deleted_urls` (
  `id` char(16) character set utf8 collate utf8_bin NOT NULL,
  `url` text character set utf8 collate utf8_bin NOT NULL,
  `ip` char(45) character set utf8 collate utf8_bin NOT NULL,
  `time` timestamp NOT NULL default CURRENT_TIMESTAMP,
  `hash` char(32) character set utf8 collate utf8_bin NOT NULL, 
  `number` INT NOT NULL, 
  `deletedbyip` char(45) character set utf8 collate utf8_bin NOT NULL,
  PRIMARY KEY  (`id`),
  UNIQUE KEY `hash` (`hash`),
  UNIQUE KEY `number` (`number`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

ALTER TABLE `hnng_uploads` ADD `deletekey` CHAR( 32 ) CHARACTER SET utf8 COLLATE utf8_bin NULL;
ALTER TABLE `hnng_urls` ADD `deletekey` CHAR( 32 ) CHARACTER SET utf8 COLLATE utf8_bin NULL;

ALTER TABLE `hnng_uploads` ADD `number` INT NOT NULL AUTO_INCREMENT ,
ADD UNIQUE (
`number`
);

ALTER TABLE `hnng_urls` ADD `number` INT NOT NULL AUTO_INCREMENT ,
ADD UNIQUE (
`number`
);

-- insert updated php files

UPDATE `hnng_uploads` SET `deletekey`=md5(CONCAT(`id`, `mime_type`, `original_name`, `ip`, `time`)) WHERE 1;
ALTER TABLE `hnng_uploads` CHANGE `deletekey` `deletekey` CHAR( 32 ) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL;
ALTER TABLE `hnng_uploads` ADD UNIQUE (
`deletekey`
);

UPDATE `hnng_urls` SET `deletekey`=md5(CONCAT(`id`, `url`, `ip`, `time`, `hash`)) WHERE 1;
ALTER TABLE `hnng_urls` CHANGE `deletekey` `deletekey` CHAR( 32 ) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL;
ALTER TABLE `hnng_urls` ADD UNIQUE (
`deletekey`
);