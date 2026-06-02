<?php
// Admin sidebar - matches the mockup design
$adminPage = $_GET['page'] ?? 'dashboard';
$user = currentUser();
?>

<!-- Sidebar Overlay (Mobile) -->
<div id="sidebar-overlay" class="sidebar-overlay fixed inset-0 z-40 lg:hidden" onclick="toggleSidebar()"></div>

<!-- Admin Sidebar -->
<aside id="sidebar"
    class="fixed left-0 top-0 h-full w-[250px] bg-white border-r border-slate-100 z-50 transform -translate-x-full lg:translate-x-0 transition-transform duration-300 flex flex-col">

    <!-- Brand -->
    <div class="px-5 py-5 flex items-center gap-3">
        <div class="w-9 h-9 rounded-xl bg-primary-600 flex items-center justify-center">
            <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                    d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
            </svg>
        </div>
        <div>
            <h1 class="text-sm font-bold text-slate-800 leading-tight">Dukcapil Desa</h1>
            <p class="text-[10px] text-slate-400 font-medium">Sistem Layanan Mandiri</p>
        </div>
    </div>

    <!-- Navigation -->
    <nav class="flex-1 px-3 py-4 space-y-1" id="admin-sidebar-nav">
        <a href="<?= baseUrl('admin.php') ?>"
            class="admin-sidebar-link flex items-center gap-3 px-3 py-2.5 rounded-xl text-sm font-medium <?= $adminPage === 'dashboard' ? 'is-active bg-primary-50 text-primary-700' : 'text-slate-500 hover:bg-slate-50 hover:text-slate-700' ?>">
            <svg class="w-[18px] h-[18px]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                    d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zm10 0a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zm10 0a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z" />
            </svg>
            Dashboard
        </a>

        <a href="<?= baseUrl('admin.php?page=permohonan') ?>"
            class="admin-sidebar-link flex items-center gap-3 px-3 py-2.5 rounded-xl text-sm font-medium <?= $adminPage === 'permohonan' ? 'is-active bg-primary-50 text-primary-700' : 'text-slate-500 hover:bg-slate-50 hover:text-slate-700' ?>">
            <svg class="w-[18px] h-[18px]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                    d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
            </svg>
            Permohonan Masuk
        </a>

        <a href="<?= baseUrl('admin.php?page=pengaduan') ?>"
            class="admin-sidebar-link flex items-center gap-3 px-3 py-2.5 rounded-xl text-sm font-medium <?= ($adminPage === 'pengaduan' || $adminPage === 'detail_pengaduan') ? 'is-active bg-primary-50 text-primary-700' : 'text-slate-500 hover:bg-slate-50 hover:text-slate-700' ?>">
            <svg class="w-[18px] h-[18px]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                    d="M8.684 13.342C8.886 12.938 9 12.482 9 12c0-.482-.114-.938-.316-1.342m0 2.684a3 3 0 110-2.684m0 2.684l6.632 3.316m-6.632-6l6.632-3.316m0 0a3 3 0 105.367-2.684 3 3 0 00-5.367 2.684zm0 9.316a3 3 0 105.368 2.684 3 3 0 00-5.368-2.684z" />
            </svg>
            Pengaduan Warga
        </a>

        <a href="<?= baseUrl('admin.php?page=arsip') ?>"
            class="admin-sidebar-link flex items-center gap-3 px-3 py-2.5 rounded-xl text-sm font-medium <?= $adminPage === 'arsip' ? 'is-active bg-primary-50 text-primary-700' : 'text-slate-500 hover:bg-slate-50 hover:text-slate-700' ?>">
            <svg class="w-[18px] h-[18px]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                    d="M5 8h14M5 8a2 2 0 110-4h14a2 2 0 110 4M5 8v10a2 2 0 002 2h10a2 2 0 002-2V8m-9 4h4" />
            </svg>
            Arsip
        </a>

        <?php if (!isLurah()): ?>
        <a href="<?= baseUrl('admin.php?page=users') ?>"
            class="admin-sidebar-link flex items-center gap-3 px-3 py-2.5 rounded-xl text-sm font-medium <?= $adminPage === 'users' ? 'is-active bg-primary-50 text-primary-700' : 'text-slate-500 hover:bg-slate-50 hover:text-slate-700' ?>">
            <svg class="w-[18px] h-[18px]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                    d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" />
            </svg>
            Manajemen User
        </a>
        <?php endif; ?>

        <a href="<?= baseUrl('admin.php?page=settings') ?>"
            class="admin-sidebar-link flex items-center gap-3 px-3 py-2.5 rounded-xl text-sm font-medium <?= $adminPage === 'settings' ? 'is-active bg-primary-50 text-primary-700' : 'text-slate-500 hover:bg-slate-50 hover:text-slate-700' ?>">
            <svg class="w-[18px] h-[18px]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                    d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.066 2.573c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.573 1.066c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.066-2.573c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z" />
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                    d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
            </svg>
            Settings
        </a>
    </nav>

    <!-- Admin Profile -->
    <div class="px-4 py-4 border-t border-slate-100">
        <div class="flex items-center justify-between gap-2">
            <div class="flex items-center gap-3 min-w-0">
                <div
                    class="w-9 h-9 rounded-full bg-gradient-to-br from-primary-400 to-primary-600 flex items-center justify-center text-white text-sm font-bold shrink-0">
                    <?= strtoupper(substr($user['nama_lengkap'] ?? 'A', 0, 1)) ?>
                </div>
                <div class="min-w-0">
                    <p class="text-sm font-semibold text-slate-800 truncate">
                        <?= htmlspecialchars($user['nama_lengkap'] ?? 'Admin') ?>
                    </p>
                    <p class="text-[10px] text-slate-400 font-medium"><?= isLurah() ? 'Lurah' : 'Petugas Layanan' ?></p>
                </div>
            </div>
            <a href="<?= baseUrl('app/Controllers/AuthController.php?action=logout') ?>" 
               class="p-2 rounded-xl text-red-500 hover:bg-red-50 hover:text-red-700 transition-colors shrink-0" 
               title="Keluar">
                <svg class="w-[18px] h-[18px]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                        d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" />
                </svg>
            </a>
        </div>
    </div>
</aside>

<!-- Main Content Wrapper -->
<div class="lg:ml-[250px] min-h-screen flex flex-col">

    <!-- Top Navigation Bar -->
    <header class="sticky top-0 z-30 bg-white border-b border-slate-100">
        <div class="flex items-center px-4 lg:px-6 py-3 gap-3">
            <!-- Mobile Menu -->
            <button type="button" onclick="toggleSidebar()"
                class="lg:hidden p-2 rounded-xl hover:bg-slate-100 shrink-0 transition-all duration-150 active:scale-95">
                <svg class="w-5 h-5 text-slate-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                </svg>
            </button>

            <div class="flex-1 min-w-0" aria-hidden="true"></div>

            <!-- Profil admin -->
            <div class="flex items-center gap-2 pl-0 lg:pl-2 lg:border-l lg:border-slate-200 shrink-0">
                    <div
                        class="w-8 h-8 rounded-full bg-gradient-to-br from-primary-400 to-primary-600 flex items-center justify-center text-white text-xs font-bold">
                        <?= strtoupper(substr($user['nama_lengkap'] ?? 'A', 0, 1)) ?>
                    </div>
                    <span class="hidden lg:block text-sm font-medium text-slate-700">
                        <?= htmlspecialchars($user['nama_lengkap'] ?? 'Admin') ?>
                    </span>
                </div>
        </div>
    </header>

    <!-- Page Content -->
    <main class="flex-1 p-4 lg:p-6">