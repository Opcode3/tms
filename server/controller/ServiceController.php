<?php

namespace app\controller;

use app\services\ServiceService;

class ServiceController
{

    private $serviceService;

    function __construct()
    {
        $this->serviceService = new ServiceService();
    }

    function addService(array $payload, $file)
    {
        return $this->serviceService->setService($payload, $file);
    }

    function getSingleService(string $slug)
    {
        return $this->serviceService->getService($slug);
    }

    function getAllServices()
    {
        return $this->serviceService->getServices();
    }

    function getCount()
    {
        return $this->serviceService->getServicesCount();
    }

    function deleteService(string $images, int $id)
    {
        return $this->serviceService->removeService($images, $id);
    }

    function modifyServiceInfo(array $payload)
    {
        return $this->serviceService->editService($payload);
    }
}
