<?php
session_start();
if (!$_SESSION['user']) {
    header("Location: /");
    exit();
}

unset($_SESSION['user']);
header("Location: /");
