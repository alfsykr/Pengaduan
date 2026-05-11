<?php $lastUpdated = !empty($user['updated_at']) ? date('d M Y', strtotime($user['updated_at'])) : date('d M Y'); ?>

<div class="grid grid-cols-1 lg:grid-cols-3 gap-6 mb-4 animate-fade-in">
    <div class="lg:col-span-2">
        <h2 class="text-4xl font-bold text-slate-900 leading-tight">Data Diri</h2>
        <p class="text-lg text-slate-500 mt-2">Profil Saya <span class="mx-1">/</span> <span class="font-semibold text-slate-700">Identitas</span></p>
    </div>
    <div class="bg-white rounded-2xl border border-slate-100 p-6 shadow-sm">
        <div class="flex items-center justify-between mb-3">
            <p class="text-xl font-semibold text-slate-700">Kelengkapan Profil</p>
            <span class="text-4xl font-bold text-primary-700"><?= $completeness ?>%</span>
        </div>
        <div class="w-full bg-blue-100 rounded-full h-2.5 overflow-hidden">
            <div class="h-2.5 rounded-full bg-primary-700 transition-all duration-700" style="width:<?= $completeness ?>%"></div>
        </div>
        <p class="text-sm text-slate-400 mt-3 flex items-center gap-2">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
            </svg>
            Terakhir diperbarui: <?= $lastUpdated ?>
        </p>
    </div>
</div>

<form method="POST" action="<?= baseUrl('profil.php') ?>" class="animate-fade-in animate-delay-1" novalidate>
    <input type="hidden" name="action" value="save_profile">

    <div class="border-b border-slate-200 mb-5 overflow-x-auto">
        <div id="profil-tab-bar" class="flex items-center gap-8 min-w-max relative z-10" role="tablist">
            <button type="button" class="profil-tab flex items-center gap-2 px-1 py-3 text-base font-semibold border-b-[2px] whitespace-nowrap transition-all duration-200 ease-out will-change-transform cursor-pointer select-none active:scale-[0.98]" data-tab="identitas">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path></svg>
                Identitas
            </button>
            <button type="button" class="profil-tab flex items-center gap-2 px-1 py-3 text-base font-semibold border-b-[2px] whitespace-nowrap transition-all duration-200 ease-out will-change-transform cursor-pointer select-none active:scale-[0.98]" data-tab="alamat">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M17.657 16.657L13.414 20.9a2 2 0 01-2.827 0l-4.243-4.243a8 8 0 1111.313 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                Alamat
            </button>
            <button type="button" class="profil-tab flex items-center gap-2 px-1 py-3 text-base font-semibold border-b-[2px] whitespace-nowrap transition-all duration-200 ease-out will-change-transform cursor-pointer select-none active:scale-[0.98]" data-tab="keluarga">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2a5 5 0 00-10 0v2m10 0H7"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M15 7a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                Keluarga
            </button>
            <button type="button" class="profil-tab flex items-center gap-2 px-1 py-3 text-base font-semibold border-b-[2px] whitespace-nowrap transition-all duration-200 ease-out will-change-transform cursor-pointer select-none active:scale-[0.98]" data-tab="kontak">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.95.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.129a11.042 11.042 0 005.516 5.516l1.129-2.257a1 1 0 011.21-.502l4.493 1.498A1 1 0 0121 15.72V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"></path></svg>
                Kontak
            </button>
        </div>
    </div>

    <div class="bg-white rounded-2xl border border-slate-100 px-5 py-4 mb-6 flex flex-col md:flex-row md:items-center justify-between gap-4">
        <p class="text-base text-slate-500 flex items-center gap-3">
            <svg class="w-5 h-5 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
            Data ini disinkronkan secara otomatis dengan pusat data DUKCAPIL.
        </p>
        <button id="edit-btn" type="button" class="inline-flex items-center justify-center gap-2 px-6 py-3 rounded-xl bg-primary-700 text-white text-base font-semibold hover:bg-primary-800 transition-colors">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5h2m-1-1v2m8.364 2.636a2 2 0 010 2.828l-8.486 8.486-4.243 1.414 1.414-4.243 8.486-8.486a2 2 0 012.829 0z"></path></svg>
            Ubah Data
        </button>
    </div>

    <div id="tab-identitas" class="profil-panel bg-white rounded-2xl border border-slate-100 p-6 mb-6">
        <h3 class="font-bold text-slate-800 mb-4">Data Identitas Utama</h3>
        <div class="view-mode grid grid-cols-1 md:grid-cols-2 gap-y-5 gap-x-8">
            <div><p class="text-xs font-semibold text-slate-400 uppercase tracking-wider mb-1">Nama Lengkap</p><p class="text-2xl font-semibold text-slate-800"><?= displayField($user['nama_lengkap'] ?? null) ?></p></div>
            <div><p class="text-xs font-semibold text-slate-400 uppercase tracking-wider mb-1">NIK (Nomor Induk Kependudukan)</p><p class="text-2xl font-semibold text-slate-800"><?= displayField($user['nik'] ?? null) ?></p></div>
            <div><p class="text-xs font-semibold text-slate-400 uppercase tracking-wider mb-1">Jenis Kelamin</p><p class="text-2xl font-semibold text-slate-800"><?php
                $jk = trim((string)($user['jenis_kelamin'] ?? ''));
                echo $jk === 'L' ? 'Laki-laki' : ($jk === 'P' ? 'Perempuan' : '-');
                ?></p></div>
            <div><p class="text-xs font-semibold text-slate-400 uppercase tracking-wider mb-1">Tempat / Tanggal Lahir</p><p class="text-2xl font-semibold text-slate-800"><?php
                $tl = trim((string)($user['tempat_lahir'] ?? ''));
                $tgl = !empty($user['tanggal_lahir']) ? date('d M Y', strtotime($user['tanggal_lahir'])) : '-';
                echo htmlspecialchars(($tl !== '' ? $tl : '-') . ', ' . $tgl);
                ?></p></div>
            <div><p class="text-xs font-semibold text-slate-400 uppercase tracking-wider mb-1">Agama</p><p class="text-2xl font-semibold text-slate-800"><?= displayField($user['agama'] ?? null) ?></p></div>
            <div><p class="text-xs font-semibold text-slate-400 uppercase tracking-wider mb-1">Pekerjaan</p><p class="text-2xl font-semibold text-slate-800"><?= displayField($user['pekerjaan'] ?? null) ?></p></div>
            <div><p class="text-xs font-semibold text-slate-400 uppercase tracking-wider mb-1">Kewarganegaraan</p><p class="text-2xl font-semibold text-slate-800"><?= displayField($user['kewarganegaraan'] ?? null) ?></p></div>
            <div><p class="text-xs font-semibold text-slate-400 uppercase tracking-wider mb-1">Status Perkawinan</p><p class="text-2xl font-semibold text-slate-800"><?= displayField($user['status_perkawinan'] ?? null) ?></p></div>
        </div>
        <div class="edit-mode hidden grid grid-cols-1 md:grid-cols-2 gap-5">
            <div><label class="block text-sm text-slate-600 mb-1">Nama Lengkap</label><input type="text" name="nama_lengkap" value="<?= htmlspecialchars($user['nama_lengkap'] ?? '') ?>" required class="profile-input w-full px-4 py-3 rounded-xl border border-slate-200 text-sm"></div>
            <div><label class="block text-sm text-slate-600 mb-1">NIK (16 Digit)</label><input type="text" name="nik" maxlength="16" value="<?= htmlspecialchars($user['nik'] ?? '') ?>" required class="profile-input w-full px-4 py-3 rounded-xl border border-slate-200 text-sm"></div>
            <div><label class="block text-sm text-slate-600 mb-1">Jenis Kelamin</label><select name="jenis_kelamin" class="profile-input w-full px-4 py-3 rounded-xl border border-slate-200 text-sm"><option value="">-- Pilih --</option><option value="L" <?= ($user['jenis_kelamin'] ?? '') === 'L' ? 'selected' : '' ?>>Laki-laki</option><option value="P" <?= ($user['jenis_kelamin'] ?? '') === 'P' ? 'selected' : '' ?>>Perempuan</option></select></div>
            <div><label class="block text-sm text-slate-600 mb-1">Tempat Lahir</label><input type="text" name="tempat_lahir" value="<?= htmlspecialchars($user['tempat_lahir'] ?? '') ?>" class="profile-input w-full px-4 py-3 rounded-xl border border-slate-200 text-sm"></div>
            <div><label class="block text-sm text-slate-600 mb-1">Tanggal Lahir</label><input type="date" name="tanggal_lahir" value="<?= htmlspecialchars($user['tanggal_lahir'] ?? '') ?>" class="profile-input w-full px-4 py-3 rounded-xl border border-slate-200 text-sm"></div>
            <div><label class="block text-sm text-slate-600 mb-1">Agama</label><select name="agama" class="profile-input w-full px-4 py-3 rounded-xl border border-slate-200 text-sm"><option value="">-- Pilih --</option><?php foreach (['Islam', 'Kristen', 'Katolik', 'Hindu', 'Buddha', 'Konghucu'] as $ag): ?><option value="<?= $ag ?>" <?= ($user['agama'] ?? '') === $ag ? 'selected' : '' ?>><?= $ag ?></option><?php endforeach; ?></select></div>
            <div><label class="block text-sm text-slate-600 mb-1">Status Perkawinan</label><select name="status_perkawinan" class="profile-input w-full px-4 py-3 rounded-xl border border-slate-200 text-sm"><option value="">-- Pilih --</option><?php foreach (['Belum Kawin', 'Kawin', 'Cerai Hidup', 'Cerai Mati'] as $sp): ?><option value="<?= $sp ?>" <?= ($user['status_perkawinan'] ?? '') === $sp ? 'selected' : '' ?>><?= $sp ?></option><?php endforeach; ?></select></div>
            <div><label class="block text-sm text-slate-600 mb-1">Pekerjaan</label><input type="text" name="pekerjaan" value="<?= htmlspecialchars($user['pekerjaan'] ?? '') ?>" class="profile-input w-full px-4 py-3 rounded-xl border border-slate-200 text-sm"></div>
            <div><label class="block text-sm text-slate-600 mb-1">Pendidikan Terakhir</label><select name="pendidikan" class="profile-input w-full px-4 py-3 rounded-xl border border-slate-200 text-sm"><option value="">-- Pilih --</option><?php foreach (['Tidak/Belum Sekolah', 'SD/Sederajat', 'SMP/Sederajat', 'SMA/Sederajat', 'D1/D2', 'D3/Akademi', 'S1/D4', 'S2', 'S3'] as $pd): ?><option value="<?= $pd ?>" <?= ($user['pendidikan'] ?? '') === $pd ? 'selected' : '' ?>><?= $pd ?></option><?php endforeach; ?></select></div>
            <div><label class="block text-sm text-slate-600 mb-1">Kewarganegaraan</label><select name="kewarganegaraan" class="profile-input w-full px-4 py-3 rounded-xl border border-slate-200 text-sm"><option value="WNI" <?= ($user['kewarganegaraan'] ?? 'WNI') === 'WNI' ? 'selected' : '' ?>>WNI</option><option value="WNA" <?= ($user['kewarganegaraan'] ?? '') === 'WNA' ? 'selected' : '' ?>>WNA</option></select></div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mt-8">
            <div class="bg-white rounded-2xl border border-slate-100 p-4">
                <div class="flex items-start gap-3 mb-2">
                    <div class="w-10 h-10 rounded-full bg-cyan-100 text-cyan-700 flex items-center justify-center">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 7h16M4 12h16M4 17h16"></path></svg>
                    </div>
                    <div>
                        <p class="text-xl font-bold text-slate-800 leading-tight">KTP Elektronik</p>
                        <p class="text-sm text-slate-400 leading-tight mt-0.5">Berlaku Seumur Hidup</p>
                    </div>
                </div>
                <?php if ($ktpDoc): ?>
                    <div class="flex items-center gap-2">
                        <a href="<?= baseUrl('uploads/dokumen/' . urlencode($ktpDoc['nama_file'])) ?>" target="_blank" class="flex-1 inline-flex items-center justify-center py-2 rounded-xl border border-primary-200 text-primary-700 text-sm font-semibold hover:bg-primary-50">Lihat Digital KTP</a>
                        <button type="button" onclick="triggerReplaceDoc('<?= $ktpDoc['id'] ?>', 'replace-ktp')" class="px-3 py-2 rounded-xl border border-blue-200 text-blue-700 text-sm font-semibold hover:bg-blue-50">Ubah</button>
                        <button type="button" onclick="deleteDoc('ktp')" class="px-3 py-2 rounded-xl border border-red-200 text-red-700 text-sm font-semibold hover:bg-red-50">Hapus</button>
                        <input type="file" id="replace-ktp" class="hidden" accept=".pdf,.jpg,.jpeg,.png" onchange="replaceDocFile('<?= $ktpDoc['id'] ?>', this.files[0])">
                    </div>
                <?php else: ?>
                    <div class="flex items-center gap-2">
                        <button type="button" onclick="triggerUploadDoc('upload-ktp')" class="flex-1 inline-flex items-center justify-center py-2 rounded-xl border border-primary-200 text-primary-700 text-sm font-semibold hover:bg-primary-50">Upload KTP</button>
                        <input type="file" id="upload-ktp" class="hidden" accept=".pdf,.jpg,.jpeg,.png" onchange="uploadProfileDoc('ktp', this.files[0])">
                    </div>
                <?php endif; ?>
            </div>
            <div class="bg-white rounded-2xl border border-slate-100 p-4">
                <div class="flex items-start gap-3 mb-2">
                    <div class="w-10 h-10 rounded-full bg-blue-100 text-blue-700 flex items-center justify-center">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-8 6h10a2 2 0 002-2V8a2 2 0 00-2-2H7a2 2 0 00-2 2v8a2 2 0 002 2z"></path></svg>
                    </div>
                    <div>
                        <p class="text-xl font-bold text-slate-800 leading-tight">Kartu Keluarga</p>
                        <p class="text-sm text-slate-400 leading-tight mt-0.5">Terakhir Update: <?= !empty($kkDoc['uploaded_at']) ? date('Y', strtotime($kkDoc['uploaded_at'])) : '-' ?></p>
                    </div>
                </div>
                <?php if ($kkDoc): ?>
                    <div class="flex items-center gap-2">
                        <a href="<?= baseUrl('uploads/dokumen/' . urlencode($kkDoc['nama_file'])) ?>" target="_blank" class="flex-1 inline-flex items-center justify-center py-2 rounded-xl border border-primary-200 text-primary-700 text-sm font-semibold hover:bg-primary-50">Lihat KK Digital</a>
                        <button type="button" onclick="triggerReplaceDoc('<?= $kkDoc['id'] ?>', 'replace-kk')" class="px-3 py-2 rounded-xl border border-blue-200 text-blue-700 text-sm font-semibold hover:bg-blue-50">Ubah</button>
                        <button type="button" onclick="deleteDoc('kk')" class="px-3 py-2 rounded-xl border border-red-200 text-red-700 text-sm font-semibold hover:bg-red-50">Hapus</button>
                        <input type="file" id="replace-kk" class="hidden" accept=".pdf,.jpg,.jpeg,.png" onchange="replaceDocFile('<?= $kkDoc['id'] ?>', this.files[0])">
                    </div>
                <?php else: ?>
                    <div class="flex items-center gap-2">
                        <button type="button" onclick="triggerUploadDoc('upload-kk')" class="flex-1 inline-flex items-center justify-center py-2 rounded-xl border border-primary-200 text-primary-700 text-sm font-semibold hover:bg-primary-50">Upload KK</button>
                        <input type="file" id="upload-kk" class="hidden" accept=".pdf,.jpg,.jpeg,.png" onchange="uploadProfileDoc('kk', this.files[0])">
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>

    <div id="tab-alamat" class="profil-panel bg-white rounded-2xl border border-slate-100 p-6 mb-6 hidden">
        <h3 class="font-bold text-slate-800 mb-4">Alamat</h3>
        <div class="view-mode grid grid-cols-1 md:grid-cols-2 gap-y-5 gap-x-8">
            <div class="md:col-span-2"><p class="text-xs font-semibold text-slate-400 uppercase tracking-wider mb-1">Alamat Lengkap</p><p class="text-xl font-semibold text-slate-800"><?= displayField($user['alamat'] ?? null) ?></p></div>
            <div><p class="text-xs font-semibold text-slate-400 uppercase tracking-wider mb-1">RT / RW</p><p class="text-xl font-semibold text-slate-800"><?php
                $rt = trim((string)($user['rt'] ?? ''));
                $rw = trim((string)($user['rw'] ?? ''));
                echo htmlspecialchars(($rt !== '' ? $rt : '-') . ' / ' . ($rw !== '' ? $rw : '-'));
                ?></p></div>
            <div><p class="text-xs font-semibold text-slate-400 uppercase tracking-wider mb-1">Kelurahan / Kecamatan</p><p class="text-xl font-semibold text-slate-800"><?php
                $kel = trim((string)($user['kelurahan'] ?? ''));
                $kec = trim((string)($user['kecamatan'] ?? ''));
                echo htmlspecialchars(($kel !== '' ? $kel : '-') . ' / ' . ($kec !== '' ? $kec : '-'));
                ?></p></div>
            <div><p class="text-xs font-semibold text-slate-400 uppercase tracking-wider mb-1">Kota / Provinsi</p><p class="text-xl font-semibold text-slate-800"><?php
                $kota = trim((string)($user['kota'] ?? ''));
                $prov = trim((string)($user['provinsi'] ?? ''));
                echo htmlspecialchars(($kota !== '' ? $kota : '-') . ' / ' . ($prov !== '' ? $prov : '-'));
                ?></p></div>
            <div><p class="text-xs font-semibold text-slate-400 uppercase tracking-wider mb-1">Kode Pos</p><p class="text-xl font-semibold text-slate-800"><?= displayField($user['kode_pos'] ?? null) ?></p></div>
            <?php if (trim((string) ($user['alamat_domisili'] ?? '')) !== ''): ?>
                <div class="md:col-span-2"><p class="text-xs font-semibold text-slate-400 uppercase tracking-wider mb-1">Alamat Domisili</p><p class="text-xl font-semibold text-slate-800"><?= displayField($user['alamat_domisili'] ?? null) ?></p></div>
            <?php endif; ?>
        </div>
        <div class="edit-mode hidden grid grid-cols-1 md:grid-cols-2 gap-5">
            <div class="md:col-span-2"><label class="block text-sm text-slate-600 mb-1">Alamat Lengkap</label><textarea name="alamat" rows="2" class="profile-input w-full px-4 py-3 rounded-xl border border-slate-200 text-sm"><?= htmlspecialchars($user['alamat'] ?? '') ?></textarea></div>
            <div><label class="block text-sm text-slate-600 mb-1">RT</label><input type="text" name="rt" value="<?= htmlspecialchars($user['rt'] ?? '') ?>" class="profile-input w-full px-4 py-3 rounded-xl border border-slate-200 text-sm"></div>
            <div><label class="block text-sm text-slate-600 mb-1">RW</label><input type="text" name="rw" value="<?= htmlspecialchars($user['rw'] ?? '') ?>" class="profile-input w-full px-4 py-3 rounded-xl border border-slate-200 text-sm"></div>
            <div><label class="block text-sm text-slate-600 mb-1">Kelurahan / Desa</label><input type="text" name="kelurahan" value="<?= htmlspecialchars($user['kelurahan'] ?? '') ?>" class="profile-input w-full px-4 py-3 rounded-xl border border-slate-200 text-sm"></div>
            <div><label class="block text-sm text-slate-600 mb-1">Kecamatan</label><input type="text" name="kecamatan" value="<?= htmlspecialchars($user['kecamatan'] ?? '') ?>" class="profile-input w-full px-4 py-3 rounded-xl border border-slate-200 text-sm"></div>
            <div><label class="block text-sm text-slate-600 mb-1">Kota / Kabupaten</label><input type="text" name="kota" value="<?= htmlspecialchars($user['kota'] ?? '') ?>" class="profile-input w-full px-4 py-3 rounded-xl border border-slate-200 text-sm"></div>
            <div><label class="block text-sm text-slate-600 mb-1">Provinsi</label><input type="text" name="provinsi" value="<?= htmlspecialchars($user['provinsi'] ?? '') ?>" class="profile-input w-full px-4 py-3 rounded-xl border border-slate-200 text-sm"></div>
            <div><label class="block text-sm text-slate-600 mb-1">Kode Pos</label><input type="text" name="kode_pos" value="<?= htmlspecialchars($user['kode_pos'] ?? '') ?>" maxlength="5" class="profile-input w-full px-4 py-3 rounded-xl border border-slate-200 text-sm"></div>
            <div class="md:col-span-2">
                <div class="flex items-center justify-between gap-3 mb-2">
                    <label class="block text-sm text-slate-600">Alamat Domisili</label>
                    <label class="inline-flex items-center gap-2 text-sm text-slate-600 select-none">
                        <input id="domisili-same" type="checkbox" class="rounded border-slate-300 text-primary-700 focus:ring-primary-200">
                        Sama dengan alamat utama
                    </label>
                </div>
                <input type="hidden" name="alamat_domisili_same" id="alamat_domisili_same" value="0">
                <textarea id="alamat-domisili" name="alamat_domisili" rows="2"
                    class="profile-input w-full px-4 py-3 rounded-xl border border-slate-200 text-sm"><?= htmlspecialchars($user['alamat_domisili'] ?? '') ?></textarea>
            </div>
        </div>
    </div>

    <div id="tab-keluarga" class="profil-panel bg-white rounded-2xl border border-slate-100 p-6 mb-6 hidden">
        <h3 class="font-bold text-slate-800 mb-4">Data Keluarga</h3>
        <div class="view-mode grid grid-cols-1 md:grid-cols-2 gap-y-5 gap-x-8">
            <div><p class="text-xs font-semibold text-slate-400 uppercase tracking-wider mb-1">Nomor Kartu Keluarga (KK)</p><p class="text-xl font-semibold text-slate-800"><?= displayField($user['no_kk'] ?? null) ?></p></div>
            <div><p class="text-xs font-semibold text-slate-400 uppercase tracking-wider mb-1">Nama Kepala Keluarga</p><p class="text-xl font-semibold text-slate-800"><?= displayField($user['nama_kepala_keluarga'] ?? null) ?></p></div>
        </div>
        <div class="edit-mode hidden grid grid-cols-1 md:grid-cols-2 gap-5">
            <div><label class="block text-sm text-slate-600 mb-1">Nomor Kartu Keluarga (KK)</label><input type="text" name="no_kk" maxlength="16" value="<?= htmlspecialchars($user['no_kk'] ?? '') ?>" class="profile-input w-full px-4 py-3 rounded-xl border border-slate-200 text-sm"></div>
            <div><label class="block text-sm text-slate-600 mb-1">Nama Kepala Keluarga</label><input type="text" name="nama_kepala_keluarga" value="<?= htmlspecialchars($user['nama_kepala_keluarga'] ?? '') ?>" class="profile-input w-full px-4 py-3 rounded-xl border border-slate-200 text-sm"></div>
        </div>
    </div>

    <div id="tab-kontak" class="profil-panel bg-white rounded-2xl border border-slate-100 p-6 mb-6 hidden">
        <h3 class="font-bold text-slate-800 mb-4">Data Kontak</h3>
        <div class="view-mode grid grid-cols-1 md:grid-cols-2 gap-y-5 gap-x-8">
            <div><p class="text-xs font-semibold text-slate-400 uppercase tracking-wider mb-1">Nomor HP</p><p class="text-xl font-semibold text-slate-800"><?= displayField($user['no_hp'] ?? null) ?></p></div>
            <div><p class="text-xs font-semibold text-slate-400 uppercase tracking-wider mb-1">Email</p><p class="text-xl font-semibold text-slate-800"><?= displayField($user['email'] ?? null) ?></p></div>
        </div>
        <div class="edit-mode hidden grid grid-cols-1 md:grid-cols-2 gap-5">
            <div><label class="block text-sm text-slate-600 mb-1">Nomor HP</label><input type="text" name="no_hp" value="<?= htmlspecialchars($user['no_hp'] ?? '') ?>" class="profile-input w-full px-4 py-3 rounded-xl border border-slate-200 text-sm"></div>
            <div><label class="block text-sm text-slate-600 mb-1">Email</label><input type="email" name="email" value="<?= htmlspecialchars($user['email'] ?? '') ?>" class="profile-input w-full px-4 py-3 rounded-xl border border-slate-200 text-sm"></div>
        </div>
    </div>

    <div class="bg-white rounded-2xl border border-slate-100 p-4 mb-6 flex items-center justify-end">
        <button id="save-btn" type="submit" disabled class="px-8 py-3 rounded-xl bg-primary-700 text-white font-semibold opacity-50 cursor-not-allowed">Simpan Perubahan</button>
    </div>
</form>

<script>
    function switchTab(tabName) {
        const panel = document.getElementById('tab-' + tabName);
        if (!panel) return;

        document.querySelectorAll('.profil-panel').forEach((p) => p.classList.add('hidden'));
        document.querySelectorAll('.profil-tab').forEach((tab) => {
            tab.classList.remove('text-primary-700', 'border-primary-700');
            tab.classList.add('text-slate-500', 'border-transparent');
        });

        panel.classList.remove('hidden');
        if (typeof window.uiAnimateTabPanel === 'function') {
            window.uiAnimateTabPanel(panel);
        }

        const active = document.querySelector('.profil-tab[data-tab="' + tabName + '"]');
        if (!active) return;
        active.classList.add('text-primary-700', 'border-primary-700');
        active.classList.remove('text-slate-500', 'border-transparent');
        active.setAttribute('aria-selected', 'true');
        document.querySelectorAll('.profil-tab').forEach((tab) => {
            if (tab !== active) tab.removeAttribute('aria-selected');
        });
    }

    function setFormEditable(enabled) {
        document.querySelectorAll('.edit-mode').forEach((section) => {
            section.classList.toggle('hidden', !enabled);
        });
        document.querySelectorAll('.view-mode').forEach((section) => {
            section.classList.toggle('hidden', enabled);
        });
        document.querySelectorAll('.profile-input').forEach((el) => {
            el.disabled = !enabled;
        });
        const saveBtn = document.getElementById('save-btn');
        if (saveBtn) {
            saveBtn.disabled = !enabled;
            saveBtn.classList.toggle('opacity-50', !enabled);
            saveBtn.classList.toggle('cursor-not-allowed', !enabled);
        }
    }

    function triggerReplaceDoc(docId, inputId) {
        const input = document.getElementById(inputId);
        if (input) input.click();
    }

    function triggerUploadDoc(inputId) {
        const input = document.getElementById(inputId);
        if (input) input.click();
    }

    function replaceDocFile(docId, file) {
        if (!file) return;
        const fd = new FormData();
        fd.append('dokumen_id', docId);
        fd.append('file', file);
        fetch('<?= baseUrl("app/Controllers/PengajuanController.php?action=replace_dokumen") ?>', { method: 'POST', body: fd })
            .then((r) => r.json())
            .then((res) => {
                if (res.success) {
                    window.location.reload();
                } else {
                    alert(res.message || 'Gagal mengganti dokumen.');
                }
            })
            .catch(() => alert('Terjadi kesalahan saat mengganti dokumen.'));
    }

    function uploadProfileDoc(docKey, file) {
        if (!file) return;
        const fd = new FormData();
        fd.append('doc_key', docKey);
        fd.append('file', file);
        fetch('<?= baseUrl("app/Controllers/PengajuanController.php?action=upload_profile_dokumen") ?>', { method: 'POST', body: fd })
            .then((r) => r.json())
            .then((res) => {
                if (res.success) {
                    window.location.reload();
                } else {
                    alert(res.message || 'Gagal upload dokumen.');
                }
            })
            .catch(() => alert('Terjadi kesalahan saat upload dokumen.'));
    }

    function deleteDoc(docKey) {
        if (!confirm('Yakin ingin menghapus dokumen ini?')) return;
        const fd = new FormData();
        fd.append('doc_key', docKey);
        fetch('<?= baseUrl("app/Controllers/PengajuanController.php?action=delete_profile_dokumen") ?>', { method: 'POST', body: fd })
            .then((r) => r.json())
            .then((res) => {
                if (res.success) {
                    window.location.reload();
                } else {
                    alert(res.message || 'Gagal menghapus dokumen.');
                }
            })
            .catch(() => alert('Terjadi kesalahan saat menghapus dokumen.'));
    }

    document.querySelectorAll('.profil-tab').forEach((tab, idx) => {
        tab.setAttribute('role', 'tab');
        if (idx === 0) {
            tab.classList.add('text-primary-700', 'border-primary-700');
            tab.setAttribute('aria-selected', 'true');
        } else {
            tab.classList.add('text-slate-500', 'border-transparent');
        }
    });

    const tabBar = document.getElementById('profil-tab-bar');
    if (tabBar) {
        tabBar.addEventListener('click', (e) => {
            const btn = e.target.closest('.profil-tab[data-tab]');
            if (!btn) return;
            e.preventDefault();
            switchTab(btn.getAttribute('data-tab'));
        });
    }

    setFormEditable(false);
    const editBtn = document.getElementById('edit-btn');
    if (editBtn) editBtn.addEventListener('click', () => setFormEditable(true));

    // Domisili toggle (same as main address)
    function initDomisiliToggle() {
        const sameCb = document.getElementById('domisili-same');
        const domisili = document.getElementById('alamat-domisili');
        const sameHidden = document.getElementById('alamat_domisili_same');
        const mainAddr = document.querySelector('textarea[name="alamat"]');
        if (!sameCb || !domisili || !sameHidden || !mainAddr) return;

        // Default: checked if domisili empty
        const hasDomisili = (domisili.value || '').trim() !== '';
        sameCb.checked = !hasDomisili;

        const apply = () => {
            if (sameCb.checked) {
                sameHidden.value = '1';
                domisili.value = '';
                domisili.disabled = true;
                domisili.classList.add('bg-slate-100', 'cursor-not-allowed');
            } else {
                sameHidden.value = '0';
                domisili.disabled = false;
                domisili.classList.remove('bg-slate-100', 'cursor-not-allowed');
                if ((domisili.value || '').trim() === '') {
                    domisili.focus();
                }
            }
        };

        sameCb.addEventListener('change', apply);
        apply();
    }

    // When edit mode is enabled, ensure toggle behaves
    const origSetFormEditable = setFormEditable;
    setFormEditable = (enabled) => {
        origSetFormEditable(enabled);
        if (enabled) initDomisiliToggle();
    };
</script>
