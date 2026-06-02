<?php

namespace App\Controllers;

use App\Models\Pengajuan;

class DetailController
{
    public static function show(): void
    {
        $isAdminView = (isAdmin() || isLurah()) && isset($_GET['admin']);
        if ($isAdminView) {
            requireAdminOrLurah();
        } else {
            requireCitizen();
        }
        $pageTitle = 'Detail Pengajuan';
        $id = intval($_GET['id'] ?? 0);

        $ctx = Pengajuan::detailContext($id, $isAdminView, (int) $_SESSION['user_id']);
        if ($ctx === null) {
            setFlash('danger', 'Pengajuan tidak ditemukan.');
            header('Location: ' . baseUrl('index.php'));
            exit;
        }
        extract($ctx);

        $jenisLabels = ['kk' => 'Kartu Keluarga (KK)', 'ktp' => 'KTP-el', 'pindah' => 'Permohonan Pindah'];
        $statusColors = ['pending' => 'bg-amber-100 text-amber-700', 'diproses' => 'bg-blue-100 text-blue-700', 'disetujui' => 'bg-emerald-100 text-emerald-700', 'ditolak' => 'bg-red-100 text-red-700', 'draft' => 'bg-slate-100 text-slate-600'];
        $statusLabels = ['pending' => 'Menunggu Verifikasi', 'diproses' => 'Sedang Diproses', 'disetujui' => 'Selesai (Diterima)', 'ditolak' => 'Ditolak', 'draft' => 'Draft'];

        partial('header');
        if ($isAdminView) {
            partial('admin_sidebar');
        } else {
            partial('sidebar');
        }
        app_view('masyarakat/detail', compact(
            'pengajuan',
            'jenis',
            'jenisLabels',
            'statusColors',
            'statusLabels',
            'dataKeluarga',
            'anggota',
            'dataPindah',
            'dokumen',
            'isAdminView',
            'adminBackPage'
        ));
        if ($isAdminView) {
            partial('admin_footer');
        } else {
            partial('footer');
        }
    }
}
