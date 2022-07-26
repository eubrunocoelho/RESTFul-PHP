<?php

namespace lib;

use Exception;
use lib\Routes;

class Request
{
    private object $Routes;
    private object $Controller;
    private array $request = [];
    public array $response = [];

    private const TYPE_REQUEST = ['GET', 'POST', 'DELETE', 'PUT'];

    public function __construct()
    {
        $this->Routes = new Routes();
        $this->request = $this->Routes->request;
        $this->response = $this->processRequest();
    }

    private function processRequest()
    {
        if (in_array($this->request['method'], self::TYPE_REQUEST, true))
            return $this->directRequest();
            
        throw new Exception('Houve algum erro na requisição');
    }

    private function directRequest()
    {
        $method = ucfirst(strtolower($this->request['method']));
        $controller = 'Controller\\' . $method . 'Controller';
        
        if (class_exists($controller)) {
            $this->Controller = new $controller;

            if (method_exists($controller, strtolower($method)))

                return $this->Controller->$method($this->request);
        }
        
        throw new Exception('Houve algum erro na requisição');
    }
}
