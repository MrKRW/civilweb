<?php
/**
 * CivilLanka – Database Setup Script
 * Run this once via browser: http://localhost/civilweb/setup.php
 * It creates the database, tables, and default admin user.
 * DELETE THIS FILE after setup is complete.
 */

$host = 'localhost';
$user = 'root';
$pass = '';

echo "<pre style='font-family:monospace;background:#111;color:#0f0;padding:30px;font-size:14px;'>";
echo "╔═══════════════════════════════════════╗\n";
echo "║   CivilLanka Database Setup           ║\n";
echo "╚═══════════════════════════════════════╝\n\n";

try {
    // Connect without database
    $pdo = new PDO("mysql:host=$host;charset=utf8mb4", $user, $pass, [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
    ]);

    // Create database
    $pdo->exec("CREATE DATABASE IF NOT EXISTS `civillanka_db` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci");
    echo "✓ Database 'civillanka_db' created\n";

    // Use database
    $pdo->exec("USE `civillanka_db`");

    // Create projects table
    $pdo->exec("
        CREATE TABLE IF NOT EXISTS `projects` (
            `id`            INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
            `title`         VARCHAR(255)   NOT NULL,
            `category`      ENUM('local','international') NOT NULL DEFAULT 'local',
            `description`   TEXT           NULL,
            `location`      VARCHAR(255)   NULL,
            `client`        VARCHAR(255)   NULL,
            `year`          YEAR           NULL,
            `service_type`  VARCHAR(100)   NULL,
            `image_main`    VARCHAR(255)   NULL,
            `image_gallery` JSON           NULL,
            `featured`      TINYINT(1)     NOT NULL DEFAULT 0,
            `status`        ENUM('draft','published') NOT NULL DEFAULT 'published',
            `sort_order`    INT            NOT NULL DEFAULT 0,
            `created_at`    TIMESTAMP      DEFAULT CURRENT_TIMESTAMP,
            `updated_at`    TIMESTAMP      DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
            INDEX `idx_category` (`category`),
            INDEX `idx_featured` (`featured`),
            INDEX `idx_status`   (`status`)
        ) ENGINE=InnoDB
    ");
    echo "✓ Table 'projects' created\n";

    // Create admin_users table
    $pdo->exec("
        CREATE TABLE IF NOT EXISTS `admin_users` (
            `id`         INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
            `username`   VARCHAR(50)   NOT NULL UNIQUE,
            `password`   VARCHAR(255)  NOT NULL,
            `full_name`  VARCHAR(100)  NULL,
            `created_at` TIMESTAMP     DEFAULT CURRENT_TIMESTAMP
        ) ENGINE=InnoDB
    ");
    echo "✓ Table 'admin_users' created\n";

    // Insert default admin
    $hash = password_hash('admin123', PASSWORD_BCRYPT);
    $stmt = $pdo->prepare("INSERT INTO `admin_users` (`username`, `password`, `full_name`) VALUES ('admin', :pw, 'Administrator') ON DUPLICATE KEY UPDATE `username` = `username`");
    $stmt->execute([':pw' => $hash]);
    echo "✓ Default admin user created (admin / admin123)\n";

    // Create uploads directory
    $uploadDir = __DIR__ . '/uploads/projects';
    if (!is_dir($uploadDir)) {
        mkdir($uploadDir, 0755, true);
        echo "✓ Upload directory created\n";
    } else {
        echo "✓ Upload directory already exists\n";
    }

    echo "\n══════════════════════════════════════════\n";
    echo "  ✅ SETUP COMPLETE!\n";
    echo "══════════════════════════════════════════\n\n";
    echo "  Admin Panel: <a href='/admin/' style='color:#0ff'>http://localhost/civilweb/admin/</a>\n";
    echo "  Username:    admin\n";
    echo "  Password:    admin123\n\n";
    echo "  ⚠️  DELETE this setup.php file after use!\n";

} catch (PDOException $e) {
    echo "✗ ERROR: " . $e->getMessage() . "\n";
    echo "\n  Make sure MySQL is running in XAMPP Control Panel.\n";
}

echo "</pre>";
