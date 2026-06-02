<?php

namespace App\Controllers;

/**
 * Panel admin multi-halaman (dashboard, permohonan, arsip, users, settings).
 */
class AdminPanelController
{
    public static function show(): void
    {
        requireAdminOrLurah();

        $pageTitle = 'Admin Panel';
        $db = getDB();
        $adminPage = $_GET['page'] ?? 'dashboard';

        if (isLurah() && in_array($adminPage, ['users'], true)) {
            setFlash('danger', 'Anda tidak memiliki akses ke halaman ini.');
            header('Location: ' . baseUrl('admin.php'));
            exit;
        }

        $totalPending = $db->query("SELECT COUNT(*) as c FROM pengajuan_layanan WHERE status = 'pending'")->fetch()['c'];
        $totalProses = $db->query("SELECT COUNT(*) as c FROM pengajuan_layanan WHERE status = 'diproses'")->fetch()['c'];
        $totalSetuju = $db->query("SELECT COUNT(*) as c FROM pengajuan_layanan WHERE status = 'disetujui'")->fetch()['c'];
        $totalTolak = $db->query("SELECT COUNT(*) as c FROM pengajuan_layanan WHERE status = 'ditolak'")->fetch()['c'];
        $totalAll = $totalPending + $totalProses + $totalSetuju + $totalTolak;
        $totalUsers = $db->query("SELECT COUNT(*) as c FROM users WHERE role = 'user'")->fetch()['c'];

        $jenisLabels = ['kk' => 'Pembaruan KK', 'ktp' => 'KTP-el', 'pindah' => 'Surat Pindah'];
        $jenisBadge = ['kk' => 'bg-blue-50 text-blue-600 border-blue-200', 'ktp' => 'bg-cyan-50 text-cyan-600 border-cyan-200', 'pindah' => 'bg-violet-50 text-violet-600 border-violet-200'];
        $statusColors = ['pending' => 'text-amber-500', 'diproses' => 'text-blue-500', 'disetujui' => 'text-emerald-500', 'ditolak' => 'text-red-500'];
        $statusBadge = ['pending' => 'bg-amber-50 text-amber-700 border-amber-200', 'diproses' => 'bg-blue-50 text-blue-700 border-blue-200', 'disetujui' => 'bg-emerald-50 text-emerald-700 border-emerald-200', 'ditolak' => 'bg-red-50 text-red-700 border-red-200'];
        $statusLabels = ['pending' => 'Pending', 'diproses' => 'Diproses', 'disetujui' => 'Selesai (Diterima)', 'ditolak' => 'Ditolak'];

        // Harus disetel di sini: partial() berjalan di function scope; variabel dari partial tidak kebawa ke view utama.
        $user = currentUser();
        if ($user === null) {
            setFlash('danger', 'Sesi tidak valid.');
            header('Location: ' . baseUrl('login.php'));
            exit;
        }

        $hour = (int) date('H');
        if ($hour < 12) {
            $greeting = 'Selamat Pagi';
        } elseif ($hour < 15) {
            $greeting = 'Selamat Siang';
        } elseif ($hour < 18) {
            $greeting = 'Selamat Sore';
        } else {
            $greeting = 'Selamat Malam';
        }

        partial('header');
        partial('admin_sidebar');
        require BASE_PATH . '/app/Views/admin/panel.php';
        partial('admin_footer');
    }
}
