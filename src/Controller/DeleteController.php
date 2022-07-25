<?php

namespace Controller;

use Model\BooksModel;

class DeleteController
{
    private object $BooksModel;
    private array $request = [];

    private const TYPE_DELETE = ['books'];
    private const RESOURCES = ['deleting'];

    public function __construct()
    {
        $this->BooksModel = new BooksModel();
    }

    public function delete($request)
    {
        $this->request = $request;

        if (in_array($this->request['router'], self::TYPE_DELETE, true))
            return $this->validate();
        else
            return ['Resposta' => 'Rota não permitida'];
    }

    private function validate()
    {
        $resource = $this->request['resource'];

        if (in_array($resource, self::RESOURCES, true) && ($this->request['ID'] != null && $this->request['ID'] > 0))
            return $this->$resource();
        else
            return ['Resposta' => 'Rota não permitida'];
    }

    private function deleting()
    {
        if ($this->BooksModel->delete($this->request['ID']) > 0) {
            $this->BooksModel->getMySQL()->getDB()->commit();

            return ['Resposta' => 'Registro deletado com sucesso'];
        }

        $this->BooksModel->getMySQL()->getDB()->rollBack();

        return ['Resposta' => 'Houve algum erro na requisição'];
    }
}
