CREATE TABLE if not exists app.content
(
    `id` UInt32,
    `urls` String,
    `content` UInt32,
    `created_at` DateTime,
    `updated_at` DateTime
)
    ENGINE = MySQL('mysql-handler:3306',
                   'app',
                   'content',
                   'admin',
                   '1234');