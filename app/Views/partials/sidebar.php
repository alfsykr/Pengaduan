<?php
// partial() berjalan di scope sendiri; variabel dari header tidak ikut ke file ini.
$user = currentUser() ?? [];
$currentPage = basename($_SERVER['PHP_SELF'], '.php');
?>
<!-- Sidebar Overlay (Mobile) -->
<div id="sidebar-overlay" class="sidebar-overlay fixed inset-0 z-40 lg:hidden" onclick="toggleSidebar()"></div>

<!-- Sidebar -->
<aside id="sidebar"
    class="fixed left-0 top-0 h-full w-[260px] bg-gradient-to-b from-primary-900 via-primary-900 to-primary-950 z-50 transform -translate-x-full lg:translate-x-0 transition-transform duration-300 flex flex-col">

    <!-- Brand -->
    <div class="px-6 py-6 border-b border-white/10">
        <h1 class="text-white font-bold text-lg">Desa Digital</h1>
        <p class="text-primary-300 text-xs font-medium tracking-wider uppercase mt-0.5">Layanan Kependudukan</p>
    </div>

    <!-- Navigation -->
    <nav class="flex-1 px-4 py-6 space-y-1 overflow-y-auto">
        <a href="<?= baseUrl('index.php') ?>"
            class="sidebar-link flex items-center gap-3 px-4 py-3 rounded-xl text-sm font-medium <?= $currentPage === 'index' ? 'active text-white' : 'text-primary-200 hover:text-white' ?>">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                    d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" />
            </svg>
            Beranda
        </a>

        <a href="<?= baseUrl('layanan.php') ?>"
            class="sidebar-link flex items-center gap-3 px-4 py-3 rounded-xl text-sm font-medium <?= ($currentPage === 'layanan' || $currentPage === 'form') ? 'active text-white' : 'text-primary-200 hover:text-white' ?>">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                    d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
            </svg>
            Layanan
        </a>

        <a href="<?= baseUrl('riwayat.php') ?>"
            class="sidebar-link flex items-center gap-3 px-4 py-3 rounded-xl text-sm font-medium <?= $currentPage === 'riwayat' ? 'active text-white' : 'text-primary-200 hover:text-white' ?>">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                    d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
            </svg>
            Riwayat
        </a>

        <a href="<?= baseUrl('profil.php') ?>"
            class="sidebar-link flex items-center gap-3 px-4 py-3 rounded-xl text-sm font-medium <?= $currentPage === 'profil' ? 'active text-white' : 'text-primary-200 hover:text-white' ?>">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                    d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
            </svg>
            Data Diri
        </a>

    </nav>

    <!-- Bottom Links -->
    <div class="px-4 py-4 border-t border-white/10 space-y-1">
        <a href="<?= baseUrl('settings.php') ?>"
            class="sidebar-link flex items-center gap-3 px-4 py-3 rounded-xl text-sm font-medium <?= $currentPage === 'settings' ? 'active text-white' : 'text-primary-200 hover:text-white' ?>">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                    d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.066 2.573c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.573 1.066c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.066-2.573c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z" />
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                    d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
            </svg>
            Pengaturan
        </a>

        <a href="<?= baseUrl('app/Controllers/AuthController.php?action=logout') ?>"
            class="sidebar-link flex items-center gap-3 px-4 py-3 rounded-xl text-sm font-medium text-red-300 hover:text-red-200">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                    d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" />
            </svg>
            Keluar
        </a>
    </div>
</aside>

<!-- Main Content Wrapper -->
<div class="lg:ml-[260px] min-h-screen">

    <!-- Top Navigation Bar -->
    <header class="sticky top-0 z-30 bg-white/80 backdrop-blur-lg border-b border-slate-100">
        <div class="flex items-center justify-between px-4 lg:px-8 py-3">
            <!-- Mobile Menu Button -->
            <button onclick="toggleSidebar()" type="button"
                class="lg:hidden p-2 rounded-xl hover:bg-slate-100 transition-all duration-150 active:scale-95">
                <svg class="w-6 h-6 text-slate-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                </svg>
            </button>

            <!-- Desktop Nav Links -->
            <nav class="hidden lg:flex items-center gap-6">
                <a href="<?= baseUrl('index.php') ?>"
                    class="app-topnav-link text-sm font-medium inline-block <?= $currentPage === 'index' ? 'text-primary-700' : 'text-slate-500 hover:text-slate-700' ?>">Beranda</a>
                <a href="<?= baseUrl('layanan.php') ?>"
                    class="app-topnav-link text-sm font-medium inline-block <?= ($currentPage === 'layanan' || $currentPage === 'form') ? 'text-primary-700' : 'text-slate-500 hover:text-slate-700' ?>">Layanan</a>
                <a href="<?= baseUrl('riwayat.php') ?>"
                    class="app-topnav-link text-sm font-medium inline-block <?= $currentPage === 'riwayat' ? 'text-primary-700' : 'text-slate-500 hover:text-slate-700' ?>">Riwayat</a>
                <a href="<?= baseUrl('settings.php') ?>"
                    class="app-topnav-link text-sm font-medium inline-block <?= $currentPage === 'settings' ? 'text-primary-700' : 'text-slate-500 hover:text-slate-700' ?>">Pengaturan</a>
            </nav>

            <div class="flex-1 lg:hidden"></div>

            <!-- Profil singkat -->
            <div class="flex items-center gap-3">
                <!-- User Avatar -->
                <div class="relative group">
                    <button type="button"
                        class="flex items-center gap-2 p-1 rounded-xl hover:bg-slate-100 transition-all duration-150 active:scale-95">
                        <div
                            class="w-8 h-8 rounded-full bg-gradient-to-br from-primary-500 to-primary-700 flex items-center justify-center text-white text-sm font-semibold">
                            <?= htmlspecialchars(strtoupper(substr(trim((string) ($user['nama_lengkap'] ?? '')), 0, 1)) ?: 'U') ?>
                        </div>
                    </button>
                    <!-- Dropdown -->
                    <div
                        class="absolute right-0 top-full mt-2 w-48 bg-white rounded-xl shadow-lg border border-slate-100 py-2 opacity-0 invisible group-hover:opacity-100 group-hover:visible transition-all duration-200">
                        <div class="px-4 py-2 border-b border-slate-100">
                            <p class="text-sm font-semibold text-slate-800">
                                <?= htmlspecialchars($user['nama_lengkap'] ?? 'User') ?>
                            </p>
                            <p class="text-xs text-slate-400">
                                <?= htmlspecialchars($user['email'] ?? '') ?>
                            </p>
                        </div>
                        <?php if (isAdmin()): ?>
                            <a href="<?= baseUrl('admin.php') ?>"
                                class="flex items-center gap-2 px-4 py-2 text-sm text-slate-600 hover:bg-slate-50 transition-transform duration-150 active:scale-[0.98]">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                        d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z" />
                                </svg>
                                Admin Panel
                            </a>
                        <?php endif; ?>
                        <a href="<?= baseUrl('profil.php') ?>"
                            class="flex items-center gap-2 px-4 py-2 text-sm text-slate-600 hover:bg-slate-50 transition-transform duration-150 active:scale-[0.98]">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                    d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                            </svg>
                            Data Diri
                        </a>
                        <a href="<?= baseUrl('settings.php') ?>"
                            class="flex items-center gap-2 px-4 py-2 text-sm text-slate-600 hover:bg-slate-50 transition-transform duration-150 active:scale-[0.98]">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                    d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.066 2.573c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.573 1.066c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.066-2.573c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z" />
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                    d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                            </svg>
                            Pengaturan
                        </a>
                        <a href="<?= baseUrl('app/Controllers/AuthController.php?action=logout') ?>"
                            class="flex items-center gap-2 px-4 py-2 text-sm text-red-500 hover:bg-red-50 transition-transform duration-150 active:scale-[0.98]">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                    d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" />
                            </svg>
                            Keluar
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </header>

    <!-- Page Content -->
    <main class="p-4 lg:p-8">