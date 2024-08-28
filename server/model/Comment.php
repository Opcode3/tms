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
        if ($this->isCommentExist($payload["_user_id"], $payload["_task_id"], $payload["_content"]) === true) {

            $sql = "INSERT INTO $this->table_name(comment_slug, comment_user_id, comment_task_id, comment_content) 
                    VALUES(:_slug, :_user_id, :_task_id, :_content)";
            $response = $this->insert($sql, $payload, "_slug");
            return $response;
        }
        return "exist";
    }

    function fetchCommentByTask(int $_id)
    {
        $sql = "SELECT $this->table_name.*, users_tb.user_fullname, users_tb.user_email, users_tb.user_picture FROM $this->table_name LEFT JOIN users_tb ON $this->table_name.comment_user_id = users_tb.user_id WHERE comment_task_id = ? ";
        $response = $this->fetchMany($sql, [$_id]);
        return $response;
    }

    function removeComment(int $comment_id)
    {
        $sql = "DELETE FROM $this->table_name WHERE comment_id = ? ";
        $response = $this->delete($sql, [$comment_id]);
        return $response;
    }


    function isCommentExist(int $user_id, int $task_id, string $desc): bool
    {
        $sql = "SELECT comment_slug from $this->table_name WHERE comment_task_id = ? AND comment_user_id = ? AND comment_content = ?";
        $stmt = $this->query($sql, [$task_id, $user_id, $desc]);
        return $stmt->rowCount() == 0;
    }
}
