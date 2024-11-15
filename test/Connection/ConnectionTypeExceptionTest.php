<?php

declare(strict_types=1);

namespace AbrahanZarza\Dbm\Test\Connection;

use AbrahanZarza\Dbm\Connection\ConnectionTypeException;
use PHPUnit\Framework\TestCase;

/** @group unit-tests */
class ConnectionTypeExceptionTest extends TestCase
{
    public function testBuildFromNotAllowedConnectionType(): void
    {
        $type = 'wrongType';
        $sut = ConnectionTypeException::notAllowedConnectionType($type);

        self::assertEquals(
            sprintf('Connection type "%s" specified not allowed.', $type),
            $sut->getMessage()
        );
    }
}