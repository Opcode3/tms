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


    // function updateThreat(array $payload)
    // {
    //     if (count($payload) == 11) {
    //         if ($this->isSlug($$payload["_slug"]) === true) {
    //             $sql = "UPDATE $this->table_name SET threat_title = :_title, threat_desc = :_desc, threat_category = :_category, date_discovered = :_discovered, affected_devices = :_affected_devices, severity_level = :_severity_level, iocs = :_iocs, mitigation_steps = :_mitigation_steps, threat_references = :_references, updated_at = :updatedAt WHERE threat_slug = :_slug";

    //             return $this->update($sql, $payload);
    //         }
    //         return "not exist";
    //     }
    //     return false;
    // }

    function fetchProjects()
    {
        $sql = "SELECT $this->table_name.*, users_tb.user_fullname, users_tb.user_email, users_tb.user_picture FROM $this->table_name LEFT JOIN users_tb ON $this->table_name.reporter_id = users_tb.user_id ORDER By created_at DESC";
        $response = $this->fetchMany($sql);
        return $response;
    }

    function fetchProjectByCreator(int $_id)
    {
        $sql = "SELECT $this->table_name.*, users_tb.user_fullname, users_tb.user_email, users_tb.user_picture FROM $this->table_name LEFT JOIN users_tb ON $this->table_name.reporter_id = users_tb.user_id WHERE reporter_id = ?";
        $response = $this->fetchMany($sql, [$_id]);
        return $response;
    }

    function fetchThreatBySlug(string $slug)
    {
        $sql = "SELECT $this->table_name.*, users_tb.user_fullname, users_tb.user_email, users_tb.user_picture FROM $this->table_name LEFT JOIN users_tb ON $this->table_name.reporter_id = users_tb.user_id WHERE threat_slug = ? ";
        $response = $this->fetch($sql, [$slug]);
        return $response;
    }

    function removeThreat(int $threat_id)
    {
        $sql = "DELETE FROM $this->table_name WHERE threat_id = ? ";
        $response = $this->delete($sql, [$threat_id]);
        return $response;
    }



    function updateLike(int $new_like, int $threat_id)
    {
        $sql = "UPDATE $this->table_name SET likes = :likes, updated_at = :updatedAt WHERE  threat_id = :threat_id";
        return $this->update($sql, ["likes" => $new_like, "threat_id" => $threat_id]);
    }


    function isProjectUser(string $project, string $member): bool
    {
        $sql = "SELECT pu_slug from $this->table_name WHERE pu_project_id = ? AND pu_member = ?";
        $stmt = $this->query($sql, [$project, $member]);
        return $stmt->rowCount() == 0;
    }

    function isSlug(string $slug): bool
    {
        $sql = "SELECT threat_id from $this->table_name WHERE threat_slug = ?";
        $stmt = $this->query($sql, [$slug]);
        return $stmt->rowCount() == 0;
    }
}
