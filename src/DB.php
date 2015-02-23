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

/**
 * DB class file
 * @property PDO $_instance
 */
class DB
{
    private static $_instance = null;
    
    private $_dbh, $_host, $_dbname, $_user, $_pass;
    
    public static function instance()
    {
        if (!isset(self::$_instance)) {
            self::$_instance = new DB();
        }
        return self::$_instance;
    }
    
    public function connect($host, $dbname, $user, $pass)
    {
        $this->_host = $host;
        $this->_dbname = $dbname;
        $this->_user = $user;
        $this->_pass = $pass;
        
        $this->_createDbHandler();
    }
    
    /* @var PDO */
    private function _createDbHandler()
    {
        try {
            $this->_dbh = new PDO('mysql:host='.$this->_host.';dbname='.$this->_dbname, $this->_user, $this->_pass);
        } catch (PDOException $ex) {
            echo 'DB connection problem';
            Logger::add($ex->getMessage(), Logger::LEVEL_WARNING);
            die();
        }
    }
    
    /**
     * PDO instance
     * @return PDO handler
     */
    public function pdo()
    {
        return $this->_dbh;
    }
    
    
    /**
     * Protected constructor to prevent creating a new instance of the
     * 'Singleton' via the 'new' operator from outside of this class.
     */
    protected function __construct() {}
    
    /**
     * Private clone method to prevent cloning the 'Singleton' instance.
     */
    private function __clone() {}

    /**
     * Private unserialize method to prevent unserializing of the 'Singleton' instance.
     */
    private function __wakeup() {}
    
}