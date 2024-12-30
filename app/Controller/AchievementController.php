<?php

namespace App\Controller;

use App\Models\Achievement;
use App\Models\Verification;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

class AchievementController
{
    private $achievementService;
    private $db;

    public function __construct($db)
    {
        $this->db = $db;
        $this->achievementService = new \App\Services\AchievementService($db);
    }

    public function approve(Request $request, Response $response, array $args)
    {
        try {
            $achievementId = $args['id'];
            $adminId = $_SESSION['user_id'];
            $adminName = $_SESSION['name'];

            // Update achievement status
            $achievement = new Achievement($this->db);
            $updateResult = $achievement->update(
                $achievementId,
                ['achievement_status' => 'Approved']
            );

            if (!$updateResult) {
                throw new \Exception('Failed to update achievement status');
            }

            // Create verification record
            $verification = new Verification($this->db);
            $verificationResult = $verification->create(
                $achievementId,
                $adminId,
                $adminName
            );

            if (!$verificationResult) {
                throw new \Exception('Failed to create verification record');
            }

            return $this->jsonResponse($response, [
                'success' => true,
                'message' => 'Achievement approved successfully'
            ]);
        } catch (\Exception $e) {
            error_log($e->getMessage());
            return $this->jsonResponse($response, [
                'success' => false,
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function reject(Request $request, Response $response, array $args)
    {
        try {
            $achievementId = $args['id'];
            $adminId = $_SESSION['user_id'];
            $adminName = $_SESSION['name'];

            // Update achievement status
            $achievement = new Achievement($this->db);
            $updateResult = $achievement->update(
                $achievementId,
                ['achievement_status' => 'Rejected']
            );

            if (!$updateResult) {
                throw new \Exception('Failed to update achievement status');
            }

            $verification = new Verification($this->db);
            $verificationResult = $verification->create(
                $achievementId,
                $adminId,
                $adminName
            );

            if (!$verificationResult) {
                throw new \Exception('Failed to create verification record');
            }

            return $this->jsonResponse($response, [
                'success' => true,
                'message' => 'Achievement rejected successfully'
            ]);
        } catch (\Exception $e) {
            error_log($e->getMessage());
            return $this->jsonResponse($response, [
                'success' => false,
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function create(Request $request, Response $response)
    {
        try {
            $files = $request->getUploadedFiles();
            $data = $request->getParsedBody();

            header('Content-Type: application/json');
            flush();

            if (!isset($files['activities']) || !isset($files['certificate'])) {
                return $this->jsonResponse($response, [
                    'success' => false,
                    'error' => 'Missing required files'
                ], 400);
            }

            $fileContents = [
                'activities' => $this->processFile($files['activities']),
                'certificate' => $this->processFile($files['certificate'])
            ];

            $requiredFields = ['title', 'description', 'category', 'date', 'organizer', 'user_id'];
            foreach ($requiredFields as $field) {
                if (!isset($data[$field])) {
                    return $this->jsonResponse($response, [
                        'success' => false,
                        'error' => "Missing required field: {$field}"
                    ], 400);
                }
            }

            $achievementId = $this->achievementService->createAchievement($data, $fileContents);

            return $response
                ->withHeader('Location', '/dashboard')
                ->withStatus(302);
        } catch (\Exception $e) {
            error_log($e->getMessage());
            return $this->jsonResponse($response, [
                'success' => false,
                'error' => 'Failed to create achievement'
            ], 500);
        }
    }

    private function jsonResponse($response, $data, $status = 200)
    {
        $response->getBody()->write(json_encode($data));
        return $response
            ->withHeader('Content-Type', 'application/json')
            ->withStatus($status);
    }

    private function processFile($file)
    {
        ini_set('memory_limit', '256M');

        $content = '';
        $stream = $file->getStream();
        while (!$stream->eof()) {
            $content .= $stream->read(8192);
        }
        return $content;
    }
}
