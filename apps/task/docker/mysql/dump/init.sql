CREATE TABLE app.tasks (
                         `id` INT(10) UNSIGNED NOT NULL AUTO_INCREMENT,
                         `urls` VARCHAR(255) NOT NULL COLLATE 'utf8mb4_general_ci',
                         `created_at` DATETIME NOT NULL DEFAULT current_timestamp(),
                         `updated_at` DATETIME NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
                         PRIMARY KEY (`id`) USING BTREE
)COLLATE='utf8mb4_general_ci'
ENGINE=InnoDB;

LOAD DATA INFILE "/var/dump/urls.csv"
REPLACE INTO TABLE app.tasks
FIELDS TERMINATED BY ','
OPTIONALLY ENCLOSED BY '"'
ESCAPED BY '"'
LINES TERMINATED BY '\n'
(@id, @urls)
SET urls=@urls

