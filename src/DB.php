<?php

/**
 * A lightweight wrapper around PDO
 * 
 * @author Leonard Shtika <leonard@shtika.info>
 * @link http://leonard.shtika.info
 * @copyright (C) Leonard Shtika
 * @license MIT. See the file LICENSE for copying permission. 
 */

namespace leoshtika\libs;

use \PDO;
use \PDOException;

/**
 * DB class using 'Singleton' pattern.
 * @property PDO $_instance
 */
class DB
{

    private static $_instance;

    /**
     * Connects to the database and creates a PDO instance
     * @param array $dbConfig
     */
    private function __construct($dbConfig)
    {
        try {
            self::$_instance = new PDO($dbConfig['dsn'], $dbConfig['user'], $dbConfig['pass']);
            self::$_instance->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $ex) {
            echo 'There is a problem with your database connection';
            Logger::add($ex->getMessage(), Logger::LEVEL_CRITICAL);
            die();
        }
    }

    /**
     * Returns a PDO instance and makes sure only one database connection is created
     * @param array $dbConfig
     * @return PDO
     */
    public static function connect($dbConfig)
    {
        if (!self::$_instance) {
            new DB($dbConfig);
        }
        return self::$_instance;
    }

    /**
     * Private __clone method prevents cloning the 'Singleton' instance.
     */
    private function __clone()
    {
        
    }

    /**
     * Private __wakeup method prevents unserializing the 'Singleton' instance.
     */
    private function __wakeup()
    {
        
    }

}
