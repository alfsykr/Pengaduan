<?php

namespace App\Controllers;

use App\Models\PengaduanModel;

class CitizenPengaduanController
{
    public static function index(): void
    {
        requireCitizen();
        
        if (($_GET['action'] ?? '') === 'ajax_detail') {
            header('Content-Type: application/json');
            $id = intval($_GET['id'] ?? 0);
            $detail = PengaduanModel::getDetail($id);
            if ($detail) {
                echo json_encode(array_merge(['success' => true], $detail));
            } else {
                echo json_encode(['success' => false]);
            }
            exit;
        }

        $pageTitle = 'Daftar Pengaduan Warga';
        
        $userId = (int) $_SESSION['user_id'];
        $stats = PengaduanModel::getStatsForUser($userId);
        
        $filters = $_GET;
        $filters['page'] = $_GET['page'] ?? 1;
        $list = PengaduanModel::listForUser($userId, $filters);
        
        $statusColors = [
            'proses' => 'bg-indigo-100 text-indigo-700 border-indigo-200',
            'selesai' => 'bg-emerald-100 text-emerald-700 border-emerald-200',
            'ditolak' => 'bg-rose-100 text-rose-700 border-rose-200',
        ];
        
        $statusText = [
            'proses' => 'Proses',
            'selesai' => 'Selesai',
            'ditolak' => 'Ditolak',
        ];

        $categoryIcons = [
            'Keamanan' => '<span class="p-2 bg-rose-50 text-rose-600 rounded-xl border border-rose-100"><svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/></svg></span>',
            'Infrastruktur' => '<span class="p-2 bg-blue-50 text-blue-600 rounded-xl border border-blue-100"><svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.066 2.573c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.573 1.066c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.066-2.573c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/></svg></span>',
            'Kebersihan' => '<span class="p-2 bg-emerald-50 text-emerald-600 rounded-xl border border-emerald-100"><svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg></span>',
            'Sosial' => '<span class="p-2 bg-amber-50 text-amber-600 rounded-xl border border-amber-100"><svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/></svg></span>',
            'Kesehatan' => '<span class="p-2 bg-teal-50 text-teal-600 rounded-xl border border-teal-100"><svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"/></svg></span>',
            'Lainnya' => '<span class="p-2 bg-slate-50 text-slate-600 rounded-xl border border-slate-100"><svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M8 12h.01M12 12h.01M16 12h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg></span>',
        ];

        partial('header');
        partial('sidebar');
        app_view('masyarakat/pengaduan', array_merge(
            compact('stats', 'statusColors', 'statusText', 'categoryIcons'),
            $list,
            ['search' => $filters['search'] ?? '', 'statusFilter' => $filters['status'] ?? '']
        ));
        partial('footer');
    }

    public static function buat(): void
    {
        requireCitizen();
        $pageTitle = 'Buat Laporan Warga';
        
        partial('header');
        partial('sidebar');
        app_view('masyarakat/buat_pengaduan');
        partial('footer');
    }
}
