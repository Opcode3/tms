<?php

namespace app\model;

use app\config\DatabaseHandler;


class ProjectUser extends BaseModel
{
    private $table_name = 'project_user_tb';

    // status = 4 means member has been delisted
    function __construct(DatabaseHandler $databaseHandler)
    {
        parent::__construct($databaseHandler);
    }

    function insertProjectUser(array $payload)
    {
        if ($this->isProjectUser($payload["_project_id"], $payload["_member"]) === true) {
            $sql = "INSERT INTO $this->table_name(pu_slug, pu_project_id, pu_member) 
                    VALUES(:_slug, :_project_id, :_member)";
            return $this->insert($sql, $payload, "_slug");
        }
        return "exist";
    }


    function fetchProjectMembers(int $_id)
    {
        $sql = "SELECT $this->table_name.*, users_tb.user_username, users_tb.user_fullname, users_tb.user_email, users_tb.user_picture FROM $this->table_name LEFT JOIN users_tb ON $this->table_name.pu_member = users_tb.user_id  WHERE pu_project_id = ?";
        $response = $this->fetchMany($sql, [$_id]);
        return $response;
    }


    function updateMemberStatus(int $id, int $status = 4)
    {
        $sql = "UPDATE $this->table_name SET pu_status = :_status, updated_at = :updatedAt WHERE  pu_member = :_member";
        return $this->update($sql, ["_member" => $id, "_status" => $status]);
    }


    function isProjectUser(string $project, string $member): bool
    {
        $sql = "SELECT pu_slug from $this->table_name WHERE pu_project_id = ? AND pu_member = ?";
        $stmt = $this->query($sql, [$project, $member]);
        return $stmt->rowCount() == 0;
    }
}
