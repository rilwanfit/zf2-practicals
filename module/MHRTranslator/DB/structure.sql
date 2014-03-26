CREATE TABLE IF NOT EXISTS `translation` (
    `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
    `locale` char(5) NOT NULL,
    `message_domain` varchar(255) NOT NULL,
    `message_key` text NOT NULL,
    `message_translation` text NOT NULL,
    PRIMARY KEY (`id`),
    KEY `message_domain` (`message_domain`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;