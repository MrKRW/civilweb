<?php
/**
 * CivilLanka MVC – BlogModel
 * All DB logic for the blog_posts table.
 */
require_once __DIR__ . '/../core/Model.php';

class BlogModel extends Model
{
    private string $uploadDir;
    private string $uploadUrl = 'uploads/blog/';

    public function __construct()
    {
        $this->uploadDir = ROOT_DIR . '/uploads/blog/';
    }

    // ── Slug helper ──────────────────────────────────────────────────

    private function generateSlug(string $title): string
    {
        $slug = strtolower(trim($title));
        $slug = preg_replace('/[^a-z0-9\s-]/', '', $slug);
        $slug = preg_replace('/[\s-]+/', '-', $slug);
        return $slug . '-' . uniqid();
    }

    // ── Read methods ─────────────────────────────────────────────────

    /** Get all posts with optional filters (status, category). */
    public function getAll(array $filters = []): array
    {
        $where  = [];
        $params = [];

        if (!empty($filters['status'])) {
            $where[]          = 'status = :st';
            $params[':st']    = $filters['status'];
        }
        if (!empty($filters['category'])) {
            $where[]          = 'category = :cat';
            $params[':cat']   = $filters['category'];
        }

        $sql = 'SELECT * FROM blog_posts';
        if ($where) $sql .= ' WHERE ' . implode(' AND ', $where);
        $sql .= ' ORDER BY sort_order ASC, created_at DESC';

        $stmt = $this->db()->prepare($sql);
        $stmt->execute($params);
        return $stmt->fetchAll();
    }

    /** Get only published posts for the public blog page. */
    public function getPublished(): array
    {
        $stmt = $this->db()->prepare(
            "SELECT * FROM blog_posts WHERE status = 'published'
             ORDER BY sort_order ASC, created_at DESC"
        );
        $stmt->execute();
        return $stmt->fetchAll();
    }

    /** Get a single post by ID. Returns null if not found. */
    public function getById(int $id): ?array
    {
        $stmt = $this->db()->prepare('SELECT * FROM blog_posts WHERE id = :id');
        $stmt->execute([':id' => $id]);
        $row = $stmt->fetch();
        return $row ?: null;
    }

    /** Count all published posts. */
    public function countPublished(): int
    {
        $stmt = $this->db()->prepare("SELECT COUNT(*) FROM blog_posts WHERE status = 'published'");
        $stmt->execute();
        return (int) $stmt->fetchColumn();
    }

    // ── Write methods ────────────────────────────────────────────────

    /** Create a new blog post. Returns the new post ID. */
    public function create(array $data, ?array $imageFile = null): int
    {
        $imageName = ($imageFile && ($imageFile['error'] ?? UPLOAD_ERR_NO_FILE) === UPLOAD_ERR_OK)
            ? $this->uploadImage($imageFile) : '';

        $stmt = $this->db()->prepare("
            INSERT INTO blog_posts
              (title, slug, category, excerpt, content, image, status, sort_order)
            VALUES
              (:title, :slug, :category, :excerpt, :content, :image, :status, :sort_order)
        ");
        $stmt->execute([
            ':title'      => $data['title'],
            ':slug'       => $this->generateSlug($data['title']),
            ':category'   => $data['category']   ?? '',
            ':excerpt'    => $data['excerpt']     ?? '',
            ':content'    => $data['content']     ?? '',
            ':image'      => $imageName,
            ':status'     => $data['status']      ?? 'published',
            ':sort_order' => (int) ($data['sort_order'] ?? 0),
        ]);
        return (int) $this->db()->lastInsertId();
    }

    /** Update a blog post by ID. Returns true on success. */
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
            UPDATE blog_posts SET
              title = :title, category = :category, excerpt = :excerpt,
              content = :content, image = :image, status = :status, sort_order = :sort_order
            WHERE id = :id
        ");
        $stmt->execute([
            ':title'      => $data['title']      ?? $existing['title'],
            ':category'   => $data['category']   ?? $existing['category'],
            ':excerpt'    => $data['excerpt']     ?? $existing['excerpt'],
            ':content'    => $data['content']    ?? $existing['content'],
            ':image'      => $imageName,
            ':status'     => $data['status']     ?? $existing['status'],
            ':sort_order' => (int) ($data['sort_order'] ?? $existing['sort_order']),
            ':id'         => $id,
        ]);
        return true;
    }

    /** Delete a post and its cover image. */
    public function delete(int $id): bool
    {
        $existing = $this->getById($id);
        if (!$existing) return false;

        $this->deleteImage($existing['image']);
        $this->db()->prepare('DELETE FROM blog_posts WHERE id = :id')->execute([':id' => $id]);
        return true;
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
        $name = uniqid('blog_', true) . '.' . $ext;
        return move_uploaded_file($file['tmp_name'], $this->uploadDir . $name) ? $name : '';
    }

    private function deleteImage(?string $filename): void
    {
        if (empty($filename)) return;
        $path = $this->uploadDir . $filename;
        if (file_exists($path)) @unlink($path);
    }

    // ── Orphan cleanup ─────────────────────────────────────

    /**
     * Scan /uploads/blog/content/ and delete any image file whose filename
     * does not appear in any rich-text content field across all tables.
     * Returns the number of files deleted.
     */
    public function cleanupContentImages(): int
    {
        $contentDir = ROOT_DIR . '/uploads/blog/content/';
        if (!is_dir($contentDir)) return 0;

        $files = array_filter(
            glob($contentDir . '*') ?: [],
            fn($f) => is_file($f)
        );
        if (empty($files)) return 0;

        // Collect all rich-text content from every table
        $allContent = '';
        $queries = [
            'SELECT content                      FROM blog_posts',
            'SELECT description                  FROM projects',
            'SELECT description, additional_info FROM shop_items',
        ];
        foreach ($queries as $sql) {
            try {
                $rows = $this->db()->query($sql)->fetchAll(\PDO::FETCH_NUM);
                foreach ($rows as $row) {
                    $allContent .= implode(' ', array_map('strval', $row));
                }
            } catch (\Throwable $e) {
                // Table may not exist — skip silently
            }
        }

        $deleted = 0;
        foreach ($files as $filePath) {
            if (strpos($allContent, basename($filePath)) === false) {
                @unlink($filePath);
                $deleted++;
            }
        }
        return $deleted;
    }
}
