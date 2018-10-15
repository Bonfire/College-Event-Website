<?php

include_once('../config.inc.php');

try
{
    $conn = new PDO("mysql:host=$servername;dbname=main_database", $username, $password);
    // set the PDO error mode to exception
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
}
catch(PDOException $e)
{
    echo "Connection to database failed: " . $e->getMessage();
}
?>