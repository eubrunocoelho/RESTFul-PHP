<?php

namespace lib;

class Routes
{
    public array $request = [];

    public function __construct()
    {
        $URLs = $this->getURLs();
        $this->request = $this->requestRoute($URLs);
    }

    private function getURLs()
    {
        $URI = $_SERVER['PATH_INFO'] ?? null;

        if ($URI != null)
            return explode('/', trim($URI, '/'));
    }

    private function requestRoute($URLs)
    {
        $request['router'] = $URLs[0];
        $request['resource'] = $URLs[1] ?? null;
        $request['ID'] = $URLs[2] ?? null;
        $request['method'] = $_SERVER['REQUEST_METHOD'];

        return $request;
    }
}
