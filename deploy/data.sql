--
-- Dumping data for table `directors`
--

LOCK TABLES `directors` WRITE;
/*!40000 ALTER TABLE `directors` DISABLE KEYS */;
INSERT INTO `directors` (`name`, `surname`)
    VALUES  ('Robert','Zemeckis'),
            ('Mike','Judge'),
            ('Peter','Jackson'),
            ('Rob','Reiner');
/*!40000 ALTER TABLE `directors` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Dumping data for table `cast`
--

LOCK TABLES `casts` WRITE;
/*!40000 ALTER TABLE `casts` DISABLE KEYS */;
INSERT INTO `casts` (`name`,`surname`)
    VALUES  ('Tom','Hanks'),
            ('Rebecca','Williams'),
            ('Sally','Field'),
            ('Michael Conner','Humphreys'),
            ('Ron','Livingston'),
            ('Jennifer','Aniston'),
            ('David','Herman'),
            ('Ajay','Naidu'),
            ('Diedrich','Bader'),
            ('Stephen','Root'),
            ('Cary','Elwes'),
            ('Mandy','Patinkin'),
            ('Robin','Wright'),
            ('Chris','Sarandon'),
            ('Christopher','Guest'),
            ('Wallace','Shawn'),
            ('André','the Giant'),
            ('Fred','Savage'),
            ('Peter','Falk'),
            ('Billy','Crystal');
/*!40000 ALTER TABLE `casts` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Dumping data for table `publishers`
--

LOCK TABLES `publishers` WRITE;
/*!40000 ALTER TABLE `publishers` DISABLE KEYS */;
INSERT INTO `publishers` (`name`)
    VALUES  ('Prentice Hall'),
            ('Addison-Wesley Professional');
/*!40000 ALTER TABLE `publishers` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Dumping data for table `authors`
--

LOCK TABLES `authors` WRITE;
/*!40000 ALTER TABLE `authors` DISABLE KEYS */;
INSERT INTO `authors` (`name`, `surname`)
    VALUES  ('Erich','Gamma'),
            ('Richard','Helm'),
            ('Ralph','Johnson'),
            ('John','Vlissides'),
            ('Robert','C. Martin'),
            ('Martin','Fowler'),
            ('Kent','Beck'),
            ('John','Brant'),
            ('William','Opdyke'),
            ('Don','Roberts');
/*!40000 ALTER TABLE `authors` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Dumping data for table `artists`
--

LOCK TABLES `artists` WRITE;
/*!40000 ALTER TABLE `artists` DISABLE KEYS */;
INSERT INTO `artists` (`name`, `surname`)
    VALUES  ('Ludwig','van Beethoven'),
            ('Elvis','Presley'),
            ('Garth','Brooks'),
            ('Nat','King Cole');
/*!40000 ALTER TABLE `artists` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Dumping data for table `genres`
--

LOCK TABLES `genres` WRITE;
/*!40000 ALTER TABLE `genres` DISABLE KEYS */;
INSERT INTO `genres` (`name`,`type`)
    VALUES  ('Action','movie'),                 -- 1
            ('Adventure','movie'),              -- 2
            ('Animation','movie'),              -- 3
            ('Biography','movie'),              -- 4
            ('Comedy','movie'),                 -- 5
            ('Crime','movie'),                  -- 6
            ('Documentary','movie'),            -- 7
            ('Drama','movie'),                  -- 8
            ('Family','movie'),                 -- 9
            ('Fantasy','movie'),                -- 10
            ('Film-Noir','movie'),              -- 11
            ('History','movie'),                -- 12
            ('Horror','movie'),                 -- 13
            ('Musical','movie'),                -- 14
            ('Mystery','movie'),                -- 15
            ('Romance','movie'),                -- 16
            ('Sci-Fi','movie'),                 -- 17
            ('Sport','movie'),                  -- 18
            ('Thriller','movie'),               -- 19
            ('War','movie'),                    -- 20
            ('Western','movie'),                -- 21
            ('Action','book'),                  -- 22
            ('Adventure','book'),               -- 23
            ('Comedy','book'),                  -- 24
            ('Documentation','book'),           -- 25
            ('Drama','book'),                   -- 26
            ('Fantasy','book'),                 -- 27
            ('Fiction','book'),                 -- 28
            ('Historical','book'),              -- 29
            ('Historical Fiction','book'),      -- 30
            ('Horror','book'),                  -- 31
            ('Magical Realism','book'),         -- 32
            ('Manual','book'),                  -- 33
            ('Mystery','book'),                 -- 34
            ('Non-fiction','book'),             -- 35
            ('Paranoid','book'),                -- 36
            ('Philosophical','book'),           -- 37
            ('Political','book'),               -- 38
            ('Realistic fiction','book'),       -- 39
            ('Romance novel','book'),           -- 40
            ('Saga','book'),                    -- 41
            ('Satire','book'),                  -- 42
            ('Sci-Fi','book'),                  -- 43
            ('Technical','book'),               -- 44
            ('Thriller','book'),                -- 45
            ('Tragedy','book'),                 -- 46
            ('Tragicomedy','book'),             -- 47
            ('Urban','book'),                   -- 48
            ('Alternative','music'),            -- 49
            ('Blues','music'),                  -- 50
            ('Classical','music'),              -- 51
            ('Country','music'),                -- 52
            ('Dance','music'),                  -- 53
            ('Easy Listening','music'),         -- 54
            ('Electronic','music'),             -- 55
            ('Folk','music'),                   -- 56
            ('Hip Hop/Rap','music'),            -- 57
            ('Inspirational/Gospel','music'),   -- 58
            ('Jazz','music'),                   -- 59
            ('Latin','music'),                  -- 60
            ('New Age','music'),                -- 61
            ('Opera','music'),                  -- 62
            ('Pop','music'),                    -- 63
            ('R&B/Sou','music'),                -- 64
            ('Reggae','music'),                 -- 65
            ('Rock','music');                   -- 66
/*!40000 ALTER TABLE `genres` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Dumping data for table `movies`
--

LOCK TABLES `movies` WRITE;
/*!40000 ALTER TABLE `movies` DISABLE KEYS */;
INSERT INTO `movies` (`title`,`year`,`format`,`image`,`genre_id`,`director_id`)
    VALUES  ('Forrest Gump',1994,'DVD','img/media/forest_gump.jpg',8,1),
            ('Office Space',1999,'VHS','img/media/office_space.jpg',5,2),
            ('The Lord of the Rings: The Fellowship of the Ring',2001,'Blu-Ray','img/media/lotr.jpg',8,3),
            ('The Princess Bride',1987,'DVD','img/media/princess_bride.jpg',5,4);
/*!40000 ALTER TABLE `movies` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Dumping data for table `books`
--

LOCK TABLES `books` WRITE;
/*!40000 ALTER TABLE `books` DISABLE KEYS */;
INSERT INTO `books` (`title`,`isbn`,`year`,`format`,`image`,`genre_id`,`publisher_id`)
    VALUES  ('A Design Patterns: Elements of Reusable Object-Oriented Software','978-0201633610',1994,'Paperback','img/media/design_patterns.jpg',44,1),
            ('Clean Code: A Handbook of Agile Software Craftsmanship','978-0132350884',2008,'Ebook','img/media/clean_code.jpg',44,1),
            ('Refactoring: Improving the Design of Existing Code','978-0201485677',1999,'Hardcover','img/media/refactoring.jpg',44,2),
            ('The Clean Coder: A Code of Conduct for Professional Programmers','007-6092046981',2011,'Audio','img/media/clean_coder.jpg',44,2);
/*!40000 ALTER TABLE `books` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Dumping data for table `music`
--

LOCK TABLES `music` WRITE;
/*!40000 ALTER TABLE `music` DISABLE KEYS */;
INSERT INTO `music` (`title`,`year`,`format`,`image`,`genre_id`,`artist_id`)
    VALUES  ('Beethoven: Complete Symphonies',2012,'CD','img/media/beethoven.jpg',51,1),
            ('Elvis Forever',2015,'Vinyl','img/media/elvis_presley.jpg',66,2),
            ('No Fences',1990,'Cassette','img/media/garth_brooks.jpg',52,3),
            ('The Very Thought of You',2008,'MP3','img/media/nat_king_cole.jpg',59,4);
/*!40000 ALTER TABLE `music` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Dumping data for table `movie_casts`
--

LOCK TABLES `movie_casts` WRITE;
/*!40000 ALTER TABLE `movie_casts` DISABLE KEYS */;
INSERT INTO `movie_casts` (`movie_id`,`cast_id`)
    VALUES  (1, 1),
            (1, 2),
            (1, 3),
            (1, 4),
            (2, 5),
            (2, 6),
            (2, 7),
            (2, 8),
            (2, 9),
            (2, 10),
            (3, 5),
            (3, 6),
            (3, 7),
            (3, 8),
            (3, 9),
            (3, 10),
            (4, 11),
            (4, 12),
            (4, 13),
            (4, 14),
            (4, 15),
            (4, 16),
            (4, 17),
            (4, 18),
            (4, 19),
            (4, 20);
/*!40000 ALTER TABLE `movie_casts` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Dumping data for table `book_authors`
--

LOCK TABLES `book_authors` WRITE;
/*!40000 ALTER TABLE `book_authors` DISABLE KEYS */;
INSERT INTO `book_authors` (`book_id`,`author_id`)
    VALUES  (1, 1),
            (1, 2),
            (1, 3),
            (1, 4),
            (2, 5),
            (3, 6),
            (3, 7),
            (3, 8),
            (3, 9),
            (3, 10),
            (4, 5);
/*!40000 ALTER TABLE `book_authors` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Dumping data for table `roles`
--

LOCK TABLES `roles` WRITE;
/*!40000 ALTER TABLE `roles` DISABLE KEYS */;
INSERT INTO `roles` (`name`)
    VALUES  ('user'),
            ('admin'),
            ('superadmin');
/*!40000 ALTER TABLE `roles` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Dumping data for table `users`
--

LOCK TABLES `users` WRITE;
/*!40000 ALTER TABLE `users` DISABLE KEYS */;
INSERT INTO `users` (`role_id`,`name`,`email`,`password`)
    VALUES  (1,'Common user','test@mail.com','$2y$10$mm2HSgdHcOr2K8jpeE5tCuVUPtMUW0DVy0nlTGbZ0gervFD4tR/qK'),
            (2,'Admin','admin@mail.com','$2y$10$mm2HSgdHcOr2K8jpeE5tCuVUPtMUW0DVy0nlTGbZ0gervFD4tR/qK'),
            (3,'Superadmin','super@mail.com','$2y$10$mm2HSgdHcOr2K8jpeE5tCuVUPtMUW0DVy0nlTGbZ0gervFD4tR/qK');
/*!40000 ALTER TABLE `users` ENABLE KEYS */;
UNLOCK TABLES;
