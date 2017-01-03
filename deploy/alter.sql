-- 2017-01-03 14:51:00
ALTER TABLE `movies` CHANGE `poster` `image`    varchar(255)    NOT NULL;

ALTER TABLE `genres` ADD    `type`              enum(
                                                    'movie',
                                                    'book',
                                                    'music'
                                                )               DEFAULT 'movie';
ALTER TABLE `genres` DROP INDEX `genre_name`;
ALTER TABLE `genres` ADD UNIQUE INDEX `genre_name` (`name`,`type`);
