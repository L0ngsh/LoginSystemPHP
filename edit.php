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
    <title>Edit | <?php echo $u->user;?></title>
</head>
<body>

    <?php
        if (isset($_POST['name']) && !empty($_POST['name'])) {
            if (isset($_POST['email']) && !empty($_POST['email'])) {
                $u->editProfile($_POST['name'], $_POST['email'], $_SESSION['login']);
                $u->setData($_SESSION['login']);
                header("Location: edit.php");
                exit;
            }
        }
    ?>

    <form method="post">
        <span>User Name</span><br>
        <input type="text" name="name" id="name" value="<?php echo $u->user;?>">
        <br><br><br>
        <span>Email</span><br>
        <input type="email" name="email" id="email" value="<?php echo $u->email;?>">
        <br><br><br>
        <input type="submit" value="Save">
    </form>
    <br><hr><br>
    <?php
        if (isset($_POST['cPassword']) && !empty($_POST['cPassword'])) {
            if (isset($_POST['nPassword']) && !empty($_POST['nPassword'])) {
                if($u->editPassword($_POST['cPassword'], $_POST['nPassword'], $u->email, $_SESSION['login'])) {
                    header("Location: logout.php");
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
        <span>Current Password</span><br>
        <input type="password" name="cPassword" id="cPassword">
        <br><br><br>
        <span>New Password</span><br>
        <input type="password" name="nPassword" id="nPassword">
        <br><br><br>
        <input type="submit" value="Save">
    </form>
    <br><br>
    <a href="/CRUDphp">[ Home ]</a>
    <a href="delete.php">[ Delete ]</a>
</body>
</html>