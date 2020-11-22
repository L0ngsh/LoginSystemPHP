<?php
$localhost = "localhost";
$dbName = "crud";
$dbUser = "root";
$dbPwd = "root";

try {
  $pdo = new PDO('mysql:host='.$localhost.';dbname='.$dbName, $dbUser, $dbPwd);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch(PDOException $e) {
    echo 'ERROR: ' . $e->getMessage();
}
?>