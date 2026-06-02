<?php

namespace App\Controllers;

use App\Models\Pengajuan;

class RiwayatController
{
    public static function index(): void
    {
        requireCitizen();
        $pageTitle = 'Riwayat';
        extract(Pengajuan::riwayatPageForUser((int) $_SESSION['user_id'], $_GET));

        $jenisLabels = ['kk' => 'Kartu Keluarga (KK)', 'ktp' => 'KTP-el', 'pindah' => 'Surat Pindah'];
        $statusColors = ['pending' => 'bg-amber-100 text-amber-700', 'diproses' => 'bg-blue-100 text-blue-700', 'disetujui' => 'bg-emerald-100 text-emerald-700', 'ditolak' => 'bg-red-100 text-red-700'];
        $statusLabels = ['pending' => 'Pending', 'diproses' => 'Diproses', 'disetujui' => 'Selesai (Diterima)', 'ditolak' => 'Ditolak'];

        partial('header');
        partial('sidebar');
        app_view('masyarakat/riwayat', compact(
            'submissions',
            'total',
            'totalPages',
            'page',
            'perPage',
            'offset',
            'statusFilter',
            'jenisLabels',
            'statusColors',
            'statusLabels'
        ));
        partial('footer');
    }
}
