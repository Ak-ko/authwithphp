<?php
require "jwt.php";

class Auth
{
    public function login()
    {
        $email = $_POST["email"] ?? null;
        $password = $_POST["password"] ?? null;
        if (!$email) {
            http_response_code(400);
            echo json_encode([
                "error" => [
                    "message" => "Email is required"
                ]
            ]);
            exit();
        }
        if (!$password) {
            http_response_code(400);
            echo json_encode([
                "error" => [
                    "message" => "Password is required"
                ]
            ]);
            exit();
        }
        $user = null;
        if ($email !== "ak@demo.com") {
            http_response_code(400);
            echo json_encode([
                "error" => [
                    "message" => "User not found"
                ]
            ]);
            exit();
        }
        $user = ["email" => "ak@demo.com", "password" => "password"];
        if (!$password == $user["password"]) {
            http_response_code(400);
            echo json_encode([
                "error" => [
                    "message" => "Password not match"
                ]
            ]);
            exit();
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
        http_response_code(200);
        echo json_encode([
            "message" => "Login Successfully"
        ]);
        exit();
    }

    public function register()
    {
        $email = $_POST["email"] ?? null;
        $password = $_POST["password"] ?? null;
        if (!$email) {
            http_response_code(400);
            echo json_encode([
                "error" => [
                    "message" => "Email is required"
                ]
            ]);
            exit();
        }
        if (!$password) {
            http_response_code(400);
            echo json_encode([
                "error" => [
                    "message" => "Password is required"
                ]
            ]);
            exit();
        }
        $user = null;
        if ($email === "existed@demo.com") {
            http_response_code(400);
            echo json_encode([
                "error" => [
                    "message" => "Email already existed"
                ]
            ]);
            exit();
        }
        $stored = $this->store(["email" => $email, "password" => $password]);
        if (!$stored) {
            http_response_code(500);
            echo json_encode([
                "error" => [
                    "message" => "Something Went Wrong!"
                ]
            ]);
            exit();
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
        http_response_code(200);
        echo json_encode([
            "message" => "Login Successfully"
        ]);
        exit();
    }

    public function logout()
    {
        if (is_null($_COOKIE["jwt"])) {
            http_response_code(400);
            echo json_encode([
                "message" => "Unauthorized"
            ]);
            exit();
        }

        setcookie(
            name: "jwt",
            value: "",
            expires_or_options: time() - 1
        );
        http_response_code(200);
        echo json_encode([
            "message" => "success"
        ]);
        exit();
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
}
