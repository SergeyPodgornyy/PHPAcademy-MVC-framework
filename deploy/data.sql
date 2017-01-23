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
-- Dumping data for table `genre_translations`
--

LOCK TABLES `genre_translations` WRITE;
/*!40000 ALTER TABLE `genre_translations` DISABLE KEYS */;
INSERT INTO `genre_translations` (`genre_id`,`locale`,`name`)
    VALUES  (1, 'en_GB', 'Action'),                   (1, 'de_DE', 'Actionfilm'),
            (1, 'ru_RU', 'Боевик'),                   (1, 'ru_UA', 'Бойовик'),
            (2, 'en_GB', 'Adventure'),                (2, 'de_DE', 'Abenteuerfilm'),
            (2, 'ru_RU', 'Приключение'),              (2, 'ru_UA', 'Пригоди'),
            (3, 'en_GB', 'Animation'),                (3, 'de_DE', 'Animation'),
            (3, 'ru_RU', 'Мультфильм'),               (3, 'ru_UA', 'Мультфильм'),
            (4, 'en_GB', 'Biography'),                (4, 'de_DE', 'Filmbiografie'),
            (4, 'ru_RU', 'Фильм-биография'),          (4, 'ru_UA', 'Фільм-біографія'),
            (5, 'en_GB', 'Comedy'),                   (5, 'de_DE', 'Komödie'),
            (5, 'ru_RU', 'Комедия'),                  (5, 'ru_UA', 'Комедія'),
            (6, 'en_GB', 'Crime'),                    (6, 'de_DE', 'Kriminalfilm'),
            (6, 'ru_RU', 'Криминальный фильм'),       (6, 'ru_UA', 'Кримінальний фільм'),
            (7, 'en_GB', 'Documentary'),              (7, 'de_DE', 'Dokumentarfilm'),
            (7, 'ru_RU', 'Документальное кино'),      (7, 'ru_UA', 'Документальний фільм'),
            (8, 'en_GB', 'Drama'),                    (8, 'de_DE', 'Drama'),
            (8, 'ru_RU', 'Драма'),                    (8, 'ru_UA', 'Драма'),
            (9, 'en_GB', 'Family'),                   (9, 'de_DE', 'Familienfilm'),
            (9, 'ru_RU', 'Семейное'),                 (9, 'ru_UA', 'Сімейне'),
            (10, 'en_GB', 'Fantasy'),                 (10, 'de_DE', 'Fantasy'),
            (10, 'ru_RU', 'Фантастика'),              (10, 'ru_UA', 'Фантастика'),
            (11, 'en_GB', 'Film-Noir'),               (11, 'de_DE', 'Film noir'),
            (11, 'ru_RU', 'Нуар'),                    (11, 'ru_UA', 'Нуар'),
            (12, 'en_GB', 'History'),                 (12, 'de_DE', 'Geschichte'),
            (12, 'ru_RU', 'Исторический фильм'),      (12, 'ru_UA', 'Історичний фільм'),
            (13, 'en_GB', 'Horror'),                  (13, 'de_DE', 'Horrorfilm'),
            (13, 'ru_RU', 'Ужастик'),                 (13, 'ru_UA', 'Фільм жахів'),
            (14, 'en_GB', 'Musical'),                 (14, 'de_DE', 'Musikalischer Film'),
            (14, 'ru_RU', 'Музыкальный'),             (14, 'ru_UA', 'Музичний'),
            (15, 'en_GB', 'Mystery'),                 (15, 'de_DE', 'Geheimnisfilm'),
            (15, 'ru_RU', 'Детектив'),                (15, 'ru_UA', 'Детектив'),
            (16, 'en_GB', 'Romance'),                 (16, 'de_DE', 'Liebesfilm'),
            (16, 'ru_RU', 'Романтическое кино'),      (16, 'ru_UA', 'Романтичний фільм'),
            (17, 'en_GB', 'Sci-Fi'),                  (17, 'de_DE', 'Science-Fiction'),
            (17, 'ru_RU', 'Научная фантастика'),      (17, 'ru_UA', 'Наукова фантастика'),
            (18, 'en_GB', 'Sport'),                   (18, 'de_DE', 'Sportfilm'),
            (18, 'ru_RU', 'Спортивное'),              (18, 'ru_UA', 'Спортивне'),
            (19, 'en_GB', 'Thriller'),                (19, 'de_DE', 'Thriller'),
            (19, 'ru_RU', 'Триллер'),                 (19, 'ru_UA', 'Трилер'),
            (20, 'en_GB', 'War'),                     (20, 'de_DE', 'Kriegsfilm'),
            (20, 'ru_RU', 'Военное'),                 (20, 'ru_UA', 'Військовий'),
            (21, 'en_GB', 'Western'),                 (21, 'de_DE', 'Western'),
            (21, 'ru_RU', 'Вестерн'),                 (21, 'ru_UA', 'Вестерн'),

            (22, 'en_GB', 'Action'),                  (22, 'de_DE', 'Action'),
            (22, 'ru_RU', 'Боевик'),                  (22, 'ru_UA', 'Бойовик'),
            (23, 'en_GB', 'Adventure'),               (23, 'de_DE', 'Abenteuer'),
            (23, 'ru_RU', 'Приключение'),             (23, 'ru_UA', 'Пригоди'),
            (24, 'en_GB', 'Comedy'),                  (24, 'de_DE', 'Komödie'),
            (24, 'ru_RU', 'Комедия'),                 (24, 'ru_UA', 'Комедія'),
            (25, 'en_GB', 'Documentation'),           (25, 'de_DE', 'Dokumentation'),
            (25, 'ru_RU', 'Документация'),            (25, 'ru_UA', 'Документація'),
            (26, 'en_GB', 'Drama'),                   (26, 'de_DE', 'Drama'),
            (26, 'ru_RU', 'Драма'),                   (26, 'ru_UA', 'Драма'),
            (27, 'en_GB', 'Fantasy'),                 (27, 'de_DE', 'Fantasy'),
            (27, 'ru_RU', 'Фантастика'),              (27, 'ru_UA', 'Фантастика'),
            (28, 'en_GB', 'Fiction'),                 (28, 'de_DE', 'Fiktion'),
            (28, 'ru_RU', 'Жанровая литература'),     (28, 'ru_UA', 'Жанрова література'),
            (29, 'en_GB', 'Historical'),              (29, 'de_DE', 'Geschichte'),
            (29, 'ru_RU', 'История'),                 (29, 'ru_UA', 'Історія'),
            (30, 'en_GB', 'Historical Fiction'),      (30, 'de_DE', 'Geschichte Fiktion'),
            (30, 'ru_RU', 'Историческая проза'),      (30, 'ru_UA', 'Історична проза'),
            (31, 'en_GB', 'Horror'),                  (31, 'de_DE', 'Horror'),
            (31, 'ru_RU', 'Ужасы'),                   (31, 'ru_UA', 'Жахи'),
            (32, 'en_GB', 'Magical Realism'),         (32, 'de_DE', 'Magischer Realismus'),
            (32, 'ru_RU', 'Магический реализм'),      (32, 'ru_UA', 'Магічний реалізм'),
            (33, 'en_GB', 'Manual'),                  (33, 'de_DE', 'Manual'),
            (33, 'ru_RU', 'Руководство'),             (33, 'ru_UA', 'Посібник'),
            (34, 'en_GB', 'Mystery'),                 (34, 'de_DE', 'Geheimnis'),
            (34, 'ru_RU', 'Детектив'),                (34, 'ru_UA', 'Детектив'),
            (35, 'en_GB', 'Non-fiction'),             (35, 'de_DE', 'Sachbücher'),
            (35, 'ru_RU', 'Научная литература'),      (35, 'ru_UA', 'Наукова література'),
            (36, 'en_GB', 'Paranoid'),                (36, 'de_DE', 'Paranoid'),
            (36, 'ru_RU', 'Паранойя'),                (36, 'ru_UA', 'Параноїдальна література'),
            (37, 'en_GB', 'Philosophical'),           (37, 'de_DE', 'Philosophisch'),
            (37, 'ru_RU', 'Философское'),             (37, 'ru_UA', 'Філософська література'),
            (38, 'en_GB', 'Political'),               (38, 'de_DE', 'Politisch'),
            (38, 'ru_RU', 'Политическое'),            (38, 'ru_UA', 'Політична література'),
            (39, 'en_GB', 'Realistic fiction'),       (39, 'de_DE', 'Realistische Fiktion'),
            (39, 'ru_RU', 'Реалистическая фантастика'),(39, 'ru_UA', 'Реалістична фантастика'),
            (40, 'en_GB', 'Romance novel'),           (40, 'de_DE', 'Romantischer Roman'),
            (40, 'ru_RU', 'Любовный роман'),          (40, 'ru_UA', 'Любовний роман'),
            (41, 'en_GB', 'Saga'),                    (41, 'de_DE', 'Saga'),
            (41, 'ru_RU', 'Сага'),                    (41, 'ru_UA', 'Сага'),
            (42, 'en_GB', 'Satire'),                  (42, 'de_DE', 'Satire'),
            (42, 'ru_RU', 'Сатира'),                  (42, 'ru_UA', 'Сатира'),
            (43, 'en_GB', 'Sci-Fi'),                  (43, 'de_DE', 'Science-Fiction'),
            (43, 'ru_RU', 'Научная фантастика'),      (43, 'ru_UA', 'Наукова фантастика'),
            (44, 'en_GB', 'Technical'),               (44, 'de_DE', 'Technisch'),
            (44, 'ru_RU', 'Техническое'),             (44, 'ru_UA', 'Технічне'),
            (45, 'en_GB', 'Thriller'),                (45, 'de_DE', 'Thriller'),
            (45, 'ru_RU', 'Триллер'),                 (45, 'ru_UA', 'Трилер'),
            (46, 'en_GB', 'Tragedy'),                 (46, 'de_DE', 'Tragödie'),
            (46, 'ru_RU', 'Трагедия'),                (46, 'ru_UA', 'Трагедія'),
            (47, 'en_GB', 'Tragicomedy'),             (47, 'de_DE', 'Tragikomödie'),
            (47, 'ru_RU', 'Трагикомедия'),            (47, 'ru_UA', 'Трагікомедія'),
            (48, 'en_GB', 'Urban'),                   (48, 'de_DE', 'Urban'),
            (48, 'ru_RU', 'Урбанистическая литература'),(48, 'ru_UA', 'Урбаністична література'),

            (49, 'en_GB', 'Alternative'),             (49, 'de_DE', 'Alternative'),
            (49, 'ru_RU', 'Альтернативное'),          (49, 'ru_UA', 'Альтернатива'),
            (50, 'en_GB', 'Blues'),                   (50, 'de_DE', 'Blues'),
            (50, 'ru_RU', 'Блюз'),                    (50, 'ru_UA', 'Блюз'),
            (51, 'en_GB', 'Classical'),               (51, 'de_DE', 'Klassische Musik'),
            (51, 'ru_RU', 'Класическое'),             (51, 'ru_UA', 'Класичне'),
            (52, 'en_GB', 'Country'),                 (52, 'de_DE', 'Country'),
            (52, 'ru_RU', 'Кантри'),                  (52, 'ru_UA', 'Кантрі'),
            (53, 'en_GB', 'Dance'),                   (53, 'de_DE', 'Tanzmusik'),
            (53, 'ru_RU', 'Танцевальное'),            (53, 'ru_UA', 'Танцювальне'),
            (54, 'en_GB', 'Easy Listening'),          (54, 'de_DE', 'Easy Listening'),
            (54, 'ru_RU', 'Легкая музыка'),           (54, 'ru_UA', 'Легка музика'),
            (55, 'en_GB', 'Electronic'),              (55, 'de_DE', 'Elektronisch'),
            (55, 'ru_RU', 'Электронное'),             (55, 'ru_UA', 'Електронне'),
            (56, 'en_GB', 'Folk'),                    (56, 'de_DE', 'Volksmusik'),
            (56, 'ru_RU', 'Народное'),                (56, 'ru_UA', 'Народне'),
            (57, 'en_GB', 'Hip Hop/Rap'),             (57, 'de_DE', 'HipHop/Rap'),
            (57, 'ru_RU', 'Хип-хоп/рэп'),             (57, 'ru_UA', 'Хіп-хоп/реп'),
            (58, 'en_GB', 'Inspirational/Gospel'),    (58, 'de_DE', 'Inspirierend/Gospel'),
            (58, 'ru_RU', 'Духовное'),                (58, 'ru_UA', 'Духовне'),
            (59, 'en_GB', 'Jazz'),                    (59, 'de_DE', 'Jazz'),
            (59, 'ru_RU', 'Джаз'),                    (59, 'ru_UA', 'Джаз'),
            (60, 'en_GB', 'Latin'),                   (60, 'de_DE', 'Lateinamerikanische Musik'),
            (60, 'ru_RU', 'Латино-американское'),     (60, 'ru_UA', 'Латіно-американске'),
            (61, 'en_GB', 'New Age'),                 (61, 'de_DE', 'New Age'),
            (61, 'ru_RU', 'Нью-эйдж'),                (61, 'ru_UA', 'Нью-ейдж'),
            (62, 'en_GB', 'Opera'),                   (62, 'de_DE', 'Oper'),
            (62, 'ru_RU', 'Опера'),                   (62, 'ru_UA', 'Опера'),
            (63, 'en_GB', 'Pop'),                     (63, 'de_DE', 'Pop'),
            (63, 'ru_RU', 'Поп-музыка'),              (63, 'ru_UA', 'Поп-музыка'),
            (64, 'en_GB', 'R&B/Sou'),                 (64, 'de_DE', 'R&B/Sou'),
            (64, 'ru_RU', 'R&B'),                     (64, 'ru_UA', 'R&B'),
            (65, 'en_GB', 'Reggae'),                  (65, 'de_DE', 'Reggae'),
            (65, 'ru_RU', 'Регги'),                   (65, 'ru_UA', 'Регі'),
            (66, 'en_GB', 'Rock'),                    (66, 'de_DE', 'Rock'),
            (66, 'ru_RU', 'Рок'),                     (66, 'ru_UA', 'Рок');
/*!40000 ALTER TABLE `genre_translations` ENABLE KEYS */;
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
