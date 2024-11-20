<?php

class User
{
    private $db;
    private $user_id;
    private $username;
    private $user_password;
    private $role_id;
    private $detail_id;


    public function __construct($db)
    {
        $this->db = $db;
    }
    public function getUserId()
    {
        return $this->user_id;
    }

    public function setUserId($user_id)
    {
        $this->user_id = $user_id;
    }

    public function getUsername()
    {
        return $this->username;
    }

    public function setUsername($username)
    {
        $this->username = $username;
    }

    public function getUserPassword()
    {
        return $this->user_password;
    }

    public function setUserPassword($user_password)
    {
        $this->user_password = $user_password;
    }

    public function getRoleId()
    {
        return $this->role_id;
    }

    public function setRoleId($role_id)
    {
        $this->role_id = $role_id;
    }

    public function getDetailId()
    {
        return $this->detail_id;
    }

    public function setDetailId($detail_id)
    {
        $this->detail_id = $detail_id;
    }

    public function save() {

        $this->username = filter_var($this->username, FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        $this->user_password = filter_var($this->user_password, FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        $this->role_id = filter_var($this->role_id, FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        $this->detail_id = filter_var($this->detail_id, FILTER_SANITIZE_FULL_SPECIAL_CHARS);

        $sql = "INSERT INTO dbo.users (username, user_password, role_id, detail_id) VALUES (:username, :user_password, :role_id, :detail_id)";
        $params = [
            ':username' => $this->username,
            ':user_password' => password_hash($this->user_password, PASSWORD_BCRYPT),
            ':role_id' => $this->role_id,
            ':detail_id' => $this->detail_id
        ];
        $this->db->prepareAndExecute($sql, $params);
    }

    public function update() {

        $this->username = filter_var($this->username, FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        $this->user_password = filter_var($this->user_password, FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        $this->role_id = filter_var($this->role_id, FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        $this->detail_id = filter_var($this->detail_id, FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        $this->user_id = filter_var($this->user_id, FILTER_SANITIZE_FULL_SPECIAL_CHARS);

        $sql = "UPDATE dbo.users SET username = :username, user_password = :user_password, role_id = :role_id, detail_id = :detail_id WHERE user_id = :user_id";
        $params = [
            ':username' => $this->username,
            ':user_password' => password_hash($this->user_password, PASSWORD_BCRYPT),
            ':role_id' => $this->role_id,
            ':detail_id' => $this->detail_id,
            ':user_id' => $this->user_id
        ];
        $this->db->prepareAndExecute($sql, $params);
    }


    public function delete() {
        $sql = "DELETE FROM dbo.users WHERE user_id = :user_id";
        $params = [':user_id' => $this->user_id];
        $this->db->prepareAndExecute($sql, $params);
    }

    public function findByUsername($username) {

        $username = filter_var($username, FILTER_SANITIZE_FULL_SPECIAL_CHARS);

        $sql = "SELECT * FROM dbo.users WHERE username = :username";
        $params = [':username' => $username];
        $stmt = $this->db->prepareAndExecute($sql, $params);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
}
