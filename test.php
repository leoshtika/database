<?php

require_once 'vendor/autoload.php';

use leoshtika\libs\DB;
use leoshtika\libs\Mysql;
use leoshtika\libs\Sqlite;

$dbConfig = array(
    'dsn' => 'mysql:dbname=crowd_notes;host=localhost',
    'user' => 'root',
    'pass' => '',
);

$dbh1 = DB::connect($dbConfig);
var_dump($dbh1);
$dbh2 = DB::connect($dbConfig);
var_dump($dbh2);


$sth = $dbh1->prepare('SELECT * FROM user');
$sth->execute();
$users = $sth->fetch(PDO::FETCH_ASSOC);
print_r($users);

// =====================

$mysqlConfig = array(
    'host' => 'localhost',
    'dbname' => 'crowd_notes',
    'user' => 'root',
    'pass' => '',
);

$dbh10 = Mysql::connect($mysqlConfig);
var_dump($dbh10);
$dbh20 = Mysql::connect($mysqlConfig);
var_dump($dbh20);


// =====================

$sqlitePath = 'demo.sqlite';

$sqliteH1 = Sqlite::connect($sqlitePath);
var_dump($sqliteH1);
$sqliteH2 = Sqlite::connect($sqlitePath);
var_dump($sqliteH2);


//
//$sth10 = $dbh10->prepare('SELECT * FROM user');
//$sth10->execute();
//$users10 = $sth10->fetch(PDO::FETCH_ASSOC);
//print_r($users10);