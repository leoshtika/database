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
    
    private $_dbh, 
			$_result = null, 
			$_count = 0, 
			$_error = false;
    
	/**
	 * Singleton DB instance 
	 * @return DB
	 */
    public static function instance()
    {
        if (!isset(self::$_instance)) {
            self::$_instance = new DB();
        }
        return self::$_instance;
    }
    
	/**
	 * Connect to MySQL Database
	 * @TODO: Validate args...
	 * 
	 * @param string $host
	 * @param string $dbname
	 * @param string $user
	 * @param string $pass
	 */
    public function connectMysql($host, $dbname, $user, $pass)
    {
        try {
            $this->_dbh = new PDO('mysql:host='.$host.';dbname='.$dbname, $user, $pass);
			$this->_dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $ex) {
            echo 'There is a problem with your Database connection';
			// @TODO: Add LEVEL_EXEPTION in logger
            Logger::add($ex->getMessage(), Logger::LEVEL_WARNING);
            die();
        }
    }
	
	/**
	 * Connect to SQLite Database and create a PDO handler
	 * @param string $sqliteDsn
	 */
	public function connectSqlite($sqliteDsn)
	{
		try {
			$this->_dbh = new PDO($sqliteDsn);
		} catch (PDOException $ex) {
			echo $ex->getMessage();
		}
	}
    
    /**
     * Get the PDO database handler
     * @return PDO
     */
    public function dbh()
    {
        return $this->_dbh;
    }
    
	/**
	 * Execute a query with binded values
	 * @param string $sql
	 * @param array $params
	 * @return DB
	 */
    public function query($sql, $params=array())
    {
		$this->_resetQueryResult();
		
        $sth = $this->_dbh->prepare($sql);
        
        if ($sth) {
            if (count($params)) {
                foreach ($params as $key=>$value) {
                    $sth->bindValue($key+1, $value);
                }
            }
			
			try {
				$sth->execute();
                $this->_result = $sth->fetchAll(PDO::FETCH_OBJ);
                $this->_count = $sth->rowCount();
			} catch (PDOException $ex) {
                $this->_error = true;
				Logger::add($ex->getMessage(), Logger::LEVEL_WARNING);				
			}
        }
        
        // Return the object to chain the methods
        return $this;
    }
    
	/**
	 * If there is an error in a query it will return true
	 * @return boolean
	 */
    public function error()
    {
        return $this->_error;
    }
    
	/**
	 * Query result
	 * @return array of objects
	 */
    public function result()
    {
        return $this->_result;
    }
    
	/**
	 * Count of query result
	 * @return type
	 */
    public function count()
    {
        return $this->_count;
    }
	
	/**
	 * Reset all the results from a query to use in a new one
	 */
	private function _resetQueryResult()
	{
		$this->_error = false;
		$this->_result = null;
		$this->_count = 0;	
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