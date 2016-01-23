<?php

/**
 * Demo SQLite
 * 
 * @author Leonard Shtika <leonard@shtika.info>
 * @link http://leonard.shtika.info
 * @copyright (C) Leonard Shtika
 * @license MIT. See the file LICENSE for copying permission. 
 */

require_once 'vendor/autoload.php';

use leoshtika\libs\Sqlite;
use leoshtika\libs\UserFaker;

$sqliteFile = 'demo.sqlite';

// Create the database if not exists
UserFaker::create($sqliteFile);

$dbh = Sqlite::connect($sqliteFile);

$sth = $dbh->prepare('SELECT * FROM user');
$sth->execute();
$users = $sth->fetchAll(PDO::FETCH_ASSOC);

foreach ($users as $user) {
    echo $user['name'] . ' Email: ' . $user['email'];
    echo '<hr>';
}