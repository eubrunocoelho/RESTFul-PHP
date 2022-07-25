<?php

namespace Util;

class Json
{
    public static function returnJson($arrData)
    {
        header('Content-Type: application/json');
        header('Cache-Control: no-cache, no-store, must-revalidate');
        header('Access-Control-Allow-Methods: GET, POST, PUT, DELETE');

        return json_encode($arrData);
    }

    public static function jsonBodyRequisition()
    {
        return json_decode(file_get_contents('php://input'), true);
    }
}
