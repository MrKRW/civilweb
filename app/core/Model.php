<?php
/**
 * CivilLanka MVC – Base Model
 */
require_once __DIR__ . '/../../config/db.php';

abstract class Model
{
    /** @var PDO|null */
    private static ?PDO $connection = null;

    /**
     * Return the shared PDO connection.
     */
    protected function db(): PDO
    {
        if (self::$connection === null) {
            self::$connection = getDB();
        }
        return self::$connection;
    }
}
