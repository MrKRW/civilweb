<?php
require_once __DIR__ . '/../core/Controller.php';
require_once __DIR__ . '/../models/PartnerLogoModel.php';

class AboutController extends Controller {
    public function index(): void {
        $logoModel = new PartnerLogoModel();
        $partnerLogos = $logoModel->getAll();
        
        $this->render('about/index', ['partnerLogos' => $partnerLogos], 'main');
    }
}
