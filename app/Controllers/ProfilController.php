<?php

namespace App\Controllers;

use App\Models\UserAccount;

class ProfilController
{
    public static function handle(): void
    {
        requireLogin();
        $pageTitle = 'Data Diri';

        if ($_SERVER['REQUEST_METHOD'] === 'POST' && ($_POST['action'] ?? '') === 'save_profile') {
            UserAccount::saveProfil((int) $_SESSION['user_id'], $_POST);
            setFlash('success', 'Data diri berhasil diperbarui.');
            header('Location: ' . baseUrl('profil.php'));
            exit;
        }

        $user = UserAccount::findById((int) $_SESSION['user_id']) ?? [];
        extract(UserAccount::profileCompleteness($user));
        extract(UserAccount::profileDocuments((int) $_SESSION['user_id']));

        $lastUpdated = !empty($user['updated_at']) ? date('d M Y', strtotime($user['updated_at'])) : date('d M Y');

        partial('header');
        partial('sidebar');
        app_view('masyarakat/profil', compact('user', 'completeness', 'lastUpdated', 'ktpDoc', 'kkDoc'));
        partial('footer');
    }
}
