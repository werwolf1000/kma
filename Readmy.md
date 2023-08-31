### Запуск обработчика



Выборка, запросы mysql
```sql

--Вывести сколько строк за минуту
SELECT DATE_FORMAT(c.created_at, "%H:%i") AS minute, count(content) AS total FROM app.content c GROUP BY DATE_FORMAT(c.created_at, "%Y-%m-%d %H:%i");

--Вывести минуту группировки
SELECT DATE_FORMAT(c.created_at, "%i") FROM app.content c GROUP BY DATE_FORMAT(c.created_at, "%Y-%m-%d %H:%i");

--Вывести среднюю длину контента
SELECT AVG(content) FROM app.content;

--Вывести когда было сохранено первое сообщение в минуте и последнее
SELECT min(created_at) AS first, max(created_at) AS last FROM app.content c GROUP BY DATE_FORMAT(c.created_at, "%Y-%m-%d %H:%i");
```

Выборка, запросы clickhouse
```sql
--Табличка реплицирована из mysql 
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

--Вывести сколько строк за минуту
SELECT formatDateTime(c.created_at, '%Y-%m-%d %H:%M') AS minute, count(content) AS total FROM app.content c GROUP BY formatDateTime(c.created_at, '%Y-%m-%d %H:%M');

--Вывести минуту группировки
select formatDateTime(parseDateTime32BestEffort(t.minute), '%M') from (SELECT formatDateTime(c.created_at, '%Y-%m-%d %H:%M') AS minute, count(content) AS total FROM app.content c GROUP BY formatDateTime(c.created_at, '%Y-%m-%d %H:%M')) t;

--Вывести среднюю длину контента
SELECT AVG(content) FROM app.content;

--Вывести когда было сохранено первое сообщение в минуте и последнее
SELECT min(created_at) AS first, max(created_at) AS last FROM app.content c GROUP BY formatDateTime(c.created_at, '%Y-%m-%d %H:%M');
```