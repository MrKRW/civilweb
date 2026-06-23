<?php
/**
 * CivilLanka MVC – PartnerLogoModel
 * DB logic for the partner_logos table.
 */
require_once __DIR__ . '/../core/Model.php';

class PartnerLogoModel extends Model
{
    private string $uploadDir;
    private string $uploadUrl = 'uploads/logos/';

    public function __construct()
    {
        $this->uploadDir = ROOT_DIR . '/uploads/logos/';
        if (!is_dir($this->uploadDir)) {
            mkdir($this->uploadDir, 0755, true);
        }
    }

    /** Get all partner logos ordered by sort_order. */
    public function getAll(): array
    {
        $stmt = $this->db()->prepare('SELECT * FROM partner_logos ORDER BY sort_order ASC, created_at DESC');
        $stmt->execute();
        return $stmt->fetchAll();
    }

    /** Get a single logo by ID. */
    public function getById(int $id): ?array
    {
        $stmt = $this->db()->prepare('SELECT * FROM partner_logos WHERE id = :id');
        $stmt->execute([':id' => $id]);
        $row = $stmt->fetch();
        return $row ?: null;
    }

    /** Create a new partner logo. */
    public function create(array $data, ?array $imageFile = null): int
    {
        $imageName = $imageFile ? $this->uploadImage($imageFile) : '';

        $stmt = $this->db()->prepare("
            INSERT INTO partner_logos (image, alt_text, sort_order)
            VALUES (:image, :alt_text, :sort_order)
        ");
        $stmt->execute([
            ':image'      => $imageName,
            ':alt_text'   => $data['alt_text'] ?? '',
            ':sort_order' => (int) ($data['sort_order'] ?? 0)
        ]);
        return (int) $this->db()->lastInsertId();
    }

    /** Update an existing partner logo. */
    public function update(int $id, array $data, ?array $imageFile = null): bool
    {
        $existing = $this->getById($id);
        if (!$existing) return false;

        $imageName = $existing['image'];
        if ($imageFile && ($imageFile['error'] ?? UPLOAD_ERR_NO_FILE) === UPLOAD_ERR_OK) {
            $newImg = $this->uploadImage($imageFile);
            if ($newImg) {
                $this->deleteImage($existing['image']);
                $imageName = $newImg;
            }
        }

        $stmt = $this->db()->prepare("
            UPDATE partner_logos SET
              image = :image, alt_text = :alt_text, sort_order = :sort_order
            WHERE id = :id
        ");
        $stmt->execute([
            ':image'      => $imageName,
            ':alt_text'   => $data['alt_text'] ?? $existing['alt_text'],
            ':sort_order' => isset($data['sort_order']) ? (int)$data['sort_order'] : $existing['sort_order'],
            ':id'         => $id
        ]);
        return true;
    }

    /** Delete a partner logo. */
    public function delete(int $id): bool
    {
        $existing = $this->getById($id);
        if (!$existing) return false;

        $this->deleteImage($existing['image']);

        $stmt = $this->db()->prepare('DELETE FROM partner_logos WHERE id = :id');
        $stmt->execute([':id' => $id]);
        return true;
    }

    // ── Image helpers ──────────────────────────────────────────────

    public function uploadImage(array $file): string
    {
        $allowed = ['image/jpeg', 'image/png', 'image/webp', 'image/gif', 'image/svg+xml'];
        if (($file['error'] ?? UPLOAD_ERR_NO_FILE) !== UPLOAD_ERR_OK) return '';
        if (!in_array($file['type'] ?? '', $allowed)) return '';
        if (($file['size'] ?? 0) > 5 * 1024 * 1024) return ''; // 5MB max

        if (!is_dir($this->uploadDir)) mkdir($this->uploadDir, 0755, true);

        $ext  = strtolower(pathinfo($file['name'], PATHINFO_EXTENSION));
        // simple security check
        if (!in_array($ext, ['jpg', 'jpeg', 'png', 'gif', 'webp', 'svg'])) return '';

        $name = uniqid('logo_', true) . '.' . $ext;
        return move_uploaded_file($file['tmp_name'], $this->uploadDir . $name) ? $name : '';
    }

    private function deleteImage(string $filename): void
    {
        if (empty($filename)) return;
        $path = $this->uploadDir . $filename;
        if (file_exists($path)) @unlink($path);
    }
}
