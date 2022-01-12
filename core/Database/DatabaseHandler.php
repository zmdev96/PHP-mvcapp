<?php
namespace Core\Database;

abstract class DatabaseHandler
{
    const DATABASE_DRIVER_POD       = 1;
    const DATABASE_DRIVER_MYSQLI    = 2;

    private function __construct()
    {
    }

    abstract protected static function init();

    abstract protected static function getInstance();

    public static function factory()
    {
        $driver = DATABASE_CONN_DRIVER;
        if ($driver == self::DATABASE_DRIVER_POD) {
            return PDOHandler::getInstance();
        } elseif ($driver == self::DATABASE_DRIVER_MYSQLI) {
            return MySQLiHandler::getInstance();
        }
    }
}
