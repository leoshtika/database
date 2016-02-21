# A lightweight wrapper around PDO

[![License](https://img.shields.io/badge/license-MIT-blue.svg)](http://opensource.org/licenses/MIT)
[![Packagist](https://img.shields.io/badge/packagist-download-orange.svg)](https://packagist.org/packages/leoshtika/database)

## Requirements
- PHP 5.3 or higher
 
## Installation with Composer
- from the command line
```
composer require leoshtika/database
```

- or updating your composer.json file
```
{
    "require": {
        "leoshtika/database": "~1.1"
    }
}
```


## Usage
#### Connect to an SQLite database
```php
<?php
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
```

#### Connect to a MySQL database
```php
require_once 'vendor/autoload.php';

use leoshtika\libs\Mysql;

$config = array(
    'host' => 'localhost',
    'dbname' => 'myapp',
    'user' => 'root',
    'pass' => '',
);

$dbh = Mysql::connect($config);

$sth = $dbh->prepare('SELECT * FROM user');
$sth->execute();
$users = $sth->fetchAll(PDO::FETCH_ASSOC);

foreach ($users as $user) {
    echo $user['name'] . ' Email: ' . $user['email'];
    echo '<hr>';
}
```

-------
Enjoy!
