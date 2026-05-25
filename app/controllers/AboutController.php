<?php
require_once __DIR__ . '/../core/Controller.php';
class AboutController extends Controller {
    public function index(): void {
        $this->render('about/index', [], 'main');
    }
}
