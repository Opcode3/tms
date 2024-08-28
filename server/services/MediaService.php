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
    }

    function getTaskAttachments(int $id): string
    {
        $response = $this->model->fetchMediaByTaskId($id);
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
