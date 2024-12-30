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

    public function getAllUsers()
    {
        $sql = "SELECT
                    u.user_id,
                    COALESCE(s.student_name, a.admin_name, c.chairman_name) as name,
                    u.user_email as user_email,
                    r.role_name
                FROM
                    dbo.users u
                    JOIN dbo.roles r ON u.role_id = r.role_id
                    LEFT JOIN dbo.student s ON u.user_id = s.user_id
                    LEFT JOIN dbo.admin a ON u.user_id = a.user_id
                    LEFT JOIN dbo.chairman c ON u.user_id = c.user_id
                ORDER BY
                    u.user_id DESC";
        $stmt = $this->db->query($sql);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getDetailUser($userId)
    {
        try {
            $query = "SELECT
            u.user_id,
            u.user_email,
            u.role_id,
            COALESCE(s.student_name, a.admin_name, c.chairman_name) as name,
            s.student_nim,
            s.student_study_program,
            s.student_gender,
            s.student_class,
            s.student_date_of_birth,
            s.student_enrollment_date,
            s.student_address,
            s.student_phone_number,
            a.admin_name,
            a.admin_nip,
            c.chairman_name,
            c.chairman_nip
        FROM dbo.users u
        LEFT JOIN dbo.student s ON u.user_id = s.user_id
        LEFT JOIN dbo.admin a ON u.user_id = a.user_id
        LEFT JOIN dbo.chairman c ON u.user_id = c.user_id
        WHERE u.user_id = :user_id";

            $params = [':user_id' => $userId];
            $result = $this->db->prepareAndExecute($query, $params);

            return $result->fetch(PDO::FETCH_ASSOC);
        } catch (\PDOException $e) {
            error_log("Error in getDetailUser: " . $e->getMessage());
            throw $e;
        }
    }

    public function updateUser($userId, $userData)
    {
        try {
            $query = "UPDATE dbo.users SET user_email = :user_email WHERE user_id = :user_id";
            $params = [
                ':user_email' => $userData['user_email'],
                ':user_id' => $userId
            ];

            return $this->db->prepareAndExecute($query, $params);
        } catch (\PDOException $e) {
            error_log("Error in updateUser: " . $e->getMessage());
            throw $e;
        }
    }

    public function deleteUser($userId)
    {
        try {
            $query = "DELETE FROM dbo.users WHERE user_id = :user_id";
            $params = [':user_id' => $userId];
            return $this->db->prepareAndExecute($query, $params);
        } catch (\PDOException $e) {
            error_log("Error in deleteUser: " . $e->getMessage());
            throw $e;
        }
    }
}
