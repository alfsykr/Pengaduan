<?php
/**
 * Pengajuan Controller - Dukcapil Mandiri
 * Handles all submission CRUD operations
 */
require_once __DIR__ . '/../bootstrap.php';

$action = $_GET['action'] ?? $_POST['action'] ?? '';

switch ($action) {
    case 'create':
        handleCreate();
        break;
    case 'save_step':
        handleSaveStep();
        break;
    case 'submit':
        handleSubmit();
        break;
    case 'upload_dokumen':
        handleUploadDokumen();
        break;
    case 'delete_dokumen':
        handleDeleteDokumen();
        break;
    case 'replace_dokumen':
        handleReplaceDokumen();
        break;
    case 'delete_profile_dokumen':
        handleDeleteProfileDokumen();
        break;
    case 'upload_profile_dokumen':
        handleUploadProfileDokumen();
        break;
    default:
        header('Location: ' . baseUrl('index.php'));
        exit;
}

function handleCreate()
{
    requireLogin();
    if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
        header('Location: ' . baseUrl('layanan.php'));
        exit;
    }

    $jenisLayanan = $_POST['jenis_layanan'] ?? '';
    if (!in_array($jenisLayanan, ['kk', 'ktp', 'pindah'])) {
        setFlash('danger', 'Jenis layanan tidak valid.');
        header('Location: ' . baseUrl('layanan.php'));
        exit;
    }

    $db = getDB();
    $noReg = generateNoRegistrasi();

    $stmt = $db->prepare("INSERT INTO pengajuan_layanan (user_id, no_registrasi, jenis_layanan, status) VALUES (?, ?, ?, 'draft')");
    $stmt->execute([$_SESSION['user_id'], $noReg, $jenisLayanan]);
    $pengajuanId = $db->lastInsertId();

    // Create related data based on service type
    if ($jenisLayanan === 'kk') {
        $stmt = $db->prepare('SELECT nama_kepala_keluarga, nama_lengkap, no_kk FROM users WHERE id = ?');
        $stmt->execute([$_SESSION['user_id']]);
        $uRow = $stmt->fetch() ?: [];
        $seedKkHead = trim((string) ($uRow['nama_kepala_keluarga'] ?? ''));
        if ($seedKkHead === '') {
            $seedKkHead = trim((string) ($uRow['nama_lengkap'] ?? ''));
        }
        $stmt = $db->prepare('INSERT INTO data_keluarga (pengajuan_id, nama_kepala_keluarga, no_kk) VALUES (?, ?, ?)');
        $stmt->execute([
            $pengajuanId,
            $seedKkHead,
            trim((string) ($uRow['no_kk'] ?? '')),
        ]);
    } elseif ($jenisLayanan === 'pindah') {
        $stmt = $db->prepare("INSERT INTO data_pindah (pengajuan_id, alamat_asal, alamat_tujuan, jenis_kepindahan) VALUES (?, '', '', 'kepala_keluarga')");
        $stmt->execute([$pengajuanId]);
    }

    header('Location: ' . baseUrl('form.php?id=' . $pengajuanId));
    exit;
}

function handleSaveStep()
{
    requireLogin();
    if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
        header('Location: ' . baseUrl('index.php'));
        exit;
    }

    $pengajuanId = intval($_POST['pengajuan_id'] ?? 0);
    $step = intval($_POST['step'] ?? 1);
    $db = getDB();

    // Verify ownership
    $stmt = $db->prepare("SELECT * FROM pengajuan_layanan WHERE id = ? AND user_id = ?");
    $stmt->execute([$pengajuanId, $_SESSION['user_id']]);
    $pengajuan = $stmt->fetch();

    if (!$pengajuan) {
        setFlash('danger', 'Pengajuan tidak ditemukan.');
        header('Location: ' . baseUrl('index.php'));
        exit;
    }

    switch ($step) {
        case 1: // Personal data - update user data
            $stmt = $db->prepare("UPDATE users SET nama_lengkap=?, no_hp=?, alamat=?, tempat_lahir=?, tanggal_lahir=?, agama=?, pekerjaan=? WHERE id=?");
            $stmt->execute([
                $_POST['nama_lengkap'] ?? '',
                $_POST['no_hp'] ?? '',
                $_POST['alamat'] ?? '',
                $_POST['tempat_lahir'] ?? '',
                $_POST['tanggal_lahir'] ?? null,
                $_POST['agama'] ?? null,
                $_POST['pekerjaan'] ?? '',
                $_SESSION['user_id']
            ]);
            break;

        case 2: // Dynamic data based on service type
            if ($pengajuan['jenis_layanan'] === 'kk') {
                saveKeluargaData($db, $pengajuanId);
            } elseif ($pengajuan['jenis_layanan'] === 'pindah') {
                savePindahData($db, $pengajuanId);
            } elseif ($pengajuan['jenis_layanan'] === 'ktp') {
                $jenisPerm = $_POST['jenis_permohonan_ktp'] ?? 'baru';
                $stmt = $db->prepare("UPDATE pengajuan_layanan SET jenis_permohonan_ktp=? WHERE id=?");
                $stmt->execute([$jenisPerm, $pengajuanId]);
            }
            break;

        case 3: // Pindah=save anggota_pindah, Others=detail layanan
            if ($pengajuan['jenis_layanan'] === 'pindah') {
                saveAnggotaPindah($db, $pengajuanId);
            } else {
                $stmt = $db->prepare("UPDATE pengajuan_layanan SET alasan_permohonan=?, metode_pengambilan=? WHERE id=?");
                $stmt->execute([
                    $_POST['alasan_permohonan'] ?? '',
                    $_POST['metode_pengambilan'] ?? 'ambil_sendiri',
                    $pengajuanId
                ]);
            }
            break;
    }

    $nextStep = $step + 1;
    header('Location: ' . baseUrl("form.php?id={$pengajuanId}&step={$nextStep}"));
    exit;
}

function saveKeluargaData($db, $pengajuanId)
{
    $stmtUser = $db->prepare('SELECT nama_kepala_keluarga, nama_lengkap, no_kk, alamat, rt, rw, kelurahan, kecamatan, kota, provinsi, kode_pos FROM users WHERE id = ?');
    $stmtUser->execute([$_SESSION['user_id']]);
    $profil = $stmtUser->fetch() ?: [];

    $namaKK = trim((string) ($_POST['nama_kepala_keluarga'] ?? ''));
    if ($namaKK === '') {
        $namaKK = trim((string) ($profil['nama_kepala_keluarga'] ?? ''));
    }
    if ($namaKK === '') {
        $namaKK = trim((string) ($profil['nama_lengkap'] ?? ''));
    }

    $noKkPost = trim((string) ($_POST['no_kk'] ?? ''));
    if ($noKkPost === '') {
        $noKkPost = trim((string) ($profil['no_kk'] ?? ''));
    }

    $alamatKk = trim((string) ($_POST['alamat_kk'] ?? ''));
    if ($alamatKk === '') {
        $alamatKk = trim((string) ($profil['alamat'] ?? ''));
    }
    $rtK = trim((string) ($_POST['rt'] ?? ''));
    if ($rtK === '') {
        $rtK = trim((string) ($profil['rt'] ?? ''));
    }
    $rwK = trim((string) ($_POST['rw'] ?? ''));
    if ($rwK === '') {
        $rwK = trim((string) ($profil['rw'] ?? ''));
    }
    $kelK = trim((string) ($_POST['kelurahan'] ?? ''));
    if ($kelK === '') {
        $kelK = trim((string) ($profil['kelurahan'] ?? ''));
    }
    $kecK = trim((string) ($_POST['kecamatan'] ?? ''));
    if ($kecK === '') {
        $kecK = trim((string) ($profil['kecamatan'] ?? ''));
    }
    $kotaK = trim((string) ($_POST['kota'] ?? ''));
    if ($kotaK === '') {
        $kotaK = trim((string) ($profil['kota'] ?? ''));
    }
    $provK = trim((string) ($_POST['provinsi'] ?? ''));
    if ($provK === '') {
        $provK = trim((string) ($profil['provinsi'] ?? ''));
    }
    $posK = trim((string) ($_POST['kode_pos'] ?? ''));
    if ($posK === '') {
        $posK = trim((string) ($profil['kode_pos'] ?? ''));
    }

    // Update or insert data_keluarga
    $stmt = $db->prepare("SELECT id FROM data_keluarga WHERE pengajuan_id = ?");
    $stmt->execute([$pengajuanId]);
    $existing = $stmt->fetch();

    if ($existing) {
        $stmt = $db->prepare("UPDATE data_keluarga SET jenis_permohonan_kk=?, sub_jenis_kk=?, no_kk=?, nama_kepala_keluarga=?, alamat_kk=?, rt=?, rw=?, kelurahan=?, kecamatan=?, kota=?, provinsi=?, kode_pos=? WHERE pengajuan_id=?");
        $stmt->execute([
            $_POST['jenis_permohonan_kk'] ?? 'baru',
            $_POST['sub_jenis_kk'] ?? null,
            $noKkPost,
            $namaKK,
            $alamatKk,
            $rtK,
            $rwK,
            $kelK,
            $kecK,
            $kotaK,
            $provK,
            $posK,
            $pengajuanId
        ]);
        $keluargaId = $existing['id'];
    } else {
        $stmt = $db->prepare("INSERT INTO data_keluarga (pengajuan_id, jenis_permohonan_kk, sub_jenis_kk, no_kk, nama_kepala_keluarga, alamat_kk, rt, rw, kelurahan, kecamatan, kota, provinsi, kode_pos) VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?)");
        $stmt->execute([
            $pengajuanId,
            $_POST['jenis_permohonan_kk'] ?? 'baru',
            $_POST['sub_jenis_kk'] ?? null,
            $noKkPost,
            $namaKK,
            $alamatKk,
            $rtK,
            $rwK,
            $kelK,
            $kecK,
            $kotaK,
            $provK,
            $posK
        ]);
        $keluargaId = $db->lastInsertId();
    }

    // Handle anggota_keluarga (dynamic rows)
    $db->prepare("DELETE FROM anggota_keluarga WHERE data_keluarga_id = ?")->execute([$keluargaId]);

    $names = $_POST['anggota_nama'] ?? [];
    $niks = $_POST['anggota_nik'] ?? [];
    $genders = $_POST['anggota_jk'] ?? [];
    $birthPlaces = $_POST['anggota_tempat_lahir'] ?? [];
    $birthDates = $_POST['anggota_tanggal_lahir'] ?? [];
    $religions = $_POST['anggota_agama'] ?? [];
    $educations = $_POST['anggota_pendidikan'] ?? [];
    $jobs = $_POST['anggota_pekerjaan'] ?? [];
    $maritalStatuses = $_POST['anggota_status_perkawinan'] ?? [];
    $relations = $_POST['anggota_hubungan'] ?? [];

    $stmt = $db->prepare("INSERT INTO anggota_keluarga (data_keluarga_id, nama, nik, jenis_kelamin, tempat_lahir, tanggal_lahir, agama, pendidikan, pekerjaan, status_perkawinan, hubungan_keluarga) VALUES (?,?,?,?,?,?,?,?,?,?,?)");

    for ($i = 0; $i < count($names); $i++) {
        if (!empty($names[$i])) {
            $stmt->execute([
                $keluargaId,
                $names[$i],
                $niks[$i] ?? '',
                $genders[$i] ?? 'L',
                $birthPlaces[$i] ?? '',
                !empty($birthDates[$i]) ? $birthDates[$i] : null,
                $religions[$i] ?? '',
                $educations[$i] ?? '',
                $jobs[$i] ?? '',
                $maritalStatuses[$i] ?? '',
                $relations[$i] ?? ''
            ]);
        }
    }
}

function savePindahData($db, $pengajuanId)
{
    $stmt = $db->prepare("SELECT id FROM data_pindah WHERE pengajuan_id = ?");
    $stmt->execute([$pengajuanId]);
    $existing = $stmt->fetch();

    $params = [
        $_POST['jenis_permohonan_pindah'] ?? 'skp',
        $_POST['alamat_asal'] ?? '',
        $_POST['rt_asal'] ?? '',
        $_POST['rw_asal'] ?? '',
        $_POST['kelurahan_asal'] ?? '',
        $_POST['kecamatan_asal'] ?? '',
        $_POST['kota_asal'] ?? '',
        $_POST['provinsi_asal'] ?? '',
        $_POST['klasifikasi_kepindahan'] ?? 'dalam_desa',
        $_POST['alamat_tujuan'] ?? '',
        $_POST['rt_tujuan'] ?? '',
        $_POST['rw_tujuan'] ?? '',
        $_POST['kelurahan_tujuan'] ?? '',
        $_POST['kecamatan_tujuan'] ?? '',
        $_POST['kota_tujuan'] ?? '',
        $_POST['provinsi_tujuan'] ?? '',
        $_POST['alasan_pindah'] ?? '',
        $_POST['alasan_pindah_lainnya'] ?? '',
        $_POST['jenis_kepindahan'] ?? 'kepala_keluarga',
        intval($_POST['jumlah_keluarga_pindah'] ?? 1),
    ];

    if ($existing) {
        $params[] = $pengajuanId;
        $stmt = $db->prepare("UPDATE data_pindah SET jenis_permohonan_pindah=?, alamat_asal=?, rt_asal=?, rw_asal=?, kelurahan_asal=?, kecamatan_asal=?, kota_asal=?, provinsi_asal=?, klasifikasi_kepindahan=?, alamat_tujuan=?, rt_tujuan=?, rw_tujuan=?, kelurahan_tujuan=?, kecamatan_tujuan=?, kota_tujuan=?, provinsi_tujuan=?, alasan_pindah=?, alasan_pindah_lainnya=?, jenis_kepindahan=?, jumlah_keluarga_pindah=? WHERE pengajuan_id=?");
        $stmt->execute($params);
    } else {
        array_unshift($params, $pengajuanId);
        $stmt = $db->prepare("INSERT INTO data_pindah (pengajuan_id, jenis_permohonan_pindah, alamat_asal, rt_asal, rw_asal, kelurahan_asal, kecamatan_asal, kota_asal, provinsi_asal, klasifikasi_kepindahan, alamat_tujuan, rt_tujuan, rw_tujuan, kelurahan_tujuan, kecamatan_tujuan, kota_tujuan, provinsi_tujuan, alasan_pindah, alasan_pindah_lainnya, jenis_kepindahan, jumlah_keluarga_pindah) VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)");
        $stmt->execute($params);
    }
}

function saveAnggotaPindah($db, $pengajuanId)
{
    // Get data_pindah id
    $stmt = $db->prepare("SELECT id FROM data_pindah WHERE pengajuan_id = ?");
    $stmt->execute([$pengajuanId]);
    $dataPindah = $stmt->fetch();
    if (!$dataPindah)
        return;

    $pindahId = $dataPindah['id'];

    // Clear existing
    $db->prepare("DELETE FROM anggota_pindah WHERE data_pindah_id = ?")->execute([$pindahId]);

    // Insert new
    $names = $_POST['pindah_nama'] ?? [];
    $niks = $_POST['pindah_nik'] ?? [];
    $shdks = $_POST['pindah_shdk'] ?? [];

    $stmt = $db->prepare("INSERT INTO anggota_pindah (data_pindah_id, nama, nik, shdk) VALUES (?,?,?,?)");
    for ($i = 0; $i < count($names); $i++) {
        if (!empty($names[$i])) {
            $stmt->execute([$pindahId, $names[$i], $niks[$i] ?? '', $shdks[$i] ?? '']);
        }
    }

    // Update jumlah_keluarga_pindah
    $count = count(array_filter($names));
    $db->prepare("UPDATE data_pindah SET jumlah_keluarga_pindah = ? WHERE id = ?")->execute([$count, $pindahId]);
}

function handleSubmit()
{
    requireLogin();
    if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
        header('Location: ' . baseUrl('index.php'));
        exit;
    }

    $pengajuanId = intval($_POST['pengajuan_id'] ?? 0);
    $db = getDB();

    // Verify ownership
    $stmt = $db->prepare("SELECT * FROM pengajuan_layanan WHERE id = ? AND user_id = ? AND status = 'draft'");
    $stmt->execute([$pengajuanId, $_SESSION['user_id']]);
    $pengajuan = $stmt->fetch();

    if (!$pengajuan) {
        setFlash('danger', 'Pengajuan tidak ditemukan atau sudah disubmit.');
        header('Location: ' . baseUrl('index.php'));
        exit;
    }

    // Update status to pending
    $stmt = $db->prepare("UPDATE pengajuan_layanan SET status = 'pending', tanggal_pengajuan = NOW() WHERE id = ?");
    $stmt->execute([$pengajuanId]);

    setFlash('success', 'Pengajuan berhasil dikirim! No. Registrasi: ' . $pengajuan['no_registrasi']);
    header('Location: ' . baseUrl('riwayat.php'));
    exit;
}

function handleUploadDokumen()
{
    requireLogin();
    header('Content-Type: application/json');

    $pengajuanId = intval($_POST['pengajuan_id'] ?? 0);
    $jenisDokumen = $_POST['jenis_dokumen'] ?? 'Dokumen';
    $db = getDB();

    // Verify ownership
    $stmt = $db->prepare("SELECT id FROM pengajuan_layanan WHERE id = ? AND user_id = ?");
    $stmt->execute([$pengajuanId, $_SESSION['user_id']]);
    if (!$stmt->fetch()) {
        echo json_encode(['success' => false, 'message' => 'Pengajuan tidak ditemukan.']);
        exit;
    }

    if (!isset($_FILES['file']) || $_FILES['file']['error'] !== UPLOAD_ERR_OK) {
        echo json_encode(['success' => false, 'message' => 'File upload gagal.']);
        exit;
    }

    $file = $_FILES['file'];
    $allowedTypes = ['application/pdf', 'image/jpeg', 'image/jpg', 'image/png'];
    $allowedExt = ['pdf', 'jpg', 'jpeg', 'png'];
    $maxSize = 5 * 1024 * 1024; // 5MB

    $ext = strtolower(pathinfo($file['name'], PATHINFO_EXTENSION));
    $finfoType = '';
    if (function_exists('finfo_open')) {
        $finfo = finfo_open(FILEINFO_MIME_TYPE);
        if ($finfo) {
            $finfoType = finfo_file($finfo, $file['tmp_name']) ?: '';
            finfo_close($finfo);
        }
    }
    $detectedType = !empty($finfoType) ? $finfoType : ($file['type'] ?? '');

    if (!in_array($ext, $allowedExt, true) || (!empty($detectedType) && !in_array($detectedType, $allowedTypes, true))) {
        echo json_encode(['success' => false, 'message' => 'Format file tidak didukung. Gunakan PDF, JPG, atau PNG.']);
        exit;
    }

    if ($file['size'] > $maxSize) {
        echo json_encode(['success' => false, 'message' => 'Ukuran file maksimal 5MB.']);
        exit;
    }

    $newName = uniqid('doc_') . '_' . time() . '.' . $ext;
    $uploadDir = BASE_PATH . '/uploads/dokumen/';

    if (!is_dir($uploadDir)) {
        mkdir($uploadDir, 0777, true);
    }

    if (move_uploaded_file($file['tmp_name'], $uploadDir . $newName)) {
        $existingStmt = $db->prepare("SELECT id, nama_file FROM dokumen WHERE pengajuan_id = ? AND jenis_dokumen = ? LIMIT 1");
        $existingStmt->execute([$pengajuanId, $jenisDokumen]);
        $existingDoc = $existingStmt->fetch();

        if ($existingDoc) {
            $oldFilePath = $uploadDir . $existingDoc['nama_file'];
            if (!empty($existingDoc['nama_file']) && file_exists($oldFilePath)) {
                unlink($oldFilePath);
            }

            $stmt = $db->prepare("UPDATE dokumen SET nama_file = ?, nama_asli = ?, ukuran_file = ?, tipe_file = ? WHERE id = ?");
            $stmt->execute([
                $newName,
                $file['name'],
                $file['size'],
                $detectedType ?: ($file['type'] ?? ''),
                $existingDoc['id']
            ]);
            $docId = $existingDoc['id'];
        } else {
            $stmt = $db->prepare("INSERT INTO dokumen (pengajuan_id, jenis_dokumen, nama_file, nama_asli, ukuran_file, tipe_file) VALUES (?,?,?,?,?,?)");
            $stmt->execute([
                $pengajuanId,
                $jenisDokumen,
                $newName,
                $file['name'],
                $file['size'],
                $detectedType ?: ($file['type'] ?? ''),
            ]);
            $docId = $db->lastInsertId();
        }

        echo json_encode([
            'success' => true,
            'message' => 'File berhasil diupload.',
            'dokumen' => [
                'id' => $docId,
                'jenis_dokumen' => $jenisDokumen,
                'nama_asli' => $file['name'],
                'ukuran_file' => $file['size'],
                'tipe_file' => $detectedType ?: ($file['type'] ?? '')
            ]
        ]);
    } else {
        echo json_encode(['success' => false, 'message' => 'Gagal menyimpan file.']);
    }
    exit;
}

function handleDeleteDokumen()
{
    requireLogin();
    header('Content-Type: application/json');

    $dokumenId = intval($_POST['dokumen_id'] ?? 0);
    $db = getDB();

    // Get document and verify ownership
    $stmt = $db->prepare("SELECT d.*, p.user_id FROM dokumen d JOIN pengajuan_layanan p ON d.pengajuan_id = p.id WHERE d.id = ? AND p.user_id = ?");
    $stmt->execute([$dokumenId, $_SESSION['user_id']]);
    $doc = $stmt->fetch();

    if (!$doc) {
        echo json_encode(['success' => false, 'message' => 'Dokumen tidak ditemukan.']);
        exit;
    }

    // Delete file
    $filePath = BASE_PATH . '/uploads/dokumen/' . $doc['nama_file'];
    if (file_exists($filePath)) {
        unlink($filePath);
    }

    // Delete record
    $stmt = $db->prepare("DELETE FROM dokumen WHERE id = ?");
    $stmt->execute([$dokumenId]);

    echo json_encode(['success' => true, 'message' => 'Dokumen berhasil dihapus.']);
    exit;
}

function handleReplaceDokumen()
{
    requireLogin();
    header('Content-Type: application/json');

    $dokumenId = intval($_POST['dokumen_id'] ?? 0);
    $db = getDB();

    $stmt = $db->prepare("SELECT d.*, p.user_id FROM dokumen d JOIN pengajuan_layanan p ON d.pengajuan_id = p.id WHERE d.id = ? AND p.user_id = ?");
    $stmt->execute([$dokumenId, $_SESSION['user_id']]);
    $doc = $stmt->fetch();

    if (!$doc) {
        echo json_encode(['success' => false, 'message' => 'Dokumen tidak ditemukan.']);
        exit;
    }

    if (!isset($_FILES['file']) || $_FILES['file']['error'] !== UPLOAD_ERR_OK) {
        echo json_encode(['success' => false, 'message' => 'File upload gagal.']);
        exit;
    }

    $file = $_FILES['file'];
    $allowedTypes = ['application/pdf', 'image/jpeg', 'image/jpg', 'image/png'];
    $allowedExt = ['pdf', 'jpg', 'jpeg', 'png'];
    $maxSize = 5 * 1024 * 1024;

    $ext = strtolower(pathinfo($file['name'], PATHINFO_EXTENSION));
    $finfoType = '';
    if (function_exists('finfo_open')) {
        $finfo = finfo_open(FILEINFO_MIME_TYPE);
        if ($finfo) {
            $finfoType = finfo_file($finfo, $file['tmp_name']) ?: '';
            finfo_close($finfo);
        }
    }
    $detectedType = !empty($finfoType) ? $finfoType : ($file['type'] ?? '');

    if (!in_array($ext, $allowedExt, true) || (!empty($detectedType) && !in_array($detectedType, $allowedTypes, true))) {
        echo json_encode(['success' => false, 'message' => 'Format file tidak didukung. Gunakan PDF, JPG, atau PNG.']);
        exit;
    }

    if ($file['size'] > $maxSize) {
        echo json_encode(['success' => false, 'message' => 'Ukuran file maksimal 5MB.']);
        exit;
    }

    $newName = uniqid('doc_') . '_' . time() . '.' . $ext;
    $uploadDir = BASE_PATH . '/uploads/dokumen/';
    if (!is_dir($uploadDir)) {
        mkdir($uploadDir, 0777, true);
    }

    if (!move_uploaded_file($file['tmp_name'], $uploadDir . $newName)) {
        echo json_encode(['success' => false, 'message' => 'Gagal menyimpan file baru.']);
        exit;
    }

    $oldPath = $uploadDir . $doc['nama_file'];
    if (!empty($doc['nama_file']) && file_exists($oldPath)) {
        unlink($oldPath);
    }

    $stmt = $db->prepare("UPDATE dokumen SET nama_file = ?, nama_asli = ?, ukuran_file = ?, tipe_file = ? WHERE id = ?");
    $stmt->execute([
        $newName,
        $file['name'],
        $file['size'],
        $detectedType ?: ($file['type'] ?? ''),
        $dokumenId
    ]);

    echo json_encode([
        'success' => true,
        'message' => 'Dokumen berhasil diperbarui.',
        'dokumen' => [
            'id' => $dokumenId,
            'nama_asli' => $file['name'],
            'ukuran_file' => $file['size'],
            'tipe_file' => $detectedType ?: ($file['type'] ?? ''),
        ]
    ]);
    exit;
}

function handleDeleteProfileDokumen()
{
    requireLogin();
    header('Content-Type: application/json');

    $docKey = strtolower(trim($_POST['doc_key'] ?? ''));
    if (!in_array($docKey, ['ktp', 'kk'], true)) {
        echo json_encode(['success' => false, 'message' => 'Tipe dokumen tidak valid.']);
        exit;
    }

    $db = getDB();
    $likeNeedle = $docKey === 'ktp' ? '%ktp%' : '%kk%';

    $stmt = $db->prepare("
        SELECT d.id, d.nama_file
        FROM dokumen d
        JOIN pengajuan_layanan p ON p.id = d.pengajuan_id
        WHERE p.user_id = ? AND LOWER(d.jenis_dokumen) LIKE ?
    ");
    $stmt->execute([$_SESSION['user_id'], $likeNeedle]);
    $docs = $stmt->fetchAll();

    if (empty($docs)) {
        echo json_encode(['success' => true, 'message' => 'Tidak ada dokumen untuk dihapus.']);
        exit;
    }

    $uploadDir = BASE_PATH . '/uploads/dokumen/';
    $deleteStmt = $db->prepare("DELETE FROM dokumen WHERE id = ?");
    foreach ($docs as $doc) {
        $filePath = $uploadDir . $doc['nama_file'];
        if (!empty($doc['nama_file']) && file_exists($filePath)) {
            unlink($filePath);
        }
        $deleteStmt->execute([$doc['id']]);
    }

    echo json_encode(['success' => true, 'message' => 'Dokumen berhasil dihapus.']);
    exit;
}

function handleUploadProfileDokumen()
{
    requireLogin();
    header('Content-Type: application/json');

    $docKey = strtolower(trim($_POST['doc_key'] ?? ''));
    if (!in_array($docKey, ['ktp', 'kk'], true)) {
        echo json_encode(['success' => false, 'message' => 'Tipe dokumen tidak valid.']);
        exit;
    }

    if (!isset($_FILES['file']) || $_FILES['file']['error'] !== UPLOAD_ERR_OK) {
        echo json_encode(['success' => false, 'message' => 'File upload gagal.']);
        exit;
    }

    $file = $_FILES['file'];
    $allowedTypes = ['application/pdf', 'image/jpeg', 'image/jpg', 'image/png'];
    $allowedExt = ['pdf', 'jpg', 'jpeg', 'png'];
    $maxSize = 5 * 1024 * 1024;

    $ext = strtolower(pathinfo($file['name'], PATHINFO_EXTENSION));
    $finfoType = '';
    if (function_exists('finfo_open')) {
        $finfo = finfo_open(FILEINFO_MIME_TYPE);
        if ($finfo) {
            $finfoType = finfo_file($finfo, $file['tmp_name']) ?: '';
            finfo_close($finfo);
        }
    }
    $detectedType = !empty($finfoType) ? $finfoType : ($file['type'] ?? '');

    if (!in_array($ext, $allowedExt, true) || (!empty($detectedType) && !in_array($detectedType, $allowedTypes, true))) {
        echo json_encode(['success' => false, 'message' => 'Format file tidak didukung. Gunakan PDF, JPG, atau PNG.']);
        exit;
    }
    if ($file['size'] > $maxSize) {
        echo json_encode(['success' => false, 'message' => 'Ukuran file maksimal 5MB.']);
        exit;
    }

    $db = getDB();
    $jenisLayanan = $docKey === 'ktp' ? 'ktp' : 'kk';
    $jenisDokumen = $docKey === 'ktp' ? 'KTP Elektronik' : 'Kartu Keluarga';

    $stmt = $db->prepare("SELECT id FROM pengajuan_layanan WHERE user_id = ? AND jenis_layanan = ? ORDER BY id DESC LIMIT 1");
    $stmt->execute([$_SESSION['user_id'], $jenisLayanan]);
    $pengajuan = $stmt->fetch();

    if (!$pengajuan) {
        $stmt = $db->prepare("INSERT INTO pengajuan_layanan (user_id, no_registrasi, jenis_layanan, status) VALUES (?, ?, ?, 'draft')");
        $stmt->execute([$_SESSION['user_id'], generateNoRegistrasi(), $jenisLayanan]);
        $pengajuanId = $db->lastInsertId();
    } else {
        $pengajuanId = $pengajuan['id'];
    }

    $newName = uniqid('doc_') . '_' . time() . '.' . $ext;
    $uploadDir = BASE_PATH . '/uploads/dokumen/';
    if (!is_dir($uploadDir)) {
        mkdir($uploadDir, 0777, true);
    }
    if (!move_uploaded_file($file['tmp_name'], $uploadDir . $newName)) {
        echo json_encode(['success' => false, 'message' => 'Gagal menyimpan file.']);
        exit;
    }

    $stmt = $db->prepare("
        SELECT d.id, d.nama_file
        FROM dokumen d
        JOIN pengajuan_layanan p ON p.id = d.pengajuan_id
        WHERE p.user_id = ? AND LOWER(d.jenis_dokumen) LIKE ?
        ORDER BY d.id DESC LIMIT 1
    ");
    $stmt->execute([$_SESSION['user_id'], $docKey === 'ktp' ? '%ktp%' : '%kk%']);
    $existing = $stmt->fetch();

    if ($existing) {
        $oldPath = $uploadDir . $existing['nama_file'];
        if (!empty($existing['nama_file']) && file_exists($oldPath)) {
            unlink($oldPath);
        }
        $stmt = $db->prepare("UPDATE dokumen SET pengajuan_id = ?, jenis_dokumen = ?, nama_file = ?, nama_asli = ?, ukuran_file = ?, tipe_file = ? WHERE id = ?");
        $stmt->execute([$pengajuanId, $jenisDokumen, $newName, $file['name'], $file['size'], $detectedType ?: ($file['type'] ?? ''), $existing['id']]);
    } else {
        $stmt = $db->prepare("INSERT INTO dokumen (pengajuan_id, jenis_dokumen, nama_file, nama_asli, ukuran_file, tipe_file) VALUES (?, ?, ?, ?, ?, ?)");
        $stmt->execute([$pengajuanId, $jenisDokumen, $newName, $file['name'], $file['size'], $detectedType ?: ($file['type'] ?? '')]);
    }

    echo json_encode(['success' => true, 'message' => 'Dokumen berhasil diunggah.']);
    exit;
}
