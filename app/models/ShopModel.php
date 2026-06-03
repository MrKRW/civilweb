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
            $item['additional_info_images'] = !empty($item['additional_info_images'])
                ? json_decode($item['additional_info_images'], true) : [];
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
        $item['additional_info_images'] = !empty($item['additional_info_images'])
            ? json_decode($item['additional_info_images'], true) : [];
        return $item;
    }

    /** Create a new shop item. Returns new ID. */
    public function create(array $data, ?array $mainFile = null, array $galleryFiles = [], array $additionalInfoFiles = []): int
    {
        $imageName = $mainFile ? $this->uploadImage($mainFile) : '';
        $gallery   = $this->uploadGallery($galleryFiles);
        $addlImgs  = $this->uploadGallery($additionalInfoFiles);

        $stmt = $this->db()->prepare("
            INSERT INTO shop_items
              (title, price, original_price, description, additional_info, additional_info_images,
               spec_sqft, spec_beds, spec_baths, spec_floors, spec_garages,
               category, image, gallery_images, status, sort_order)
            VALUES
              (:title, :price, :original_price, :description, :additional_info, :additional_info_images,
               :spec_sqft, :spec_beds, :spec_baths, :spec_floors, :spec_garages,
               :category, :image, :gallery_images, :status, :sort_order)
        ");
        $stmt->execute([
            ':title'                   => $data['title'],
            ':price'                   => (float) ($data['price'] ?? 0),
            ':original_price'          => !empty($data['original_price']) ? (float) $data['original_price'] : null,
            ':description'             => $data['description'] ?? '',
            ':additional_info'         => $data['additional_info'] ?? '',
            ':additional_info_images'  => json_encode($addlImgs),
            ':spec_sqft'               => $data['spec_sqft'] ?? '',
            ':spec_beds'               => $data['spec_beds'] ?? '',
            ':spec_baths'              => $data['spec_baths'] ?? '',
            ':spec_floors'             => $data['spec_floors'] ?? '',
            ':spec_garages'            => $data['spec_garages'] ?? '',
            ':category'                => $data['category']    ?? '',
            ':image'                   => $imageName,
            ':gallery_images'          => json_encode($gallery),
            ':status'                  => $data['status']      ?? 'published',
            ':sort_order'              => (int) ($data['sort_order'] ?? 0),
        ]);
        return (int) $this->db()->lastInsertId();
    }

    /** Update a shop item by ID. */
    public function update(int $id, array $data, ?array $mainFile = null, array $galleryFiles = [], array $removeGallery = [], array $additionalInfoFiles = [], array $removeAddlImgs = []): bool
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

        // Gallery
        $gallery = is_array($existing['gallery_images']) ? $existing['gallery_images'] : [];
        foreach ($removeGallery as $rem) {
            $this->deleteImage($rem);
            $gallery = array_values(array_filter($gallery, fn($g) => $g !== $rem));
        }
        $newGallery = $this->uploadGallery($galleryFiles);
        $gallery = array_slice(array_merge($gallery, $newGallery), 0, 4);

        // Additional Info Images
        $addlImgs = is_array($existing['additional_info_images']) ? $existing['additional_info_images'] : [];
        foreach ($removeAddlImgs as $rem) {
            $this->deleteImage($rem);
            $addlImgs = array_values(array_filter($addlImgs, fn($g) => $g !== $rem));
        }
        $newAddlImgs = $this->uploadGallery($additionalInfoFiles);
        $addlImgs = array_slice(array_merge($addlImgs, $newAddlImgs), 0, 6);

        $stmt = $this->db()->prepare("
            UPDATE shop_items SET
              title = :title, price = :price, original_price = :original_price,
              description = :description, additional_info = :additional_info,
              additional_info_images = :additional_info_images,
              spec_sqft = :spec_sqft, spec_beds = :spec_beds, spec_baths = :spec_baths,
              spec_floors = :spec_floors, spec_garages = :spec_garages,
              category = :category, image = :image,
              gallery_images = :gallery_images, status = :status, sort_order = :sort_order
            WHERE id = :id
        ");
        $stmt->execute([
            ':title'                  => $data['title']          ?? $existing['title'],
            ':price'                  => isset($data['price'])   ? (float) $data['price'] : $existing['price'],
            ':original_price'         => !empty($data['original_price']) ? (float) $data['original_price'] : null,
            ':description'            => $data['description']    ?? $existing['description'],
            ':additional_info'        => $data['additional_info'] ?? $existing['additional_info'],
            ':additional_info_images' => json_encode($addlImgs),
            ':spec_sqft'              => $data['spec_sqft']      ?? $existing['spec_sqft'],
            ':spec_beds'              => $data['spec_beds']      ?? $existing['spec_beds'],
            ':spec_baths'             => $data['spec_baths']     ?? $existing['spec_baths'],
            ':spec_floors'            => $data['spec_floors']    ?? $existing['spec_floors'],
            ':spec_garages'           => $data['spec_garages']   ?? $existing['spec_garages'],
            ':category'               => $data['category']       ?? $existing['category'],
            ':image'                  => $imageName,
            ':gallery_images'         => json_encode($gallery),
            ':status'                 => $data['status']         ?? $existing['status'],
            ':sort_order'             => (int) ($data['sort_order'] ?? $existing['sort_order']),
            ':id'                     => $id,
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

    // ── Reviews ────────────────────────────────────────────────────

    /** Get all reviews for a product, newest first. */
    public function getReviews(int $productId): array
    {
        $stmt = $this->db()->prepare(
            'SELECT id, reviewer_name, rating, review_text, created_at
             FROM product_reviews
             WHERE product_id = :pid
             ORDER BY created_at DESC'
        );
        $stmt->execute([':pid' => $productId]);
        return $stmt->fetchAll();
    }

    /** Count reviews for a product. */
    public function getReviewCount(int $productId): int
    {
        $stmt = $this->db()->prepare(
            'SELECT COUNT(*) FROM product_reviews WHERE product_id = :pid'
        );
        $stmt->execute([':pid' => $productId]);
        return (int) $stmt->fetchColumn();
    }

    /** Average rating for a product (0 if none). */
    public function getAverageRating(int $productId): float
    {
        $stmt = $this->db()->prepare(
            'SELECT AVG(rating) FROM product_reviews WHERE product_id = :pid'
        );
        $stmt->execute([':pid' => $productId]);
        return round((float) $stmt->fetchColumn(), 1);
    }

    /** Insert a new review. Returns the new review ID. */
    public function addReview(int $productId, string $name, string $email, int $rating, string $text): int
    {
        $rating = max(1, min(5, $rating));
        $stmt = $this->db()->prepare(
            'INSERT INTO product_reviews (product_id, reviewer_name, reviewer_email, rating, review_text)
             VALUES (:pid, :name, :email, :rating, :text)'
        );
        $stmt->execute([
            ':pid'    => $productId,
            ':name'   => $name,
            ':email'  => $email,
            ':rating' => $rating,
            ':text'   => $text,
        ]);
        return (int) $this->db()->lastInsertId();
    }
}
