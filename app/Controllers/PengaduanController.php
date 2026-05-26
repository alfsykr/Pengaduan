<?php

namespace App\Controllers;

require_once __DIR__ . '/../bootstrap.php';

use App\Models\PengaduanModel;

$action = $_GET['action'] ?? $_POST['action'] ?? '';

switch ($action) {
    case 'create':
        handleCreate();
        break;
    case 'update_status':
        handleUpdateStatus();
        break;
    default:
        header('Location: ' . baseUrl('pengaduan.php'));
        exit;
}

function handleCreate()
{
    requireLogin();
    if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
        header('Location: ' . baseUrl('pengaduan.php'));
        exit;
    }

    $judul = trim($_POST['judul'] ?? '');
    $kategori = trim($_POST['kategori'] ?? '');
    $deskripsi = trim($_POST['deskripsi'] ?? '');
    $lokasi = trim($_POST['lokasi'] ?? '');
    $latitude = $_POST['latitude'] ?? null;
    $longitude = $_POST['longitude'] ?? null;

    if ($judul === '' || $kategori === '' || $deskripsi === '' || $lokasi === '') {
        setFlash('danger', 'Semua field wajib diisi.');
        header('Location: ' . baseUrl('buat_pengaduan.php'));
        exit;
    }

    // Sanitize lat/lng (nullable floats)
    $latitude = ($latitude !== null && $latitude !== '') ? floatval($latitude) : null;
    $longitude = ($longitude !== null && $longitude !== '') ? floatval($longitude) : null;

    // Format uploaded files
    $files = [];
    if (!empty($_FILES['foto_bukti'])) {
        $uploaded = $_FILES['foto_bukti'];
        // If it's multiple files
        if (is_array($uploaded['name'])) {
            for ($i = 0; $i < count($uploaded['name']); $i++) {
                if ($uploaded['name'][$i] !== '') {
                    $files[] = [
                        'name' => $uploaded['name'][$i],
                        'type' => $uploaded['type'][$i],
                        'tmp_name' => $uploaded['tmp_name'][$i],
                        'error' => $uploaded['error'][$i],
                        'size' => $uploaded['size'][$i],
                    ];
                }
            }
        } else {
            // Single file
            if ($uploaded['name'] !== '') {
                $files[] = $uploaded;
            }
        }
    }

    // Validate file sizes and types
    $allowed = ['jpg', 'jpeg', 'png', 'webp'];
    foreach ($files as $file) {
        if ($file['error'] !== UPLOAD_ERR_OK) {
            continue;
        }
        $ext = strtolower(pathinfo($file['name'], PATHINFO_EXTENSION));
        if (!in_array($ext, $allowed, true)) {
            setFlash('danger', 'Foto bukti harus berupa file JPG, PNG, atau WebP.');
            header('Location: ' . baseUrl('buat_pengaduan.php'));
            exit;
        }
        if ($file['size'] > 5 * 1024 * 1024) {
            setFlash('danger', 'Ukuran foto bukti maksimal 5MB per file.');
            header('Location: ' . baseUrl('buat_pengaduan.php'));
            exit;
        }
    }

    $userId = (int) $_SESSION['user_id'];
    $data = compact('judul', 'kategori', 'deskripsi', 'lokasi', 'latitude', 'longitude');

    $result = PengaduanModel::create($userId, $data, $files);

    if ($result['success']) {
        setFlash('success', $result['message']);
        header('Location: ' . baseUrl('pengaduan.php'));
    } else {
        setFlash('danger', $result['message']);
        header('Location: ' . baseUrl('buat_pengaduan.php'));
    }
    exit;
}

function handleUpdateStatus()
{
    requireAdmin();
    if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
        header('Location: ' . baseUrl('admin.php?page=pengaduan'));
        exit;
    }

    $id = intval($_POST['pengaduan_id'] ?? 0);
    $status = $_POST['status'] ?? '';
    $catatan = trim($_POST['catatan_admin'] ?? '');

    $validStatuses = ['proses', 'selesai', 'ditolak'];
    if (!in_array($status, $validStatuses, true)) {
        setFlash('danger', 'Status tidak valid.');
        header('Location: ' . baseUrl('admin.php?page=pengaduan'));
        exit;
    }

    if ($id <= 0) {
        setFlash('danger', 'ID pengaduan tidak valid.');
        header('Location: ' . baseUrl('admin.php?page=pengaduan'));
        exit;
    }

    $success = PengaduanModel::updateStatus($id, $status, $catatan);

    if ($success) {
        setFlash('success', 'Status pengaduan berhasil diperbarui.');
    } else {
        setFlash('danger', 'Gagal memperbarui status pengaduan.');
    }

    header('Location: ' . baseUrl('admin.php?page=detail_pengaduan&id=' . $id));
    exit;
}
