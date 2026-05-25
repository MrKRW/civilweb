<?php
/**
 * CivilLanka MVC – ShopModel
 * All DB logic for the shop_items table.
 */
require_once __DIR__ . '/../core/Model.php';

class ShopModel extends Model
{
    private string $uploadDir;

    public function __construct()
    {
        $this->uploadDir = ROOT_DIR . '/uploads/shop/';
    }

    /** Get all shop items ordered by sort_order. */
    public function getAll(): array
    {
        $stmt = $this->db()->prepare('SELECT * FROM shop_items ORDER BY sort_order ASC, created_at DESC');
        $stmt->execute();
        $items = $stmt->fetchAll();
        foreach ($items as &$item) {
            $item['gallery_images'] = !empty($item['gallery_images'])
                ? json_decode($item['gallery_images'], true) : [];
        }
        return $items;
    }

    /** Get a single shop item by ID. Returns null if not found. */
    public function getById(int $id): ?array
    {
        $stmt = $this->db()->prepare('SELECT * FROM shop_items WHERE id = :id');
        $stmt->execute([':id' => $id]);
        $item = $stmt->fetch();
        if (!$item) return null;
        $item['gallery_images'] = !empty($item['gallery_images'])
            ? json_decode($item['gallery_images'], true) : [];
        return $item;
    }

    /** Create a new shop item. Returns new ID. */
    public function create(array $data, ?array $mainFile = null, array $galleryFiles = []): int
    {
        $imageName = $mainFile ? $this->uploadImage($mainFile) : '';
        $gallery   = $this->uploadGallery($galleryFiles);

        $stmt = $this->db()->prepare("
            INSERT INTO shop_items
              (title, price, original_price, description, category, image, gallery_images, status, sort_order)
            VALUES
              (:title, :price, :original_price, :description, :category, :image, :gallery_images, :status, :sort_order)
        ");
        $stmt->execute([
            ':title'          => $data['title'],
            ':price'          => (float) ($data['price'] ?? 0),
            ':original_price' => !empty($data['original_price']) ? (float) $data['original_price'] : null,
            ':description'    => $data['description'] ?? '',
            ':category'       => $data['category']    ?? '',
            ':image'          => $imageName,
            ':gallery_images' => json_encode($gallery),
            ':status'         => $data['status']      ?? 'published',
            ':sort_order'     => (int) ($data['sort_order'] ?? 0),
        ]);
        return (int) $this->db()->lastInsertId();
    }

    /** Update a shop item by ID. */
    public function update(int $id, array $data, ?array $mainFile = null, array $galleryFiles = [], array $removeGallery = []): bool
    {
        $existing = $this->getById($id);
        if (!$existing) return false;

        $imageName = $existing['image'];
        if ($mainFile && ($mainFile['error'] ?? UPLOAD_ERR_NO_FILE) === UPLOAD_ERR_OK) {
            $newImg = $this->uploadImage($mainFile);
            if ($newImg) {
                $this->deleteImage($existing['image']);
                $imageName = $newImg;
            }
        }

        $gallery = is_array($existing['gallery_images']) ? $existing['gallery_images'] : [];
        foreach ($removeGallery as $rem) {
            $this->deleteImage($rem);
            $gallery = array_values(array_filter($gallery, fn($g) => $g !== $rem));
        }
        $newGallery = $this->uploadGallery($galleryFiles);
        $gallery = array_slice(array_merge($gallery, $newGallery), 0, 4);

        $stmt = $this->db()->prepare("
            UPDATE shop_items SET
              title = :title, price = :price, original_price = :original_price,
              description = :description, category = :category, image = :image,
              gallery_images = :gallery_images, status = :status, sort_order = :sort_order
            WHERE id = :id
        ");
        $stmt->execute([
            ':title'          => $data['title']          ?? $existing['title'],
            ':price'          => isset($data['price'])   ? (float) $data['price'] : $existing['price'],
            ':original_price' => !empty($data['original_price']) ? (float) $data['original_price'] : null,
            ':description'    => $data['description']    ?? $existing['description'],
            ':category'       => $data['category']       ?? $existing['category'],
            ':image'          => $imageName,
            ':gallery_images' => json_encode($gallery),
            ':status'         => $data['status']         ?? $existing['status'],
            ':sort_order'     => (int) ($data['sort_order'] ?? $existing['sort_order']),
            ':id'             => $id,
        ]);
        return true;
    }

    /** Delete a shop item and its images. */
    public function delete(int $id): bool
    {
        $existing = $this->getById($id);
        if (!$existing) return false;

        $this->deleteImage($existing['image']);
        if (is_array($existing['gallery_images'])) {
            foreach ($existing['gallery_images'] as $gi) $this->deleteImage($gi);
        }

        $this->db()->prepare('DELETE FROM shop_items WHERE id = :id')->execute([':id' => $id]);
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
        $name = uniqid('shop_', true) . '.' . $ext;
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

    private function deleteImage(?string $filename): void
    {
        if (empty($filename)) return;
        $path = $this->uploadDir . $filename;
        if (file_exists($path)) @unlink($path);
    }
}
