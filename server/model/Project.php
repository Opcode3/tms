<?php

namespace app\model;

use app\config\DatabaseHandler;


class Project extends BaseModel
{
    private $table_name = 'projects_tb';

    function __construct(DatabaseHandler $databaseHandler)
    {
        parent::__construct($databaseHandler);
    }

    function insertProject(array $payload)
    {

        if ($this->isProject($payload["_name"], $payload["_creator_id"]) === true) {
            $sql = "INSERT INTO $this->table_name(project_slug, project_name, creator_id, project_deadline, project_color) 
                    VALUES(:_slug, :_name, :_creator_id, :_deadline, :_color)";
            return $this->insertOutputId($sql, $payload, "_slug");
        }
        return "exist";
    }

    function updateProject(array $payload)
    {
        if ($this->isSlug($payload["_slug"]) == false) {
            $sql = "UPDATE $this->table_name SET project_name = :_name, project_deadline = :_deadline, project_color = :_color, updated_at = :updatedAt WHERE project_slug = :_slug";
            return $this->update($sql, $payload);
        }
        return "not exist";
    }

    function fetchProjects()
    {
        $sql = "SELECT $this->table_name.*, users_tb.user_fullname, users_tb.user_email, users_tb.user_picture FROM $this->table_name LEFT JOIN users_tb ON $this->table_name.reporter_id = users_tb.user_id ORDER By created_at DESC";
        $response = $this->fetchMany($sql);
        return $response;
    }

    function fetchProjectByCreator(int $_id)
    {
        $sql = "SELECT $this->table_name.* FROM $this->table_name LEFT JOIN users_tb ON $this->table_name.creator_id = users_tb.user_id WHERE creator_id = ?";
        $response = $this->fetchMany($sql, [$_id]);
        return $response;
    }

    function fetchProjectById(int $_id)
    {
        $sql = "SELECT $this->table_name.* FROM $this->table_name LEFT JOIN users_tb ON $this->table_name.creator_id = users_tb.user_id WHERE project_id = ?";
        $response = $this->fetch($sql, [$_id]);
        return $response;
    }

    function fetchProjectByStatus(int $_id, int $status = 0)
    {
        $sql = "SELECT $this->table_name.* FROM $this->table_name LEFT JOIN users_tb ON $this->table_name.creator_id = users_tb.user_id WHERE creator_id = ? AND project_status = ?";
        $response = $this->fetchMany($sql, [$_id, $status]);
        return $response;
    }

    function fetchProjectBySlug(string $slug)
    {
        $sql = "SELECT $this->table_name.*, users_tb.user_picture, users_tb.user_fullname, users_tb.user_username FROM $this->table_name LEFT JOIN users_tb ON $this->table_name.creator_id = users_tb.user_id WHERE project_slug = ? ";
        $response = $this->fetch($sql, [$slug]);
        return $response;
    }

    function deleteProject(string $slug)
    {
        $sql = "DELETE FROM $this->table_name WHERE project_slug = ? ";
        $response = $this->delete($sql, [$slug]);
        return $response;
    }



    function updateLike(int $new_like, int $threat_id)
    {
        $sql = "UPDATE $this->table_name SET likes = :likes, updated_at = :updatedAt WHERE  threat_id = :threat_id";
        return $this->update($sql, ["likes" => $new_like, "threat_id" => $threat_id]);
    }


    function isProject(string $name, string $creator): bool
    {
        $sql = "SELECT project_slug from $this->table_name WHERE project_name = ? AND creator_id = ?";
        $stmt = $this->query($sql, [$name, $creator]);
        return $stmt->rowCount() == 0;
    }

    function isSlug(string $slug): bool
    {
        $sql = "SELECT project_id from $this->table_name WHERE project_slug = ?";
        $stmt = $this->query($sql, [$slug]);
        return $stmt->rowCount() == 0;
    }
}
