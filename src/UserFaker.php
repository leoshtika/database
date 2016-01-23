<?php

/**
 * Creates a SQLite database, a user table and fill it with dummy data
 */

namespace leoshtika\libs;

use \PDO;
use \PDOException;
use \Faker;

class UserFaker
{

    public static function create($sqliteFile = 'demo.sqlite', $newRecords = 123)
    {
        if (file_exists($sqliteFile)) {
            echo 'This (' . $sqliteFile . ') SQLite database already exists...<br>';
        } else {
            echo 'A new (' . $sqliteFile . ') SQLite database was created...<br>';
        }

        DB::instance()->connectSqlite($sqliteFile);

        try {
            $sql = "CREATE TABLE IF NOT EXISTS user (
					id		INTEGER PRIMARY KEY AUTOINCREMENT,
					name	TEXT,
					email	TEXT,
					address TEXT,
					phone   TEXT);";

            $create = DB::instance()->dbh()->prepare($sql);
            $create->execute();

            // Start adding dummy data to the db with the help of Faker
            $faker = Faker\Factory::create();

            for ($i = 1; $i <= $newRecords; $i++) {
                $sth = DB::instance()->dbh()->prepare('INSERT INTO user (name, email, address, phone) 
																 VALUES (:name, :email, :address, :phone)');
                $sth->bindParam(':name', $faker->name, PDO::PARAM_STR);
                $sth->bindParam(':email', $faker->email, PDO::PARAM_STR);
                $sth->bindParam(':address', $faker->address, PDO::PARAM_STR);
                $sth->bindParam(':phone', $faker->phoneNumber, PDO::PARAM_STR);
                $sth->execute();
                echo '. ';
            }
            echo '<br>' . $newRecords . ' new records were created<hr>';
        } catch (PDOException $ex) {
            echo $ex->getMessage();
        }
    }

}
