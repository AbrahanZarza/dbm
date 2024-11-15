<?php

declare(strict_types=1);

namespace AbrahanZarza\Dbm\Dsn;

use AbrahanZarza\Dbm\Connection\ConnectionType;

final readonly class DsnBuilder
{
    public static function buildSqliteDsn(string $dbFilePath): string
    {
        return sprintf('%s:%s', ConnectionType::SQLITE->value, $dbFilePath);
    }

    public static function buildMysqlDsn(
        string $host,
        int $port,
        string $database,
        string $charset = 'utf8mb4',
    ): string {
        return sprintf(
            '%s:host=%s;port=%s;dbname=%s;charset=%s',
            ConnectionType::MYSQL->value,
            $host,
            $port,
            $database,
            $charset
        );
    }

    public static function buildPgsqlDsn(
        string $host,
        int $port,
        string $database,
    ): string {
        return sprintf(
            '%s:host=%s;port=%s;dbname=%s',
            ConnectionType::PGSQL->value,
            $host,
            $port,
            $database
        );
    }
}