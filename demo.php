<?php

// Testing

require_once 'vendor/autoload.php';

use leoshtika\libs\DB;
use leoshtika\libs\Mysql;
use leoshtika\libs\Sqlite;
use leoshtika\libs\UserFaker;

// DB::instance()->connectMysql('localhost', 'leoshtika_database', 'root', '');
$sqliteFile = 'demo.sqlite';


if (!file_exists($sqliteFile)) {
    UserFaker::create($sqliteFile);
}
$dbh = Sqlite::connect($sqliteFile);


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

// @TODO: Fix query for more general input data
$sth = $dbh->prepare('SELECT * FROM user');
$sth->execute();
$users = $sth->fetchAll(PDO::FETCH_ASSOC);
echo '<pre>';
print_r($users);
echo '</pre>';

//if (!$users->error()) {
//    foreach ($users->result() as $user) {
//        echo "{$user->id} {$user->name} ({$user->email})<br>";
//    }
//} else {
//    echo 'There is a problem with your query';
//}