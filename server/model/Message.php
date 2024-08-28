<?php

namespace app\model;

use app\config\DatabaseHandler;


class Message extends BaseModel
{
    private $table_name = 'messages_tb';

    function __construct(DatabaseHandler $databaseHandler)
    {
        parent::__construct($databaseHandler);
    }


    function insertMessage(array $payload)
    {
        if ($this->isMessageExist($payload["_task_id"], $payload["_content"]) === true) {

            $sql = "INSERT INTO $this->table_name(message_slug, message_task_id, message_user_id, message_content) 
                    VALUES(:_slug, :_task_id, :_user_id, :_content)";
            $response = $this->insert($sql, $payload, "_slug");
            return $response;
        }
        return "exist";
    }

    function fetchMessageByTask(int $_id)
    {
        $sql = "SELECT $this->table_name.*, users_tb.user_fullname, users_tb.user_email, users_tb.user_picture FROM $this->table_name LEFT JOIN users_tb ON $this->table_name.message_user_id = users_tb.user_id WHERE message_task_id = ? ";
        $response = $this->fetchMany($sql, [$_id]);
        return $response;
    }

    function removeMessage(int $comment_id)
    {
        $sql = "DELETE FROM $this->table_name WHERE message_id = ? ";
        $response = $this->delete($sql, [$comment_id]);
        return $response;
    }


    function isMessageExist(int $task_id, string $desc): bool
    {
        $sql = "SELECT message_slug from $this->table_name WHERE message_task_id = ? AND message_content = ?";
        $stmt = $this->query($sql, [$task_id, $desc]);
        return $stmt->rowCount() == 0;
    }
}
