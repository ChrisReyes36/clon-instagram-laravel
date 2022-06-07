DROP DATABASE IF EXISTS laravel_master;

CREATE DATABASE IF NOT EXISTS laravel_master CHARACTER SET "utf8" COLLATE "utf8_spanish2_ci";

USE laravel_master;

DROP TABLE IF EXISTS users;

DROP TABLE IF EXISTS images;

DROP TABLE IF EXISTS comments;

DROP TABLE IF EXISTS likes;

CREATE TABLE IF NOT EXISTS `users`(
    `id` INT(11) NOT NULL AUTO_INCREMENT,
    `role` TEXT,
    `name` TEXT,
    `surname` TEXT,
    `nick` TEXT,
    `email` TEXT,
    `password` TEXT,
    `image` TEXT,
    `created_at` DATETIME,
    `updated_at` DATETIME,
    `remember_token` TEXT,
    PRIMARY KEY (`id`)
) ENGINE = InnoDB DEFAULT CHARSET = utf8 COLLATE = utf8_spanish2_ci;

INSERT INTO `users`(`id`, `role`, `name`, `surname`, `nick`, `email`, `password`, `image`, `created_at`, `updated_at`, `remember_token`)
VALUES (NULL,'user','christopher','reyes','chris.reyes','chris@gmail.com','pass',NULL,CURRENT_TIMESTAMP,CURRENT_TIMESTAMP,NULL);

INSERT INTO `users`(`id`, `role`, `name`, `surname`, `nick`, `email`, `password`, `image`, `created_at`, `updated_at`, `remember_token`)
VALUES (NULL,'user','juan','lopez','juan.lopez','juan@gmail.com','pass',NULL,CURRENT_TIMESTAMP,CURRENT_TIMESTAMP,NULL);

INSERT INTO `users`(`id`, `role`, `name`, `surname`, `nick`, `email`, `password`, `image`, `created_at`, `updated_at`, `remember_token`)
VALUES (NULL,'user','manolo','garcia','manolo.garcia','manolo@gmail.com','pass',NULL,CURRENT_TIMESTAMP,CURRENT_TIMESTAMP,NULL);

CREATE TABLE IF NOT EXISTS `images`(
    `id` INT(11) NOT NULL AUTO_INCREMENT,
    `user_id` INT(11) NOT NULL,
    `image_path` TEXT,
    `description` TEXT,
    `created_at` DATETIME,
    `updated_at` DATETIME,
    PRIMARY KEY (`id`),
    CONSTRAINT `fk_images_users` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE = InnoDB DEFAULT CHARSET = utf8 COLLATE = utf8_spanish2_ci;

INSERT INTO `images`(`id`, `user_id`, `image_path`, `description`, `created_at`, `updated_at`)
VALUES (NULL,1,'test.jpg','Descripción de prueba 1',CURRENT_TIMESTAMP,CURRENT_TIMESTAMP);

INSERT INTO `images`(`id`, `user_id`, `image_path`, `description`, `created_at`, `updated_at`)
VALUES (NULL,1,'playa.jpg','Descripción de prueba 2',CURRENT_TIMESTAMP,CURRENT_TIMESTAMP);

INSERT INTO `images`(`id`, `user_id`, `image_path`, `description`, `created_at`, `updated_at`)
VALUES (NULL,1,'arena.jpg','Descripción de prueba 3',CURRENT_TIMESTAMP,CURRENT_TIMESTAMP);

INSERT INTO `images`(`id`, `user_id`, `image_path`, `description`, `created_at`, `updated_at`)
VALUES (NULL,3,'familia.jpg','Descripción de prueba 4',CURRENT_TIMESTAMP,CURRENT_TIMESTAMP);

CREATE TABLE IF NOT EXISTS `comments`(
    `id` INT(11) NOT NULL AUTO_INCREMENT,
    `user_id` INT(11) NOT NULL,
    `image_id` INT(11) NOT NULL,
    `content` TEXT,
    `created_at` DATETIME,
    `updated_at` DATETIME,
    PRIMARY KEY (`id`),
    CONSTRAINT `fk_comments_users` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
    CONSTRAINT `fk_comments_images` FOREIGN KEY (`image_id`) REFERENCES `images` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE = InnoDB DEFAULT CHARSET = utf8 COLLATE = utf8_spanish2_ci;

INSERT INTO `comments`(`id`, `user_id`, `image_id`, `content`, `created_at`, `updated_at`)
VALUES (NULL,1,4,'Buena foto de familia!!!!!',CURRENT_TIMESTAMP,CURRENT_TIMESTAMP);

INSERT INTO `comments`(`id`, `user_id`, `image_id`, `content`, `created_at`, `updated_at`)
VALUES (NULL,2,1,'Buena foto de playa!!!!!',CURRENT_TIMESTAMP,CURRENT_TIMESTAMP);

INSERT INTO `comments`(`id`, `user_id`, `image_id`, `content`, `created_at`, `updated_at`)
VALUES (NULL,2,4,'Que bueno!!!!!',CURRENT_TIMESTAMP,CURRENT_TIMESTAMP);

CREATE TABLE IF NOT EXISTS `likes`(
    `id` INT(11) NOT NULL AUTO_INCREMENT,
    `user_id` INT(11) NOT NULL,
    `image_id` INT(11) NOT NULL,
    `created_at` DATETIME,
    `updated_at` DATETIME,
    PRIMARY KEY (`id`),
    CONSTRAINT `fk_likes_users` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
    CONSTRAINT `fk_likes_images` FOREIGN KEY (`image_id`) REFERENCES `images` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE = InnoDB DEFAULT CHARSET = utf8 COLLATE = utf8_spanish2_ci;

INSERT INTO `likes`(`id`, `user_id`, `image_id`, `created_at`, `updated_at`)
VALUES (NULL,1,4,CURRENT_TIMESTAMP,CURRENT_TIMESTAMP);

INSERT INTO `likes`(`id`, `user_id`, `image_id`, `created_at`, `updated_at`)
VALUES (NULL,2,4,CURRENT_TIMESTAMP,CURRENT_TIMESTAMP);

INSERT INTO `likes`(`id`, `user_id`, `image_id`, `created_at`, `updated_at`)
VALUES (NULL,3,1,CURRENT_TIMESTAMP,CURRENT_TIMESTAMP);

INSERT INTO `likes`(`id`, `user_id`, `image_id`, `created_at`, `updated_at`)
VALUES (NULL,3,2,CURRENT_TIMESTAMP,CURRENT_TIMESTAMP);

INSERT INTO `likes`(`id`, `user_id`, `image_id`, `created_at`, `updated_at`)
VALUES (NULL,2,1,CURRENT_TIMESTAMP,CURRENT_TIMESTAMP);