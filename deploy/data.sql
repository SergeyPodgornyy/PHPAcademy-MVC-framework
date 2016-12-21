--
-- Dumping data for table `directors`
--

LOCK TABLES `directors` WRITE;
/*!40000 ALTER TABLE `directors` DISABLE KEYS */;
INSERT INTO `directors`
    VALUES  (1,'Robert','Zemeckis'),
            (2,'Mike','Judge'),
            (3,'Peter','Jackson'),
            (4,'Rob','Reiner');
/*!40000 ALTER TABLE `directors` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Dumping data for table `genres`
--

LOCK TABLES `genres` WRITE;
/*!40000 ALTER TABLE `genres` DISABLE KEYS */;
INSERT INTO `genres`
    VALUES  (1,'Drama'),
            (2,'Comedy'),
            (3,'Action'),
            (4,'Adventure'),
            (5,'Crime'),
            (6,'Horror'),
            (7,'Musical'),
            (8,'Sci-Fi'),
            (9,'War'),
            (10,'Western');
/*!40000 ALTER TABLE `genres` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Dumping data for table `movies`
--

LOCK TABLES `movies` WRITE;
/*!40000 ALTER TABLE `movies` DISABLE KEYS */;
INSERT INTO `movies`
    VALUES  (1,'Forrest Gump',1994,'DVD','img/media/forest_gump.jpg',2,1),
            (2,'Office Space',1999,'VHS','img/media/office_space.jpg',2,2),
            (3,'The Lord of the Rings: The Fellowship of the Ring',2001,'Blu-Ray','img/media/lotr.jpg',1,3),
            (4,'The Princess Bride',1987,'DVD','img/media/princess_bride.jpg',2,4);
/*!40000 ALTER TABLE `movies` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Dumping data for table `cast`
--

LOCK TABLES `casts` WRITE;
/*!40000 ALTER TABLE `casts` DISABLE KEYS */;
INSERT INTO `casts`
    VALUES  (1,'Tom','Hanks'),
            (2,'Rebecca','Williams'),
            (3,'Sally','Field'),
            (4,'Michael Conner','Humphreys'),
            (5,'Ron','Livingston'),
            (6,'Jennifer','Aniston'),
            (7,'David','Herman'),
            (8,'Ajay','Naidu'),
            (9,'Diedrich','Bader'),
            (10,'Stephen','Root'),
            (11,'Cary','Elwes'),
            (12,'Mandy','Patinkin'),
            (13,'Robin','Wright'),
            (14,'Chris','Sarandon'),
            (15,'Christopher','Guest'),
            (16,'Wallace','Shawn'),
            (17,'André','the Giant'),
            (18,'Fred','Savage'),
            (19,'Peter','Falk'),
            (24,'Billy','Crystal');
/*!40000 ALTER TABLE `casts` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Dumping data for table `movie_casts`
--

LOCK TABLES `movie_casts` WRITE;
/*!40000 ALTER TABLE `movie_casts` DISABLE KEYS */;
INSERT INTO `movie_casts`
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
            (4, 24);
/*!40000 ALTER TABLE `movie_casts` ENABLE KEYS */;
UNLOCK TABLES;
