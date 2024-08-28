<?php

namespace app\services\impl;

interface MediaServiceImpl
{
    function setMedia(array $data): string;
    function getTaskAttachments(int $id): string;
    function getMediasByResourceId(int $resource_id): string;
    function removeMedia(string $slug): string;
}
