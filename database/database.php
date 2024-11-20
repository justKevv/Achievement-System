<?php

require_once(__DIR__ . '/../config/config.php');

class Database
{
    private $conn;

    public function __construct()
    {
        $this->connect();
    }

    private function connect()
    {
        try {
            $this->conn = new PDO("sqlsrv:Server=" . DB_HOST . ";Database=" . DB_NAME, DB_USER, DB_PASS);
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
            throw new Exception("Prepare and execute failed: " . $e->getMessage());
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

// $db = new Database();

// $stmt = $db->prepare("SELECT * FROM dbo.roles");

// $stmt->execute();

// while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
//     print_r($row);
// }
