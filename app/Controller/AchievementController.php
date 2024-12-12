<?php

namespace App\Controller;

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

class AchievementController
{
    protected $achievement;
    protected $achievementFile;

    public function __construct($db)
    {
        $this->achievement = new \App\Models\Achievement($db);
        $this->achievementFile = new \App\Models\AchievementFile($db);
    }

    public function create(Request $request, Response $response)
    {
        try {
            $files = $request->getUploadedFiles();
            $data = $request->getParsedBody();

            if (!isset($files['activities']) || !isset($files['certificate'])) {
                $response->getBody()->write(json_encode([
                    'success' => false,
                    'error' => 'Missing required files'
                ]));
                return $response->withHeader('Content-Type', 'application/json')->withStatus(400);
            }

            $activitiesContent = $files['activities']->getStream()->getContents();
            $certificateContent = $files['certificate']->getStream()->getContents();

            $achievementId = $this->achievement->create($data);
            if (!$achievementId) {
                throw new \Exception('Failed to create achievement record');
            }

            $result = $this->achievementFile->create(
                $achievementId,
                $activitiesContent,
                $certificateContent
            );

            if (!$result) {
                throw new \Exception('Failed to save files');
            }

            $response->getBody()->write(json_encode([
                'success' => true,
                'message' => 'Achievement created successfully'
            ]));
            return $response->withHeader('Content-Type', 'application/json');

        } catch (\Exception $e) {
            error_log($e->getMessage());
            $response->getBody()->write(json_encode([
                'success' => false,
                'error' => $e->getMessage()
            ]));
            return $response->withHeader('Content-Type', 'application/json')->withStatus(500);
        }
    }
}
