<?php
header("Content-Type: application/json");
class Response
{
    public static function methodNotAllowed()
    {
        header("Method not allowed", true, 405);
        exit();
    }
}
