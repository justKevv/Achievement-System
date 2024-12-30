<?php

namespace App\Controller;

use App\Controller\Controller;
use App\Models\Admin;
use App\Models\Chairman;
use App\Models\Student;
use App\Models\User;

class UserController extends Controller
{
    private $userModel;
    private $adminModel;

    public function __construct($db)
    {
        parent::__construct($db);
        $this->userModel = new User($db);
        $this->adminModel = new Admin($db);
    }

    public function login($email, $user_password)
    {

        $email = filter_var($email, FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        $user_password = filter_var($user_password, FILTER_SANITIZE_FULL_SPECIAL_CHARS);

        $user = $this->userModel->findByEmail($email);

        if ($user && strtoupper(hash('sha256', $user_password)) === $user['user_password']) {
            if ($user['role_id'] === 'A') {
                $admin = $this->adminModel->getAdminByUserId($user['user_id']);
                $_SESSION['name'] = $admin['admin_name'] ?? null;
            }
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
        echo "<script>localStorage.removeItem('modalShown');</script>";
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
                'role_id' => match ($data['role']) {
                    'student' => 'S',
                    'admin' => 'A',
                    'chairman' => 'C'
                }
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
            } else if ($data['role'] === 'admin') {
                $adminModel = new Admin($this->db);
                $adminData = [
                    'user_id' => $userId,
                    'admin_name' => $data['admin_name'] ?? '',
                    'admin_nip' => $data['admin_nip'] ?? ''
                ];

                if (!$adminModel->save('admin', $adminData)) {
                    throw new \Exception('Failed to create admin record');
                }
            } else if ($data['role'] === 'chairman') {
                $chairmanModel = new Chairman($this->db);
                $chairmanData = [
                    'user_id' => $userId,
                    'chairman_name' => $data['chairman_name'] ?? '',
                    'chairman_nip' => $data['chairman_nip'] ?? ''
                ];

                error_log('Chairman data: ' . print_r($chairmanData, true));

                if (!$chairmanModel->save('chairman', $chairmanData)) {
                    error_log('Failed to create chairman record');
                    throw new \Exception('Failed to create chairman record');
                }
            } else {
                throw new \Exception('Invalid role');
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

    public function getUser($request, $response, $args)
    {
        try {
            $userId = $args['id'];
            error_log("Fetching user with ID: " . $userId);

            $user = $this->userModel->getDetailUser($userId);

            if (!$user) {
                error_log("User not found for ID: " . $userId);
                $response->getBody()->write(json_encode([
                    'error' => 'User not found'
                ]));
                return $response
                    ->withHeader('Content-Type', 'application/json')
                    ->withStatus(404);
            }

            error_log("User data found: " . print_r($user, true));
            $response->getBody()->write(json_encode($user));
            return $response
                ->withHeader('Content-Type', 'application/json')
                ->withStatus(200);
        } catch (\Exception $e) {
            error_log("Error in getUser: " . $e->getMessage());
            $response->getBody()->write(json_encode([
                'error' => 'Error loading user data: ' . $e->getMessage()
            ]));
            return $response
                ->withHeader('Content-Type', 'application/json')
                ->withStatus(500);
        }
    }

    public function updateUser($request, $response, $args)
    {
        try {
            $userId = $args['id'];
            $data = json_decode($request->getBody()->getContents(), true);
            error_log('Update user data received: ' . print_r($data, true));

            // Format dates if they exist
            if (isset($data['student_date_of_birth'])) {
                $data['student_date_of_birth'] = date('Y-m-d', strtotime($data['student_date_of_birth']));
            }
            if (isset($data['student_enrollment_date'])) {
                $data['student_enrollment_date'] = date('Y-m-d', strtotime($data['student_enrollment_date']));
            }

            // Update user email
            $userData = [
                'user_email' => $data['email']
            ];
            $this->userModel->updateUser($userId, $userData);

            // Update role-specific data
            switch ($data['role']) {
                case 'student':
                    $studentModel = new Student($this->db);
                    $studentData = [
                        'student_nim' => $data['student_nim'],
                        'student_name' => $data['student_name'],
                        'student_study_program' => $data['student_study_program'],
                        'student_gender' => $data['student_gender'],
                        'student_class' => $data['student_class'],
                        'student_date_of_birth' => $data['student_date_of_birth'],
                        'student_enrollment_date' => $data['student_enrollment_date'],
                        'student_address' => $data['student_address'],
                        'student_phone_number' => $data['student_phone_number']
                    ];
                    $studentModel->updateStudent($userId, $studentData);
                    break;
                case 'admin':
                    $adminModel = new Admin($this->db);
                    $adminData = [
                        'admin_name' => $data['admin_name'],
                        'admin_nip' => $data['admin_nip']
                    ];
                    $adminModel->updateAdmin($userId, $adminData);
                    break;
                case 'chairman':
                    $chairmanModel = new Chairman($this->db);
                    $chairmanData = [
                        'chairman_name' => $data['chairman_name'],
                        'chairman_nip' => $data['chairman_nip']
                    ];
                    $chairmanModel->updateChairman($userId, $chairmanData);
                    break;
                default:
                    throw new \Exception('Invalid role');
            }

            $response->getBody()->write(json_encode(['success' => true]));
            return $response->withHeader('Content-Type', 'application/json');
        } catch (\Exception $e) {
            error_log("Error updating user: " . $e->getMessage());
            $response->getBody()->write(json_encode([
                'success' => false,
                'message' => $e->getMessage()
            ]));
            return $response
                ->withHeader('Content-Type', 'application/json')
                ->withStatus(500);
        }
    }

    // Add this method
public function deleteUser($request, $response, $args)
{
    try {
        $userId = $args['id'];

        // Get user role first
        $user = $this->userModel->getDetailUser($userId);
        if (!$user) {
            throw new \Exception('User not found');
        }

        // Delete role-specific record first
        switch ($user['role_id']) {
            case 'S':
                $studentModel = new Student($this->db);
                $studentModel->deleteStudent($userId);
                break;
            case 'A':
                $adminModel = new Admin($this->db);
                $adminModel->deleteAdmin($userId);
                break;
            case 'C':
                $chairmanModel = new Chairman($this->db);
                $chairmanModel->deleteChairman($userId);
                break;
        }

        // Then delete user record
        if (!$this->userModel->deleteUser($userId)) {
            throw new \Exception('Failed to delete user');
        }

        $response->getBody()->write(json_encode(['success' => true]));
        return $response->withHeader('Content-Type', 'application/json');

    } catch (\Exception $e) {
        error_log("Error deleting user: " . $e->getMessage());
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
