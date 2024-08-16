<?php

namespace app\services\impl;

interface ContactServiceImpl
{
    function getContacts(): string;
    function editContact(array $data): string;
}
