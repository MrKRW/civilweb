<?php
require_once __DIR__ . '/../core/Controller.php';
require_once __DIR__ . '/../models/BlogModel.php';

class HomeController extends Controller {
    public function index(): void {
        $blogModel = new BlogModel();
        $recentBlogs = [];
        try {
            $recentBlogs = array_slice($blogModel->getPublished(), 0, 4);
        } catch (\Throwable $e) {
            // Table may not exist yet or other error
        }
        $this->render('home/index', ['recentBlogs' => $recentBlogs], 'main');
    }
}
