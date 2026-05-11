<?php

namespace App\Controllers;

use App\Models\UserAccount;

class SettingsController
{
    public static function handle(): void
    {
        requireLogin();
        $pageTitle = 'Pengaturan';

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $action = $_POST['action'] ?? '';
            $uid = (int) $_SESSION['user_id'];

            if ($action === 'remove_avatar') {
                UserAccount::removeUserAvatar($uid);
                currentUser(true);
                setFlash('success', 'Foto profil dihapus.');
                header('Location: ' . baseUrl('settings.php'));
                exit;
            }

            if ($action === 'save_settings') {
                try {
                    UserAccount::updateSettings($uid, $_POST);
                    UserAccount::saveUserAvatarIfUploaded($uid);
                    $_SESSION['user_name'] = trim((string) ($_POST['nama_lengkap'] ?? $_SESSION['user_name']));
                    $_SESSION['user_nik'] = trim((string) ($_POST['nik'] ?? $_SESSION['user_nik']));
                    currentUser(true);
                    setFlash('success', 'Pengaturan berhasil disimpan.');
                } catch (\InvalidArgumentException $e) {
                    setFlash('danger', $e->getMessage());
                } catch (\Throwable $e) {
                    setFlash('danger', 'Terjadi kesalahan saat menyimpan pengaturan.');
                }
                header('Location: ' . baseUrl('settings.php'));
                exit;
            }
            if ($action === 'change_password') {
                $result = UserAccount::changePassword(
                    (int) $_SESSION['user_id'],
                    $_POST['current_password'] ?? '',
                    $_POST['new_password'] ?? '',
                    $_POST['confirm_password'] ?? ''
                );
                if ($result['ok']) {
                    setFlash('success', 'Password berhasil diubah.');
                } else {
                    setFlash('danger', $result['message'] ?? 'Gagal mengubah password.');
                }
                header('Location: ' . baseUrl('settings.php'));
                exit;
            }
        }

        $user = UserAccount::findById((int) $_SESSION['user_id']) ?? [];
        partial('header');
        partial('sidebar');
        app_view('masyarakat/settings', compact('user'));
        partial('footer');
    }
}
