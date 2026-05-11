<!-- Breadcrumb -->
<nav class="flex items-center gap-2 text-sm mb-6 animate-fade-in">
    <a href="<?= baseUrl('index.php') ?>" class="text-slate-400 hover:text-slate-600">Layanan</a>
    <svg class="w-4 h-4 text-slate-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
    </svg>
    <span class="text-primary-600 font-medium">Pilih Jenis</span>
</nav>

<div class="mb-8 animate-fade-in">
    <h2 class="text-2xl font-bold text-slate-800 mb-2">Pilih Jenis Layanan</h2>
    <p class="text-slate-500">Silakan pilih jenis dokumen kependudukan yang ingin Anda ajukan. Pastikan Anda telah
        menyiapkan dokumen persyaratan digital.</p>
</div>

<!-- Service Cards -->
<div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-10">

    <!-- Kartu Keluarga -->
    <form method="POST" action="<?= baseUrl('app/Controllers/PengajuanController.php?action=create') ?>">
        <input type="hidden" name="jenis_layanan" value="kk">
        <button type="submit"
            class="w-full text-left bg-white rounded-2xl border border-slate-100 p-6 card-hover group animate-fade-in animate-delay-1">
            <div
                class="w-12 h-12 rounded-xl bg-primary-50 flex items-center justify-center mb-4 group-hover:bg-primary-100 transition-colors">
                <svg class="w-6 h-6 text-primary-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                        d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />
                </svg>
            </div>
            <h3 class="text-lg font-bold text-slate-800 mb-2">Kartu Keluarga (KK)</h3>
            <p class="text-sm text-slate-500 mb-4 leading-relaxed">Pengajuan pembuatan KK baru, penambahan anggota
                keluarga, atau pembaharuan data kartu keluarga.</p>
            <div class="flex items-center justify-between">
                <span
                    class="inline-flex items-center px-3 py-1 rounded-full text-xs font-semibold bg-primary-50 text-primary-600">3
                    Hari Kerja</span>
                <svg class="w-5 h-5 text-slate-300 group-hover:text-primary-500 group-hover:translate-x-1 transition-all"
                    fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M17 8l4 4m0 0l-4 4m4-4H3" />
                </svg>
            </div>
        </button>
    </form>

    <!-- KTP-el -->
    <form method="POST" action="<?= baseUrl('app/Controllers/PengajuanController.php?action=create') ?>">
        <input type="hidden" name="jenis_layanan" value="ktp">
        <button type="submit"
            class="w-full text-left bg-white rounded-2xl border border-slate-100 p-6 card-hover group animate-fade-in animate-delay-2">
            <div
                class="w-12 h-12 rounded-xl bg-accent-50 flex items-center justify-center mb-4 group-hover:bg-accent-100 transition-colors">
                <svg class="w-6 h-6 text-accent-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                        d="M10 6H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V8a2 2 0 00-2-2h-5m-4 0V5a2 2 0 114 0v1m-4 0a2 2 0 104 0m-5 8a2 2 0 100-4 2 2 0 000 4zm0 0c1.306 0 2.417.835 2.83 2M9 14a3.001 3.001 0 00-2.83 2M15 11h3m-3 4h2" />
                </svg>
            </div>
            <h3 class="text-lg font-bold text-slate-800 mb-2">KTP-el</h3>
            <p class="text-sm text-slate-500 mb-4 leading-relaxed">Rekam baru KTP-el, pengajuan cetak ulang karena
                rusak/hilang, atau perubahan data status pada kartu.</p>
            <div class="flex items-center justify-between">
                <span
                    class="inline-flex items-center px-3 py-1 rounded-full text-xs font-semibold bg-accent-50 text-accent-600">1
                    Hari Kerja</span>
                <svg class="w-5 h-5 text-slate-300 group-hover:text-accent-500 group-hover:translate-x-1 transition-all"
                    fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M17 8l4 4m0 0l-4 4m4-4H3" />
                </svg>
            </div>
        </button>
    </form>

    <!-- Pindah Penduduk -->
    <form method="POST" action="<?= baseUrl('app/Controllers/PengajuanController.php?action=create') ?>">
        <input type="hidden" name="jenis_layanan" value="pindah">
        <button type="submit"
            class="w-full text-left bg-white rounded-2xl border border-slate-100 p-6 card-hover group animate-fade-in animate-delay-3">
            <div
                class="w-12 h-12 rounded-xl bg-violet-50 flex items-center justify-center mb-4 group-hover:bg-violet-100 transition-colors">
                <svg class="w-6 h-6 text-violet-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                        d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                        d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                </svg>
            </div>
            <h3 class="text-lg font-bold text-slate-800 mb-2">Pindah Penduduk</h3>
            <p class="text-sm text-slate-500 mb-4 leading-relaxed">Pengurusan surat keterangan pindah (SKP) antar desa,
                kecamatan, maupun antar kota/provinsi.</p>
            <div class="flex items-center justify-between">
                <span
                    class="inline-flex items-center px-3 py-1 rounded-full text-xs font-semibold bg-violet-50 text-violet-600">2
                    Hari Kerja</span>
                <svg class="w-5 h-5 text-slate-300 group-hover:text-violet-500 group-hover:translate-x-1 transition-all"
                    fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M17 8l4 4m0 0l-4 4m4-4H3" />
                </svg>
            </div>
        </button>
    </form>
</div>

<!-- Bottom Stats -->
<div class="grid grid-cols-2 lg:grid-cols-4 gap-6 mb-4 animate-fade-in">
    <div class="text-center">
        <p class="text-2xl lg:text-3xl font-extrabold text-primary-700">1.2k+</p>
        <p class="text-xs font-semibold text-slate-400 uppercase tracking-wider mt-1">Layanan Selesai</p>
    </div>
    <div class="text-center">
        <p class="text-2xl lg:text-3xl font-extrabold text-primary-700">98%</p>
        <p class="text-xs font-semibold text-slate-400 uppercase tracking-wider mt-1">Kepuasan Warga</p>
    </div>
    <div class="text-center">
        <p class="text-2xl lg:text-3xl font-extrabold text-primary-700">24 Jam</p>
        <p class="text-xs font-semibold text-slate-400 uppercase tracking-wider mt-1">Proses Digital</p>
    </div>
    <div class="text-center">
        <p class="text-2xl lg:text-3xl font-extrabold text-primary-700">Eco</p>
        <p class="text-xs font-semibold text-slate-400 uppercase tracking-wider mt-1">Tanpa Kertas</p>
    </div>
</div>
