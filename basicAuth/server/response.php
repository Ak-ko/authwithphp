<?php
header("Content-Type: application/json");
class Response
{
    public static function methodNotAllowed()
    {
        header("Method not allowed", true, 405);
        exit();
    }

    public static function badRequest($payload)
    {
        http_response_code(400);
        echo json_encode($payload);
        exit();
    }

    public static function unAuthorized($payload)
    {
        http_response_code(401);
        echo json_encode($payload);
        exit();
    }

    public static function internalServerError($payload)
    {
        http_response_code(500);
        echo json_encode($payload);
        exit();
    }


    public static function success($payload)
    {
        http_response_code(200);
        echo json_encode($payload);
        exit();
    }
}
