drop table if exists `motorcycle_types`;
CREATE TABLE `motorcycles_types`
(
    `id`   integer NOT NULL,
    `name` VARCHAR(50),
    PRIMARY KEY (id)
);

INSERT INTO `motorcycles_types` (`name`)
VALUES ('Дорожные'),
       ('Электробайк'),
       ('Турер'),
       ('Минибайк'),
       ('Тяжёлые мотоциклы');

DROP TABLE IF EXISTS `motorcycles`;
CREATE TABLE `motorcycles`
(
    `id`           integer NOT NULL,
    `name`         VARCHAR(50),
    `discontinued` DATE DEFAULT NULL,
    `type_id`      INT     NOT NULL references `motorcycle_types` (`id`),
    PRIMARY KEY (id)
);

INSERT INTO `motorcycles` (`name`, `discontinued`, `type_id`)
VALUES ('Honda 1-Test', NULL, 1),
       ('Kawasaki 2-Test', NULL, 2),
       ('Moto 3-Test', '2009-01-01', 3),
       ('Мини М-1', NULL, 4),
       ('Урал-Т', '1991-01-01', 5),
       ('Иж Планета-5', '2008-01-01', 5);

SELECT `mt`.`name` AS 'moto_type', COUNT(`m`.`id`) AS 'moto_count'
FROM `motorcycles_types` AS mt
         LEFT JOIN `motorcycles` AS m ON `m`.`type_id` = `mt`.`id`
    AND `m`.`discontinued` IS NULL
GROUP BY `mt`.`id`;