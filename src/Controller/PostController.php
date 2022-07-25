<?php

namespace Controller;

use Model\BooksModel;
use Util\Json;

class PostController
{
    private object $BooksModel;
    private array $request = [];
    private array $requestData = [];

    private const TYPE_POST = ['books'];
    private const RESOURCES = ['register'];

    public function __construct()
    {
        $this->BooksModel = new BooksModel();
    }

    public function post($request)
    {
        $this->request = $request;

        if (in_array($this->request['router'], self::TYPE_POST, true))
            return $this->validate();
        else
            return ['Resposta' => 'Rota não permitida'];
    }

    private function validate()
    {
        $resource = $this->request['resource'];

        if (in_array($resource, self::RESOURCES, true)) {
            $this->requestData = Json::jsonBodyRequisition();
            return $this->$resource();
        } else
            return ['Resposta' => 'Rota não permitida'];
    }

    private function register()
    {
        if (is_array($this->requestData))
            if (isset($this->requestData['pages']))
                $this->requestData['pages'] = intval($this->requestData['pages']);

        if (
            isset($this->requestData['name']) &&
            isset($this->requestData['authors']) &&
            is_int($this->requestData['pages'])
        ) {
            if (
                $this->BooksModel->insertBook(
                    $this->requestData['name'],
                    $this->requestData['authors'],
                    $this->requestData['pages']
                ) > 0
            ) {
                $lastInsertID = $this->BooksModel->getMySQL()->getDB()->lastInsertId();
                $this->BooksModel->getMySQL()->getDB()->commit();

                return ['Resposta' => 'ID #' . $lastInsertID . ' registrado'];
            }

            $this->BooksModel->getMySQL()->getDB()->rollBack();

            return ['Respota' => 'Houve algum erro na requisição'];
        }
        
        return ['Respota' => 'Houve algum erro na requisição'];
    }
}
