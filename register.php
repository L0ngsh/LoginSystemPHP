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
    <title>Register</title>
</head>
<body>

    <?php
        if (isset($_POST['name']) && !empty($_POST['name'])) {
            if (isset($_POST['email']) && !empty($_POST['email'])) {
                if (isset($_POST['password']) && !empty($_POST['password'])) {
                    if ($u->register($_POST['name'], $_POST['email'], $_POST['password'])) {
                        $_SESSION['login'] = $u->getId($_POST['email']);
                        header("Location: /CRUDphp");
                        exit;
                    } else {
                        ?>
                            <span>Please try again latter!!</span>
                        <?php
                    }
                }
            }
        }
    ?>

    <form method="post">
        <span>User Name</span><br>
        <input type="text" name="name" id="name">
        <br><br><br>
        <span>Email</span><br>
        <input type="email" name="email" id="email">
        <br><br><br>
        <span>Password</span><br>
        <input type="password" name="password" id="password">
        <br><br><br>
        <input type="submit" value="Register">
    </form>
    <br><br>
    <a href="login.php">[ Login ]</a>
</body>
</html>