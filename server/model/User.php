<?php

namespace app\model;

use app\config\DatabaseHandler;
use app\utils\PasswordEncoder;


class User extends BaseModel
{
    private $table_name = 'users_tb';

    function __construct(DatabaseHandler $databaseHandler)
    {
        parent::__construct($databaseHandler);
    }

    function createUser(array $payload)
    {
        if ($this->isUser($payload["_email"], $payload["_username"],) === true) {
            $payload["_password"] = PasswordEncoder::encodePassword($payload["_password"]);
            $sql = "INSERT INTO $this->table_name(user_slug, user_fullname, user_email, user_username, user_password) VALUES(:_slug, :_fullname, :_email, :_username, :_password)";
            return $this->insert($sql, $payload, "_slug");
        }
        return "exist";
    }

    function updateUserAccount(array $payload)
    {
        $payload["_password"] = PasswordEncoder::encodePassword($payload["_password"]);
        $sql = "UPDATE $this->table_name SET user_fullname = :_fullname, user_password = :_password, updated_at = :updatedAt WHERE user_slug = :_slug";
        return $this->update($sql, $payload);
    }

    function updateUserPic(array $payload)
    {
        $sql = "UPDATE $this->table_name SET user_picture = :_picture, updated_at = :updatedAt WHERE user_id = :_id";
        return $this->update($sql, $payload);
    }

    function fetchUsers()
    {
        $sql = "SELECT * FROM $this->table_name";
        $response = $this->fetchMany($sql);
        return $response;
    }

    function fetchUserByUsername(string $username)
    {
        $sql = "SELECT * from $this->table_name WHERE user_username = ?";
        $response = $this->fetch($sql, [$username]);
        return $response;
    }


    function isUser(string $email, $username): bool
    {
        $sql = "SELECT user_slug from $this->table_name WHERE user_email = ? OR user_username = ?";
        $stmt = $this->query($sql, [$email, $username]);
        return $stmt->rowCount() == 0;
    }

    function isUsername(string $username)
    {
        $sql = "SELECT user_id from $this->table_name WHERE user_username = ?";
        $res = $this->fetch($sql, [$username]);
        return $res;
    }
}
