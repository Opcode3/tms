<?php

namespace app\model;

use app\config\DatabaseHandler;


class Task extends BaseModel
{
    private $table_name = 'tasks_tb';

    /***
     * Status Definitions
     * 0 = Unstarted
     * 1 = In-Progress
     * 2 = Completed
     * 3 = Finished
     */

    function __construct(DatabaseHandler $databaseHandler)
    {
        parent::__construct($databaseHandler);
    }

    // Create Task

    function createTask(array $payload)
    {
        if ($this->isTask($payload["_title"], $payload["_project_id"]) === true) {
            $sql = "INSERT INTO $this->table_name(task_slug, task_project_id, task_title, task_desc, assigned_to, created_by, deadline) 
                    VALUES(:_slug, :_project_id, :_title, :_desc, :_assigned_to, :_created_by, :_deadline)";
            return $this->insertOutputId($sql, $payload, "_slug");
        }
        return "exist";
    }

    // Update Task
    function updateTask(array $payload)
    {
        if ($this->isSlug($payload["_slug"]) == false) {
            $sql = "UPDATE $this->table_name SET task_title = :_title, task_desc = :_desc, assigned_to = :_assigned_to, deadline = :_deadline, updated_at = :updatedAt WHERE task_slug = :_slug";
            return $this->update($sql, $payload);
        }
        return "not exist";
    }


    // Update Task Status
    function updateTaskStatus(string $slug, int $status)
    {
        $sql = "UPDATE $this->table_name SET task_status = :_status, updated_at = :updatedAt WHERE  task_slug = :slug";
        return $this->update($sql, ["_status" => $status, "slug" => $slug]);
    }

    // Delete Task
    function deleteTask(string $slug)
    {
        $sql = "DELETE FROM $this->table_name WHERE task_slug = ? ";
        $response = $this->delete($sql, [$slug]);
        return $response;
    }

    // Fetch Task By Project
    function fetchTaskByProject(int $_project_id)
    {
        $sql = "SELECT $this->table_name.*, users_tb.user_fullname, users_tb.user_picture FROM $this->table_name LEFT JOIN users_tb ON $this->table_name.assigned_to = users_tb.user_id WHERE task_project_id = ?";
        $response = $this->fetchMany($sql, [$_project_id]);
        return $response;
    }

    function fetchTaskBySlug(string $slug)
    {
        $sql = "SELECT $this->table_name.*, projects_tb.project_status, users_tb.user_fullname, users_tb.user_username, users_tb.user_picture FROM $this->table_name LEFT JOIN users_tb ON $this->table_name.assigned_to = users_tb.user_id LEFT JOIN projects_tb ON $this->table_name.task_project_id = projects_tb.project_id WHERE task_slug = ?";
        $response = $this->fetch($sql, [$slug]);
        return $response;
    }


    function fetchTaskByCreator(int $_id)
    {
        $sql = "SELECT $this->table_name.* FROM $this->table_name LEFT JOIN users_tb ON $this->table_name.created_by = users_tb.user_id WHERE created_by = ?";
        $response = $this->fetchMany($sql, [$_id]);
        return $response;
    }



    function fetchMyAssignedTask(int $_id)
    {
        $sql = "SELECT $this->table_name.*, users_tb.user_fullname, users_tb.user_username, users_tb.user_picture FROM $this->table_name LEFT JOIN users_tb ON $this->table_name.assigned_to = users_tb.user_id WHERE assigned_to = ?";
        $response = $this->fetchMany($sql, [$_id]);
        return $response;
    }

    function fetchMyAssignedTaskByProjectId(int $project_id, int $user_id)
    {
        $sql = "SELECT $this->table_name.*, users_tb.user_fullname, users_tb.user_username, users_tb.user_picture FROM $this->table_name LEFT JOIN users_tb ON $this->table_name.assigned_to = users_tb.user_id WHERE assigned_to = ? AND task_project_id = ?";
        $response = $this->fetchMany($sql, [$user_id, $project_id]);
        return $response;
    }



    function isTask(string $title, string $project_id): bool
    {
        $sql = "SELECT task_slug from $this->table_name WHERE task_title = ? AND task_project_id = ?";
        $stmt = $this->query($sql, [$title, $project_id]);
        return $stmt->rowCount() == 0;
    }

    function isSlug(string $slug): bool
    {
        $sql = "SELECT task_id from $this->table_name WHERE task_slug = ?";
        $stmt = $this->query($sql, [$slug]);
        return $stmt->rowCount() == 0;
    }
}
