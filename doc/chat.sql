create database if not exists chats;

use chats;
-- ---------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------

create table if not exists `users`
 (
  `code` int(10) NOT NULL,
  `name` varchar(20) NOT NULL,
  `surname` varchar(30) NOT NULL,
  `email` varchar(30) NOT NULL,
  `password` varchar(60) NOT NULL,
  `address` varchar(80) NOT NULL,
  `username` varchar(15) NOT NULL,
  `picture` varchar(2000), 
  `role` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;


ALTER TABLE `users`
  ADD PRIMARY KEY (`code`),
  ADD UNIQUE KEY `USER_NAME` (`username`);

ALTER TABLE `users`
  MODIFY `code` int(10) NOT NULL AUTO_INCREMENT;
 

-- ---------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------

create table if not exists `message`
 (
  `id_msg` int(10) NOT NULL,
  `body` varchar(1000) NOT NULL,
  `origin_user_id` int(10) NOT NULL,
  `time` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;


ALTER TABLE `message`
  ADD PRIMARY KEY (`id_msg`),
  ADD KEY `code_user` (`origin_user_id`);

ALTER TABLE `message`
  MODIFY `id_msg` int(10) NOT NULL AUTO_INCREMENT;

-- ---------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------

create table if not exists `sent_to`
 (
	`code_sent` int(10) NOT NULL,
  `id_msg` int(10) NOT NULL,
  `id_dest_user` int(10) NOT NULL,
  `read` boolean NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;


ALTER TABLE `sent_to`
  ADD PRIMARY KEY (`code_sent`),
  ADD KEY `message_id` (`id_msg`),
  ADD KEY `message_des` (`id_dest_user`);


ALTER TABLE `sent_to`
  MODIFY `code_sent` int(10) NOT NULL AUTO_INCREMENT;


-- ---------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------
Create table if not exists `groups`
 (
	`id_group` int(10) NOT NULL,
  `id_msg` int(10) NOT NULL,
  `id_user` int(10) NOT NULL,
  `name` varchar(20) NOT NULL 
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

ALTER TABLE `groups`
  ADD PRIMARY KEY (`id_group`),
  ADD KEY `message_id` (`id_msg`),
  ADD KEY `user_group` (`id_user`);

ALTER TABLE `groups`
  MODIFY `id_group` int(10) NOT NULL AUTO_INCREMENT;
-- ---------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------
Create table if not exists `groups_users`
 (
   `id_group_user` int(10) NOT NULL,
	`id_group` int(10) NOT NULL,
  `id_user` int(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

ALTER TABLE `groups_users`
  ADD PRIMARY KEY (`id_group_user`),
  ADD KEY `group_id` (`id_group`),
  ADD KEY `user_group` (`id_user`);

ALTER TABLE `groups_users`
  MODIFY `id_group_user` int(10) NOT NULL AUTO_INCREMENT;

-- ---------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------

-- ---------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------

ALTER TABLE `message`
  ADD CONSTRAINT `origin_user_id_fk` FOREIGN KEY (`origin_user_id`) REFERENCES `users` (`code`);
  
ALTER TABLE `sent_to`
  ADD CONSTRAINT `dest_user_id_fk` FOREIGN KEY (`id_dest_user`) REFERENCES `users` (`code`),
  ADD CONSTRAINT `id_msg_fk` FOREIGN KEY (`id_msg`) REFERENCES `message` (`id_msg`);

ALTER TABLE `groups`
  ADD CONSTRAINT `id_msg_fk2` FOREIGN KEY (`id_msg`) REFERENCES `message` (`id_msg`);

ALTER TABLE `groups_users`
  ADD CONSTRAINT `id_user_fk` FOREIGN KEY (`id_user`) REFERENCES `users` (`code`),
  ADD CONSTRAINT `id_group_fk` FOREIGN KEY (`id_group`) REFERENCES `groups` (`id_group`);
  
-- ---------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------





INSERT INTO `users` (`code`, `name`, `surname`, `email`, `password`, `address`, `username`,`picture`, `role`) VALUES
(null, 'David', 'López', 'davidl@gmail.com', '$2y$10$fRoHxArYEAG74of6CV/TsuR1H0.olHyRBsLcUs4Ou.qKZ.m4/vxtW','Calle Mayor 33 1ºC 24402 Ponferrada, León, España', 'davidL', 'http://localhost/Aplicacion-Mensajeria/profilePic/davidL.jpg',0),
(null, 'Adrián', 'Rodríguez', 'adrianr@gmail.com', '$2y$10$8AkI98nhu494Ke.1M4S0Luah3vaIT0sDKCCpNLd49Kybb1TdgsFs2','Calle Mayor 33 1ºC 24402 Ponferrada, León, España', 'AdrianR', 'http://localhost/Aplicacion-Mensajeria/profilePic/AdrianR.jpg',0),
(null, 'Daniel', 'García', 'danielg@gmail.com', '$2y$10$GU7nuhRImp/V9Yx3aPyC3e8fDIf1nPyD2cWh7AEkSfKEbdhgb4PEq','Calle Mayor 33 1ºC 24402 Ponferrada, León, España', 'DanielG', 'http://localhost/Aplicacion-Mensajeria/profilePic/DanielG.jpg',0),
(null, 'Guillermo', 'Gil', 'guillermog@gmail.com', '$2y$10$yCl.AV8C/gWP1CxAHXEBZeCaIlgrcr2.mpWI2vhAyb/mXnJFSi5jS','Calle Mayor 33 1ºC 24402 Ponferrada, León, España', 'GuillermoG', 'http://localhost/Aplicacion-Mensajeria/profilePic/GuillermoG.jpg',0),
(null, 'Bernardo', 'Alcántara', 'bernardoa@gmail.com', '$2y$10$4LIdhSZd2diKQbCWnKk6GOq0l6oDsERL1zK6tjzhKUsyJwnNVC.U','Calle Mayor 33 1ºC 24402 Ponferrada, León, España', 'BernardoA', 'http://localhost/Aplicacion-Mensajeria/profilePic/BernardoA.jpg',0),
(null, 'Lu', 'Romero', 'lur@gmail.com', '$2y$10$8fknlPWHtuVOuCNJQ4XOpO/FGLB0zCVEx7KrFuhsHgbHkWv1mGXSu','Calle Mayor 33 1ºC 24402 Ponferrada, León, España', 'LuR', 'http://localhost/Aplicacion-Mensajeria/profilePic/LuR.jpg',0),
(null, 'Angélica', 'Pérez', 'angelicap@gmail.com', '$2y$10$.5E2mH7E3ug0SGmKhbKiKeXBcjfF3BYrRikrJ.RP0z5ItMI8CuuuC','Calle Mayor 33 1ºC 24402 Ponferrada, León, España', 'AngelicaP', 'http://localhost/Aplicacion-Mensajeria/profilePic/AngelicaP.jpg',0),
(null, 'Jorge', 'Sánchez', 'jorges@gmail.com', '$2y$10$5IswkizKeS2JnMoma7MvMeCFR.dnCH2XEA0OsjDFFxH1piIjDjRye','Calle Mayor 33 1ºC 24402 Ponferrada, León, España', 'JorgeS', 'http://localhost/Aplicacion-Mensajeria/profilePic/JorgeS.jpg',0),
(null, 'Roberto', 'Fernández', 'robertof@gmail.com', '$2y$10$3UD0KOOHMVemftHVBSiXJejAo18XBHDAuryW85j3oRQcKdiZk/fCi','Calle Mayor 33 1ºC 24402 Ponferrada, León, España', 'RobertoF', 'http://localhost/Aplicacion-Mensajeria/profilePic/RobertoF.jpg',0),
(null, 'Ariel', 'Martínez', 'arielm@gmail.com', '$2y$10$ken3dj3KmyhNcYsKTTrP4.LL2abqL34IDQBB5KFThOTcgKZfByTmy','Calle Mayor 33 1ºC 24402 Ponferrada, León, España', 'ArielM', 'http://localhost/Aplicacion-Mensajeria/profilePic/ArielM.jpg',0);

-- -----------------------------------------------------------------------------------------


INSERT INTO `message` (`id_msg`,`body`,`origin_user_id`,`time`) VALUES
  (null,'Lorem ipsum dolor sit amet','1','2020-11-12 10:10:10'),
  (null,'Lorem ipsum dolor sit amet','2','2020-11-13 10:10:30'),
  (null,'Lorem ipsum dolor sit amet','1','2020-11-13 10:11:10'),
  (null,'Lorem ipsum dolor sit amet','2','2020-11-13 10:10:20'),
   (null,'Lorem ipsum dolor sit amet','1','2020-11-14 10:10:10'),
  (null,'Lorem ipsum dolor sit amet','2','2020-11-15 10:10:30'),
  (null,'Lorem ipsum dolor sit amet','1','2020-11-15 10:11:10'),
  (null,'Lorem ipsum dolor sit amet','2','2020-11-15 10:10:20'),
   (null,'Lorem ipsum dolor sit amet','1','2020-11-16 10:10:10'),
  (null,'Lorem ipsum dolor sit amet','2','2020-11-17 10:10:30'),
  (null,'Lorem ipsum dolor sit amet','1','2020-11-17 10:11:10'),
  (null,'Lorem ipsum dolor sit amet','1','2020-11-17 10:10:20'),
  (null,'Lorem ipsum dolor sit amet','3','2020-11-12 10:10:10'),
  (null,'Lorem ipsum dolor sit amet','2','2020-11-13 10:10:30'),
  (null,'Lorem ipsum dolor sit amet','3','2020-11-13 10:11:10'),
  (null,'Lorem ipsum dolor sit amet','2','2020-11-13 10:10:20'),
   (null,'Lorem ipsum dolor sit amet','3','2020-11-14 10:10:10'),
  (null,'Lorem ipsum dolor sit amet','2','2020-11-15 10:10:30'),
  (null,'Lorem ipsum dolor sit amet','3','2020-11-15 10:11:10'),
  (null,'Lorem ipsum dolor sit amet','2','2020-11-15 10:10:20'),
   (null,'Lorem ipsum dolor sit amet','3','2020-11-16 10:10:10'),
  (null,'Lorem ipsum dolor sit amet','2','2020-11-17 10:10:30'),
  (null,'Lorem ipsum dolor sit amet','3','2020-11-17 10:11:10'),
  (null,'Lorem ipsum dolor sit amet','3','2020-11-17 10:10:20'),
   (null,'Lorem ipsum dolor sit amet','3','2020-11-17 10:10:20'),
  (null,'Primer mensaje de el grupo soria','1','2020-11-17 10:10:20'),
  (null,'Segundo mensaje de el grupo soria','2','2020-11-17 10:10:20'),
  (null,'Tercer mensaje de el grupo soria','3','2020-11-17 10:10:20');


  -- -------------------------------------------------------------------------------------------------
  

  INSERT INTO `sent_to` (`code_sent`,`id_msg`,`id_dest_user`,`read`) VALUES
  (null,'1','2','1'),
  (null,'2','1','1'),
  (null,'3','2','1'),
  (null,'4','1','1'),
   (null,'5','2','1'),
  (null,'6','1','1'),
  (null,'7','2','1'),
  (null,'8','1','1'),
   (null,'9','2','1'),
  (null,'10','1','1'),
  (null,'11','2','1'),
 (null,'12','2','1'),
  (null,'13','2','1'),
  (null,'14','3','1'),
  (null,'15','2','1'),
  (null,'16','3','1'),
   (null,'17','2','1'),
  (null,'18','3','1'),
  (null,'19','2','1'),
  (null,'20','3','1'),
   (null,'21','2','1'),
  (null,'22','3','1'),
  (null,'23','2','1'),
 (null,'24','2','1');
 
 INSERT INTO `groups` (`id_group`,`id_msg`, `id_user`, `name`) VALUES
  (null,'25', '1', 'soria'),
  (null,'26', '2', 'soria'),
  (null,'27', '3', 'soria');

  -- -------------------------------------------------------------------------------------------------

   INSERT INTO `groups_users` (`id_group_user`,`id_group`, `id_user`) VALUES
  (null,'1', '1'),
  (null,'2', '2'),
  (null,'3', '3');