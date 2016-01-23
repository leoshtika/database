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

/**
 * Sqlite class extends the (Singleton PDO wrapper) DB class
 */
class Sqlite extends DB
{

    /**
     * Returns a PDO instance
     * @param string $sqliteFile
     * @return PDO
     */
    public static function connect($sqliteFile)
    {
        $dbConfig = array(
            'dsn' => 'sqlite:'.$sqliteFile,
        );

        return parent::connect($dbConfig);
    }

}
