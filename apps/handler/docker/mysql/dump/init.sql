CREATE TABLE app.content (
                         `id` INT(10) UNSIGNED NOT NULL AUTO_INCREMENT,
                         `urls` VARCHAR(255) NOT NULL COLLATE 'utf8mb4_general_ci',
                         `content` INT(10)  NOT NULL,
                         `created_at` DATETIME NOT NULL DEFAULT current_timestamp(),
                         `updated_at` DATETIME NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
                         PRIMARY KEY (`id`) USING BTREE
)COLLATE='utf8mb4_general_ci'
ENGINE=InnoDB;

