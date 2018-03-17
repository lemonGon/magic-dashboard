<?php

namespace Core;

use PDO;
use App\Config;

/**
 * Class Model
 * @package Core
 */
abstract class Model
{
    /** @var PDO */
    protected $db;

    /**
     * Get the PDO database connection
     */
    protected function setDB()
    {
        $dsn = 'mysql:host=' . Config::DB_HOST . ';dbname=' . Config::DB_NAME . ';charset=utf8';
        $this->db = new PDO($dsn, Config::DB_USER, Config::DB_PASSWORD);

        // Throw an Exception when an error occurs
        $this->db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    }

    /**
     * @return PDO
     */
    protected function getDB()
    {
        return $this->db;
    }
}
