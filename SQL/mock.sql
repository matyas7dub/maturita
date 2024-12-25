DROP TABLE IF EXISTS `scores`;
DROP TABLE IF EXISTS `users`;

#
# TABLE STRUCTURE FOR: users
#


CREATE TABLE `users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(15) NOT NULL,
  `password` char(64) NOT NULL,
  `email` varchar(30) NOT NULL,
  `verified` enum('yes','no') DEFAULT 'no',
  PRIMARY KEY (`id`),
  UNIQUE KEY `username` (`username`),
  UNIQUE KEY `email` (`email`)
) ENGINE=InnoDB AUTO_INCREMENT=31 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO `users` (`id`, `username`, `password`, `email`, `verified`) VALUES (1, 'lynch.bria', '38fb70b23f241ce0e24677d43e8ede3b7f3c7734bb25a6df1ad02068ad6c2c2f', 'fisher.alexandro@example.org', 'no');
INSERT INTO `users` (`id`, `username`, `password`, `email`, `verified`) VALUES (2, 'price.lawrence', '6c668b9c7c81efc82ae879d5c1409e548c366d8cfaf64a26b1891e946301225e', 'lori.klein@example.com', 'no');
INSERT INTO `users` (`id`, `username`, `password`, `email`, `verified`) VALUES (3, 'kadin39', '7fe7aaa9544952039650e8745ff0c5e5636e4cba4445fbfb3885cf5a426d9a11', 'hester.gaylord@example.org', 'no');
INSERT INTO `users` (`id`, `username`, `password`, `email`, `verified`) VALUES (4, 'maude36', '16c9959835baa178ddfd5e7bcbeb0e2abd26568ef93e7282b2b4e2d9e52348bc', 'sigmund.goodwin@example.org', 'no');
INSERT INTO `users` (`id`, `username`, `password`, `email`, `verified`) VALUES (5, 'kbins', '7c596befdd372e883a3e71bfcb3658d50c3f37adb0ae916c485080be87055f43', 'spencer.rey@example.org', 'no');
INSERT INTO `users` (`id`, `username`, `password`, `email`, `verified`) VALUES (6, 'wolf.diana', 'e656a5ae303e836468fe6282d1f4eb3f7504592938ad840656f782a7446d38fa', 'rigoberto01@example.com', 'no');
INSERT INTO `users` (`id`, `username`, `password`, `email`, `verified`) VALUES (7, 'wilderman.gerry', 'f133863ff22b124a2593ce448c64499fc2947e4a54358b24bf9df9e65f391a27', 'kfeil@example.net', 'no');
INSERT INTO `users` (`id`, `username`, `password`, `email`, `verified`) VALUES (8, 'armstrong.jazmy', '4c9880032d1687f4f61663b12502a115606e4717a6570f3654a7e56d048b8449', 'selena35@example.net', 'no');
INSERT INTO `users` (`id`, `username`, `password`, `email`, `verified`) VALUES (9, 'dejah48', '29ff5b9c2a14b931b252b35be020b63b5b25c64842e8f1dd4714db3828782049', 'salvatore.gibson@example.org', 'no');
INSERT INTO `users` (`id`, `username`, `password`, `email`, `verified`) VALUES (10, 'sylvia74', '7e62659caf8a5baa857d8589721f6b487624704ebfdb3c5b30d0f6ddf2eed7b1', 'aliza.mann@example.com', 'no');
INSERT INTO `users` (`id`, `username`, `password`, `email`, `verified`) VALUES (11, 'martine18', 'ab0c0645ea5c51080773ed85e69678a98e2af18596b19879580294c5e1be1d88', 'homenick.nelda@example.com', 'no');
INSERT INTO `users` (`id`, `username`, `password`, `email`, `verified`) VALUES (12, 'nina26', '2a02d36590252cbc31ce62e6483b825aab4dd1c853353887970b348787005963', 'sharvey@example.org', 'no');
INSERT INTO `users` (`id`, `username`, `password`, `email`, `verified`) VALUES (13, 'ijacobson', '66f909d907e2ade56e8de596109df59cba0fbf1aba8d71e71b7f5cba41714a93', 'gavin.kreiger@example.net', 'no');
INSERT INTO `users` (`id`, `username`, `password`, `email`, `verified`) VALUES (14, 'sipes.coy', 'ae23ad1a8d5dcb181a8a07b03784795d90840ceee14e5cecf4a193e008d4397a', 'gussie19@example.net', 'no');
INSERT INTO `users` (`id`, `username`, `password`, `email`, `verified`) VALUES (15, 'jessy.pfeffer', '03ecfdcecd0fb8f1417087d052b91a3c5f8465135e804c571749e471ccb3ee57', 'kenton.hoeger@example.net', 'no');
INSERT INTO `users` (`id`, `username`, `password`, `email`, `verified`) VALUES (16, 'elian93', '83d92cb805adc194aef7712ce3b6e3e8a7863e7ea9bd772ffd52456aafc5a5b0', 'forest.bartoletti@example.net', 'no');
INSERT INTO `users` (`id`, `username`, `password`, `email`, `verified`) VALUES (17, 'omoen', 'b2ff04be9e1892a51b383298438cdcb8da7df9d38676a94f5813d54b2403966d', 'miller.taylor@example.org', 'no');
INSERT INTO `users` (`id`, `username`, `password`, `email`, `verified`) VALUES (18, 'kevon.flatley', 'a44bb9c7862a274a09fde25ea3c595c349344136ed76955a3381ef64ab1d498c', 'mkreiger@example.net', 'no');
INSERT INTO `users` (`id`, `username`, `password`, `email`, `verified`) VALUES (19, 'kbogan', '9705c50de20be43a99e62b0a6b372151368deb20131ee579371769a37b4bc7ec', 'funk.monty@example.org', 'no');
INSERT INTO `users` (`id`, `username`, `password`, `email`, `verified`) VALUES (20, 'christelle.pauc', 'a0395c47062b7c68ac8330c90980f1d9784157291e245fe64289b67d79762d5b', 'reinhold02@example.net', 'no');
INSERT INTO `users` (`id`, `username`, `password`, `email`, `verified`) VALUES (21, 'hspinka', '9a113ed30133da99c6c163b991698904a313b011bb4a0dd0cf6cc619c8bbb16c', 'lucas18@example.com', 'no');
INSERT INTO `users` (`id`, `username`, `password`, `email`, `verified`) VALUES (22, 'ron83', '01846ab7174e18071ee91124f971235711039a311a8877d5398702cc8e0e9ef0', 'conn.gussie@example.com', 'no');
INSERT INTO `users` (`id`, `username`, `password`, `email`, `verified`) VALUES (23, 'qrenner', 'f465c0846718336c3d59cc6716e5582d9be390361966888f43903273a4e21d89', 'vhoppe@example.net', 'no');
INSERT INTO `users` (`id`, `username`, `password`, `email`, `verified`) VALUES (24, 'baron48', 'f1512a0b465e3bf751b32b7d7f0d28203df5d3ed52920f16323b8c9b4afcd97e', 'kay.towne@example.net', 'no');
INSERT INTO `users` (`id`, `username`, `password`, `email`, `verified`) VALUES (25, 'romaguera.judah', 'd8ffc319ab9c1ad706b2c33e6ade7a707ce8eaf083319222cb05b7a904508cb0', 'dkihn@example.org', 'no');
INSERT INTO `users` (`id`, `username`, `password`, `email`, `verified`) VALUES (26, 'godfrey.kreiger', '9dae0dae7dd455702284e3b87754c04a42e713ff6c4f4c21eff416a91e4b72e0', 'farrell.cyrus@example.com', 'no');
INSERT INTO `users` (`id`, `username`, `password`, `email`, `verified`) VALUES (27, 'helen.flatley', '69c57dfbf6ed7acc19814ad29a321dd109f1988a7c7cdee0ba1db0f990c610bc', 'yveum@example.org', 'no');
INSERT INTO `users` (`id`, `username`, `password`, `email`, `verified`) VALUES (28, 'cflatley', '4b0131679f171b197a02a8bd61840aed3bfa6882544b59eed44f6edc5744db7e', 'petra.hoppe@example.com', 'no');
INSERT INTO `users` (`id`, `username`, `password`, `email`, `verified`) VALUES (29, 'miguel.hartmann', '99646aaf6d40738b82252bc947bd3ffe94562ceb0c2b2c03e527e58a3a21261d', 'kyler.lubowitz@example.org', 'no');
INSERT INTO `users` (`id`, `username`, `password`, `email`, `verified`) VALUES (30, 'hilton05', '2df0e99e55997c43e78a95bf7809e72fd7d738dd35a09ead4b32b6ec7db93ae0', 'jody17@example.net', 'no');
INSERT INTO `users` (`id`, `username`, `password`, `email`, `verified`) VALUES (31, 'test1', 'f0e4c2f76c58916ec258f246851bea091d14d4247a2fc3e18694461b1816e13b', 'test1@example.com', 'no');
INSERT INTO `users` (`id`, `username`, `password`, `email`, `verified`) VALUES (32, 'test2', 'f0e4c2f76c58916ec258f246851bea091d14d4247a2fc3e18694461b1816e13b', 'test2@example.com', 'no');

#
# TABLE STRUCTURE FOR: scores
#

CREATE TABLE `scores` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) DEFAULT NULL,
  `score` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_user` (`user_id`),
  CONSTRAINT `fk_user` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=51 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO `scores` (`id`, `user_id`, `score`) VALUES (1, 1, 8467);
INSERT INTO `scores` (`id`, `user_id`, `score`) VALUES (2, 2, 7075);
INSERT INTO `scores` (`id`, `user_id`, `score`) VALUES (3, 3, 5820);
INSERT INTO `scores` (`id`, `user_id`, `score`) VALUES (4, 4, 365);
INSERT INTO `scores` (`id`, `user_id`, `score`) VALUES (5, 5, 128);
INSERT INTO `scores` (`id`, `user_id`, `score`) VALUES (6, 6, 7951);
INSERT INTO `scores` (`id`, `user_id`, `score`) VALUES (7, 7, 9678);
INSERT INTO `scores` (`id`, `user_id`, `score`) VALUES (8, 8, 1685);
INSERT INTO `scores` (`id`, `user_id`, `score`) VALUES (9, 9, 9914);
INSERT INTO `scores` (`id`, `user_id`, `score`) VALUES (10, 10, 6527);
INSERT INTO `scores` (`id`, `user_id`, `score`) VALUES (11, 11, 6096);
INSERT INTO `scores` (`id`, `user_id`, `score`) VALUES (12, 12, 3260);
INSERT INTO `scores` (`id`, `user_id`, `score`) VALUES (13, 13, 6395);
INSERT INTO `scores` (`id`, `user_id`, `score`) VALUES (14, 14, 9995);
INSERT INTO `scores` (`id`, `user_id`, `score`) VALUES (15, 15, 1723);
INSERT INTO `scores` (`id`, `user_id`, `score`) VALUES (16, 16, 2914);
INSERT INTO `scores` (`id`, `user_id`, `score`) VALUES (17, 17, 694);
INSERT INTO `scores` (`id`, `user_id`, `score`) VALUES (18, 18, 9310);
INSERT INTO `scores` (`id`, `user_id`, `score`) VALUES (19, 19, 4325);
INSERT INTO `scores` (`id`, `user_id`, `score`) VALUES (20, 20, 9335);
INSERT INTO `scores` (`id`, `user_id`, `score`) VALUES (21, 21, 501);
INSERT INTO `scores` (`id`, `user_id`, `score`) VALUES (22, 22, 7484);
INSERT INTO `scores` (`id`, `user_id`, `score`) VALUES (23, 23, 5313);
INSERT INTO `scores` (`id`, `user_id`, `score`) VALUES (24, 24, 433);
INSERT INTO `scores` (`id`, `user_id`, `score`) VALUES (25, 25, 6652);
INSERT INTO `scores` (`id`, `user_id`, `score`) VALUES (26, 26, 8641);
INSERT INTO `scores` (`id`, `user_id`, `score`) VALUES (27, 27, 3355);
INSERT INTO `scores` (`id`, `user_id`, `score`) VALUES (28, 28, 3082);
INSERT INTO `scores` (`id`, `user_id`, `score`) VALUES (29, 29, 3621);
INSERT INTO `scores` (`id`, `user_id`, `score`) VALUES (30, 30, 6242);
INSERT INTO `scores` (`id`, `user_id`, `score`) VALUES (31, 1, 766);
INSERT INTO `scores` (`id`, `user_id`, `score`) VALUES (32, 2, 9431);
INSERT INTO `scores` (`id`, `user_id`, `score`) VALUES (33, 3, 6535);
INSERT INTO `scores` (`id`, `user_id`, `score`) VALUES (34, 4, 1078);
INSERT INTO `scores` (`id`, `user_id`, `score`) VALUES (35, 5, 3085);
INSERT INTO `scores` (`id`, `user_id`, `score`) VALUES (36, 6, 4458);
INSERT INTO `scores` (`id`, `user_id`, `score`) VALUES (37, 7, 4799);
INSERT INTO `scores` (`id`, `user_id`, `score`) VALUES (38, 8, 5109);
INSERT INTO `scores` (`id`, `user_id`, `score`) VALUES (39, 9, 3002);
INSERT INTO `scores` (`id`, `user_id`, `score`) VALUES (40, 10, 6352);
INSERT INTO `scores` (`id`, `user_id`, `score`) VALUES (41, 11, 3086);
INSERT INTO `scores` (`id`, `user_id`, `score`) VALUES (42, 12, 6046);
INSERT INTO `scores` (`id`, `user_id`, `score`) VALUES (43, 13, 1246);
INSERT INTO `scores` (`id`, `user_id`, `score`) VALUES (44, 14, 5711);
INSERT INTO `scores` (`id`, `user_id`, `score`) VALUES (45, 15, 191);
INSERT INTO `scores` (`id`, `user_id`, `score`) VALUES (46, 16, 2811);
INSERT INTO `scores` (`id`, `user_id`, `score`) VALUES (47, 17, 9390);
INSERT INTO `scores` (`id`, `user_id`, `score`) VALUES (48, 18, 1853);
INSERT INTO `scores` (`id`, `user_id`, `score`) VALUES (49, 19, 1756);
INSERT INTO `scores` (`id`, `user_id`, `score`) VALUES (50, 20, 7338);
INSERT INTO `scores` (`id`, `user_id`, `score`) VALUES (51, 31, 8000);
