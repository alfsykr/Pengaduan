<?php
$user = $user ?? [];
$hasAvatar = !empty($user['avatar']);
$alamatUtama = trim((string) ($user['alamat'] ?? ''));
$rt = trim((string) ($user['rt'] ?? ''));
$rw = trim((string) ($user['rw'] ?? ''));
$kel = trim((string) ($user['kelurahan'] ?? ''));
$kec = trim((string) ($user['kecamatan'] ?? ''));
$kota = trim((string) ($user['kota'] ?? ''));
$prov = trim((string) ($user['provinsi'] ?? ''));
$pos = trim((string) ($user['kode_pos'] ?? ''));

$alamatBaris = [];
if ($alamatUtama !== '') {
    $alamatBaris[] = $alamatUtama;
}
if ($rt !== '' || $rw !== '') {
    $alamatBaris[] = 'RT ' . ($rt !== '' ? $rt : '-') . '/RW ' . ($rw !== '' ? $rw : '-');
}
$wilayah = array_filter([
    $kel !== '' ? $kel : null,
    $kec !== '' ? ('Kecamatan ' . $kec) : null,
    $kota !== '' ? $kota : null,
    $prov !== '' ? $prov : null,
    $pos !== '' ? $pos : null,
]);
if ($wilayah !== []) {
    $alamatBaris[] = implode(', ', $wilayah);
}
$formattedAlamat = $alamatBaris !== [] ? implode(', ', $alamatBaris) : 'Belum ada alamat terdaftar — lengkapi di tab Detail Alamat.';
$mapsQuery = urlencode($formattedAlamat);
?>

<div class="pb-8">
    <nav class="flex items-center gap-2 text-sm mb-6 animate-fade-in">
        <a href="<?= baseUrl('index.php') ?>" class="text-slate-400 hover:text-slate-600">Beranda</a>
        <svg class="w-4 h-4 text-slate-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
        </svg>
        <span class="text-primary-600 font-medium">Pengaturan</span>
    </nav>

    <div class="mb-8 animate-fade-in animate-delay-1">
        <h1 class="text-3xl font-bold text-slate-900 tracking-tight">Pengaturan</h1>
        <p class="text-slate-500 mt-1 text-sm lg:text-base">Kelola profil, alamat, dan keamanan akun Anda.</p>
    </div>

    <div class="flex flex-col lg:flex-row gap-8 lg:gap-10 animate-fade-in animate-delay-2">
        <!-- Sub-nav -->
        <aside class="w-full lg:w-[280px] shrink-0">
            <div class="bg-white rounded-2xl border border-slate-100 shadow-sm overflow-hidden">
                <p class="text-[11px] font-semibold text-slate-400 uppercase tracking-wider px-4 pt-4 pb-2">Menu
                    pengaturan</p>
                <nav class="flex flex-col p-2 gap-0.5">
                    <button type="button" data-settings-tab="profil"
                        class="settings-nav-btn w-full flex items-center gap-3 px-4 py-3 rounded-xl text-sm font-semibold text-left transition-all duration-200 ease-out will-change-transform active:scale-[0.98] bg-primary-50 text-primary-800 border border-primary-100/80">
                        <svg class="w-5 h-5 shrink-0 text-primary-700" fill="none" stroke="currentColor"
                            viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.6"
                                d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                        </svg>
                        Profil Saya
                    </button>
                    <button type="button" data-settings-tab="keamanan"
                        class="settings-nav-btn w-full flex items-center gap-3 px-4 py-3 rounded-xl text-sm font-semibold text-left transition-all duration-200 ease-out will-change-transform active:scale-[0.98] text-slate-600 hover:bg-slate-50 border border-transparent">
                        <svg class="w-5 h-5 shrink-0 text-slate-500" fill="none" stroke="currentColor"
                            viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.6"
                                d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                        </svg>
                        Keamanan
                    </button>
                    <button type="button" data-settings-tab="alamat"
                        class="settings-nav-btn w-full flex items-center gap-3 px-4 py-3 rounded-xl text-sm font-semibold text-left transition-all duration-200 ease-out will-change-transform active:scale-[0.98] text-slate-600 hover:bg-slate-50 border border-transparent">
                        <svg class="w-5 h-5 shrink-0 text-slate-500" fill="none" stroke="currentColor"
                            viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.6"
                                d="M17.657 16.657L13.414 20.9a2 2 0 01-2.827 0l-4.243-4.243a8 8 0 1111.313 0z" />
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.6"
                                d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                        </svg>
                        Detail Alamat
                    </button>
                </nav>
                <div class="border-t border-slate-100 p-2 mt-1">
                    <a href="<?= baseUrl('app/Controllers/AuthController.php?action=logout') ?>"
                        class="flex items-center gap-3 px-4 py-3 rounded-xl text-sm font-semibold text-red-600 hover:bg-red-50 transition-all duration-150 ease-out will-change-transform active:scale-[0.97]">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.6"
                                d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" />
                        </svg>
                        Keluar Sesi
                    </a>
                </div>
            </div>
        </aside>

        <!-- Konten + form -->
        <div class="flex-1 min-w-0 space-y-6">
            <form id="settings-remove-avatar-form" method="POST" action="<?= baseUrl('settings.php') ?>" class="hidden"
                aria-hidden="true">
                <input type="hidden" name="action" value="remove_avatar">
            </form>

            <form id="settings-main-form" method="POST" action="<?= baseUrl('settings.php') ?>"
                enctype="multipart/form-data" class="space-y-6">
                <input type="hidden" name="action" value="save_settings">

                <!-- Panel: Profil -->
                <div id="settings-panel-profil" class="settings-panel space-y-6">
                    <!-- Foto profil (unggah/hapus hanya saat mode ubah dari kartu Informasi Pribadi) -->
                    <div id="settings-foto-zone"
                        class="bg-white rounded-2xl border border-slate-100 shadow-sm p-6 lg:p-8 pointer-events-none opacity-60 saturate-75 transition-opacity">
                        <div class="flex flex-col sm:flex-row sm:items-start gap-6">
                            <div class="relative shrink-0 mx-auto sm:mx-0">
                                <div
                                    class="w-36 h-36 rounded-2xl bg-slate-100 overflow-hidden border border-slate-200 shadow-inner">
                                    <?php if ($hasAvatar): ?>
                                        <img src="<?= baseUrl('uploads/avatars/' . rawurlencode((string) $user['avatar'])) ?>"
                                            alt="" class="w-full h-full object-cover">
                                    <?php else: ?>
                                        <div
                                            class="w-full h-full flex items-center justify-center bg-gradient-to-br from-primary-500 to-primary-800 text-white text-4xl font-bold">
                                            <?= strtoupper(substr(trim((string) ($user['nama_lengkap'] ?? '')), 0, 1) ?: 'U') ?>
                                        </div>
                                    <?php endif; ?>
                                </div>
                                <label for="settings-avatar-input"
                                    class="avatar-edit-label absolute -bottom-2 -right-2 w-10 h-10 rounded-full bg-primary-600 text-white shadow-lg flex items-center justify-center cursor-pointer hover:bg-primary-700 transition-colors border-4 border-white"
                                    title="Ubah foto">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z" />
                                    </svg>
                                </label>
                                <input type="file" id="settings-avatar-input" name="avatar" accept="image/jpeg,image/png,image/webp"
                                    class="sr-only" tabindex="-1" disabled aria-disabled="true">
                            </div>
                            <div class="flex-1 text-center sm:text-left">
                                <h3 class="text-lg font-bold text-slate-900">Foto Profil</h3>
                                <p class="text-sm text-slate-500 mt-2 leading-relaxed max-w-md mx-auto sm:mx-0">
                                    Gunakan foto wajah terbaru untuk kemudahan verifikasi identitas di kantor desa.
                                    JPG, PNG, atau WebP — maks. 2MB.
                                </p>
                                <p id="settings-foto-hint" class="text-xs text-amber-700 font-medium mt-3">Klik <span
                                        class="font-bold">Ubah Data</span>
                                    pada Informasi Pribadi untuk mengganti foto.</p>
                                <div id="settings-avatar-upload-row"
                                    class="flex flex-wrap items-center justify-center sm:justify-start gap-3 mt-4 hidden">
                                    <label for="settings-avatar-input"
                                        class="inline-flex items-center justify-center px-5 py-2.5 rounded-xl bg-primary-50 text-primary-800 text-sm font-semibold border border-primary-100 hover:bg-primary-100 cursor-pointer transition-colors">
                                        Unggah Baru
                                    </label>
                                    <?php if ($hasAvatar): ?>
                                        <button type="submit" form="settings-remove-avatar-form"
                                            onclick="return confirm('Hapus foto profil Anda?');"
                                            class="btn-remove-photo px-5 py-2.5 rounded-xl text-sm font-semibold text-slate-600 hover:bg-slate-100 transition-colors">
                                            Hapus Foto
                                        </button>
                                    <?php endif; ?>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Informasi pribadi -->
                    <div class="bg-white rounded-2xl border border-slate-100 shadow-sm p-6 lg:p-8">
                        <div class="flex flex-wrap items-start justify-between gap-4 mb-6 pb-4 border-b border-slate-100">
                            <div class="flex items-center gap-3">
                                <div class="w-11 h-11 rounded-xl bg-primary-50 flex items-center justify-center">
                                    <svg class="w-6 h-6 text-primary-700" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.6"
                                            d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                                    </svg>
                                </div>
                                <div>
                                    <h3 class="text-lg font-bold text-slate-900">Informasi Pribadi</h3>
                                    <p class="text-xs text-slate-400 mt-0.5">Data yang tampil di layanan mandiri</p>
                                </div>
                            </div>
                            <div class="flex flex-wrap items-center gap-2">
                                <span
                                    class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full bg-emerald-50 text-emerald-800 text-xs font-bold border border-emerald-100">
                                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M5 13l4 4L19 7" />
                                    </svg>
                                    DATA TERVERIFIKASI
                                </span>
                                <button type="button" id="settings-btn-edit-profil"
                                    class="inline-flex items-center gap-2 px-4 py-2 rounded-xl bg-primary-700 hover:bg-primary-800 text-white text-sm font-semibold transition-colors shadow-sm">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M11 5h2m-1-1v2m8.364 2.636a2 2 0 010 2.828l-8.486 8.486-4.243 1.414 1.414-4.243 8.486-8.486a2 2 0 012.829 0z" />
                                    </svg>
                                    Ubah Data
                                </button>
                            </div>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                            <div>
                                <label class="flex items-center gap-2 text-xs font-semibold text-slate-500 mb-2">
                                    <svg class="w-4 h-4 text-slate-400" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.6"
                                            d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                                    </svg>
                                    Nama Lengkap
                                </label>
                                <input type="text" id="settings-nama" name="nama_lengkap" required readonly
                                    value="<?= htmlspecialchars((string) ($user['nama_lengkap'] ?? '')) ?>"
                                    class="settings-profil-field w-full px-4 py-3 rounded-xl border border-slate-200 text-sm text-slate-800 bg-slate-50 cursor-default focus:outline-none focus:ring-2 focus:ring-primary-500/25 focus:border-primary-500">
                            </div>
                            <div>
                                <label class="flex items-center gap-2 text-xs font-semibold text-slate-500 mb-2">
                                    <svg class="w-4 h-4 text-slate-400" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.6"
                                            d="M10 6H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V8a2 2 0 00-2-2h-5m-4 0V5a2 2 0 114 0v1m-4 0a2 2 0 104 0m-5 4h10" />
                                    </svg>
                                    NIK (Nomor Induk Kependudukan)
                                </label>
                                <input type="text" id="settings-nik" name="nik" maxlength="16" required readonly inputmode="numeric"
                                    value="<?= htmlspecialchars((string) ($user['nik'] ?? '')) ?>"
                                    class="settings-profil-field w-full px-4 py-3 rounded-xl border border-slate-200 text-sm text-slate-800 bg-slate-50 cursor-default focus:outline-none focus:ring-2 focus:ring-primary-500/25 focus:border-primary-500">
                            </div>
                            <div>
                                <label class="flex items-center gap-2 text-xs font-semibold text-slate-500 mb-2">
                                    <svg class="w-4 h-4 text-slate-400" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.6"
                                            d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.517l1.13-2.258a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z" />
                                    </svg>
                                    Nomor Telepon
                                </label>
                                <input type="text" id="settings-hp" name="no_hp" readonly
                                    value="<?= htmlspecialchars((string) ($user['no_hp'] ?? '')) ?>"
                                    class="settings-profil-field w-full px-4 py-3 rounded-xl border border-slate-200 text-sm text-slate-800 bg-slate-50 cursor-default focus:outline-none focus:ring-2 focus:ring-primary-500/25 focus:border-primary-500"
                                    placeholder="+62 …">
                            </div>
                            <div>
                                <label class="flex items-center gap-2 text-xs font-semibold text-slate-500 mb-2">
                                    <svg class="w-4 h-4 text-slate-400" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.6"
                                            d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                                    </svg>
                                    Alamat Email
                                </label>
                                <input type="email" readonly tabindex="-1"
                                    value="<?= htmlspecialchars((string) ($user['email'] ?? '')) ?>"
                                    class="w-full px-4 py-3 rounded-xl border border-slate-200 text-sm text-slate-500 bg-slate-50 cursor-not-allowed"
                                    title="Email mengikuti akun Anda saat registrasi / login">
                                <p class="text-[11px] text-slate-400 mt-1.5">Email tidak dapat diubah dari halaman ini.</p>
                            </div>
                        </div>

                        <div id="settings-profil-actions" class="hidden flex flex-wrap items-center justify-end gap-3 mt-8 pt-6 border-t border-slate-100">
                            <button type="button" id="settings-btn-cancel-profil"
                                class="px-5 py-2.5 rounded-xl text-sm font-semibold text-slate-600 hover:bg-slate-100 transition-colors">
                                Batalkan
                            </button>
                            <button type="submit"
                                class="px-8 py-3 rounded-xl bg-primary-700 hover:bg-primary-800 text-white text-sm font-bold shadow-lg shadow-primary-700/20 transition-colors">
                                Simpan Perubahan
                            </button>
                        </div>
                    </div>

                    <!-- Ringkasan alamat (panel profil) -->
                    <div class="bg-white rounded-2xl border border-slate-100 shadow-sm p-6 lg:p-8">
                        <div class="flex items-center gap-3 mb-5">
                            <div class="w-11 h-11 rounded-xl bg-blue-50 flex items-center justify-center">
                                <svg class="w-6 h-6 text-blue-700" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.6"
                                        d="M17.657 16.657L13.414 20.9a2 2 0 01-2.827 0l-4.243-4.243a8 8 0 1111.313 0z" />
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.6"
                                        d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                                </svg>
                            </div>
                            <h3 class="text-lg font-bold text-slate-900">Detail Alamat</h3>
                        </div>
                        <div class="rounded-2xl bg-gradient-to-br from-primary-700 to-primary-900 text-white p-6 shadow-lg">
                            <div class="flex items-start gap-3 mb-4">
                                <div class="w-10 h-10 rounded-full bg-white/15 flex items-center justify-center shrink-0">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M5 13l4 4L19 7" />
                                    </svg>
                                </div>
                                <div>
                                    <p class="text-[11px] font-bold uppercase tracking-wider text-primary-200">Domisili resmi
                                        terdaftar</p>
                                    <p class="text-base font-medium leading-relaxed mt-1"><?= htmlspecialchars($formattedAlamat) ?>
                                    </p>
                                </div>
                            </div>
                            <div class="flex flex-wrap gap-3 pt-2">
                                <a href="https://www.google.com/maps/search/?api=1&query=<?= $mapsQuery ?>"
                                    target="_blank" rel="noopener noreferrer"
                                    class="inline-flex items-center justify-center px-4 py-2.5 rounded-xl bg-white/10 hover:bg-white/20 text-sm font-semibold border border-white/20 transition-colors">
                                    Lihat di Peta
                                </a>
                                <a href="<?= baseUrl('layanan.php') ?>"
                                    class="inline-flex items-center justify-center px-4 py-2.5 rounded-xl bg-white text-primary-800 text-sm font-semibold hover:bg-primary-50 transition-colors">
                                    Ajukan layanan
                                </a>
                                <button type="button" id="settings-btn-goto-edit-alamat"
                                    class="inline-flex items-center justify-center px-4 py-2.5 rounded-xl bg-white/20 hover:bg-white/30 text-sm font-semibold border border-white/30 text-white transition-colors">
                                    Ubah alamat
                                </button>
                            </div>
                        </div>
                        <p class="text-xs text-slate-400 mt-4">Alamat dapat diedit lengkap dari tab Detail Alamat setelah Anda
                            klik Ubah Data di sana.</p>
                    </div>
                </div>

                <!-- Panel: Keamanan -->
                <div id="settings-panel-keamanan" class="settings-panel hidden space-y-6">
                    <div class="bg-white rounded-2xl border border-slate-100 shadow-sm p-6 lg:p-8">
                        <div class="flex items-center gap-3 mb-2">
                            <div class="w-11 h-11 rounded-xl bg-amber-50 flex items-center justify-center">
                                <svg class="w-6 h-6 text-amber-700" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.6"
                                        d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                                </svg>
                            </div>
                            <div>
                                <h3 class="text-lg font-bold text-slate-900">Keamanan akun</h3>
                                <p class="text-sm text-slate-500">Lindungi akun dengan kata sandi yang kuat.</p>
                            </div>
                        </div>
                        <div
                            class="mt-8 flex flex-col sm:flex-row sm:items-center justify-between gap-4 bg-slate-50 border border-slate-100 rounded-xl p-6">
                            <div class="flex items-start gap-4">
                                <div
                                    class="w-14 h-14 rounded-2xl bg-white border border-slate-200 flex items-center justify-center text-slate-500 font-bold">
                                    •••</div>
                                <div>
                                    <p class="font-bold text-slate-900 text-lg">Kata sandi</p>
                                    <p class="text-sm text-slate-500 mt-1 max-w-md">Gunakan kombinasi huruf, angka, dan simbol.
                                        Minimal 6 karakter.</p>
                                </div>
                            </div>
                            <button type="button" onclick="openPasswordModal()"
                                class="shrink-0 px-8 py-3.5 rounded-xl bg-primary-700 hover:bg-primary-800 text-white font-semibold shadow-md shadow-primary-700/20 transition-colors">
                                Ubah Kata Sandi
                            </button>
                        </div>
                    </div>
                </div>

                <!-- Panel: Detail alamat (input) -->
                <div id="settings-panel-alamat" class="settings-panel hidden space-y-6">
                    <div class="bg-white rounded-2xl border border-slate-100 shadow-sm p-6 lg:p-8">
                        <div class="flex flex-wrap items-start justify-between gap-4 mb-6">
                            <div>
                                <h3 class="text-lg font-bold text-slate-900 mb-1">Detail Alamat</h3>
                                <p class="text-sm text-slate-500">Lengkapi alamat sesuai dokumen kependudukan Anda.</p>
                            </div>
                            <button type="button" id="settings-btn-edit-alamat"
                                class="inline-flex items-center gap-2 px-4 py-2 rounded-xl bg-primary-700 hover:bg-primary-800 text-white text-sm font-semibold transition-colors shadow-sm shrink-0">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M11 5h2m-1-1v2m8.364 2.636a2 2 0 010 2.828l-8.486 8.486-4.243 1.414 1.414-4.243 8.486-8.486a2 2 0 012.829 0z" />
                                </svg>
                                Ubah Data
                            </button>
                        </div>
                        <div class="space-y-5">
                            <div>
                                <label class="block text-xs font-semibold text-slate-500 mb-2">Alamat lengkap</label>
                                <textarea name="alamat" rows="3" readonly
                                    class="settings-alamat-field w-full px-4 py-3 rounded-xl border border-slate-200 text-sm bg-slate-50 cursor-default focus:outline-none focus:ring-2 focus:ring-primary-500/25 focus:border-primary-500"><?= htmlspecialchars((string) ($user['alamat'] ?? '')) ?></textarea>
                            </div>
                            <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">
                                <div>
                                    <label class="block text-xs font-semibold text-slate-500 mb-2">RT</label>
                                    <input type="text" name="rt" readonly
                                        value="<?= htmlspecialchars((string) ($user['rt'] ?? '')) ?>"
                                        class="settings-alamat-field w-full px-4 py-3 rounded-xl border border-slate-200 text-sm bg-slate-50 cursor-default focus:outline-none focus:ring-2 focus:ring-primary-500/25 focus:border-primary-500">
                                </div>
                                <div>
                                    <label class="block text-xs font-semibold text-slate-500 mb-2">RW</label>
                                    <input type="text" name="rw" readonly
                                        value="<?= htmlspecialchars((string) ($user['rw'] ?? '')) ?>"
                                        class="settings-alamat-field w-full px-4 py-3 rounded-xl border border-slate-200 text-sm bg-slate-50 cursor-default focus:outline-none focus:ring-2 focus:ring-primary-500/25 focus:border-primary-500">
                                </div>
                                <div>
                                    <label class="block text-xs font-semibold text-slate-500 mb-2">Kelurahan / Desa</label>
                                    <input type="text" name="kelurahan" readonly
                                        value="<?= htmlspecialchars((string) ($user['kelurahan'] ?? '')) ?>"
                                        class="settings-alamat-field w-full px-4 py-3 rounded-xl border border-slate-200 text-sm bg-slate-50 cursor-default focus:outline-none focus:ring-2 focus:ring-primary-500/25 focus:border-primary-500">
                                </div>
                                <div>
                                    <label class="block text-xs font-semibold text-slate-500 mb-2">Kecamatan</label>
                                    <input type="text" name="kecamatan" readonly
                                        value="<?= htmlspecialchars((string) ($user['kecamatan'] ?? '')) ?>"
                                        class="settings-alamat-field w-full px-4 py-3 rounded-xl border border-slate-200 text-sm bg-slate-50 cursor-default focus:outline-none focus:ring-2 focus:ring-primary-500/25 focus:border-primary-500">
                                </div>
                                <div>
                                    <label class="block text-xs font-semibold text-slate-500 mb-2">Kota / Kabupaten</label>
                                    <input type="text" name="kota" readonly
                                        value="<?= htmlspecialchars((string) ($user['kota'] ?? '')) ?>"
                                        class="settings-alamat-field w-full px-4 py-3 rounded-xl border border-slate-200 text-sm bg-slate-50 cursor-default focus:outline-none focus:ring-2 focus:ring-primary-500/25 focus:border-primary-500">
                                </div>
                                <div>
                                    <label class="block text-xs font-semibold text-slate-500 mb-2">Provinsi</label>
                                    <input type="text" name="provinsi" readonly
                                        value="<?= htmlspecialchars((string) ($user['provinsi'] ?? '')) ?>"
                                        class="settings-alamat-field w-full px-4 py-3 rounded-xl border border-slate-200 text-sm bg-slate-50 cursor-default focus:outline-none focus:ring-2 focus:ring-primary-500/25 focus:border-primary-500">
                                </div>
                                <div class="sm:col-span-2">
                                    <label class="block text-xs font-semibold text-slate-500 mb-2">Kode pos</label>
                                    <input type="text" name="kode_pos" maxlength="10" readonly
                                        value="<?= htmlspecialchars((string) ($user['kode_pos'] ?? '')) ?>"
                                        class="settings-alamat-field w-full px-4 py-3 rounded-xl border border-slate-200 text-sm bg-slate-50 cursor-default focus:outline-none focus:ring-2 focus:ring-primary-500/25 focus:border-primary-500 max-w-xs">
                                </div>
                                <div class="sm:col-span-2">
                                    <label class="block text-xs font-semibold text-slate-500 mb-2">Alamat domisili (opsional)</label>
                                    <textarea name="alamat_domisili" rows="2" readonly
                                        class="settings-alamat-field w-full px-4 py-3 rounded-xl border border-slate-200 text-sm bg-slate-50 cursor-default focus:outline-none focus:ring-2 focus:ring-primary-500/25 focus:border-primary-500"><?= htmlspecialchars((string) ($user['alamat_domisili'] ?? '')) ?></textarea>
                                </div>
                            </div>
                        </div>

                        <div id="settings-alamat-actions" class="hidden flex flex-wrap items-center justify-end gap-3 mt-8 pt-6 border-t border-slate-100">
                            <button type="button" id="settings-btn-cancel-alamat"
                                class="px-5 py-2.5 rounded-xl text-sm font-semibold text-slate-600 hover:bg-slate-100 transition-colors">
                                Batalkan
                            </button>
                            <button type="submit"
                                class="px-8 py-3 rounded-xl bg-primary-700 hover:bg-primary-800 text-white text-sm font-bold shadow-lg shadow-primary-700/20 transition-colors">
                                Simpan Perubahan
                            </button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Modal password -->
<div id="password-modal" class="fixed inset-0 z-[120] hidden">
    <div class="absolute inset-0 bg-black/40" onclick="closePasswordModal()"></div>
    <div class="relative max-w-lg mx-auto mt-24 bg-white rounded-2xl shadow-xl border border-slate-100 overflow-hidden">
        <div class="p-5 border-b border-slate-100 flex items-center justify-between">
            <h4 class="font-bold text-slate-800">Ubah kata sandi</h4>
            <button type="button" onclick="closePasswordModal()" class="p-2 rounded-lg hover:bg-slate-100">
                <svg class="w-5 h-5 text-slate-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                </svg>
            </button>
        </div>
        <form method="POST" action="<?= baseUrl('settings.php') ?>" class="p-5 space-y-4">
            <input type="hidden" name="action" value="change_password">
            <div>
                <label class="block text-sm font-medium text-slate-700 mb-1">Kata sandi saat ini</label>
                <input type="password" name="current_password" required autocomplete="current-password"
                    class="w-full px-4 py-3 rounded-xl border border-slate-200 text-sm focus:outline-none focus:ring-2 focus:ring-primary-200 focus:border-primary-500">
            </div>
            <div>
                <label class="block text-sm font-medium text-slate-700 mb-1">Kata sandi baru</label>
                <input type="password" name="new_password" minlength="6" required autocomplete="new-password"
                    class="w-full px-4 py-3 rounded-xl border border-slate-200 text-sm focus:outline-none focus:ring-2 focus:ring-primary-200 focus:border-primary-500">
            </div>
            <div>
                <label class="block text-sm font-medium text-slate-700 mb-1">Konfirmasi kata sandi baru</label>
                <input type="password" name="confirm_password" minlength="6" required autocomplete="new-password"
                    class="w-full px-4 py-3 rounded-xl border border-slate-200 text-sm focus:outline-none focus:ring-2 focus:ring-primary-200 focus:border-primary-500">
            </div>
            <div class="flex items-center justify-end gap-2 pt-2">
                <button type="button" onclick="closePasswordModal()"
                    class="px-4 py-2.5 rounded-xl border border-slate-200 text-sm font-semibold text-slate-600 hover:bg-slate-50">
                    Batal
                </button>
                <button type="submit"
                    class="px-5 py-2.5 rounded-xl bg-primary-700 hover:bg-primary-800 text-white font-semibold text-sm">
                    Simpan
                </button>
            </div>
        </form>
    </div>
</div>

<script>
    function switchSettingsTab(tab) {
        document.querySelectorAll('.settings-panel').forEach((el) => {
            el.classList.toggle('hidden', el.id !== 'settings-panel-' + tab);
        });
        const visible = document.getElementById('settings-panel-' + tab);
        if (visible && typeof window.uiAnimateTabPanel === 'function') {
            window.uiAnimateTabPanel(visible);
        }
        document.querySelectorAll('[data-settings-tab]').forEach((btn) => {
            const on = btn.getAttribute('data-settings-tab') === tab;
            btn.classList.toggle('bg-primary-50', on);
            btn.classList.toggle('text-primary-800', on);
            btn.classList.toggle('border-primary-100/80', on);
            btn.classList.toggle('border', on);
            btn.classList.toggle('text-slate-600', !on);
            btn.classList.toggle('hover:bg-slate-50', !on);
            btn.classList.toggle('border-transparent', !on);
        });
    }

    document.querySelectorAll('[data-settings-tab]').forEach((btn) => {
        btn.addEventListener('click', () => switchSettingsTab(btn.getAttribute('data-settings-tab')));
    });

    function openPasswordModal() {
        const m = document.getElementById('password-modal');
        if (!m) return;
        m.classList.remove('hidden');
        const first = m.querySelector('input[name="current_password"]');
        if (first) setTimeout(() => first.focus(), 50);
    }

    function closePasswordModal() {
        const m = document.getElementById('password-modal');
        if (!m) return;
        m.classList.add('hidden');
        m.querySelectorAll('input[type="password"]').forEach((i) => { i.value = ''; });
    }

    document.addEventListener('keydown', (e) => {
        if (e.key === 'Escape') closePasswordModal();
    });

    (function () {
        var fotoZone = document.getElementById('settings-foto-zone');
        var fotoHint = document.getElementById('settings-foto-hint');
        var avatarInput = document.getElementById('settings-avatar-input');
        var uploadRow = document.getElementById('settings-avatar-upload-row');
        var btnEditProfil = document.getElementById('settings-btn-edit-profil');
        var btnCancelProfil = document.getElementById('settings-btn-cancel-profil');
        var actionsProfil = document.getElementById('settings-profil-actions');
        var profilFields = document.querySelectorAll('.settings-profil-field');

        var btnEditAlamat = document.getElementById('settings-btn-edit-alamat');
        var btnCancelAlamat = document.getElementById('settings-btn-cancel-alamat');
        var actionsAlamat = document.getElementById('settings-alamat-actions');
        var alamatFields = document.querySelectorAll('.settings-alamat-field');
        var btnGotoAlamat = document.getElementById('settings-btn-goto-edit-alamat');

        function applyFieldEditable(fields, on) {
            fields.forEach(function (el) {
                if (on) {
                    el.removeAttribute('readonly');
                    el.classList.remove('bg-slate-50', 'cursor-default');
                    el.classList.add('bg-white', 'cursor-text');
                } else {
                    el.setAttribute('readonly', '');
                    el.classList.remove('bg-white', 'cursor-text');
                    el.classList.add('bg-slate-50', 'cursor-default');
                }
            });
        }

        function setProfilEditing(on) {
            applyFieldEditable(profilFields, on);
            if (fotoZone) {
                fotoZone.classList.toggle('pointer-events-none', !on);
                fotoZone.classList.toggle('opacity-60', !on);
                fotoZone.classList.toggle('saturate-75', !on);
            }
            if (avatarInput) {
                avatarInput.disabled = !on;
                avatarInput.setAttribute('aria-disabled', on ? 'false' : 'true');
                avatarInput.tabIndex = on ? 0 : -1;
                if (!on) avatarInput.value = '';
            }
            if (fotoHint) fotoHint.classList.toggle('hidden', on);
            if (uploadRow) uploadRow.classList.toggle('hidden', !on);
            if (actionsProfil) actionsProfil.classList.toggle('hidden', !on);
            if (btnEditProfil) btnEditProfil.classList.toggle('hidden', on);
        }

        function setAlamatEditing(on) {
            applyFieldEditable(alamatFields, on);
            if (actionsAlamat) actionsAlamat.classList.toggle('hidden', !on);
            if (btnEditAlamat) btnEditAlamat.classList.toggle('hidden', on);
        }

        if (btnEditProfil) btnEditProfil.addEventListener('click', function () { setProfilEditing(true); });
        if (btnCancelProfil) btnCancelProfil.addEventListener('click', function () { location.reload(); });

        if (btnEditAlamat) btnEditAlamat.addEventListener('click', function () { setAlamatEditing(true); });
        if (btnCancelAlamat) btnCancelAlamat.addEventListener('click', function () { location.reload(); });

        if (btnGotoAlamat) {
            btnGotoAlamat.addEventListener('click', function () {
                switchSettingsTab('alamat');
                setAlamatEditing(true);
            });
        }
    })();
</script>
