<?php
session_start();

require "config/config.php";
require "class/user.php";

$u = new User($pdo);

if (!isset($_SESSION['login']) || empty($_SESSION['login']) || !$u->verifyId($_SESSION['login'])) {
    header("Location: logout.php");
    exit;
}

$u->setData($_SESSION['login']);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Home | <?php echo $u->user;?></title>
</head>
<body>
    <h1 class="name">Hy <?php echo $u->user;?></h1>
    <h1>email: <?php echo $u->email;?></h1>
    <a href="logout.php">[ Logout ]</a>
    <a href="edit.php">[ Edit ]</a>
</body>
</html>