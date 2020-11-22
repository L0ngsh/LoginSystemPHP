<?php
session_start();

require "config/config.php";
require "class/user.php";

$u = new User($pdo);

if (isset($_SESSION['login']) && !empty($_SESSION['login'])) {
    if ($u->verifyId($_SESSION['login'])) {
        header("Location: /CRUDphp");
        exit;
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
</head>
<body>

    <?php
        if (isset($_POST['email']) && !empty($_POST['email'])) {
            if (isset($_POST['password']) && !empty($_POST['password'])) {
                 if ($u->login($_POST['password'], $_POST['email'])) {
                     $_SESSION['login'] = $u->getId($_POST['email']);
                     header("Location: /CRUDphp");
                     exit;
                 } else {
                     ?>
                             <span>Please try again later</span>
                     <?php
               }
            }
        }
    ?>

    <form method="post">
        <span>Email</span><br>
        <input type="email" name="email" id="email">
        <br><br><br>
        <span>Password</span><br>
        <input type="password" name="password" id="password">
        <br><br><br>
        <input type="submit" value="Log In">
    </form>
    <br><br>
    <a href="register.php">[ Register ]</a>
</body>
</html>