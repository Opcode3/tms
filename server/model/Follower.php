<?php

namespace app\model;

use app\config\DatabaseHandler;
use app\utils\PasswordEncoder;


class Follower extends BaseModel
{
    private $table_name = 'followers_tb';

    function __construct(DatabaseHandler $databaseHandler)
    {
        parent::__construct($databaseHandler);
    }


    function createFollower($payload)
    {
        if ($this->isFollowing($payload["_user_id"], $payload["_threat_id"]) === true) {

            $sql = "INSERT INTO $this->table_name(comment_slug, user_id, threat_id, comment_desc) 
                    VALUES(:comment_slug, :_user_id, :_threat_id, :_description)";
            $response = $this->insert($sql, $payload, "comment_slug");
            return $response;
        }
        return "exist";
    }

    function fetchFollowersByThreat(int $threat_id)
    {
        $sql = "SELECT * FROM $this->table_name WHERE threat_id = ? ";
        $response = $this->fetchMany($sql, [$threat_id]);
        return $response;
    }

    function fetchThreatFollowing(int $user_id)
    {
        $sql = "SELECT * FROM $this->table_name WHERE user_id = ? ";
        $response = $this->fetchMany($sql, [$user_id]);
        return $response;
    }

    function unFollowThreat(int $follower_id)
    {
        $sql = "DELETE FROM $this->table_name WHERE follower_id = ? ";
        $response = $this->delete($sql, [$follower_id]);
        return $response;
    }

    function isFollowing(int $user_id, int $threat_id): bool
    {
        $sql = "SELECT follower_slug from $this->table_name WHERE threat_id = ? AND user_id = ?";
        $stmt = $this->query($sql, [$threat_id, $user_id,]);
        return $stmt->rowCount() == 0;
    }
}
