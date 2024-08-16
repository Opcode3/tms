<?php

namespace app\services;

use app\config\MysqlDBH;
use app\dto\ResponseDto;
use app\model\Service;
use app\services\impl\ServiceServiceImpl;
use app\utils\MediaFileHandler;

class ServiceService implements ServiceServiceImpl
{

    private $model;

    function __construct()
    {
        $connector = new MysqlDBH();
        $this->model = new Service($connector);
    }

    function setService(array $payload, $file): string
    {
        $media = new MediaFileHandler();

        if ($media->singleFileUpload($file) == true) {
            $response = $this->model->createService($payload);
            if (is_int($response)) {
                $res = $media->sealUpload($response);
                return $res ? ResponseDto::json("Service post was created successfully!", 201) :
                    ResponseDto::json("An error was encountered while trying to create service post!", 500);
            } else if (is_bool($response)) {
                return ResponseDto::json("An error was encountered while trying to create service post!", 500);
            } else if ($response == "exist") {
                return ResponseDto::json("This service title already exist in our system!", 422);
            } else {
                return ResponseDto::json($response, 422);
            }
        }
        return ResponseDto::json("An issue was encountered while trying to upload the media!", 422);
    }

    function getService(string $slug): string
    {
        $response = $this->model->fetchServiceBySlug($slug);
        return ResponseDto::json($response);
    }

    function getServices(): string
    {
        $response = $this->model->fetchServices();
        return ResponseDto::json($response);
    }

    function getServicesCount(): int
    {
        $response = $this->model->fetchServices();
        return count($response);
    }

    function editService(array $payload): string
    {

        $response = $this->model->updateService($payload);
        if (is_bool($response)) {
            if ($response) {
                return ResponseDto::json("This service update was successful!", 200);
            }
            return ResponseDto::json("We are unable to update this service. Please try again!");
        }
        return "This service was not found in our system!";
    }


    function removeService(string $images, int $id): string
    {
        $response = $this->model->deleteService($id);
        if ($response) {
            $media = new MediaFileHandler();
            if ($media->deleteFiles($images)) {
                return ResponseDto::json("Service post was deleted successfully", 200);
            }
            return ResponseDto::json("Service post has been deleted; but we are unable to delete it's resources entirely!");
        }
        return ResponseDto::json("We are unable to delete this service post at the moment. Please try again!");
    }
}
