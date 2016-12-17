--
-- Dumping data for table `movie`
--

LOCK TABLES `movies` WRITE;
/*!40000 ALTER TABLE `movies` DISABLE KEYS */;
INSERT INTO `movies`
    VALUES  (1,'The Lord of the Rings: The Fellowship of the Ring',2001,'Blu-Ray'),
            (2,'The Matrix',1999,'DVD'),
            (3,'Forrest Gump',1994,'VHS');
/*!40000 ALTER TABLE `movies` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Dumping data for table `cast`
--

LOCK TABLES `casts` WRITE;
/*!40000 ALTER TABLE `casts` DISABLE KEYS */;
INSERT INTO `casts`
    VALUES  (1,'Alan','Howard',1),
            (2,'Noel','Appleby',1),
            (3,'Sean','Astin',1),
            (4,'Sala','Baker',1),
            (5,'Sean','Bean',1),
            (6,'Cate','Blanchett',1),
            (7,'Orlando','Bloom',1),
            (8,'Billy','Boyd',1),
            (9,'Marton','Csokas',1),
            (10,'Ian','Holm',1),
            (11,'Christopher','Lee',1),
            (12,'Keanu','Reeves',2),
            (13,'Laurence','Fishburne',2),
            (14,'Carrie-Anne','Moss',2),
            (15,'Hugo','Weaving',2),
            (16,'Gloria','Foster',2),
            (17,'Tom','Hanks',3),
            (18,'Rebecca','Williams',3),
            (19,'Sally','Field',3),
            (20,'Michael Conner','Humphreys',3),
            (21,'Harold G.','Herthum',3),
            (22,'George','Kelly',3),
            (23,'Bob','Penny',3),
            (24,'John','Randall',3);
/*!40000 ALTER TABLE `casts` ENABLE KEYS */;
UNLOCK TABLES;
