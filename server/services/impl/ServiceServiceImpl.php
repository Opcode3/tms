<?php

namespace app\services\impl;

interface ServiceServiceImpl
{
    function setService(array $data, $file): string;
    function getServices(): string;
    function getServicesCount(): int;
    function getService(string $slug): string;
    function editService(array $data): string;
    function removeService(string $images, int $id): string;
}
