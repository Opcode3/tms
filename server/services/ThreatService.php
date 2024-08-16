<?php

namespace app\services;

use app\config\MysqlDBH;
use app\dto\ResponseDto;
use app\model\Service;
use app\model\Threat;
use app\services\impl\ThreatServiceImpl;
use app\utils\MediaFileHandler;

class ThreatService implements ThreatServiceImpl
{

    private $model;

    function __construct()
    {
        $connector = new MysqlDBH();
        $this->model = new Threat($connector);
    }

    function setThreat(array $payload, $file): string
    {
        $media = new MediaFileHandler();

        if ($media->singleFileUpload($file) == true) {
            $payload['_attachment'] = $media->getMediaUrl();
            $response = $this->model->insertThreat($payload);
            if (is_bool($response)) return ResponseDto::json("Threat post was created successfully!", 201);

            if (is_string($response) && $response == "exist")
                return ResponseDto::json("A report with this title already exist in our system!", 422);

            return ResponseDto::json("An error was encountered while trying to create service post!", 500);
        }
        return ResponseDto::json("An issue was encountered while trying to upload the media!", 422);
    }

    function getThreats(): string
    {
        $response = $this->model->fetchThreats();
        return ResponseDto::json($response);
    }

    function getReporterThreat(int $_id): string
    {
        $response = $this->model->fetchThreatsByReporter($_id);
        return ResponseDto::json($response);
    }

    function getThreatBySlug(string $_slug): string
    {
        $response = $this->model->fetchThreatBySlug($_slug);
        return ResponseDto::json($response);
    }

    function getMyThreatsCount(int $_id): int
    {
        $response = $this->model->fetchThreatsByReporter($_id);
        return count($response);
    }

    function getThreatsCount(): int
    {
        $response = $this->model->fetchThreats();
        return count($response);
    }

    // function editService(array $payload): string
    // {

    //     $response = $this->model->updateService($payload);
    //     if (is_bool($response)) {
    //         if ($response) {
    //             return ResponseDto::json("This service update was successful!", 200);
    //         }
    //         return ResponseDto::json("We are unable to update this service. Please try again!");
    //     }
    //     return "This service was not found in our system!";
    // }


    // function removeService(string $images, int $id): string
    // {
    //     $response = $this->model->deleteService($id);
    //     if ($response) {
    //         $media = new MediaFileHandler();
    //         if ($media->deleteFiles($images)) {
    //             return ResponseDto::json("Service post was deleted successfully", 200);
    //         }
    //         return ResponseDto::json("Service post has been deleted; but we are unable to delete it's resources entirely!");
    //     }
    //     return ResponseDto::json("We are unable to delete this service post at the moment. Please try again!");
    // }
}
