# Dbm

![PHP](https://img.shields.io/badge/php-8.3-blue)

This library provides mechanisms to connect to a database and perform queries easily and conveniently, leveraging all the advantages of the [PHP PDO](https://www.php.net/manual/es/book.pdo.php) extension. It currently supports connections with MySQL, Postgres, and SQLite databases.

It was designed to be used in simple PHP projects but can also serve as the database layer for a more complex web application.

## How to start

Install it in your PHP project using [composer](https://getcomposer.org/doc/):
```
composer require abrahanzarza/dbm
```

With that you are ready to connect with your database.

### MySQL database connection
```
$dbm = Dbm::build(
    ConnectionType $type,  //ConnectionType::MYSQL
    string $host,
    int $port,
    string $user,
    string $password,
    string $database,
    string $charset = 'utf8mb4',
);
```

Example:

```
$dbm = Dbm::build(ConnectionType::MYSQL, 'localhost', 3306, 'db_user', 'db_pass', 'database', 'latin1');
```

### PostgreSQL database connection
```
$dbm = Dbm::build(
    ConnectionType $type,  //ConnectionType::PGSQL
    string $host,
    int $port,
    string $user,
    string $password,
    string $database,
);
```

Example:

```
$dbm = Dbm::build(ConnectionType::PGSQL, 'localhost', 3306, 'db_user', 'db_pass', 'database');
```

### SQLite database connection
```
$dbm = Dbm::buildForSqlite(
    string $dbFilePath,  //The database file location
);
```

Example:

```
$dbm = Dbm::buildForSqlite(__DIR__ . '/database.sqlite');
```

## How to use

Once you have been connected successfully following the previous steps, you can work with your database.

### The `read` method
This method must be used for all **read operations** with your database, for example:
```
$result = $dbm->read('SELECT * FROM users');
```
>The `$result` variable contains an array with all records of the users table.

#### Available parameters

| Name        | Type   | Description                | Optional | Default value |
|-------------|--------|----------------------------|----------|--------------|
| $query      | string | The database query         | No       |              |
| $parameters | array  | Bind params for your query | Yes      | [ ]          |
| $singleRow | bool   | Returns only a single row  | Yes      | false        |

### The `write` method
This method must be used for all **write operations** with your database, for example:

* Insert one user:
```
$dbm->write(
    'INSERT INTO users (id, name) VALUES (:id, :name)',
    [':id' => 2, ':name' => 'Jane']
);
```

* Update the user:
```
$dbm->write(
    'UPDATE users SET name = :name WHERE id = :id',
    [':name' => 'Lorem', ':id' => 2]
);
```

* Delete the user:
```
$dbm->write('DELETE FROM users WHERE id = :id', [':id' => 2]);
```

* Also, drop the _users_ table:
```
$dbm->write('DROP TABLE users');
```

#### Available parameters

| Name        | Type   | Description                   | Optional | Default value |
|-------------|--------|-------------------------------|----------|--------------|
| $query      | string | The database query            | No       |              |
| $parameters | array  | Bind params for your query    | Yes      | [ ]          |
| $returnLastInsertId | bool   | Returns the last insertion ID | Yes      | false        |

## Authors

* [Abrahan Zarza](https://github.com/AbrahanZarza). The project creator and maintainer.
