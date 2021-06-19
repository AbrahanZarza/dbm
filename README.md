# Dbm
Esta herramienta provee de mecanismos para conectarse a una base de datos y realizar consultas de forma sencilla y cómoda, aportando todas las ventajas de la extensión [PHP PDO](https://www.php.net/manual/es/book.pdo.php). Actualmente, soporta conexiones con bases de datos MySQL, Postgres, SQLServer y SQLite.

Fue creada para ser empleada en proyectos web sencillos, pero también se puede usar como la capa de base de datos de una aplicación web más compleja.

## Instrucciones de uso

Instalamos la librería vía [composer](https://getcomposer.org/doc/) en nuestro proyecto:
```
composer require abrahan-zarza/dbm
```

Posteriormente, debemos que establecer los siguientes valores en las variables de entorno del proyecto:
```
$_ENV['DB'] = 'database_type';
$_ENV['DB_HOST'] = 'address';
$_ENV['DB_PORT'] = 'port';
$_ENV['DB_USER'] = 'user';
$_ENV['DB_PASSWORD'] = 'password';
$_ENV['DB_NAME'] = 'database';
```

### Instanciar una conexión
```
$conn = \Dbm\Dbm::getInstance();
```

### Cerrar una conexión
```
$conn->destroy();
```

### Método `executeS`
Este método se usa para realizar consultas de las que necesitemos obtener múltiples registros de la base de datos, normalmente consultas SELECT.
```
executeS(string $query, array $bindParams = null, bool $destroyInstance = true)
```

### Método `getRow`
Este otro método se usa para realizar consultas de las que necesitemos obtener un solo registro de la base de datos, como las consultas `SELECT`.
```
getRow(string $query, array $bindParams = null, bool $destroyInstance = true)
```

### Método `execute`
Este método se usa para realizar consultas de las que no necesitamos extraer datos de la base de datos, es decir, operaciones como `INSERT`, `UPDATE` o `DELETE`.
```
execute(string $query, array $bindParams = null, bool $destroyInstance = true)
```

## Parámetros

### `$query`
Este parámetro es la consulta a base de datos.

### `$bindParams`
En el caso que la consulta requiera de valores dinámicos, se especifican como array asociativo, cuya clave sería el nombre del valor que necesitamos y el valor de dicha clave sería el valor a mostrar.

### `$destroyInstance`
Por defecto, cada vez que ejecutamos una consulta, la instancia de base de datos se cierra. En el caso de querer mantenerla abierta, haremos uso de este parámetro, pasando su valor como `TRUE`.

## Ejemplos

**Obtener un listado de usuarios:**
```
$results = $conn->executeS('SELECT id, name FROM users');
```

**Obtener un usuario concreto por su id:**
```
$results = $conn->getRow('SELECT id, name FROM users WHERE id = :id', ['id' => 1]);
```

**Insertar un nuevo usuario:**
```
$lastInsertId = $conn->execute('INSERT INTO users (name, email) VALUES (:name, :email)', ['name' => 'John', 'email' => 'john@doe.com']);
```

