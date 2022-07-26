<?php

namespace Controller;

use Exception;
use Model\BooksModel;

class GetController
{
    private object $BooksModel;
    private array $request = [];

    private const TYPE_GET = ['books'];
    private const RESOURCES = ['list'];

    public function __construct()
    {
        $this->BooksModel = new BooksModel();
    }

    public function get($request)
    {
        $this->request = $request;

        if (in_array($this->request['router'], self::TYPE_GET, true))
            return $this->validate();
        else
            throw new Exception('Rota não permitida');
    }

    private function validate()
    {
        $resource = $this->request['resource'];

        if (in_array($resource, self::RESOURCES, true))
            return ($this->request['ID'] != null && $this->request['ID'] > 0) ? $this->getOneByKey() : $this->$resource();
        else
            throw new Exception('Rota não permitida');
    }

    private function list()
    {
        $registers = $this->BooksModel->getAll();

        if (is_array($registers) && count($registers) > 0)
            return ['Resposta' => $registers];
        else
            throw new Exception('Nenhum registro encontrado');
    }

    private function getOneByKey()
    {
        $result = $this->BooksModel->getOneByKey($this->request['ID']);

        if (!empty($result))
            return ['Resposta' => $result];
        else
            throw new Exception('Nenhum registro correspondente a este ID');
    }
}
