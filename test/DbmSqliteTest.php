<?php

declare(strict_types=1);

namespace AbrahanZarza\Dbm\Test;

use AbrahanZarza\Dbm\Dbm;
use PHPUnit\Framework\TestCase;

/**
 * @group integration-tests
 * @group sqlite
 */
class DbmSqliteTest extends TestCase
{
    private readonly Dbm $sut;

    public function testWrite(): void
    {
        $expectedResult = [
            'id' => 1,
            'name' => 'Jane',
        ];

        $this->sut->write(
            'INSERT INTO users (id, name) VALUES (:id, :name)',
            [
                ':id' => $expectedResult['id'],
                ':name' => $expectedResult['name'],
            ]
        );

        $result = $this->sut->read(
            'SELECT id, name FROM users WHERE id = :id',
            [':id' => $expectedResult['id']],
            true
        );

        self::assertEquals($expectedResult, $result);
    }

    protected function setUp(): void
    {
        $this->sut = Dbm::buildForSqlite(__DIR__ . '/../etc/database/sqlite/db.sqlite');

        $this->sut->write('
            CREATE TABLE IF NOT EXISTS users (
                `id` int NOT NULL,
                `name` varchar NOT NULL
            )
        ');
    }

    protected function tearDown(): void
    {
        $this->sut->write('DROP TABLE users');
    }
}