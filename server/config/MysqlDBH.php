<?php

namespace app\config;

class MysqlDBH implements DatabaseHandler
{


    // DB Details
    private $host = 'localhost';
    private $password = "";
    private $dbname = "tms";
    private $username = 'root';
    private $charset = 'utf8mb4';
    private $connectionString;

    // private $dbname = "homebest_tms_db";
    // private $password = "}NEUWU36&[~m";
    // private $username = 'homebest_tms_root';










    function __construct()
    {
        try {
            $dsn = "mysql:host=$this->host;charset=$this->charset;dbname=$this->dbname";
            $this->connectionString = new \PDO($dsn, $this->username, $this->password);
        } catch (\Exception $ex) {
            echo ('Oooooops; we are unable to connect to server at the moment...');
        }
    }

    function connection()
    {
        return $this->connectionString;
    }
}
