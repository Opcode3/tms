<?php

namespace app\model;

use app\config\DatabaseHandler;


class SubTask extends BaseModel
{
    private $table_name = 'subtask_tb';

    function __construct(DatabaseHandler $databaseHandler)
    {
        parent::__construct($databaseHandler);
    }

    // Create SubTask
    function createSubTask(array $payload)
    {
        if ($this->isSubTask($payload["_desc"], $payload["_parent_id"]) === true) {
            $sql = "INSERT INTO $this->table_name(subtask_slug, subtask_desc, subtask_parent_id) VALUES(:_slug, :_desc, :_parent_id)";
            return $this->insert($sql, $payload, "_slug");
        }
        return "exist";
    }


    // Update Task Status
    function updateSubTaskStatus(string $slug, int $status)
    {
        $sql = "UPDATE $this->table_name SET subtask_status = :_status, updated_at = :updatedAt WHERE  subtask_slug = :_slug";
        return $this->update($sql, ["_status" => $status, "_slug" => $slug]);
    }


    // Delete Task
    function deleteSubTask(string $slug)
    {
        $sql = "DELETE FROM $this->table_name WHERE subtask_slug = ? ";
        return $this->delete($sql, [$slug]);
    }


    // Fetch Sub Task By Project
    function fetchSubTaskByParentTaskId(int $_project_id)
    {
        $sql = "SELECT * FROM $this->table_name WHERE subtask_parent_id = ?";
        return $this->fetchMany($sql, [$_project_id]);
    }


    function isSubTask(string $desc, string $parent_id): bool
    {
        $sql = "SELECT subtask_slug from $this->table_name WHERE subtask_desc = ? AND subtask_parent_id = ?";
        $stmt = $this->query($sql, [$desc, $parent_id]);
        return $stmt->rowCount() == 0;
    }

    function isSlug(string $slug): bool
    {
        $sql = "SELECT subtask_id from $this->table_name WHERE subtask_slug = ?";
        $stmt = $this->query($sql, [$slug]);
        return $stmt->rowCount() == 0;
    }
}
