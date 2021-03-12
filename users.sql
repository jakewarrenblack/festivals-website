CREATE TABLE `users` (
  `id` int(11) UNSIGNED NOT NULL,
  `email` varchar(64) NOT NULL,
  `password` varchar(256) NOT NULL,
  `name` varchar(64) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

INSERT INTO `users` (`id`, `email`, `password`, `name`) VALUES
(1, 'francis@bloggs.com', '$2y$10$ZBPBhHYkJlJECQQi.P2.4ey.pc5KIbsglmPl6K57Gi7wwlf1FXmlW', 'Francis Bloggs'),
(2, 'jamie@bloggs.com', '$2y$10$eqN6j1Oz1LnE1HjrCNHEz.l1t4YkzELOicByLXVPZ2H74iiIr92s.', 'Jamie Bloggs'),
(3, 'pat@bloggs.com', '$2y$10$OBrWCAI8uSFsZ5.zS7H3m.22qT2/F7hbuC2CIIIg6tHPenfl1jFne', 'Pat Bloggs'),
(4, 'harry@bloggs.com', '$2y$10$r7G2x.xWcHWXI71WbshNiOHaBuRfc6nhqcyxFc73Sq6gpaiJ742Su', 'Harry Bloggs'),
(5, 'leslie@bloggs.com', '$2y$10$hf1ykNW1javdWfmNmMS8xezH.xk.Sf6fv.nQ5N8Zjhv5ZluR5qSMS', 'Leslie Bloggs');

ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_email_unique` (`email`);

ALTER TABLE `users`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;
