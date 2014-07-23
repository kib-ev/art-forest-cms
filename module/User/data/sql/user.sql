CREATE TABLE IF NOT EXISTS `user` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `username` text,
  `email` text,
  `password` text,
  `ipAddress` text,
  `active` text,
  `activationToken` text,
  `forgotPasswordToken` text,
  `failedLoginIp` text,
  `lastLoginDate` text,
  `createDate` text,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

