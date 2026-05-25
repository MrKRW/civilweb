<?php
/**
 * CivilLanka MVC – ProjectModel
 * All DB logic for the projects table.
 */
require_once __DIR__ . '/../core/Model.php';

class ProjectModel extends Model
{
    private string $uploadDir;
    private string $uploadUrl = 'uploads/projects/';

    public function __construct()
    {
        $this->uploadDir = ROOT_DIR . '/uploads/projects/';
    }

    /** Get all projects with optional filters. */
    public function getAll(array $filters = []): array
    {
        $where  = [];
        $params = [];

        if (!empty($filters['category'])) {
            $where[]           = 'category = :cat';
            $params[':cat']    = $filters['category'];
        }
        if (!empty($filters['status'])) {
            $where[]           = 'status = :st';
            $params[':st']     = $filters['status'];
        }
        if (isset($filters['featured']) && $filters['featured'] !== '') {
            $where[]           = 'featured = :feat';
            $params[':feat']   = (int) $filters['featured'];
        }

        $sql = 'SELECT * FROM projects';
        if ($where) $sql .= ' WHERE ' . implode(' AND ', $where);
        $sql .= ' ORDER BY sort_order ASC, created_at DESC';

        $stmt = $this->db()->prepare($sql);
        $stmt->execute($params);
        $rows = $stmt->fetchAll();

        foreach ($rows as &$row) {
            $row['image_gallery'] = $row['image_gallery']
                ? json_decode($row['image_gallery'], true) : [];
        }
        return $rows;
    }

    /** Get featured + published projects (for homepage). */
    public function getFeatured(): array
    {
        $stmt = $this->db()->prepare(
            "SELECT * FROM projects WHERE featured = 1 AND status = 'published'
             ORDER BY sort_order ASC, created_at DESC"
        );
        $stmt->execute();
        $rows = $stmt->fetchAll();
        foreach ($rows as &$row) {
            $row['image_gallery'] = $row['image_gallery']
                ? json_decode($row['image_gallery'], true) : [];
        }
        return $rows;
    }

    /** Get a single project by ID. Returns null if not found. */
    public function getById(int $id): ?array
    {
        $stmt = $this->db()->prepare('SELECT * FROM projects WHERE id = :id');
        $stmt->execute([':id' => $id]);
        $row = $stmt->fetch();
        if (!$row) return null;
        $row['image_gallery'] = $row['image_gallery']
            ? json_decode($row['image_gallery'], true) : [];
        return $row;
    }

    /** Create a new project. Returns the new project ID. */
    public function create(array $data, ?array $mainFile = null, array $galleryFiles = []): int
    {
        $imageName = $mainFile ? $this->uploadImage($mainFile) : '';
        $gallery   = $this->uploadGallery($galleryFiles);

        $stmt = $this->db()->prepare("
            INSERT INTO projects
              (title, category, description, location, client, year,
               service_type, image_main, image_gallery, featured, status, sort_order)
            VALUES
              (:title, :category, :description, :location, :client, :year,
               :service_type, :image_main, :image_gallery, :featured, :status, :sort_order)
        ");
        $stmt->execute([
            ':title'       => $data['title'],
            ':category'    => $data['category']    ?? 'local',
            ':description' => $data['description'] ?? '',
            ':location'    => $data['location']    ?? '',
            ':client'      => $data['client']      ?? '',
            ':year'        => !empty($data['year']) ? $data['year'] : null,
            ':service_type'=> $data['service_type']?? '',
            ':image_main'  => $imageName,
            ':image_gallery'=> json_encode($gallery),
            ':featured'    => (int) ($data['featured'] ?? 0),
            ':status'      => $data['status']      ?? 'published',
            ':sort_order'  => (int) ($data['sort_order'] ?? 0),
        ]);
        return (int) $this->db()->lastInsertId();
    }

    /** Update a project by ID. Returns true on success. */
    public function update(int $id, array $data, ?array $mainFile = null, array $galleryFiles = [], array $removeGallery = []): bool
    {
        $existing = $this->getById($id);
        if (!$existing) return false;

        $imageName = $existing['image_main'];
        if ($mainFile && ($mainFile['error'] ?? UPLOAD_ERR_NO_FILE) === UPLOAD_ERR_OK) {
            $newImg = $this->uploadImage($mainFile);
            if ($newImg) {
                $this->deleteImage($existing['image_main']);
                $imageName = $newImg;
            }
        }

        $gallery = is_array($existing['image_gallery']) ? $existing['image_gallery'] : [];

        // Remove requested gallery images
        foreach ($removeGallery as $rem) {
            $this->deleteImage($rem);
            $gallery = array_values(array_filter($gallery, fn($g) => $g !== $rem));
        }

        // Add new gallery images
        $gallery = array_merge($gallery, $this->uploadGallery($galleryFiles));

        $stmt = $this->db()->prepare("
            UPDATE projects SET
              title = :title, category = :category, description = :description,
              location = :location, client = :client, year = :year,
              service_type = :service_type, image_main = :image_main,
              image_gallery = :image_gallery, featured = :featured,
              status = :status, sort_order = :sort_order
            WHERE id = :id
        ");
        $stmt->execute([
            ':title'       => $data['title']        ?? $existing['title'],
            ':category'    => $data['category']     ?? $existing['category'],
            ':description' => $data['description']  ?? $existing['description'],
            ':location'    => $data['location']     ?? $existing['location'],
            ':client'      => $data['client']       ?? $existing['client'],
            ':year'        => !empty($data['year']) ? $data['year'] : $existing['year'],
            ':service_type'=> $data['service_type'] ?? $existing['service_type'],
            ':image_main'  => $imageName,
            ':image_gallery'=> json_encode($gallery),
            ':featured'    => (int) ($data['featured'] ?? $existing['featured']),
            ':status'      => $data['status']       ?? $existing['status'],
            ':sort_order'  => (int) ($data['sort_order'] ?? $existing['sort_order']),
            ':id'          => $id,
        ]);
        return true;
    }

    /** Delete a project and its images. */
    public function delete(int $id): bool
    {
        $existing = $this->getById($id);
        if (!$existing) return false;

        $this->deleteImage($existing['image_main']);
        if (is_array($existing['image_gallery'])) {
            foreach ($existing['image_gallery'] as $gi) $this->deleteImage($gi);
        }

        $stmt = $this->db()->prepare('DELETE FROM projects WHERE id = :id');
        $stmt->execute([':id' => $id]);
        return true;
    }

    /** Toggle featured flag. */
    public function toggleFeatured(int $id): void
    {
        $this->db()->prepare('UPDATE projects SET featured = NOT featured WHERE id = :id')
            ->execute([':id' => $id]);
    }

    /** Toggle published/draft status. */
    public function toggleStatus(int $id): void
    {
        $this->db()->prepare("UPDATE projects SET status = IF(status='published','draft','published') WHERE id = :id")
            ->execute([':id' => $id]);
    }

    // ── Image helpers ──────────────────────────────────────────────

    public function uploadImage(array $file): string
    {
        $allowed = ['image/jpeg', 'image/png', 'image/webp', 'image/gif'];
        if (($file['error'] ?? UPLOAD_ERR_NO_FILE) !== UPLOAD_ERR_OK) return '';
        if (!in_array($file['type'] ?? '', $allowed)) return '';
        if (($file['size'] ?? 0) > 10 * 1024 * 1024) return '';

        if (!is_dir($this->uploadDir)) mkdir($this->uploadDir, 0755, true);

        $ext  = strtolower(pathinfo($file['name'], PATHINFO_EXTENSION));
        $name = uniqid('proj_', true) . '.' . $ext;
        return move_uploaded_file($file['tmp_name'], $this->uploadDir . $name) ? $name : '';
    }

    public function uploadGallery(array $files): array
    {
        $result = [];
        if (empty($files['name'])) return $result;

        $names = (array) $files['name'];
        $types = (array) ($files['type']     ?? []);
        $tmps  = (array) ($files['tmp_name'] ?? []);
        $errs  = (array) ($files['error']    ?? []);
        $sizes = (array) ($files['size']     ?? []);

        for ($i = 0; $i < count($names); $i++) {
            if (($errs[$i] ?? UPLOAD_ERR_NO_FILE) !== UPLOAD_ERR_OK) continue;
            $f = [
                'name'     => $names[$i] ?? '',
                'type'     => $types[$i] ?? '',
                'tmp_name' => $tmps[$i]  ?? '',
                'error'    => $errs[$i]  ?? UPLOAD_ERR_NO_FILE,
                'size'     => $sizes[$i] ?? 0,
            ];
            $n = $this->uploadImage($f);
            if ($n) $result[] = $n;
        }
        return $result;
    }

    private function deleteImage(string $filename): void
    {
        if (empty($filename)) return;
        $path = $this->uploadDir . $filename;
        if (file_exists($path)) @unlink($path);
    }
}
