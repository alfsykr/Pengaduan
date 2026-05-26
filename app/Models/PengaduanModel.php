<?php

namespace App\Models;

/**
 * Model untuk Pengaduan Warga
 */
class PengaduanModel
{
    /**
     * Get statistics for a specific user
     */
    public static function getStatsForUser(int $userId): array
    {
        $db = getDB();
        $stats = ['total' => 0, 'proses' => 0, 'selesai' => 0, 'ditolak' => 0];

        // Total
        $stmt = $db->prepare("SELECT COUNT(*) as c FROM pengaduan_warga WHERE user_id = ?");
        $stmt->execute([$userId]);
        $stats['total'] = (int) $stmt->fetch()['c'];

        // Stats by status
        foreach (['proses', 'selesai', 'ditolak'] as $s) {
            $stmt = $db->prepare("SELECT COUNT(*) as c FROM pengaduan_warga WHERE user_id = ? AND status = ?");
            $stmt->execute([$userId, $s]);
            $stats[$s] = (int) $stmt->fetch()['c'];
        }

        return $stats;
    }

    /**
     * Get statistics for admin (all users)
     */
    public static function getStatsForAdmin(): array
    {
        $db = getDB();
        $stats = ['total' => 0, 'proses' => 0, 'selesai' => 0, 'ditolak' => 0];

        $stats['total'] = (int) $db->query("SELECT COUNT(*) as c FROM pengaduan_warga")->fetch()['c'];

        foreach (['proses', 'selesai', 'ditolak'] as $s) {
            $stmt = $db->prepare("SELECT COUNT(*) as c FROM pengaduan_warga WHERE status = ?");
            $stmt->execute([$s]);
            $stats[$s] = (int) $stmt->fetch()['c'];
        }

        return $stats;
    }

    /**
     * List complaints for a specific user
     */
    public static function listForUser(int $userId, array $filters = []): array
    {
        $db = getDB();
        $where = "WHERE user_id = ?";
        $params = [$userId];

        if (!empty($filters['status'])) {
            $where .= " AND status = ?";
            $params[] = $filters['status'];
        }

        if (!empty($filters['search'])) {
            $where .= " AND (judul LIKE ? OR deskripsi LIKE ? OR lokasi LIKE ?)";
            $search = "%" . $filters['search'] . "%";
            $params[] = $search;
            $params[] = $search;
            $params[] = $search;
        }

        $page = max(1, intval($filters['page'] ?? 1));
        $perPage = 10;
        $offset = ($page - 1) * $perPage;

        $countStmt = $db->prepare("SELECT COUNT(*) as c FROM pengaduan_warga $where");
        $countStmt->execute($params);
        $total = (int) $countStmt->fetch()['c'];
        $totalPages = max(1, (int) ceil($total / $perPage));

        $stmt = $db->prepare("SELECT * FROM pengaduan_warga $where ORDER BY created_at DESC LIMIT $perPage OFFSET $offset");
        $stmt->execute($params);
        $items = $stmt->fetchAll();

        return compact('items', 'total', 'totalPages', 'page', 'perPage');
    }

    /**
     * List complaints for admin (all users)
     */
    public static function listForAdmin(array $filters = []): array
    {
        $db = getDB();
        $where = "WHERE 1=1";
        $params = [];

        if (!empty($filters['status'])) {
            $where .= " AND p.status = ?";
            $params[] = $filters['status'];
        }

        if (!empty($filters['kategori'])) {
            $where .= " AND p.kategori = ?";
            $params[] = $filters['kategori'];
        }

        if (!empty($filters['search'])) {
            $where .= " AND (p.judul LIKE ? OR p.deskripsi LIKE ? OR p.lokasi LIKE ? OR u.nama_lengkap LIKE ? OR p.no_pengaduan LIKE ?)";
            $search = "%" . $filters['search'] . "%";
            $params[] = $search;
            $params[] = $search;
            $params[] = $search;
            $params[] = $search;
            $params[] = $search;
        }

        $page = max(1, intval($filters['page'] ?? 1));
        $perPage = 10;
        $offset = ($page - 1) * $perPage;

        $countStmt = $db->prepare("SELECT COUNT(*) as c FROM pengaduan_warga p JOIN users u ON p.user_id = u.id $where");
        $countStmt->execute($params);
        $total = (int) $countStmt->fetch()['c'];
        $totalPages = max(1, (int) ceil($total / $perPage));

        $stmt = $db->prepare("
            SELECT p.*, u.nama_lengkap, u.nik, u.avatar 
            FROM pengaduan_warga p 
            JOIN users u ON p.user_id = u.id 
            $where 
            ORDER BY p.created_at DESC 
            LIMIT $perPage OFFSET $offset
        ");
        $stmt->execute($params);
        $items = $stmt->fetchAll();

        return compact('items', 'total', 'totalPages', 'page', 'perPage');
    }

    /**
     * Get detail of a specific complaint
     */
    public static function getDetail(int $id): ?array
    {
        $db = getDB();
        $stmt = $db->prepare("
            SELECT p.*, u.nama_lengkap, u.nik, u.email, u.no_hp, u.avatar 
            FROM pengaduan_warga p 
            JOIN users u ON p.user_id = u.id 
            WHERE p.id = ?
        ");
        $stmt->execute([$id]);
        $complaint = $stmt->fetch();

        if (!$complaint) {
            return null;
        }

        // Get photos
        $stmt = $db->prepare("SELECT * FROM foto_pengaduan_warga WHERE pengaduan_id = ?");
        $stmt->execute([$id]);
        $photos = $stmt->fetchAll();

        return compact('complaint', 'photos');
    }

    /**
     * Create a new complaint report
     */
    public static function create(int $userId, array $data, array $uploadedFiles): array
    {
        $db = getDB();
        
        try {
            $db->beginTransaction();

            $noPengaduan = 'PGD/' . date('Y') . '/' . date('md') . '/' . str_pad((string)rand(1, 9999), 4, '0', STR_PAD_LEFT);

            $stmt = $db->prepare("
                INSERT INTO pengaduan_warga (user_id, no_pengaduan, judul, kategori, deskripsi, lokasi, latitude, longitude, status) 
                VALUES (?, ?, ?, ?, ?, ?, ?, ?, 'proses')
            ");
            $stmt->execute([
                $userId,
                $noPengaduan,
                $data['judul'],
                $data['kategori'],
                $data['deskripsi'],
                $data['lokasi'],
                $data['latitude'] ?? null,
                $data['longitude'] ?? null
            ]);

            $pengaduanId = (int) $db->lastInsertId();

            // Save photos
            $uploadDir = BASE_PATH . '/uploads/pengaduan/';
            if (!is_dir($uploadDir)) {
                mkdir($uploadDir, 0777, true);
            }

            foreach ($uploadedFiles as $file) {
                if ($file['error'] !== UPLOAD_ERR_OK) {
                    continue;
                }

                $ext = strtolower(pathinfo($file['name'], PATHINFO_EXTENSION));
                $newName = 'pgd_' . $pengaduanId . '_' . uniqid() . '.' . $ext;
                
                if (move_uploaded_file($file['tmp_name'], $uploadDir . $newName)) {
                    $stmt = $db->prepare("
                        INSERT INTO foto_pengaduan_warga (pengaduan_id, nama_file, nama_asli) 
                        VALUES (?, ?, ?)
                    ");
                    $stmt->execute([$pengaduanId, $newName, $file['name']]);
                }
            }

            $db->commit();
            return ['success' => true, 'id' => $pengaduanId, 'message' => 'Laporan pengaduan berhasil dikirim!'];
        } catch (\Exception $e) {
            $db->rollBack();
            return ['success' => false, 'message' => 'Gagal membuat laporan: ' . $e->getMessage()];
        }
    }

    /**
     * Update status
     */
    public static function updateStatus(int $id, string $status, ?string $catatan): bool
    {
        $db = getDB();
        $stmt = $db->prepare("UPDATE pengaduan_warga SET status = ?, catatan_admin = ? WHERE id = ?");
        return $stmt->execute([$status, $catatan, $id]);
    }
}
