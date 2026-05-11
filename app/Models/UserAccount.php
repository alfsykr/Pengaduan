<?php

namespace App\Models;

/**
 * Profil & pengaturan akun pengguna.
 */
class UserAccount
{
    public static function findById(int $userId): ?array
    {
        $db = getDB();
        $stmt = $db->prepare('SELECT * FROM users WHERE id = ?');
        $stmt->execute([$userId]);
        $row = $stmt->fetch();

        return $row ?: null;
    }

    /**
     * Pengaturan akun warga: email tidak diubah di sini (mengikuti akun login).
     *
     * @throws \InvalidArgumentException Jika NIK dipakai akun lain
     */
    public static function updateSettings(int $userId, array $post): void
    {
        $db = getDB();
        $nik = trim((string) ($post['nik'] ?? ''));
        if ($nik !== '') {
            $chk = $db->prepare('SELECT id FROM users WHERE nik = ? AND id != ?');
            $chk->execute([$nik, $userId]);
            if ($chk->fetch()) {
                throw new \InvalidArgumentException('NIK sudah digunakan akun lain.');
            }
        }

        $stmt = $db->prepare('UPDATE users SET nama_lengkap = ?, nik = ?, no_hp = ?, alamat = ?, rt = ?, rw = ?, kelurahan = ?, kecamatan = ?, kota = ?, provinsi = ?, kode_pos = ?, alamat_domisili = ? WHERE id = ? AND role = ?');
        $stmt->execute([
            trim((string) ($post['nama_lengkap'] ?? '')),
            $nik,
            trim((string) ($post['no_hp'] ?? '')),
            trim((string) ($post['alamat'] ?? '')),
            trim((string) ($post['rt'] ?? '')),
            trim((string) ($post['rw'] ?? '')),
            trim((string) ($post['kelurahan'] ?? '')),
            trim((string) ($post['kecamatan'] ?? '')),
            trim((string) ($post['kota'] ?? '')),
            trim((string) ($post['provinsi'] ?? '')),
            trim((string) ($post['kode_pos'] ?? '')),
            trim((string) ($post['alamat_domisili'] ?? '')),
            $userId,
            'user',
        ]);
    }

    /** @return string|null Nama file avatar baru, atau null jika tidak ada unggahan */
    public static function saveUserAvatarIfUploaded(int $userId): ?string
    {
        if (empty($_FILES['avatar']['name'])) {
            return null;
        }
        $err = (int) ($_FILES['avatar']['error'] ?? UPLOAD_ERR_NO_FILE);
        if ($err !== UPLOAD_ERR_OK) {
            return null;
        }

        $file = $_FILES['avatar'];
        $ext = strtolower(pathinfo((string) $file['name'], PATHINFO_EXTENSION));
        $allowed = ['jpg', 'jpeg', 'png', 'webp'];
        if (!in_array($ext, $allowed, true)) {
            throw new \InvalidArgumentException('Foto harus JPG, PNG, atau WebP.');
        }
        if (($file['size'] ?? 0) > 2 * 1024 * 1024) {
            throw new \InvalidArgumentException('Ukuran foto maksimal 2MB.');
        }

        $baseDir = dirname(__DIR__, 2) . '/uploads/avatars/';
        if (!is_dir($baseDir)) {
            mkdir($baseDir, 0777, true);
        }

        $db = getDB();
        $stmt = $db->prepare('SELECT avatar FROM users WHERE id = ? AND role = ?');
        $stmt->execute([$userId, 'user']);
        $old = $stmt->fetch();
        if (!empty($old['avatar'])) {
            $p = $baseDir . $old['avatar'];
            if (is_file($p)) {
                @unlink($p);
            }
        }

        $filename = 'user_' . $userId . '_' . time() . '.' . $ext;
        if (!move_uploaded_file((string) $file['tmp_name'], $baseDir . $filename)) {
            throw new \RuntimeException('Gagal menyimpan foto profil.');
        }

        $db->prepare('UPDATE users SET avatar = ? WHERE id = ? AND role = ?')->execute([$filename, $userId, 'user']);

        return $filename;
    }

    public static function removeUserAvatar(int $userId): void
    {
        $db = getDB();
        $stmt = $db->prepare('SELECT avatar FROM users WHERE id = ? AND role = ?');
        $stmt->execute([$userId, 'user']);
        $row = $stmt->fetch();
        if (empty($row['avatar'])) {
            return;
        }
        $baseDir = dirname(__DIR__, 2) . '/uploads/avatars/';
        $p = $baseDir . $row['avatar'];
        if (is_file($p)) {
            @unlink($p);
        }
        $db->prepare('UPDATE users SET avatar = NULL WHERE id = ? AND role = ?')->execute([$userId, 'user']);
    }

    /** @return array{ok: bool, message?: string} */
    public static function changePassword(int $userId, string $current, string $new, string $confirm): array
    {
        $db = getDB();
        $stmt = $db->prepare('SELECT password FROM users WHERE id = ?');
        $stmt->execute([$userId]);
        $row = $stmt->fetch();
        if (!$row || !password_verify($current, $row['password'])) {
            return ['ok' => false, 'message' => 'Password lama tidak sesuai.'];
        }
        if (strlen($new) < 6) {
            return ['ok' => false, 'message' => 'Password baru minimal 6 karakter.'];
        }
        if ($new !== $confirm) {
            return ['ok' => false, 'message' => 'Konfirmasi password tidak cocok.'];
        }
        $hash = password_hash($new, PASSWORD_DEFAULT);
        $db->prepare('UPDATE users SET password = ? WHERE id = ?')->execute([$hash, $userId]);

        return ['ok' => true];
    }

    public static function saveProfil(int $userId, array $post): void
    {
        $domisiliSame = ($post['alamat_domisili_same'] ?? '') === '1';
        $db = getDB();
        $stmt = $db->prepare('UPDATE users SET
            nama_lengkap=?, nik=?, jenis_kelamin=?, tempat_lahir=?, tanggal_lahir=?,
            agama=?, status_perkawinan=?, pekerjaan=?, pendidikan=?, kewarganegaraan=?,
            no_hp=?, email=?,
            alamat=?, rt=?, rw=?, kelurahan=?, kecamatan=?, kota=?, provinsi=?, kode_pos=?,
            alamat_domisili=?,
            no_kk=?, nama_kepala_keluarga=?
            WHERE id=?');
        $stmt->execute([
            $post['nama_lengkap'] ?? '',
            $post['nik'] ?? '',
            $post['jenis_kelamin'] ?? null,
            $post['tempat_lahir'] ?? '',
            !empty($post['tanggal_lahir']) ? $post['tanggal_lahir'] : null,
            $post['agama'] ?? null,
            $post['status_perkawinan'] ?? null,
            $post['pekerjaan'] ?? '',
            $post['pendidikan'] ?? '',
            $post['kewarganegaraan'] ?? 'WNI',
            $post['no_hp'] ?? '',
            $post['email'] ?? '',
            $post['alamat'] ?? '',
            $post['rt'] ?? '',
            $post['rw'] ?? '',
            $post['kelurahan'] ?? '',
            $post['kecamatan'] ?? '',
            $post['kota'] ?? '',
            $post['provinsi'] ?? '',
            $post['kode_pos'] ?? '',
            $domisiliSame ? '' : ($post['alamat_domisili'] ?? ''),
            $post['no_kk'] ?? '',
            $post['nama_kepala_keluarga'] ?? '',
            $userId,
        ]);
    }

    /**
     * Dokumen KTP/KK terbaru untuk halaman profil.
     * @return array{ktpDoc: ?array, kkDoc: ?array}
     */
    public static function profileDocuments(int $userId): array
    {
        $db = getDB();
        $stmt = $db->prepare('SELECT d.* FROM dokumen d JOIN pengajuan_layanan p ON p.id = d.pengajuan_id WHERE p.user_id = ? ORDER BY d.uploaded_at DESC');
        $stmt->execute([$userId]);
        $allDocs = $stmt->fetchAll();
        $ktpDoc = null;
        $kkDoc = null;
        foreach ($allDocs as $doc) {
            $jenisLower = strtolower($doc['jenis_dokumen'] ?? '');
            if ($ktpDoc === null && strpos($jenisLower, 'ktp') !== false) {
                $ktpDoc = $doc;
            }
            if ($kkDoc === null && (strpos($jenisLower, 'kk') !== false || strpos($jenisLower, 'kartu keluarga') !== false)) {
                $kkDoc = $doc;
            }
        }

        return compact('ktpDoc', 'kkDoc');
    }

    /** @return array{filled: int, completeness: float} */
    public static function profileCompleteness(array $user): array
    {
        $profileFields = ['nama_lengkap', 'nik', 'jenis_kelamin', 'tempat_lahir', 'tanggal_lahir', 'agama', 'status_perkawinan', 'pekerjaan', 'no_hp', 'email', 'alamat', 'rt', 'rw', 'kelurahan', 'kecamatan', 'kota', 'provinsi', 'no_kk', 'nama_kepala_keluarga'];
        $filled = 0;
        foreach ($profileFields as $f) {
            if (!empty($user[$f])) {
                $filled++;
            }
        }
        $completeness = round(($filled / count($profileFields)) * 100);

        return compact('filled', 'completeness');
    }
}
