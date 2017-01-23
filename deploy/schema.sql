--
-- Table structure for table `directors`
--

CREATE TABLE IF NOT EXISTS `directors` (
  `id`      int(32)     NOT NULL        AUTO_INCREMENT,
  `name`    varchar(20) DEFAULT NULL,
  `surname` varchar(20) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE INDEX `director_full_name` (`name`,`surname`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Table structure for table `publishers`
--

CREATE TABLE IF NOT EXISTS `publishers` (
  `id`      int(32)     NOT NULL        AUTO_INCREMENT,
  `name`    varchar(64) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE INDEX `publisher_name` (`name`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Table structure for table `artists`
--

CREATE TABLE IF NOT EXISTS `artists` (
  `id`      int(32)     NOT NULL        AUTO_INCREMENT,
  `name`    varchar(20) DEFAULT NULL,
  `surname` varchar(20) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE INDEX `artist_full_name` (`name`,`surname`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Table structure for table `genres`
--

CREATE TABLE IF NOT EXISTS `genres` (
  `id`      int(32)     NOT NULL        AUTO_INCREMENT,
  `name`    varchar(20) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE INDEX `genre_name` (`name`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Table structure for table `genre_translations`
--

CREATE TABLE IF NOT EXISTS `genre_translations` (
  `id`        int(32)                               NOT NULL  AUTO_INCREMENT,
  `genre_id`  int(10)                               NOT NULL,
  `locale`    varchar(5)    COLLATE utf8_unicode_ci NOT NULL,
  `name`      varchar(255)  COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE INDEX `genre_locale_name` (`genre_id`, `locale`),
  KEY `genre_translations_locale_index` (`locale`),
  CONSTRAINT `genre_translations_genre_id_foreign` FOREIGN KEY (`genre_id`) REFERENCES `genres` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Table structure for table `movies`
--

CREATE TABLE IF NOT EXISTS `movies` (
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
-- Table structure for table `books`
--

CREATE TABLE IF NOT EXISTS `books` (
  `id`              int(32)         NOT NULL AUTO_INCREMENT,
  `title`           varchar(100)    NOT NULL,
  `isbn`            varchar(64)     DEFAULT NULL,
  `year`            int(11)         NOT NULL,
  `format`          enum('Paperback', 'Ebook', 'Hardcover', 'Audio')   NOT NULL,
  `image`           varchar(255)    NOT NULL,
  `genre_id`        int(32)         DEFAULT NULL,
  `publisher_id`    int(32)         DEFAULT NULL,
  PRIMARY KEY (`id`),
  FOREIGN KEY (`genre_id`)
    REFERENCES `genres`(`id`)
    ON DELETE SET NULL,
  FOREIGN KEY (`publisher_id`)
    REFERENCES `publishers`(`id`)
    ON DELETE SET NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Table structure for table `music`
--

CREATE TABLE IF NOT EXISTS `music` (
  `id`              int(32)         NOT NULL AUTO_INCREMENT,
  `title`           varchar(100)    NOT NULL,
  `year`            int(11)         NOT NULL,
  `format`          enum('Cassette', 'CD', 'MP3', 'Vinyl')   NOT NULL,
  `image`           varchar(255)    NOT NULL,
  `genre_id`        int(32)         DEFAULT NULL,
  `artist_id`    int(32)         DEFAULT NULL,
  PRIMARY KEY (`id`),
  FOREIGN KEY (`genre_id`)
    REFERENCES `genres`(`id`)
    ON DELETE SET NULL,
  FOREIGN KEY (`artist_id`)
    REFERENCES `artists`(`id`)
    ON DELETE SET NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Table structure for table `casts`
--

CREATE TABLE IF NOT EXISTS `casts` (
  `id`      int(32)     NOT NULL        AUTO_INCREMENT,
  `name`    varchar(20) DEFAULT NULL,
  `surname` varchar(20) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE INDEX `cast_full_name` (`name`,`surname`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Table structure for table `movie_casts`
--

CREATE TABLE IF NOT EXISTS `movie_casts` (
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

--
-- Table structure for table `authors`
--

CREATE TABLE IF NOT EXISTS `authors` (
  `id`      int(32)     NOT NULL        AUTO_INCREMENT,
  `name`    varchar(20) DEFAULT NULL,
  `surname` varchar(20) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE INDEX `author_full_name` (`name`,`surname`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Table structure for table `book_authors`
--

CREATE TABLE IF NOT EXISTS `book_authors` (
  `book_id`     int(32)  NOT NULL,
  `author_id`   int(32)  NOT NULL,
  PRIMARY KEY (`book_id`,`author_id`),
  FOREIGN KEY (`book_id`)
    REFERENCES `books`(`id`)
    ON DELETE CASCADE,
  FOREIGN KEY (`author_id`)
    REFERENCES `authors`(`id`)
    ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;


--
-- Table structure for table `roles`
--

CREATE TABLE IF NOT EXISTS `roles` (
  `id`          int(32)  NOT NULL        AUTO_INCREMENT,
  `name`        varchar(255) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE INDEX `role_name` (`name`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Table structure for table `users`
--

CREATE TABLE IF NOT EXISTS `users` (
  `id`          int(32)  NOT NULL        AUTO_INCREMENT,
  `role_id`     int(32)      NULL,
  `name`        varchar(255) NULL,
  `email`       varchar(255) NOT NULL,
  `password`    varchar(255) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE INDEX `user_email` (`email`),
  FOREIGN KEY (`role_id`)
    REFERENCES `roles`(`id`)
    ON DELETE SET NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

