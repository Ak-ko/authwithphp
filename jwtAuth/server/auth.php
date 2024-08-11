<?php
require "jwt.php";

class Auth
{
    public function login()
    {
        $email = $_POST["email"] ?? null;
        $password = $_POST["password"] ?? null;
        if (!$email) {
            Response::badRequest([
                "error" => [
                    "message" => "Email is required"
                ]
            ]);
        }
        if (!$password) {
            Response::badRequest([
                "error" => [
                    "message" => "Password is required"
                ]
            ]);
        }
        $user = null;
        if ($email !== "ak@demo.com") {
            Response::badRequest([
                "error" => [
                    "message" => "User not found"
                ]
            ]);
        }
        $user = ["email" => "ak@demo.com", "password" => "password"];
        if (!$password == $user["password"]) {
            Response::badRequest([
                "error" => [
                    "message" => "Password not match"
                ]
            ]);
        }

        $jwt = new JWT([
            "email" => $email
        ]);
        setcookie(
            name: "jwt",
            value: $jwt->generateToken(),
            expires_or_options: $jwt->getExpirationTime(),
            httponly: true,
            path: '/',
            domain: "localhost"
        );
        Response::success([
            "message" => "Login Successfully"
        ]);
    }

    public function register()
    {
        $email = $_POST["email"] ?? null;
        $password = $_POST["password"] ?? null;
        if (!$email) {
            Response::badRequest([
                "error" => [
                    "message" => "Email is required"
                ]
            ]);
        }
        if (!$password) {
            Response::badRequest([
                "error" => [
                    "message" => "Password is required"
                ]
            ]);
        }
        $user = null;
        if ($email === "existed@demo.com") {
            Response::badRequest([
                "error" => [
                    "message" => "Email already existed"
                ]
            ]);
        }
        $stored = $this->store(["email" => $email, "password" => $password]);
        if (!$stored) {
            Response::internalServerError([
                "error" => [
                    "message" => "Something Went Wrong!"
                ]
            ]);
        }
        $jwt = new JWT([
            "email" => $user["email"]
        ]);
        setcookie(
            name: "jwt",
            value: $jwt->generateToken(),
            expires_or_options: $jwt->getExpirationTime(),
            httponly: true,
            path: '/',
            domain: "localhost"
        );
        Response::success([
            "message" => "Login Successfully"
        ]);
    }

    public function logout()
    {
        if (is_null($_COOKIE["jwt"])) {
            Response::badRequest([
                "message" => "Unauthorized"
            ]);
        }

        setcookie(
            name: "jwt",
            value: "",
            expires_or_options: time() - 1
        );
        Response::success([
            "message" => "success"
        ]);
    }

    protected function store($userData)
    {
        $storage = [];
        if (isset($userData)) {
            $storage["user"] = $userData;
            return true;
        }
        return false;
    }

    public function getUser()
    {
        $jwttoken = $_COOKIE["jwt"] ?? null;
        if (is_null($jwttoken)) {
            Response::badRequest([
                "error" => [
                    "message" => "No Token"
                ]
            ]);
        }
        $jwt = new JWT();
        $verify = $jwt->verifyToken($jwttoken);
        if (!$verify) {
            Response::badRequest([
                "error" => [
                    "message" => "Token expired"
                ]
            ]);
        }
        $user = $jwt->decodeToken($jwttoken);
        Response::success(["user" => $user]);
    }
}
