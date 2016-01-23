<?php

/**
 * DB: A lightweight wrapper around PDO
 * 
 * @author Leonard Shtika <leonard@shtika.info>
 * @link http://leonard.shtika.info
 * @copyright (C) Leonard Shtika
 * @license MIT. See the file LICENSE for copying permission. 
 */

namespace leoshtika\libs;

use \PDO;
use \PDOException;
use leoshtika\libs\Logger;

/**
 * DB class file
 * @property PDO $_instance
 */
class DB
{

    private static $_instance;

    private function __construct($host, $dbname, $user, $pass)
    {
        try {
            self::$_instance = new PDO('mysql:host=' . $host . ';dbname=' . $dbname, $user, $pass);
            self::$_instance->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $ex) {
            echo 'There is a problem with your Database connection';
            Logger::add($ex->getMessage(), Logger::LEVEL_CRITICAL);
            die();
        }
    }
    
    public static function connect($host, $dbname, $user, $pass)
    {
        if (!self::$_instance) {
            new DB($host, $dbname, $user, $pass);
        }
        return self::$_instance;
    }
    

    /**
     * Private clone method to prevent cloning the 'Singleton' instance.
     */
    private function __clone()
    {
        
    }

    /**
     * Private unserialize method to prevent unserializing of the 'Singleton' instance.
     */
    private function __wakeup()
    {
        
    }

}
