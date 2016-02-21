<?php

/**
 * Creates a SQLite database, a user table and fills it with dummy data
 * 
 * @author Leonard Shtika <leonard@shtika.info>
 * @link http://leonard.shtika.info
 * @copyright (C) Leonard Shtika
 * @license MIT. See the file LICENSE for copying permission. 
 */

namespace leoshtika\libs;

use \PDO;
use \PDOException;
use \Faker;

class UserFaker
{

    public static function create($sqliteFile, $newRecords = 32)
    {
        if (!file_exists($sqliteFile)) {

            $dbh = Sqlite::connect($sqliteFile);

            try {
                $sql = "CREATE TABLE IF NOT EXISTS user (
                            id INTEGER PRIMARY KEY AUTOINCREMENT,
                            name TEXT,
                            email TEXT,
                            address TEXT,
                            phone TEXT);";

                $create = $dbh->prepare($sql);
                $create->execute();

                // Start adding dummy data to the db with the help of Faker
                $faker = Faker\Factory::create();

                for ($i = 1; $i <= $newRecords; $i++) {
                    $sth = $dbh->prepare('INSERT INTO user (name, email, address, phone) 
                                            VALUES (:name, :email, :address, :phone)');
                    $sth->bindParam(':name', $faker->name, PDO::PARAM_STR);
                    $sth->bindParam(':email', $faker->email, PDO::PARAM_STR);
                    $sth->bindParam(':address', $faker->address, PDO::PARAM_STR);
                    $sth->bindParam(':phone', $faker->phoneNumber, PDO::PARAM_STR);
                    $sth->execute();

                    // Echo a point for each new record
                    echo '. ';
                }

                echo '<br><strong>' . $newRecords . ' new records were created</strong><hr>';
            } catch (PDOException $ex) {
                echo $ex->getMessage();
            }
            
        } else {
            echo 'Attention! Remove <code>UserFaker::create()</code> line from your code. ' . $sqliteFile . ' database already exists.<hr>';
        }
    }

}
