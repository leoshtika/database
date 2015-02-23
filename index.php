<?php

// Testing

require_once 'vendor/autoload.php';

use leoshtika\libs\DB;

DB::instance()->connect('localhost', 'leoshtika_database', '', '');

/*
$id = 1;
$sth = DB::instance()->dbh()->prepare('SELECT * FROM user WHERE id = :id');
$sth->bindParam(':id', $id, PDO::PARAM_INT);
$sth->execute();
$user = $sth->fetch(PDO::FETCH_OBJ);
if ($user) {
    echo $user->name;
}
*/

$users = DB::instance()->query('SELECT * FROM user WHERE id = ?', array(1));

if ($users->error()) {
    echo 'There is an error';
} else {
    foreach ($users->result() as $user) {
        echo $user->name;
        echo '<hr>';
    }
}