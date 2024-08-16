<?php

namespace app\controller;

use app\services\ServiceService;
use app\services\ThreatService;

class ThreatController
{

    private $threatService;

    function __construct()
    {
        $this->threatService = new ThreatService();
    }

    function addThreat(array $payload, $file)
    {
        return $this->threatService->setThreat($payload, $file);
    }

    function getMyThreatReports(int $_id)
    {
        return $this->threatService->getReporterThreat($_id);
    }

    function getThreatReportBySlug(string $_slug)
    {
        return $this->threatService->getThreatBySlug($_slug);
    }

    function getAllThreats()
    {
        return $this->threatService->getThreats();
    }

    function getCount()
    {
        return $this->threatService->getThreatsCount();
    }

    function getMyCount(int $_id)
    {
        return $this->threatService->getMyThreatsCount($_id);
    }

    // function deleteService(string $images, int $id)
    // {
    //     return $this->serviceService->removeService($images, $id);
    // }

    // function modifyServiceInfo(array $payload)
    // {
    //     return $this->serviceService->editService($payload);
    // }
}