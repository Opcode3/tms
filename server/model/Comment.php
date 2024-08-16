<?php

namespace app\model;

use app\config\DatabaseHandler;


class Comment extends BaseModel
{
    private $table_name = 'comments_tb';

    function __construct(DatabaseHandler $databaseHandler)
    {
        parent::__construct($databaseHandler);
    }


    function insertComment(array $payload)
    {
        if ($this->isCommentExist($payload["_user_id"], $payload["_threat_id"], $payload["_description"]) === true) {

            $sql = "INSERT INTO $this->table_name(comment_slug, user_id, threat_id, comment_desc, comment_attachment) 
                    VALUES(:comment_slug, :_user_id, :_threat_id, :_description, :_attachment)";
            $response = $this->insert($sql, $payload, "comment_slug");
            return $response;
        }
        return "exist";
    }

    function fetchCommentByThreat(int $threat_id)
    {
        $sql = "SELECT $this->table_name.*, users_tb.user_fullname, users_tb.user_email, users_tb.user_picture FROM $this->table_name LEFT JOIN users_tb ON $this->table_name.user_id = users_tb.user_id WHERE threat_id = ? ";
        $response = $this->fetchMany($sql, [$threat_id]);
        return $response;
    }

    function removeComment(int $comment_id)
    {
        $sql = "DELETE FROM $this->table_name WHERE comment_id = ? ";
        $response = $this->delete($sql, [$comment_id]);
        return $response;
    }


    function updateLike(int $new_like, int $comment_id)
    {
        $sql = "UPDATE $this->table_name SET likes = :likes, updated_at = :updatedAt WHERE  comment_id = :comment_id";
        return $this->update($sql, ["likes" => $new_like, "comment_id" => $comment_id]);
    }


    function isCommentExist(int $user_id, int $threat_id, string $desc): bool
    {
        $sql = "SELECT comment_slug from $this->table_name WHERE threat_id = ? AND user_id = ? AND comment_desc = ?";
        $stmt = $this->query($sql, [$threat_id, $user_id, $desc]);
        return $stmt->rowCount() == 0;
    }
}
