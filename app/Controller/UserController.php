<?php

namespace App\Controller;

use App\Controller\Controller;
use App\Models\Admin;
use App\Models\Student;
use App\Models\User;

class UserController extends Controller
{
    private $userModel;

    public function __construct($db)
    {
        parent::__construct($db);
        $this->userModel = new User($db);
    }

    public function login($email, $user_password)
    {

        $email = filter_var($email, FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        $user_password = filter_var($user_password, FILTER_SANITIZE_FULL_SPECIAL_CHARS);

        $user = $this->userModel->findByEmail($email);

        if ($user && strtoupper(hash('sha256', $user_password)) === $user['user_password']) {
            // Store user data in session
            $_SESSION['user_id'] = $user['user_id'];
            $_SESSION['role_id'] = $user['role_id'];
            $_SESSION['is_logged_in'] = true;

            $response = new \Slim\Psr7\Response();
            return $response->withHeader('Location', '/dashboard')->withStatus(302);
        } else {
            $response = new \Slim\Psr7\Response();
            return $response->withHeader('Location', '/')->withStatus(302);
        }
    }

    public function logout()
    {
        session_destroy();
        $response = new \Slim\Psr7\Response();
        return $response->withHeader('Location', '/')->withStatus(302);
    }


    public function createUser($request, $response)
    {
        $data = json_decode($request->getBody()->getContents(), true);
        error_log('Received data: ' . print_r($data, true));

        try {
            // Create base user
            $userData = [
                'user_email' => $data['email'] ?? '',
                'user_password' => strtoupper(hash('sha256', $data['password'] ?? '')),
                'role_id' => $data['role'] === 'student' ? 'S' : 'A'
            ];

            $userId = $this->userModel->save('users', $userData);

            if (!$userId) {
                throw new \Exception('Failed to create user record');
            }

            // Create role-specific record
            if ($data['role'] === 'student') {
                $studentModel = new Student($this->db);
                $studentData = [
                    'user_id' => $userId,
                    'student_nim' => $data['student_nim'] ?? '',
                    'student_name' => $data['student_name'] ?? '',
                    'student_study_program' => $data['student_study_program'] ?? '',
                    'student_gender' => $data['student_gender'] ?? '',
                    'student_class' => $data['student_class'] ?? '',
                    'student_date_of_birth' => $data['student_date_of_birth'] ?? '',
                    'student_enrollment_date' => $data['student_enrollment_date'] ?? '',
                    'student_address' => $data['student_address'] ?? '',
                    'student_phone_number' => $data['student_phone_number'] ?? ''
                ];

                if (!$studentModel->save('student', $studentData)) {
                    throw new \Exception('Failed to create student record');
                }
            } else {
                $adminModel = new Admin($this->db);
                $adminData = [
                    'user_id' => $userId,
                    'admin_name' => $data['admin_name'] ?? '',
                    'admin_nip' => $data['admin_nip'] ?? ''
                ];

                if (!$adminModel->save('admin', $adminData)) {
                    throw new \Exception('Failed to create admin record');
                }
            }

            $response->getBody()->write(json_encode(['success' => true]));
            return $response->withHeader('Content-Type', 'application/json');
        } catch (\Exception $e) {
            error_log("Error creating user: " . $e->getMessage());
            $response->getBody()->write(json_encode([
                'success' => false,
                'message' => $e->getMessage()
            ]));
            return $response
                ->withHeader('Content-Type', 'application/json')
                ->withStatus(500);
        }
    }
}
