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

use PDO;

/**
 * Mysql class extends the (Singleton PDO wrapper) DB class
 */
class Mysql extends DB
{

    /**
     * Returns a PDO instance
     * @param array $mysqlConfig
     * @return PDO
     */
    public static function connect($mysqlConfig)
    {
        $dbConfig = array(
            'dsn' => 'mysql:dbname=' . $mysqlConfig['dbname'] . ';host=' . $mysqlConfig['host'],
            'user' => $mysqlConfig['user'],
            'pass' => $mysqlConfig['pass'],
            'options' => array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8"),
        );

        return parent::connect($dbConfig);
    }

}
