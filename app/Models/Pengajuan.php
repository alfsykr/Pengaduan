<?php

namespace App\Models;

/**
 * Query & aggregation untuk pengajuan layanan (dashboard, riwayat, detail).
 */
class Pengajuan
{
    /** @return array{stats: array<string,int>, recentSubmissions: array, totalSubmissions: int} */
    public static function dashboardForUser(int $userId): array
    {
        $db = getDB();
        $stats = [];
        foreach (['pending', 'diproses', 'disetujui', 'ditolak'] as $s) {
            $stmt = $db->prepare('SELECT COUNT(*) as total FROM pengajuan_layanan WHERE user_id = ? AND status = ?');
            $stmt->execute([$userId, $s]);
            $stats[$s] = (int) $stmt->fetch()['total'];
        }
        $stmt = $db->prepare("SELECT * FROM pengajuan_layanan WHERE user_id = ? AND status != 'draft' ORDER BY tanggal_pengajuan DESC LIMIT 5");
        $stmt->execute([$userId]);
        $recentSubmissions = $stmt->fetchAll();
        $stmt = $db->prepare("SELECT COUNT(*) as total FROM pengajuan_layanan WHERE user_id = ? AND status != 'draft'");
        $stmt->execute([$userId]);
        $totalSubmissions = (int) $stmt->fetch()['total'];

        return compact('stats', 'recentSubmissions', 'totalSubmissions');
    }

    /**
     * @return array{submissions: array, total: int, totalPages: int, page: int, perPage: int, offset: int, statusFilter: string}
     */
    public static function riwayatPageForUser(int $userId, array $query): array
    {
        $db = getDB();
        $statusFilter = $query['status'] ?? '';
        $where = 'WHERE user_id = ? AND status != \'draft\'';
        $params = [$userId];
        if ($statusFilter && in_array($statusFilter, ['pending', 'diproses', 'disetujui', 'ditolak'], true)) {
            $where .= ' AND status = ?';
            $params[] = $statusFilter;
        }
        $page = max(1, intval($query['page'] ?? 1));
        $perPage = 10;
        $offset = ($page - 1) * $perPage;

        $stmt = $db->prepare("SELECT COUNT(*) as total FROM pengajuan_layanan $where");
        $stmt->execute($params);
        $total = (int) $stmt->fetch()['total'];
        $totalPages = (int) ceil($total / $perPage);

        $stmt = $db->prepare("SELECT * FROM pengajuan_layanan $where ORDER BY tanggal_pengajuan DESC LIMIT $perPage OFFSET $offset");
        $stmt->execute($params);
        $submissions = $stmt->fetchAll();

        return compact('submissions', 'total', 'totalPages', 'page', 'perPage', 'offset', 'statusFilter');
    }

    /**
     * @return array<string, mixed>|null null jika tidak ditemukan / tidak berhak
     */
    public static function detailContext(int $id, bool $isAdminView, int $sessionUserId): ?array
    {
        $db = getDB();
        if ($isAdminView) {
            $stmt = $db->prepare('SELECT p.*, u.nama_lengkap, u.nik, u.email, u.no_hp, u.alamat, u.tempat_lahir, u.tanggal_lahir, u.avatar AS pemohon_avatar, u.nama_kepala_keluarga AS pemohon_nama_kepala_keluarga, u.no_kk AS pemohon_no_kk FROM pengajuan_layanan p JOIN users u ON p.user_id = u.id WHERE p.id = ?');
            $stmt->execute([$id]);
        } else {
            $stmt = $db->prepare('SELECT p.*, u.nama_lengkap, u.nik, u.email, u.no_hp, u.alamat, u.tempat_lahir, u.tanggal_lahir, u.avatar AS pemohon_avatar, u.nama_kepala_keluarga AS pemohon_nama_kepala_keluarga, u.no_kk AS pemohon_no_kk FROM pengajuan_layanan p JOIN users u ON p.user_id = u.id WHERE p.id = ? AND p.user_id = ?');
            $stmt->execute([$id, $sessionUserId]);
        }
        $pengajuan = $stmt->fetch();
        if (!$pengajuan) {
            return null;
        }

        $jenis = $pengajuan['jenis_layanan'];
        $dataKeluarga = null;
        $anggota = [];
        $dataPindah = null;
        if ($jenis === 'kk') {
            $stmt = $db->prepare('SELECT * FROM data_keluarga WHERE pengajuan_id = ?');
            $stmt->execute([$id]);
            $dataKeluarga = $stmt->fetch();
            if ($dataKeluarga) {
                $stmt = $db->prepare('SELECT * FROM anggota_keluarga WHERE data_keluarga_id = ?');
                $stmt->execute([$dataKeluarga['id']]);
                $anggota = $stmt->fetchAll();
            }
        } elseif ($jenis === 'pindah') {
            $stmt = $db->prepare('SELECT * FROM data_pindah WHERE pengajuan_id = ?');
            $stmt->execute([$id]);
            $dataPindah = $stmt->fetch();
        }
        $stmt = $db->prepare('SELECT * FROM dokumen WHERE pengajuan_id = ?');
        $stmt->execute([$id]);
        $dokumen = $stmt->fetchAll();

        $adminBackPage = in_array($pengajuan['status'], ['disetujui', 'ditolak'], true) ? 'arsip' : 'permohonan';

        return compact('pengajuan', 'jenis', 'dataKeluarga', 'anggota', 'dataPindah', 'dokumen', 'isAdminView', 'adminBackPage');
    }
}
