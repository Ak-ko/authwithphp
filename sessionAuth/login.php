<?php
session_start();

if ($_SERVER['REQUEST_METHOD'] === "POST") {
    $email = $_POST["email"];
    $password = $_POST["password"];

    // validate [ empty or not, email => email format | unique, password => min:8 ]

    // retrieve the user from db.

    // check user exists by email. If not exited, return error.

    // password check against user password and password from db. If not matched, return error.

    // redirect to home ( store current user => session )
    $_SESSION['user'] = ['email' => $email];
    header("Location: /");
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title> Register</title>
</head>

<style>
    form>div+div {
        margin-top: 10px;
    }
</style>

<body>
    <form action="login.php" method="POST">
        <div>
            <input name="email" type="email" require placeholder="Email">
        </div>
        <div>
            <input name="password" type="password" require placeholder="Password">
        </div>
        <div>
            <button type="submit">Login</button>
        </div>
    </form>
</body>

</html>