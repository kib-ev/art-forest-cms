CREATE TABLE IF NOT EXISTS `post` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `userId` int(11) NOT NULL,
  `title` text,
  `text` text,
  `price` text,
  `public` tinyint(4) DEFAULT NULL,
  `tags` text,
  `active` tinyint(4) DEFAULT NULL,
  `createDate` text,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;