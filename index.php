<?php

// Testing

require_once 'vendor/autoload.php';

use leoshtika\libs\DB;

DB::instance()->connect('localhost', 'database', '', '');

$sth = DB::instance()->query()->prepare('SELECT * FROM user');
$sth->execute();


$users = $sth->fetchAll(PDO::FETCH_OBJ);

foreach ($users as $user) {
    echo $user->name;
    echo '<br>';
    echo $user->username;
    echo '<br><hr>';
}