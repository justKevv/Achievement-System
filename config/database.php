<?php

namespace Config;

use PDO;
use PDOException;
use Exception;

class database
{
    private $conn;
    private string $dbHost;
    private string $dbName;
    private string $dbUsername;
    private string $dbPassword;

    public function __construct()
    {
        $this->dbHost = $_ENV['DB_HOST'];
        $this->dbName = $_ENV['DB_NAME'];
        $this->dbUsername = $_ENV['DB_USER'];
        $this->dbPassword = $_ENV['DB_PASS'];
        $this->connect();
    }

    private function connect()
    {
        try {
            $this->conn = new PDO("sqlsrv:Server=" . $this->dbHost . ";Database=" . $this->dbName, $this->dbUsername, $this->dbPassword);
            $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            // echo "Connected successfully";
        } catch (PDOException $e) {
            throw new Exception("Connection failed: " . $e->getMessage());
        }
    }

    public function query($sql)
    {
        try {
            return $this->conn->query($sql);
        } catch (PDOException $e) {
            throw new Exception("Query failed: " . $e->getMessage());
        }
    }

    public function prepareAndExecute($sql, $params)
    {
        try {
            $stmt = $this->conn->prepare($sql);
            foreach ($params as $key => &$value) {
                $stmt->bindParam($key, $value);
            }
            $stmt->execute();
            return $stmt;
        } catch (PDOException $e) {
            throw new Exception("Prepare and execute failed: " . $e->getMessage() .
                "\nSQL: " . $sql .
                "\nParams: " . print_r($params, true));
        }
    }

    public function close()
    {
        $this->conn = null;
    }

    public function __destruct()
    {
        $this->close();
    }
}
