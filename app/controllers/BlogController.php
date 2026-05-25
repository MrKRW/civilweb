<?php
require_once __DIR__ . '/../core/Controller.php';
class BlogController extends Controller {
    public function index(): void {
        $this->render('blog/index', [], 'main');
    }
}
