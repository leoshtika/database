<?php

// Testing

require_once 'vendor/autoload.php';

use leoshtika\libs\DB;
use leoshtika\libs\Logger;

DB::instance()->connect('localhost', 'leoshtika_database', 'root', '');

// Get all active users
$active = 1;

//try {
//	$sth = DB::instance()->dbh()->prepare('SELECT * FROM user WHERE active = :active');
//	$sth->bindParam(':active', $active, PDO::PARAM_INT);
//	$sth->execute();
//	$users = $sth->fetchAll(PDO::FETCH_OBJ);
//
//	foreach ($users as $user) {
//		echo $user->name;
//		echo '<hr>';
//	}
//} catch (PDOException $ex) {
//	echo 'There is a problem with your query';
//	Logger::add($ex->getMessage(), Logger::LEVEL_WARNING);
//}


$users = DB::instance()->query('SELECT * FROM user WHERE active = ?', array($active));
if (!$users->error()) {
    foreach ($users->result() as $user) {
        echo $user->name;
        echo '<hr>';
    }
} else {
    echo 'There is a problem with your query';
}