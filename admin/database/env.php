<?php
$hostname = "localhost";
$dbuser = "root";
$dbPsk = "";
$dbname = "ataur_portfolio";
try{
    $db = mysqli_connect($hostname, $dbuser, $dbPsk, $dbname);
} catch (Exception $error) {
    echo $error->getMessage(); 
    exit();
}
