<?php

namespace app\services;

use app\config\MysqlDBH;
use app\dto\ResponseDto;
use app\model\Media;
use app\services\impl\MediaServiceImpl;

class MediaService implements MediaServiceImpl
{

    private $model;

    function __construct()
    {
        $connector = new MysqlDBH();
        $this->model = new Media($connector);
    }

    function setMedia(array $data): string
    {
        $response = $this->model->createMedia($data);
        return $response;
        // TODO: Remove later
        // return ResponseDto::json("New user account registration was successful!", 201);
        // return ResponseDto::json("An error was encountered while trying to register user details!", 500);
    }

    function getMedias(): string
    {
        $response = $this->model->fetchMedias();
        return ResponseDto::json($response);
    }

    function getMediasByResourceId(int $resource_id): string
    {
        return "";
    }

    function removeMedia(string $slug): string
    {
        return "";
    }
}
