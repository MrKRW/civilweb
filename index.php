<?php
/**
 * CivilLanka – Front Controller
 * All HTTP requests are routed through here via .htaccess.
 */

define('BASE_PATH', '/civilweb');
define('ROOT_DIR', __DIR__);

require_once __DIR__ . '/app/core/Router.php';
require_once __DIR__ . '/app/core/Controller.php';
require_once __DIR__ . '/app/core/Model.php';
require_once __DIR__ . '/app/core/View.php';

$router = new Router(BASE_PATH);

// ── Public pages ──────────────────────────────────────────────────
$router->add('/',           'HomeController',     'index');
$router->add('/about',      'AboutController',    'index');
$router->add('/services',   'ServicesController', 'index');
$router->add('/projects',   'ProjectsController', 'index');
$router->add('/blog',       'BlogController',     'index');
$router->add('/contact',    'ContactController',  'index');
$router->add('/shop',       'ShopController',     'index');

// ── Parameterised public pages ─────────────────────────────────────
$router->addParam('/projects/{id}',   'ProjectsController', 'detail',  'id');
$router->addParam('/shop/product/{id}', 'ShopController',   'product', 'id');

// ── Admin pages ───────────────────────────────────────────────────
$router->add('/admin',         'AdminController', 'dashboard');
$router->add('/admin/login',   'AuthController',  'loginPage');
$router->add('/admin/logout',  'AuthController',  'logout');

// ── JSON API endpoints ────────────────────────────────────────────
$router->add('/api/projects',  'ProjectsController', 'api');
$router->add('/api/shop',      'ShopController',     'api');
$router->add('/api/auth',      'AuthController',     'api');
$router->add('/api/settings',  'AdminController',    'apiSettings');

$router->dispatch();
