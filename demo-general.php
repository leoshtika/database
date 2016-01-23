<?php

/**
 * Demo general DB
 * 
 * @author Leonard Shtika <leonard@shtika.info>
 * @link http://leonard.shtika.info
 * @copyright (C) Leonard Shtika
 * @license MIT. See the file LICENSE for copying permission. 
 */

require_once 'vendor/autoload.php';

use leoshtika\libs\DB;

$config = array(
    'dsn' => 'mysql:dbname=myapp;host=localhost',
    'user' => 'root',
    'pass' => '',
);

$dbh = DB::connect($config);

$sth = $dbh->prepare('SELECT * FROM user');
$sth->execute();
$users = $sth->fetchAll(PDO::FETCH_ASSOC);

foreach ($users as $user) {
    echo $user['name'] . ' Email: ' . $user['email'];
    echo '<hr>';
}