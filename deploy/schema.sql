--
-- Table structure for table `directors`
--

DROP TABLE IF EXISTS `directors`;
CREATE TABLE `directors` (
  `id`      int(32)     NOT NULL        AUTO_INCREMENT,
  `name`    varchar(20) DEFAULT NULL,
  `surname` varchar(20) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE INDEX `director_full_name` (`name`,`surname`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Table structure for table `genres`
--

DROP TABLE IF EXISTS `genres`;
CREATE TABLE `genres` (
  `id`      int(32)     NOT NULL        AUTO_INCREMENT,
  `name`    varchar(20) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE INDEX `genre_name` (`name`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Table structure for table `movies`
--

DROP TABLE IF EXISTS `movies`;
CREATE TABLE `movies` (
  `id`              int(32)         NOT NULL AUTO_INCREMENT,
  `title`           varchar(100)    NOT NULL,
  `year`            int(11)         NOT NULL,
  `format`          enum('DVD', 'VHS', 'Blu-Ray')   NOT NULL,
  `poster`          varchar(255)    NOT NULL,
  `genre_id`        int(32)         DEFAULT NULL,
  `director_id`     int(32)         DEFAULT NULL,
  PRIMARY KEY (`id`),
  FOREIGN KEY (`genre_id`)
        REFERENCES `genres`(`id`)
        ON DELETE SET NULL,
  FOREIGN KEY (`director_id`)
        REFERENCES `directors`(`id`)
        ON DELETE SET NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Table structure for table `casts`
--

DROP TABLE IF EXISTS `casts`;
CREATE TABLE `casts` (
  `id`      int(32)     NOT NULL        AUTO_INCREMENT,
  `name`    varchar(20) DEFAULT NULL,
  `surname` varchar(20) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE INDEX `cast_full_name` (`name`,`surname`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Table structure for table `movie_casts`
--

DROP TABLE IF EXISTS `movie_casts`;
CREATE TABLE `movie_casts` (
  `movie_id`   int(32)  NOT NULL,
  `cast_id`    int(32)  NOT NULL,
  PRIMARY KEY (`movie_id`,`cast_id`),
  FOREIGN KEY (`movie_id`)
        REFERENCES `movies`(`id`)
        ON DELETE CASCADE,
  FOREIGN KEY (`cast_id`)
        REFERENCES `casts`(`id`)
        ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

