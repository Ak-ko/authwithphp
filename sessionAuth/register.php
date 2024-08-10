<?php
session_start();

if ($_SERVER['REQUEST_METHOD'] === "POST") {
    $email = $_POST["email"];
    $password = $_POST["password"];

    // validate [ empty or not, email => email format | unique, password => min:8 ]
    // password => hash ( bcrypt ), eg: "password" => $2a$12$N2AIrjPzi8PgKjB1br7TleLNldZF1yp4GLJ4v5oZANSMdwoKUHPs.

    // store => db , user table => email,hash

    // redirect to login / redirect to home ( store current user => session )
    $_SESSION['user'] = ['email' => $email];
    header("Location: login.php");
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
    <form action="register.php" method="POST">
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