<?php

declare(strict_types=1);

namespace AbrahanZarza\Dbm;

use PDO;
use PDOException;

final readonly class Dbm
{
    private const int FETCH_MODE = PDO::FETCH_ASSOC;

    private function __construct(
        private PDO $pdo,
    ) {
    }

    /** @throws PDOException */
    public static function buildForSqlite(string $dbFilePath): self
    {
        $dsn = DsnBuilder::buildSqliteDsn($dbFilePath);

        $pdo = new PDO($dsn, null, null, [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]);

        return new self($pdo);
    }

    /**
     * @throws ConnectionTypeException
     * @throws PDOException
     */
    public static function build(
        ConnectionType $type,
        string $host,
        int $port,
        string $user,
        string $password,
        string $database,
        string $charset = 'utf8mb4',
    ): self {
        $dsn = match ($type) {
            ConnectionType::MYSQL => DsnBuilder::buildMysqlDsn($host, $port, $database, $charset),
            ConnectionType::PGSQL => DsnBuilder::buildPgsqlDsn($host, $port, $database, $charset),
            default => throw ConnectionTypeException::notAllowedConnectionType($type->value),
        };

        $pdo = new PDO($dsn, $user, $password, [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]);

        return new self($pdo);
    }

    public function read(string $query, array $parameters, bool $singleRow = false): string|array
    {
        $stmt = $this->pdo->prepare($query);
        $stmt->execute($parameters);
        $result = $singleRow
            ? $stmt->fetch(self::FETCH_MODE)
            : $stmt->fetchAll(self::FETCH_MODE);

        $stmt->closeCursor();

        return $result;
    }

    public function write(string $query, array $parameters): false|string
    {
        $stmt = $this->pdo->prepare($query);
        $stmt->execute($parameters);
        $lastInsertId = $this->pdo->lastInsertId();

        $stmt->closeCursor();

        return $lastInsertId;
    }
}