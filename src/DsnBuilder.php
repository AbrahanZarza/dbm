<?php

declare(strict_types=1);

namespace AbrahanZarza\Dbm;

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
        return self::buildFullDsn(ConnectionType::MYSQL, $host, $port, $database, $charset);
    }

    public static function buildPgsqlDsn(
        string $host,
        int $port,
        string $database,
        string $charset = 'utf8mb4',
    ): string {
        return self::buildFullDsn(ConnectionType::PGSQL, $host, $port, $database, $charset);
    }

    private static function buildFullDsn(
        ConnectionType $type,
        string $host,
        int $port,
        string $database,
        string $charset = 'utf8mb4',
    ): string {
        return sprintf(
            '%s:host=%s;port=%s;dbname=%s;charset=%s',
            $type->value,
            $host,
            $port,
            $database,
            $charset
        );
    }
}