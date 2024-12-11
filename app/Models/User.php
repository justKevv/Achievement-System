<?php

namespace App\Models;

use PDO;

class User extends Model
{
    protected $db;

    protected $table = 'dbo.users';
    private $user_id;
    private $user_email;
    private $user_password;
    private $role_id;


    public function __construct($db)
    {
        parent::__construct($db);
    }
    public function getUserId()
    {
        return $this->user_id;
    }

    public function setUserId($user_id)
    {
        $this->user_id = $this->sanitize($user_id);
    }

    public function getuser_email()
    {
        return $this->user_email;
    }

    public function setuser_email($user_email)
    {
        $this->user_email = $this->sanitize($user_email);
    }

    public function getUserPassword()
    {
        return $this->user_password;
    }

    public function setUserPassword($user_password)
    {
        $this->user_password = $this->sanitize($user_password);
    }

    public function getRoleId()
    {
        return $this->role_id;
    }

    public function setRoleId($role_id)
    {
        $this->role_id = $this->sanitize($role_id);
    }

    public function save($table, $userData)
{
    try {
        $query = "INSERT INTO users (user_email, user_password, role_id)
                 VALUES (:user_email, :user_password, :role_id)";

        $params = [
            ':user_email' => $userData['user_email'],
            ':user_password' => $userData['user_password'],
            ':role_id' => $userData['role_id']
        ];

        $result = $this->db->prepareAndExecute($query, $params);

        if ($result) {
            // Get the last inserted ID
            return $this->db->getConnection()->lastInsertId();
        }
        return false;
    } catch (\PDOException $e) {
        error_log("Error in User save(): " . $e->getMessage());
        throw $e;
    }
}

    public function update($table = 'dbo.users', $data = [], $where = "user_id = :user_id")
    {

        $this->setUserId($this->user_id);
        $this->setuser_email($this->user_email);
        $this->setUserPassword($this->user_password);
        $this->setRoleId($this->role_id);

        $data = [
            ':user_email' => $this->user_email,
            ':user_password' => $this->user_password,
            ':role_id' => $this->role_id,
            ':user_id' => $this->user_id
        ];
        parent::update($table, $data, $where);
    }


    public function delete($table = 'dbo.users', $where = "user_id = :user_id", $params = [])
    {
        $params = [':user_id' => $this->user_id];
        parent::delete($table, $where, $params);
    }

    public function findByEmail($email)
    {

        $email = filter_var($email, FILTER_SANITIZE_FULL_SPECIAL_CHARS);

        $sql = "SELECT * FROM dbo.users WHERE user_email = :email";
        $params = [':email' => $email];
        $stmt = $this->db->prepareAndExecute($sql, $params);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
}
