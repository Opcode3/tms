<?php

namespace app\controller;

use app\services\ContactService;

class ContactController
{

    private $contactService;

    function __construct()
    {
        $this->contactService = new ContactService();
    }

    function updateContact(array $payload)
    {
        return $this->contactService->editContact($payload);
    }

    function getAllContacts()
    {
        return $this->contactService->getContacts();
    }
}
