<?php
session_start();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login | Register</title>
</head>

<style>
    form>div+div {
        margin-top: 10px;
    }
</style>

<body>
    <a href="login.php">Login</a>
    <a href="register.php">Register</a>
    <a href="logout.php">Logout</a>

    <div>Current User => <?php var_dump($_SESSION['user']); ?></div>
</body>

</html>