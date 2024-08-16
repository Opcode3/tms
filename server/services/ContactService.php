<?php

namespace app\services;


use app\config\MysqlDBH;
use app\dto\ResponseDto;
use app\model\Contact;
use app\services\impl\ContactServiceImpl;

class ContactService implements ContactServiceImpl
{

    private $model;

    function __construct()
    {
        $mysqlConnector = new MysqlDBH();
        $this->model = new Contact($mysqlConnector);
    }

    function getContacts(): string
    {
        return ResponseDto::json("Fetched all contact", 200, $this->model->fetchContacts());
    }

    function editContact(array $data): string
    {
        $response = $this->model->updateContact($data);
        if ($response) {
            return ResponseDto::json("Contact updated was successful!", 200);
        }
        return ResponseDto::json("We are unable to update your contact. Please try again!");
    }
}
