<?php

declare(strict_types=1);

namespace AbrahanZarza\Dbm;

enum ConnectionType: string
{
    case SQLITE = 'sqlite';
    case MYSQL = 'mysql';
    case PGSQL = 'pgsql';
}