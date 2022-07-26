<?php

namespace Controller;

use Exception;
use Model\BooksModel;
use Util\Json;

class PutController
{
    private object $BooksModel;
    private array $request = [];

    private const TYPE_PUT = ['books'];
    private const RESOURCES = ['update'];

    public function __construct()
    {
        $this->BooksModel = new BooksModel();
    }

    public function put($request)
    {
        $this->request = $request;

        if (in_array($this->request['router'], self::TYPE_PUT, true))
            return $this->validate();
        else
            throw new Exception('Rota não permitida');
    }

    private function validate()
    {
        $resource = $this->request['resource'];

        if (in_array($resource, self::RESOURCES, true) && ($this->request['ID'] != null && $this->request['ID'] > 0)) {
            $this->requestData = Json::jsonBodyRequisition();
            return $this->$resource();
        } else
            throw new Exception('Rota não permitida');
    }

    private function update()
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
                $this->BooksModel->updateBook(
                    $this->request['ID'],
                    $this->requestData['name'],
                    $this->requestData['authors'],
                    $this->requestData['pages']
                ) > 0
            ) {
                $this->BooksModel->getMySQL()->getDB()->commit();

                return ['Resposta' => 'Registro atualizado com sucesso'];
            }

            $this->BooksModel->getMySQL()->getDB()->rollBack();

            throw new Exception('Nenhum registro afetado');
        }

        throw new Exception('Houve algum erro na requisição');
    }
}
