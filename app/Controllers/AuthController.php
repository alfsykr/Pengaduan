<?php
/**
 * Auth Controller - Dukcapil Mandiri
 * Handles login, register, and logout actions
 */
require_once __DIR__ . '/../bootstrap.php';

$action = $_GET['action'] ?? $_POST['action'] ?? '';

switch ($action) {
    case 'login':
        handleLogin();
        break;
    case 'register':
        handleRegister();
        break;
    case 'logout':
        handleLogout();
        break;
    default:
        header('Location: ' . baseUrl('login.php'));
        exit;
}

function handleLogin()
{
    if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
        header('Location: ' . baseUrl('login.php'));
        exit;
    }

    $identifier = trim($_POST['identifier'] ?? '');
    $password = $_POST['password'] ?? '';

    if (empty($identifier) || empty($password)) {
        setFlash('danger', 'NIK/Email dan password harus diisi.');
        header('Location: ' . baseUrl('login.php'));
        exit;
    }

    if (loginUser($identifier, $password)) {
        setFlash('success', 'Selamat datang, ' . $_SESSION['user_name'] . '!');
        if ($_SESSION['user_role'] === 'admin') {
            header('Location: ' . baseUrl('admin.php'));
        } else {
            header('Location: ' . baseUrl('index.php'));
        }
    } else {
        setFlash('danger', 'NIK/Email atau password salah.');
        header('Location: ' . baseUrl('login.php'));
    }
    exit;
}

function handleRegister()
{
    if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
        header('Location: ' . baseUrl('register.php'));
        exit;
    }

    $data = [
        'nama_lengkap' => trim($_POST['nama_lengkap'] ?? ''),
        'nik' => trim($_POST['nik'] ?? ''),
        'email' => trim($_POST['email'] ?? ''),
        'no_hp' => trim($_POST['no_hp'] ?? ''),
        'password' => $_POST['password'] ?? '',
        'alamat' => trim($_POST['alamat'] ?? ''),
        'tempat_lahir' => trim($_POST['tempat_lahir'] ?? ''),
        'tanggal_lahir' => $_POST['tanggal_lahir'] ?? null,
        'jenis_kelamin' => $_POST['jenis_kelamin'] ?? null,
    ];

    // Validation
    if (empty($data['nama_lengkap']) || empty($data['nik']) || empty($data['email']) || empty($data['password'])) {
        setFlash('danger', 'Semua field wajib harus diisi.');
        header('Location: ' . baseUrl('register.php'));
        exit;
    }

    if (strlen($data['nik']) !== 16 || !ctype_digit($data['nik'])) {
        setFlash('danger', 'NIK harus terdiri dari 16 digit angka.');
        header('Location: ' . baseUrl('register.php'));
        exit;
    }

    if (strlen($data['password']) < 6) {
        setFlash('danger', 'Password minimal 6 karakter.');
        header('Location: ' . baseUrl('register.php'));
        exit;
    }

    $confirmPassword = $_POST['confirm_password'] ?? '';
    if ($data['password'] !== $confirmPassword) {
        setFlash('danger', 'Konfirmasi password tidak cocok.');
        header('Location: ' . baseUrl('register.php'));
        exit;
    }

    $result = registerUser($data);

    if ($result['success']) {
        setFlash('success', $result['message']);
        header('Location: ' . baseUrl('login.php'));
    } else {
        setFlash('danger', $result['message']);
        header('Location: ' . baseUrl('register.php'));
    }
    exit;
}

function handleLogout()
{
    logoutUser();
    setFlash('success', 'Anda telah berhasil keluar.');
    header('Location: ' . baseUrl('login.php'));
    exit;
}
