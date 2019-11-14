CREATE TABLE comments (
	`id` int(11) NOT NULL auto_increment,
	`author` varchar(255) NOT NULL default '',
	`date` datetime NOT NULL default '2000-01-01 00:00:00',
	`text` text NOT NULL,
	PRIMARY KEY  (`id`),
	KEY `date` (`date`)
) ENGINE=InnoDB DEFAULT CHARACTER SET utf8mb4;