<?php
require "cors.php";
require "response.php";
require "auth.php";

$auth = new Auth;

$method = $_SERVER['REQUEST_METHOD'];
$uri = parse_url($_SERVER["REQUEST_URI"], PHP_URL_PATH);

switch ($uri) {
    case "/login":
        if ($method === "POST") {
            $auth->login();
        } else {
            Response::methodNotAllowed();
        }
        break;
}
