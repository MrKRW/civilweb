<?php
/**
 * CivilLanka – Database Connection
 * Uses PDO for secure, prepared-statement queries.
 */

if (!defined('IS_LOCAL')) {
    define('IS_LOCAL', in_array($_SERVER['HTTP_HOST'] ?? '', ['localhost', '127.0.0.1', '::1']));
}
define('DB_HOST', 'localhost');
define('DB_NAME', IS_LOCAL ? 'civillanka_db' : 'u828029692_civilankadb');
define('DB_USER', IS_LOCAL ? 'root' : 'u828029692_civilankausr');
define('DB_PASS', IS_LOCAL ? '' : 'RootFh@21$');
define('DB_CHARSET', 'utf8mb4');

function getDB(): PDO {
    static $pdo = null;
    if ($pdo === null) {
        $dsn = 'mysql:host=' . DB_HOST . ';dbname=' . DB_NAME . ';charset=' . DB_CHARSET;
        $options = [
            PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
            PDO::ATTR_EMULATE_PREPARES   => false,
        ];
        try {
            $pdo = new PDO($dsn, DB_USER, DB_PASS, $options);
        } catch (PDOException $e) {
            http_response_code(500);
            echo json_encode(['error' => 'Database connection failed: ' . $e->getMessage()]);
            exit;
        }
    }
    return $pdo;
}

/** Tiny helper – JSON response */
function jsonResponse(array $data, int $code = 200): void {
    http_response_code($code);
    header('Content-Type: application/json; charset=utf-8');
    echo json_encode($data, JSON_UNESCAPED_UNICODE);
    exit;
}

/** Base URL helper */
function baseUrl(): string {
    $protocol = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off') ? 'https' : 'http';
    return $protocol . '://' . $_SERVER['HTTP_HOST'] . (IS_LOCAL ? '/civilweb' : '');
}
