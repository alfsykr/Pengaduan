<?php
/**
 * Admin Controller - Dukcapil Mandiri
 * Handles admin actions: view submissions, update status
 */
require_once __DIR__ . '/../bootstrap.php';

$action = $_GET['action'] ?? $_POST['action'] ?? '';

switch ($action) {
    case 'update_status':
        handleUpdateStatus();
        break;
    case 'reset_password':
        handleResetPassword();
        break;
    case 'update_admin_profile':
        handleUpdateAdminProfile();
        break;
    default:
        header('Location: ' . baseUrl('admin.php'));
        exit;
}

function handleUpdateStatus()
{
    requireAdmin();
    if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
        header('Location: ' . baseUrl('admin.php'));
        exit;
    }

    $pengajuanId = intval($_POST['pengajuan_id'] ?? 0);
    $newStatus = $_POST['status'] ?? '';
    $catatan = trim($_POST['catatan_admin'] ?? '');

    $validStatuses = ['pending', 'diproses', 'disetujui', 'ditolak'];
    if (!in_array($newStatus, $validStatuses, true)) {
        setFlash('danger', 'Status tidak valid.');
        header('Location: ' . baseUrl('admin.php'));
        exit;
    }

    $db = getDB();
    $stmt = $db->prepare('SELECT status FROM pengajuan_layanan WHERE id = ?');
    $stmt->execute([$pengajuanId]);
    $row = $stmt->fetch();
    if (!$row) {
        setFlash('danger', 'Pengajuan tidak ditemukan.');
        header('Location: ' . baseUrl('admin.php?page=permohonan'));
        exit;
    }

    $currentStatus = $row['status'];

    // Form catatan: status sama dengan saat ini — hanya perbarui catatan, jangan sentuh timestamp penyelesaian.
    if ($newStatus === $currentStatus) {
        $stmt = $db->prepare('UPDATE pengajuan_layanan SET catatan_admin = ? WHERE id = ?');
        $stmt->execute([$catatan, $pengajuanId]);
        setFlash('success', 'Catatan berhasil disimpan.');
        $redirect = $_POST['redirect'] ?? baseUrl('admin.php?page=permohonan');
        header('Location: ' . $redirect);
        exit;
    }

    if (in_array($currentStatus, ['disetujui', 'ditolak'], true)) {
        setFlash('danger', 'Pengajuan ini sudah selesai — status tidak dapat diubah lagi.');
        $redirect = $_POST['redirect'] ?? baseUrl('admin.php?page=arsip');
        header('Location: ' . $redirect);
        exit;
    }

    // Terima / tolak hanya setelah "Tandai Diproses".
    if (in_array($newStatus, ['disetujui', 'ditolak'], true) && $currentStatus !== 'diproses') {
        setFlash('warning', 'Tandai sebagai Diproses terlebih dahulu sebelum menerima atau menolak permohonan.');
        $redirect = $_POST['redirect'] ?? baseUrl('admin.php?page=permohonan');
        header('Location: ' . $redirect);
        exit;
    }

    if (in_array($newStatus, ['disetujui', 'ditolak'], true)) {
        $stmt = $db->prepare('UPDATE pengajuan_layanan SET status = ?, catatan_admin = ?, tanggal_diproses = NOW() WHERE id = ?');
        $stmt->execute([$newStatus, $catatan, $pengajuanId]);
    } else {
        $stmt = $db->prepare('UPDATE pengajuan_layanan SET status = ?, catatan_admin = ?, tanggal_diproses = NULL WHERE id = ?');
        $stmt->execute([$newStatus, $catatan, $pengajuanId]);
    }

    setFlash('success', 'Status pengajuan berhasil diperbarui.');
    $redirect = $_POST['redirect'] ?? baseUrl('admin.php?page=permohonan');
    header('Location: ' . $redirect);
    exit;
}

function handleResetPassword()
{
    requireAdmin();
    if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
        header('Location: ' . baseUrl('admin.php?page=settings'));
        exit;
    }

    $identifier = trim($_POST['user_identifier'] ?? '');

    if (empty($identifier)) {
        setFlash('danger', 'NIK atau Email pengguna harus diisi.');
        header('Location: ' . baseUrl('admin.php?page=settings'));
        exit;
    }

    $db = getDB();
    $stmt = $db->prepare("SELECT * FROM users WHERE (email = ? OR nik = ?) AND role = 'user'");
    $stmt->execute([$identifier, $identifier]);
    $targetUser = $stmt->fetch();

    if (!$targetUser) {
        setFlash('danger', 'Pengguna tidak ditemukan atau pengguna tersebut adalah admin.');
        header('Location: ' . baseUrl('admin.php?page=settings'));
        exit;
    }

    $defaultPassword = password_hash('user123', PASSWORD_DEFAULT);
    $updateStmt = $db->prepare("UPDATE users SET password = ? WHERE id = ?");
    $updateStmt->execute([$defaultPassword, $targetUser['id']]);

    setFlash('success', 'Kata sandi akun ' . $targetUser['nama_lengkap'] . ' berhasil direset menjadi "user123".');
    header('Location: ' . baseUrl('admin.php?page=settings'));
    exit;
}

function handleUpdateAdminProfile()
{
    requireAdmin();
    if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
        header('Location: ' . baseUrl('admin.php?page=settings'));
        exit;
    }

    $nama = trim((string) ($_POST['nama_lengkap'] ?? ''));
    $nik = trim((string) ($_POST['nik'] ?? ''));
    if ($nama === '' || $nik === '') {
        setFlash('danger', 'Nama dan NIP/NIK wajib diisi.');
        header('Location: ' . baseUrl('admin.php?page=settings'));
        exit;
    }
    if (strlen($nik) > 16) {
        setFlash('danger', 'NIP/NIK maksimal 16 karakter.');
        header('Location: ' . baseUrl('admin.php?page=settings'));
        exit;
    }

    $db = getDB();
    $uid = (int) $_SESSION['user_id'];

    $stmt = $db->prepare('SELECT id FROM users WHERE nik = ? AND id != ?');
    $stmt->execute([$nik, $uid]);
    if ($stmt->fetch()) {
        setFlash('danger', 'NIP/NIK sudah digunakan akun lain.');
        header('Location: ' . baseUrl('admin.php?page=settings'));
        exit;
    }

    $avatarFileName = null;
    if (!empty($_FILES['avatar']['name']) && isset($_FILES['avatar']['error']) && $_FILES['avatar']['error'] === UPLOAD_ERR_OK) {
        $file = $_FILES['avatar'];
        $ext = strtolower(pathinfo($file['name'], PATHINFO_EXTENSION));
        $allowed = ['jpg', 'jpeg', 'png', 'webp'];
        if (!in_array($ext, $allowed, true)) {
            setFlash('danger', 'Foto harus JPG, PNG, atau WebP.');
            header('Location: ' . baseUrl('admin.php?page=settings'));
            exit;
        }
        if ($file['size'] > 2 * 1024 * 1024) {
            setFlash('danger', 'Ukuran foto maksimal 2MB.');
            header('Location: ' . baseUrl('admin.php?page=settings'));
            exit;
        }
        $uploadDir = dirname(__DIR__, 2) . '/uploads/avatars/';
        if (!is_dir($uploadDir)) {
            mkdir($uploadDir, 0777, true);
        }

        $stmt = $db->prepare('SELECT avatar FROM users WHERE id = ?');
        $stmt->execute([$uid]);
        $old = $stmt->fetch();
        if (!empty($old['avatar'])) {
            $oldPath = $uploadDir . $old['avatar'];
            if (is_file($oldPath)) {
                @unlink($oldPath);
            }
        }

        $avatarFileName = 'admin_' . $uid . '_' . time() . '.' . $ext;
        if (!move_uploaded_file($file['tmp_name'], $uploadDir . $avatarFileName)) {
            setFlash('danger', 'Gagal menyimpan foto profil.');
            header('Location: ' . baseUrl('admin.php?page=settings'));
            exit;
        }
    }

    if ($avatarFileName !== null) {
        $stmt = $db->prepare('UPDATE users SET nama_lengkap = ?, nik = ?, avatar = ? WHERE id = ? AND role = ?');
        $stmt->execute([$nama, $nik, $avatarFileName, $uid, 'admin']);
    } else {
        $stmt = $db->prepare('UPDATE users SET nama_lengkap = ?, nik = ? WHERE id = ? AND role = ?');
        $stmt->execute([$nama, $nik, $uid, 'admin']);
    }

    $_SESSION['user_name'] = $nama;
    $_SESSION['user_nik'] = $nik;
    currentUser(true);
    setFlash('success', 'Profil admin berhasil diperbarui.');

    header('Location: ' . baseUrl('admin.php?page=settings'));
    exit;
}
