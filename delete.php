<?php
session_start();

require "config/config.php";
require "class/user.php";

$u = new User($pdo);

if (isset($_SESSION['login']) && !empty($_SESSION['login'])) {
    if ($u->verifyId($_SESSION['login'])) {
        $u->delete($_SESSION['login']);
    }
}

header("Location: logout.php");
exit;
?>