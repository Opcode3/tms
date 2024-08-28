<?php

namespace app\model;

use app\config\DatabaseHandler;

class Media extends BaseModel
{
    private $table_name = 'files_tb';

    function __construct(DatabaseHandler $databaseHandler)
    {
        parent::__construct($databaseHandler);
    }

    function createMedia(array $payload)
    {
        $sql = "INSERT INTO $this->table_name(file_slug, file_task_id, file_path) VALUES(:_slug, :_task_id, :_path)";
        return $this->insert($sql, $payload, "_slug");
    }


    function fetchMediaByTaskId(int $_id)
    {
        $sql = "SELECT * from $this->table_name WHERE file_task_id = ?";
        return $this->fetchMany($sql, [$_id]);
    }
}
