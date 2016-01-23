<?php

require_once 'vendor/autoload.php';

use leoshtika\libs\DB;

$dbConfig = array(
    'dsn' => 'mysql:dbname=crowd_notes;host=localhost',
    'user' => 'root',
    'pass' => '',
);

$dbh1 = DB::connect($dbConfig);
var_dump($dbh1);
$dbh2 = DB::connect($dbConfig);
var_dump($dbh2);
$dbh3 = DB::connect($dbConfig);
var_dump($dbh3);


$sth = $dbh3->prepare('SELECT * FROM user');
$sth->execute();
$users = $sth->fetch(PDO::FETCH_ASSOC);
print_r($users);