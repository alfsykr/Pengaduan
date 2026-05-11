<?php

namespace App\Controllers;

use App\Models\Pengajuan;

class HomeController
{
    public static function index(): void
    {
        requireLogin();
        $pageTitle = 'Beranda';
        $userId = (int) $_SESSION['user_id'];
        extract(Pengajuan::dashboardForUser($userId));
        $user = currentUser();

        $jenisLabels = ['kk' => 'Kartu Keluarga (KK)', 'ktp' => 'KTP-el', 'pindah' => 'Surat Pindah'];
        $statusColors = [
            'pending' => 'bg-amber-100 text-amber-700',
            'diproses' => 'bg-blue-100 text-blue-700',
            'disetujui' => 'bg-emerald-100 text-emerald-700',
            'ditolak' => 'bg-red-100 text-red-700',
            'draft' => 'bg-slate-100 text-slate-600',
        ];
        $statusLabels = ['pending' => 'Pending', 'diproses' => 'Diproses', 'disetujui' => 'Selesai (Diterima)', 'ditolak' => 'Ditolak', 'draft' => 'Draft'];

        partial('header');
        partial('sidebar');
        app_view('masyarakat/home', compact(
            'user',
            'stats',
            'recentSubmissions',
            'totalSubmissions',
            'jenisLabels',
            'statusColors',
            'statusLabels'
        ));
        partial('footer');
    }
}
