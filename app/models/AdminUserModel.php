<?php
/**
 * CivilLanka MVC – AdminUserModel
 * All DB logic for admin_users table (auth + settings).
 */
require_once __DIR__ . '/../core/Model.php';

class AdminUserModel extends Model
{
    /** Find an admin user by username. Returns null if not found. */
    public function findByUsername(string $username): ?array
    {
        $stmt = $this->db()->prepare('SELECT * FROM admin_users WHERE username = :u LIMIT 1');
        $stmt->execute([':u' => $username]);
        $row = $stmt->fetch();
        return $row ?: null;
    }

    /** Find an admin user by ID. Returns null if not found. */
    public function findById(int $id): ?array
    {
        $stmt = $this->db()->prepare('SELECT * FROM admin_users WHERE id = :id LIMIT 1');
        $stmt->execute([':id' => $id]);
        $row = $stmt->fetch();
        return $row ?: null;
    }

    /** Update the password for a given user ID. */
    public function updatePassword(int $id, string $newPassword): void
    {
        $hash = password_hash($newPassword, PASSWORD_BCRYPT);
        $this->db()->prepare('UPDATE admin_users SET password = :pw WHERE id = :id')
            ->execute([':pw' => $hash, ':id' => $id]);
    }

    /** Verify a plain password against the stored hash. */
    public function verifyPassword(string $plain, string $hash): bool
    {
        return password_verify($plain, $hash);
    }
}
