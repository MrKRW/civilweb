<?php
require_once __DIR__ . '/../core/Controller.php';
class ContactController extends Controller {
    public function index(): void {
        $this->render('contact/index', [], 'main');
    }
}
