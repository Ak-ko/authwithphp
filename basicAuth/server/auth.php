<?php

class Auth
{
    public function login()
    {
        $authUser = $_SERVER["PHP_AUTH_USER"] ?? null;
        $authPassword = $_SERVER["PHP_AUTH_PW"] ?? null;

        if (!$authUser || !$authPassword) {
            header("WWW-Authenticate: Basic realm='Access to index page'");
            Response::unAuthorized([
                "error" => [
                    "message" => "Unauthorized"
                ]
            ]);
        }

        $allowUser = "ak@demo.com";
        $allowPassword = "password";

        if ($allowUser !== $authUser || $allowPassword !== $authPassword) {
            Response::badRequest([
                "error" => [
                    "message" => "Invalid Credentials"
                ]
            ]);
        }

        Response::success([
            "message" => "Login Success"
        ]);
    }
}
