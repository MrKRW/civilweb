<?php
/**
 * CivilLanka MVC – PartnerLogoController
 * Handles: /api/partner-logos JSON endpoints for admin
 */
require_once __DIR__ . '/../core/Controller.php';
require_once __DIR__ . '/../models/PartnerLogoModel.php';

class PartnerLogoController extends Controller
{
    private PartnerLogoModel $model;

    public function __construct()
    {
        if (session_status() === PHP_SESSION_NONE) session_start();
        $this->model = new PartnerLogoModel();
    }

    /** 
     * Route handler for /api/partner-logos
     * Expects basic routing logic similar to ProjectsController/api 
     */
    public function api(): void
    {
        $this->requireAdmin(); // All endpoints here require admin
        
        $action = $_POST['action'] ?? $_GET['action'] ?? '';
        
        switch ($action) {
            case 'list':
                $this->listLogos();
                break;
            case 'save':
                $this->saveLogo();
                break;
            case 'delete':
                $this->deleteLogo();
                break;
            default:
                $this->json(['error' => 'Invalid action'], 400);
        }
    }

    private function listLogos(): void
    {
        $logos = $this->model->getAll();
        $this->json(['success' => true, 'logos' => $logos]);
    }

    private function saveLogo(): void
    {
        $id = isset($_POST['id']) ? (int) $_POST['id'] : 0;
        $data = [
            'alt_text'   => $_POST['alt_text'] ?? '',
            'sort_order' => $_POST['sort_order'] ?? 0
        ];
        
        $imageFile = $_FILES['image'] ?? null;

        if ($id > 0) {
            $success = $this->model->update($id, $data, $imageFile);
            if ($success) {
                $this->json(['success' => true, 'message' => 'Partner logo updated']);
            } else {
                $this->json(['error' => 'Failed to update logo'], 500);
            }
        } else {
            // Create requires an image
            if (!$imageFile || ($imageFile['error'] ?? UPLOAD_ERR_NO_FILE) !== UPLOAD_ERR_OK) {
                $this->json(['error' => 'Image file is required for a new logo'], 400);
            }
            $newId = $this->model->create($data, $imageFile);
            if ($newId) {
                $this->json(['success' => true, 'message' => 'Partner logo added']);
            } else {
                $this->json(['error' => 'Failed to add logo'], 500);
            }
        }
    }

    private function deleteLogo(): void
    {
        $id = isset($_POST['id']) ? (int) $_POST['id'] : 0;
        if ($id <= 0) {
            $this->json(['error' => 'Invalid ID'], 400);
        }
        $success = $this->model->delete($id);
        if ($success) {
            $this->json(['success' => true, 'message' => 'Partner logo deleted']);
        } else {
            $this->json(['error' => 'Failed to delete logo'], 500);
        }
    }
}
