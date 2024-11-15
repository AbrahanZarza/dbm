<?php

declare(strict_types=1);

namespace AbrahanZarza\Dbm\Test\Dsn;

use AbrahanZarza\Dbm\Connection\ConnectionType;
use AbrahanZarza\Dbm\Dsn\DsnBuilder;
use PHPUnit\Framework\TestCase;

/** @group unit-tests */
class DsnBuilderTest extends TestCase
{
    private const string DB_HOST = 'host';
    private const int DB_PORT = 1234;
    private const string DB_DATABASE = 'database';
    private const string DB_CHARSET = 'latin1';

    public function testBuildSqliteDsn(): void
    {
        $dbFilePath = 'file/path.sqlite';
        $result = DsnBuilder::buildSqliteDsn($dbFilePath);

        self::assertEquals(
            sprintf('%s:%s', ConnectionType::SQLITE->value, $dbFilePath),
            $result
        );
    }

    public function testBuildMysqlDsn(): void
    {
        $result = DsnBuilder::buildMysqlDsn(
            self::DB_HOST,
            self::DB_PORT,
            self::DB_DATABASE,
            self::DB_CHARSET
        );

        self::assertEquals(
            sprintf(
                '%s:host=%s;port=%s;dbname=%s;charset=%s',
                ConnectionType::MYSQL->value,
                self::DB_HOST,
                self::DB_PORT,
                self::DB_DATABASE,
                self::DB_CHARSET
            ),
            $result
        );
    }

    public function testBuildPgsqlDsn(): void
    {
        $result = DsnBuilder::buildPgsqlDsn(
            self::DB_HOST,
            self::DB_PORT,
            self::DB_DATABASE,
        );

        self::assertEquals(
            sprintf(
                '%s:host=%s;port=%s;dbname=%s',
                ConnectionType::PGSQL->value,
                self::DB_HOST,
                self::DB_PORT,
                self::DB_DATABASE
            ),
            $result
        );
    }
}