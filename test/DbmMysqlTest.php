<?php

declare(strict_types=1);

namespace AbrahanZarza\Dbm\Test;

use AbrahanZarza\Dbm\Connection\ConnectionType;
use AbrahanZarza\Dbm\Connection\ConnectionTypeException;
use AbrahanZarza\Dbm\Dbm;
use PHPUnit\Framework\TestCase;

/**
 * @group integration-tests
 * @group mysql
 */
class DbmMysqlTest extends TestCase
{
    private const ConnectionType TYPE = ConnectionType::MYSQL;
    private const string HOST = 'mysql-db';
    private const int PORT = 3306;
    private const string USER = 'root';
    private const string PASSWORD = 'root';
    private const string DATABASE = 'test';
    private readonly Dbm $sut;

    public function testBuildWithNotAllowedType(): void
    {
        $type = ConnectionType::SQLITE;

        self::expectException(ConnectionTypeException::class);
        self::expectExceptionMessage(sprintf('Connection type "%s" specified not allowed.', $type->value));

        Dbm::build($type, self::HOST, self::PORT, self::USER, self::PASSWORD, self::DATABASE);
    }

    public function testReadOneResult(): void
    {
        $expectedResult = [
            'product_id' => 1,
            'product_name' => 'Pizza',
            'product_description' => 'A pizza with BBQ sauce.',
            'category_name' => 'Food',
        ];

        $sql = '
            SELECT
                p.id AS product_id,
                p.name AS product_name,
                p.description AS product_description,
                c.name AS category_name
            FROM
                products p
                LEFT JOIN categories c ON p.category_id = c.id
            WHERE
                p.id = :id
        ';

        $parameters = [':id' => $expectedResult['product_id']];

        $result = $this->sut->read($sql, $parameters, true);

        self::assertEquals($expectedResult, $result);
    }

    public function testReadMultipleResults(): void
    {
        $expectedResult = [
            [
                'product_id' => 1,
                'product_name' => 'Pizza',
                'product_description' => 'A pizza with BBQ sauce.',
                'category_name' => 'Food',
            ],
            [
                'product_id' => 3,
                'product_name' => 'Chart',
                'product_description' => 'A chart with a boat in the sea.',
                'category_name' => 'Home',
            ],
        ];

        $sql = '
            SELECT
                p.id AS product_id,
                p.name AS product_name,
                p.description AS product_description,
                c.name AS category_name
            FROM
                products p
                LEFT JOIN categories c ON p.category_id = c.id
            WHERE
                p.id IN (:firstId, :secondId)
        ';

        $parameters = [
            ':firstId' => $expectedResult[0]['product_id'],
            ':secondId' => $expectedResult[1]['product_id'],
        ];

        $result = $this->sut->read($sql, $parameters);

        self::assertEquals($expectedResult, $result);
    }

    public function testWrite(): void
    {
        $newRecord = [
            'id' => 6,
            'name' => 'Chair',
            'category_id' => 2,
        ];

        $parameters = [
            ':id' => $newRecord['id'],
            ':name' => $newRecord['name'],
            ':category_id' => $newRecord['category_id'],
        ];

        $this->sut->write('INSERT INTO products (id, name, category_id) VALUES (:id, :name, :category_id)', $parameters, true);

        $result = $this->sut->read(
            'SELECT id, name, category_id FROM products WHERE id = :id',
            [':id' => $newRecord['id']],
            true
        );
        self::assertEquals($newRecord, $result);

        $this->sut->write('DELETE FROM products WHERE id = :id LIMIT 1', [':id' => $newRecord['id']]);
    }

    protected function setUp(): void
    {
        $this->sut = Dbm::build(
            self::TYPE,
            self::HOST,
            self::PORT,
            self::USER,
            self::PASSWORD,
            self::DATABASE
        );
    }
}