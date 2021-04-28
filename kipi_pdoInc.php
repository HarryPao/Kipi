<?php
$db_server = "localhost";
$db_user = "harrybou";
$db_passwd = "5k4g4au4a83";
$db_name = "kipi";
 
try {
    $dsn = "mysql:host=$db_server;dbname=$db_name";
    $dbh = new PDO($dsn, $db_user, $db_passwd);
}
catch (Exception $e){
    die('無法對資料庫連線');
}
 
$dbh->exec("SET NAMES utf8");
?>