--
-- Table structure for table `movies`
--

DROP TABLE IF EXISTS `movies`;
CREATE TABLE `movies` (
  `id`      int(11)         NOT NULL AUTO_INCREMENT,
  `title`   varchar(100)    NOT NULL,
  `year`    int(11)         NOT NULL,
  `format`  varchar(10)     NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;

--
-- Table structure for table `cast`
--

DROP TABLE IF EXISTS `casts`;
CREATE TABLE `casts` (
  `id`      int(11)     NOT NULL AUTO_INCREMENT,
  `name`    varchar(20) DEFAULT NULL,
  `surname` varchar(20) NOT NULL,
  `movie_id` int(11)     NOT NULL,
  PRIMARY KEY (`id`),
  FOREIGN KEY (`movie_id`)
        REFERENCES `movies`(`id`)
        ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=25 DEFAULT CHARSET=utf8;
