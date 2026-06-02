<?php
/**
 * Authentication Helper - Dukcapil Mandiri
 * Session-based authentication with role checking
 */

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

require_once __DIR__ . '/database.php';

/**
 * Check if user is logged in
 */
function isLoggedIn()
{
    return isset($_SESSION['user_id']) && !empty($_SESSION['user_id']);
}

/**
 * Check if user is admin
 */
function isAdmin()
{
    return isLoggedIn() && isset($_SESSION['user_role']) && $_SESSION['user_role'] === 'admin';
}

/**
 * Check if user is lurah
 */
function isLurah()
{
    return isLoggedIn() && isset($_SESSION['user_role']) && $_SESSION['user_role'] === 'lurah';
}

/**
 * Check if user is admin or lurah
 */
function isAdminOrLurah()
{
    return isAdmin() || isLurah();
}

/**
 * Get current user data. Set $refresh true setelah memperbarui profil di database.
 */
function currentUser(bool $refresh = false)
{
    static $cacheId = null;
    static $user = null;

    if (!isLoggedIn()) {
        $cacheId = null;
        $user = null;
        return null;
    }

    $uid = (int) $_SESSION['user_id'];
    if ($refresh || $cacheId !== $uid || $user === null) {
        $db = getDB();
        $stmt = $db->prepare('SELECT * FROM users WHERE id = ?');
        $stmt->execute([$uid]);
        $user = $stmt->fetch();
        $cacheId = $uid;
    }

    return $user;
}

/**
 * Require login - redirect to login page if not logged in
 */
function requireLogin()
{
    if (!isLoggedIn()) {
        setFlash('warning', 'Silakan login terlebih dahulu.');
        header('Location: ' . baseUrl('login.php'));
        exit;
    }
}

/**
 * Require admin - redirect if not admin
 */
function requireAdmin()
{
    requireLogin();
    if (!isAdmin()) {
        setFlash('danger', 'Anda tidak memiliki akses ke halaman ini.');
        header('Location: ' . baseUrl('index.php'));
        exit;
    }
}

/**
 * Require admin or lurah - redirect if neither
 */
function requireAdminOrLurah()
{
    requireLogin();
    if (!isAdminOrLurah()) {
        setFlash('danger', 'Anda tidak memiliki akses ke halaman ini.');
        header('Location: ' . baseUrl('index.php'));
        exit;
    }
}

/**
 * Require citizen role - redirect admin or lurah to admin panel
 */
function requireCitizen()
{
    requireLogin();
    if (isAdmin() || isLurah()) {
        header('Location: ' . baseUrl('admin.php'));
        exit;
    }
}

/**
 * Redirect logged-in users away from login/register pages
 */
function redirectIfLoggedIn()
{
    if (isLoggedIn()) {
        if (isAdmin() || isLurah()) {
            header('Location: ' . baseUrl('admin.php'));
        } else {
            header('Location: ' . baseUrl('index.php'));
        }
        exit;
    }
}

/**
 * Login user
 */
function loginUser($identifier, $password)
{
    $db = getDB();
    // Support login by email or NIK
    $stmt = $db->prepare("SELECT * FROM users WHERE email = ? OR nik = ?");
    $stmt->execute([$identifier, $identifier]);
    $user = $stmt->fetch();

    if ($user && password_verify($password, $user['password'])) {
        $_SESSION['user_id'] = $user['id'];
        $_SESSION['user_name'] = $user['nama_lengkap'];
        $_SESSION['user_role'] = $user['role'];
        $_SESSION['user_email'] = $user['email'];
        $_SESSION['user_nik'] = $user['nik'];
        return true;
    }
    return false;
}

/**
 * Register user
 */
function registerUser($data)
{
    $db = getDB();

    // Check existing NIK
    $stmt = $db->prepare("SELECT id FROM users WHERE nik = ?");
    $stmt->execute([$data['nik']]);
    if ($stmt->fetch()) {
        return ['success' => false, 'message' => 'NIK sudah terdaftar.'];
    }

    // Check existing email
    $stmt = $db->prepare("SELECT id FROM users WHERE email = ?");
    $stmt->execute([$data['email']]);
    if ($stmt->fetch()) {
        return ['success' => false, 'message' => 'Email sudah terdaftar.'];
    }

    $hashedPassword = password_hash($data['password'], PASSWORD_DEFAULT);

    $stmt = $db->prepare("INSERT INTO users (nama_lengkap, nik, email, no_hp, password, alamat, tempat_lahir, tanggal_lahir, jenis_kelamin) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)");

    $stmt->execute([
        $data['nama_lengkap'],
        $data['nik'],
        $data['email'],
        $data['no_hp'] ?? null,
        $hashedPassword,
        $data['alamat'] ?? null,
        $data['tempat_lahir'] ?? null,
        $data['tanggal_lahir'] ?? null,
        $data['jenis_kelamin'] ?? null,
    ]);

    return ['success' => true, 'message' => 'Registrasi berhasil! Silakan login.'];
}

/**
 * Logout user
 */
function logoutUser()
{
    session_unset();
    session_destroy();
}
