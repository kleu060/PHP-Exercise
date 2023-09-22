<?php

define('DB_HOST', getenv('DB_HOST'));
define('DB_USERNAME',  getenv('MYSQL_USER'));
define('DB_PASSWORD', getenv('MYSQL_PASSWORD'));
define('DB_DATABASE', getenv('MYSQL_DATABASE'));
global $connection;
$connection = new mysqli("db", DB_USERNAME,  DB_PASSWORD ,DB_DATABASE);
if ($connection->connect_error) {
    die("Connection failed: " . $connection->connect_error);
}

?>