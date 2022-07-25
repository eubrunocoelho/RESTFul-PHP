<?php

namespace lib;

use lib\Request;
use Util\Json;

class Application
{
    private object $Request;

    public function __construct()
    {
        $this->Request = new Request();
        $this->show($this->Request->response);
    }

    private function show($reponse)
    {
        echo Json::returnJson($reponse);
    }
}
