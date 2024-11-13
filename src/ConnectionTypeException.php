<?php

declare(strict_types=1);

namespace AbrahanZarza\Dbm;

use Exception;

final class ConnectionTypeException extends Exception
{
    public static function notAllowedConnectionType(string $type): self
    {
        return new self(sprintf('Connection type "%s" specified not allowed.', $type));
    }
}