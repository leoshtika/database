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
    
    private $_dbh, $_result, $_count, $_error, 
            $_host, $_dbname, $_user, $_pass;
    
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
     * Get the PDO database handler
     * @return PDO handler
     */
    public function dbh()
    {
        return $this->_dbh;
    }
    
    public function query($sql, $params=array())
    {
        $this->_error = false;
        $sth = $this->_dbh->prepare($sql);
        
        if ($sth) {
            if (count($params)) {
                foreach ($params as $key=>$value) {
                    $sth->bindValue($key+1, $value);
                }
            }
            
            if ($sth->execute()) {
                $this->_result = $sth->fetchAll(PDO::FETCH_OBJ);
                $this->_count = $sth->rowCount();
            } else {
                $this->_error = true;
            }
        }
        
        // Return the object to chain the methods
        return $this;
    }
    
    public function error()
    {
        return $this->_error;
    }
    
    public function result()
    {
        return $this->_result;
    }
    
    public function count()
    {
        return $this->_count;
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