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
-- Dumping data for table `genres`
--

LOCK TABLES `genres` WRITE;
/*!40000 ALTER TABLE `genres` DISABLE KEYS */;
INSERT INTO `genres` (`name`)
    VALUES  ('Drama'),
            ('Comedy'),
            ('Action'),
            ('Adventure'),
            ('Crime'),
            ('Horror'),
            ('Musical'),
            ('Sci-Fi'),
            ('War'),
            ('Western');
/*!40000 ALTER TABLE `genres` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Dumping data for table `movies`
--

LOCK TABLES `movies` WRITE;
/*!40000 ALTER TABLE `movies` DISABLE KEYS */;
INSERT INTO `movies` (`title`,`year`,`format`,`image`,`genre_id`,`director_id`)
    VALUES  ('Forrest Gump',1994,'DVD','img/media/forest_gump.jpg',2,1),
            ('Office Space',1999,'VHS','img/media/office_space.jpg',2,2),
            ('The Lord of the Rings: The Fellowship of the Ring',2001,'Blu-Ray','img/media/lotr.jpg',1,3),
            ('The Princess Bride',1987,'DVD','img/media/princess_bride.jpg',2,4);
/*!40000 ALTER TABLE `movies` ENABLE KEYS */;
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


################################################################################
-- 2017-01-03 15:15:00
################################################################################

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
-- Dumping data for table `genres` (books)
--

LOCK TABLES `genres` WRITE;
/*!40000 ALTER TABLE `genres` DISABLE KEYS */;
INSERT INTO `genres` (`name`,`type`)
    VALUES  ('Drama','book'),
            ('Comedy','book'),
            ('Horror','book'),
            ('Fiction','book'),
            ('Non-fiction','book'),
            ('Realistic fiction','book'),
            ('Romance novel','book'),
            ('Satire','book'),
            ('Tragedy','book'),
            ('Tragicomedy','book'),
            ('Fantasy','book'),
            ('Technical','book'),
            ('Documentation','book'),
            ('Manual','book');
/*!40000 ALTER TABLE `genres` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Dumping data for table `books`
--

LOCK TABLES `books` WRITE;
/*!40000 ALTER TABLE `books` DISABLE KEYS */;
INSERT INTO `books` (`title`,`isbn`,`year`,`format`,`image`,`genre_id`,`publisher_id`)
    VALUES  ('A Design Patterns: Elements of Reusable Object-Oriented Software','978-0201633610',1994,'Paperback','img/media/design_patterns.jpg',22,1),
            ('Clean Code: A Handbook of Agile Software Craftsmanship','978-0132350884',2008,'Ebook','img/media/clean_code.jpg',22,1),
            ('Refactoring: Improving the Design of Existing Code','978-0201485677',1999,'Hardcover','img/media/refactoring.jpg',22,2),
            ('The Clean Coder: A Code of Conduct for Professional Programmers','007-6092046981',2011,'Audio','img/media/clean_coder.jpg',22,2);
/*!40000 ALTER TABLE `books` ENABLE KEYS */;
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
