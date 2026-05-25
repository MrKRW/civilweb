<?php
require_once __DIR__ . '/../core/Controller.php';
class ServicesController extends Controller {
    public function index(): void {
        $this->render('services/index', [], 'main');
    }
}
