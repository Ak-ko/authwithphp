<?php
require "cors.php";
require "response.php";
require "auth.php";

$auth = new Auth;

$method = $_SERVER['REQUEST_METHOD'];
$uri = parse_url($_SERVER["REQUEST_URI"], PHP_URL_PATH);

switch ($uri) {
    case "/":
        if ($method == "GET") {
            $jwttoken = $_COOKIE["jwt"];
            $jwt = new JWT();
            $verify = $jwt->verifyToken($jwttoken);
            if (!$verify) {
                exit();
            }
            $user = $jwt->decodeToken($jwttoken);
            echo json_encode([
                "user" => $user ?? null
            ]);
            exit();
        } else {
            Response::methodNotAllowed();
        }
        break;
    case "/login":
        if ($method === "POST") {
            $auth->login();
        } else {
            Response::methodNotAllowed();
        }
        break;
    case "/register":
        if ($method === "POST") {
            $auth->register();
        } else {
            Response::methodNotAllowed();
        }
        break;
    case "/logout":
        if ($method === "POST") {
            $auth->logout();
        } else {
            Response::methodNotAllowed();
        }
        break;
}
