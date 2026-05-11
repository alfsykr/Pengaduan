
<nav class="flex items-center gap-2 text-sm mb-6">
    <a href="<?= baseUrl('layanan.php') ?>" class="text-slate-400 hover:text-slate-600">Layanan</a>
    <svg class="w-4 h-4 text-slate-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
    </svg>
    <span class="text-primary-600 font-medium">
        <?= $jenisLabels[$jenis] ?>
    </span>
</nav>

<h2 class="text-2xl font-bold text-slate-800 mb-1">Permohonan
    <?= $jenisLabels[$jenis] ?>
</h2>
<p class="text-slate-500 mb-8">Mohon lengkapi semua data yang diperlukan.</p>

<!-- Stepper -->
<div class="flex items-center justify-between mb-10 max-w-3xl mx-auto">
    <?php for ($i = 1; $i <= 5; $i++): ?>
        <div class="flex flex-col items-center relative z-10">
            <div class="w-10 h-10 rounded-full flex items-center justify-center text-sm font-bold border-2 transition-all
            <?php if ($i < $step): ?>bg-primary-600 border-primary-600 text-white
            <?php elseif ($i === $step): ?>bg-white border-primary-600 text-primary-600 ring-4 ring-primary-100
            <?php else: ?>bg-white border-slate-200 text-slate-400<?php endif; ?>">
                <?php if ($i < $step): ?>
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7" />
                    </svg>
                <?php else:
                    echo $i;
                endif; ?>
            </div>
            <span
                class="text-xs mt-2 font-medium <?= $i <= $step ? 'text-primary-600' : 'text-slate-400' ?> hidden sm:block whitespace-nowrap">
                <?= $stepNames[$i - 1] ?>
            </span>
        </div>
        <?php if ($i < 5): ?>
            <div class="flex-1 h-0.5 -mt-4 sm:-mt-7 <?= $i < $step ? 'bg-primary-600' : 'bg-slate-200' ?> mx-2"></div>
        <?php endif; endfor; ?>
</div>

<!-- Step Content -->
<div class="max-w-3xl mx-auto">

    <?php if ($step === 1): // DATA PRIBADI ?>
        <form method="POST" action="<?= baseUrl('app/Controllers/PengajuanController.php?action=save_step') ?>">
            <input type="hidden" name="pengajuan_id" value="<?= $pengajuanId ?>">
            <input type="hidden" name="step" value="1">
            <div class="bg-white rounded-2xl border border-slate-100 p-6 mb-6">
                <h3 class="text-lg font-bold text-slate-800 mb-1">Step 1: Data Pribadi</h3>
                <p class="text-sm text-slate-500 mb-4">Mohon lengkapi data diri Anda sesuai dengan KTP yang berlaku.</p>

                <?php if (!empty($user['agama']) && !empty($user['pekerjaan'])): ?>
                    <div class="bg-emerald-50 rounded-xl p-3 mb-6 flex items-center gap-3">
                        <span class="text-lg">✅</span>
                        <div>
                            <p class="text-sm font-medium text-emerald-700">Data terisi otomatis dari profil Anda</p>
                            <p class="text-xs text-emerald-600">Periksa kembali dan klik Lanjut. <a
                                    href="<?= baseUrl('profil.php') ?>" class="underline font-semibold">Ubah di Data Diri →</a>
                            </p>
                        </div>
                    </div>
                <?php else: ?>
                    <div class="bg-amber-50 rounded-xl p-3 mb-6 flex items-center gap-3">
                        <span class="text-lg">💡</span>
                        <div>
                            <p class="text-sm font-medium text-amber-700">Lengkapi profil supaya form terisi otomatis</p>
                            <p class="text-xs text-amber-600"><a href="<?= baseUrl('profil.php') ?>"
                                    class="underline font-semibold">Isi Data Diri →</a> agar tidak perlu mengulang di setiap
                                permohonan.</p>
                        </div>
                    </div>
                <?php endif; ?>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                    <div>
                        <label class="block text-sm font-medium text-slate-700 mb-1">Nama Lengkap</label>
                        <input type="text" name="nama_lengkap" value="<?= htmlspecialchars($user['nama_lengkap'] ?? '') ?>"
                            required
                            class="w-full px-4 py-3 rounded-xl border border-slate-200 focus:border-primary-500 focus:ring-2 focus:ring-primary-500/20 outline-none text-sm">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-slate-700 mb-1">NIK (16 Digit)</label>
                        <input type="text" value="<?= htmlspecialchars($user['nik'] ?? '') ?>" disabled
                            class="w-full px-4 py-3 rounded-xl border border-slate-200 bg-slate-50 text-sm text-slate-500">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-slate-700 mb-1">No HP</label>
                        <input type="text" name="no_hp" value="<?= htmlspecialchars($user['no_hp'] ?? '') ?>"
                            class="w-full px-4 py-3 rounded-xl border border-slate-200 focus:border-primary-500 focus:ring-2 focus:ring-primary-500/20 outline-none text-sm">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-slate-700 mb-1">Email</label>
                        <input type="email" value="<?= htmlspecialchars($user['email'] ?? '') ?>" disabled
                            class="w-full px-4 py-3 rounded-xl border border-slate-200 bg-slate-50 text-sm text-slate-500">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-slate-700 mb-1">Tempat Lahir</label>
                        <input type="text" name="tempat_lahir" value="<?= htmlspecialchars($user['tempat_lahir'] ?? '') ?>"
                            class="w-full px-4 py-3 rounded-xl border border-slate-200 focus:border-primary-500 focus:ring-2 focus:ring-primary-500/20 outline-none text-sm">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-slate-700 mb-1">Tanggal Lahir</label>
                        <input type="date" name="tanggal_lahir"
                            value="<?= htmlspecialchars($user['tanggal_lahir'] ?? '') ?>"
                            class="w-full px-4 py-3 rounded-xl border border-slate-200 focus:border-primary-500 focus:ring-2 focus:ring-primary-500/20 outline-none text-sm">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-slate-700 mb-1">Agama</label>
                        <select name="agama"
                            class="w-full px-4 py-3 rounded-xl border border-slate-200 focus:border-primary-500 focus:ring-2 focus:ring-primary-500/20 outline-none text-sm">
                            <option value="">-- Pilih --</option>
                            <?php foreach (['Islam', 'Kristen', 'Katolik', 'Hindu', 'Buddha', 'Konghucu'] as $ag): ?>
                                <option value="<?= $ag ?>" <?= ($user['agama'] ?? '') === $ag ? 'selected' : '' ?>><?= $ag ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-slate-700 mb-1">Pekerjaan</label>
                        <input type="text" name="pekerjaan" value="<?= htmlspecialchars($user['pekerjaan'] ?? '') ?>"
                            placeholder="PNS, Wiraswasta, dll"
                            class="w-full px-4 py-3 rounded-xl border border-slate-200 focus:border-primary-500 focus:ring-2 focus:ring-primary-500/20 outline-none text-sm">
                    </div>
                    <div class="md:col-span-2">
                        <label class="block text-sm font-medium text-slate-700 mb-1">Alamat Domisili</label>
                        <textarea name="alamat" rows="2"
                            class="w-full px-4 py-3 rounded-xl border border-slate-200 focus:border-primary-500 focus:ring-2 focus:ring-primary-500/20 outline-none text-sm"><?= htmlspecialchars($user['alamat'] ?? '') ?></textarea>
                    </div>
                </div>
            </div>
            <div class="flex items-center justify-between">
                <a href="<?= baseUrl('layanan.php') ?>"
                    class="text-sm text-slate-500 hover:text-slate-700 flex items-center gap-1">✕ Batal</a>
                <button type="submit"
                    class="bg-primary-600 hover:bg-primary-700 text-white font-semibold px-6 py-3 rounded-xl transition-all shadow-lg shadow-primary-500/25 flex items-center gap-2">Lanjut
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M17 8l4 4m0 0l-4 4m4-4H3" />
                    </svg></button>
            </div>
        </form>

    <?php elseif ($step === 2): // DYNAMIC: KELUARGA / PINDAH / KTP ?>
        <form method="POST" action="<?= baseUrl('app/Controllers/PengajuanController.php?action=save_step') ?>">
            <input type="hidden" name="pengajuan_id" value="<?= $pengajuanId ?>">
            <input type="hidden" name="step" value="2">
            <div class="bg-white rounded-2xl border border-slate-100 p-6 mb-6">

                <?php if ($jenis === 'kk'): ?>
                    <h3 class="text-lg font-bold text-slate-800 mb-1">Step 2: Data Keluarga</h3>
                    <p class="text-sm text-slate-500 mb-6">Pilih jenis permohonan dan lengkapi data KK.</p>

                    <!-- Jenis Permohonan KK -->
                    <div class="mb-6">
                        <label class="block text-sm font-semibold text-slate-700 mb-3">Jenis Permohonan KK <span
                                class="text-red-500">*</span></label>
                        <?php
                        $kkTypes = [
                            'baru' => [
                                'label' => 'Baru',
                                'icon' => '📋',
                                'color' => 'emerald',
                                'subs' => [
                                    'membentuk_keluarga' => 'Membentuk Keluarga Baru',
                                    'penggantian_kk' => 'Penggantian Kepala Keluarga',
                                    'pisah_kk' => 'Pisah KK',
                                    'pindah_datang' => 'Pindah Datang',
                                    'wni_luar_negeri' => 'WNI dari Luar Negeri',
                                ]
                            ],
                            'perubahan' => [
                                'label' => 'Perubahan Data',
                                'icon' => '✏️',
                                'color' => 'amber',
                                'subs' => [
                                    'menumpang_kk' => 'Menumpang dalam KK',
                                    'peristiwa_penting' => 'Peristiwa Penting',
                                    'perubahan_elemen' => 'Perubahan Elemen Data',
                                ]
                            ],
                            'hilang_rusak' => [
                                'label' => 'Hilang / Rusak',
                                'icon' => '🔴',
                                'color' => 'red',
                                'subs' => [
                                    'hilang' => 'Hilang',
                                    'rusak' => 'Rusak',
                                ]
                            ],
                        ];
                        $curType = $dataKeluarga['jenis_permohonan_kk'] ?? 'baru';
                        $curSub = $dataKeluarga['sub_jenis_kk'] ?? '';
                        ?>
                        <div class="grid grid-cols-1 md:grid-cols-3 gap-3 mb-4">
                            <?php foreach ($kkTypes as $tk => $tv): ?>
                                <label
                                    class="kk-type-card flex flex-col items-center gap-2 bg-slate-50 rounded-xl p-4 cursor-pointer border-2 transition-all text-center <?= $curType === $tk ? 'border-primary-500 bg-primary-50' : 'border-transparent hover:bg-slate-100' ?>"
                                    data-type="<?= $tk ?>">
                                    <input type="radio" name="jenis_permohonan_kk" value="<?= $tk ?>" <?= $curType === $tk ? 'checked' : '' ?> class="hidden" required>
                                    <span class="text-2xl">
                                        <?= $tv['icon'] ?>
                                    </span>
                                    <span class="text-sm font-bold text-slate-700">
                                        <?= $tv['label'] ?>
                                    </span>
                                </label>
                            <?php endforeach; ?>
                        </div>

                        <!-- Sub-categories -->
                        <?php foreach ($kkTypes as $tk => $tv): ?>
                            <div class="kk-sub-group bg-slate-50 rounded-xl p-4 mb-4" data-parent="<?= $tk ?>"
                                style="display:<?= $curType === $tk ? 'block' : 'none' ?>">
                                <p class="text-xs font-semibold text-slate-500 uppercase mb-3">Sub Jenis —
                                    <?= $tv['label'] ?>
                                </p>
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-2">
                                    <?php foreach ($tv['subs'] as $sk => $sv): ?>
                                        <label
                                            class="kk-sub-card flex items-center gap-3 bg-white rounded-lg p-3 cursor-pointer border transition-all <?= $curSub === $sk ? 'border-primary-500 bg-primary-50' : 'border-slate-200 hover:border-primary-300' ?>">
                                            <input type="radio" name="sub_jenis_kk" value="<?= $sk ?>" <?= $curSub === $sk ? 'checked' : '' ?> class="w-4 h-4 text-primary-600">
                                            <span class="text-sm text-slate-700">
                                                <?= $sv ?>
                                            </span>
                                        </label>
                                    <?php endforeach; ?>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div>

                    <hr class="border-slate-100 mb-6">

                    <!-- Data KK fields -->
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-5 mb-6">
                        <div><label class="block text-sm font-medium text-slate-700 mb-1">No KK</label><input type="text"
                                name="no_kk" value="<?= htmlspecialchars(formValueFromDraftOrUser($dataKeluarga, $user, 'no_kk')) ?>"
                                maxlength="16"
                                class="w-full px-4 py-3 rounded-xl border border-slate-200 focus:border-primary-500 focus:ring-2 focus:ring-primary-500/20 outline-none text-sm font-mono">
                        </div>
                        <div><label class="block text-sm font-medium text-slate-700 mb-1">Kepala Keluarga</label><input
                                type="text" name="nama_kepala_keluarga"
                                value="<?= htmlspecialchars(formValueFromDraftOrUser($dataKeluarga, $user, 'nama_kepala_keluarga', 'nama_kepala_keluarga', 'nama_lengkap')) ?>"
                                required
                                class="w-full px-4 py-3 rounded-xl border border-slate-200 focus:border-primary-500 focus:ring-2 focus:ring-primary-500/20 outline-none text-sm">
                        </div>
                        <div class="md:col-span-2"><label class="block text-sm font-medium text-slate-700 mb-1">Alamat
                                KK</label><textarea name="alamat_kk" rows="2"
                                class="w-full px-4 py-3 rounded-xl border border-slate-200 focus:border-primary-500 focus:ring-2 focus:ring-primary-500/20 outline-none text-sm"><?= htmlspecialchars(formValueFromDraftOrUser($dataKeluarga, $user, 'alamat_kk', 'alamat')) ?></textarea>
                        </div>
                        <div><label class="block text-sm font-medium text-slate-700 mb-1">RT</label><input type="text" name="rt"
                                value="<?= htmlspecialchars(formValueFromDraftOrUser($dataKeluarga, $user, 'rt')) ?>"
                                class="w-full px-4 py-3 rounded-xl border border-slate-200 focus:border-primary-500 focus:ring-2 focus:ring-primary-500/20 outline-none text-sm">
                        </div>
                        <div><label class="block text-sm font-medium text-slate-700 mb-1">RW</label><input type="text" name="rw"
                                value="<?= htmlspecialchars(formValueFromDraftOrUser($dataKeluarga, $user, 'rw')) ?>"
                                class="w-full px-4 py-3 rounded-xl border border-slate-200 focus:border-primary-500 focus:ring-2 focus:ring-primary-500/20 outline-none text-sm">
                        </div>
                        <div><label class="block text-sm font-medium text-slate-700 mb-1">Kelurahan</label><input type="text"
                                name="kelurahan"
                                value="<?= htmlspecialchars(formValueFromDraftOrUser($dataKeluarga, $user, 'kelurahan')) ?>"
                                class="w-full px-4 py-3 rounded-xl border border-slate-200 focus:border-primary-500 focus:ring-2 focus:ring-primary-500/20 outline-none text-sm">
                        </div>
                        <div><label class="block text-sm font-medium text-slate-700 mb-1">Kecamatan</label><input type="text"
                                name="kecamatan"
                                value="<?= htmlspecialchars(formValueFromDraftOrUser($dataKeluarga, $user, 'kecamatan')) ?>"
                                class="w-full px-4 py-3 rounded-xl border border-slate-200 focus:border-primary-500 focus:ring-2 focus:ring-primary-500/20 outline-none text-sm">
                        </div>
                        <div><label class="block text-sm font-medium text-slate-700 mb-1">Kota</label><input type="text"
                                name="kota" value="<?= htmlspecialchars(formValueFromDraftOrUser($dataKeluarga, $user, 'kota')) ?>"
                                class="w-full px-4 py-3 rounded-xl border border-slate-200 focus:border-primary-500 focus:ring-2 focus:ring-primary-500/20 outline-none text-sm">
                        </div>
                        <div><label class="block text-sm font-medium text-slate-700 mb-1">Provinsi</label><input type="text"
                                name="provinsi"
                                value="<?= htmlspecialchars(formValueFromDraftOrUser($dataKeluarga, $user, 'provinsi')) ?>"
                                class="w-full px-4 py-3 rounded-xl border border-slate-200 focus:border-primary-500 focus:ring-2 focus:ring-primary-500/20 outline-none text-sm">
                        </div>
                    </div>
                    <!-- Anggota Keluarga -->
                    <h4 class="font-bold text-slate-800 mb-3">Anggota Keluarga</h4>
                    <div id="anggota-container">
                        <?php if (!empty($anggotaKeluarga)):
                            foreach ($anggotaKeluarga as $idx => $a): ?>
                                <div class="anggota-row bg-slate-50 rounded-xl p-4 mb-3">
                                    <div class="flex justify-between items-center mb-3"><span
                                            class="text-sm font-semibold text-slate-600">Anggota #
                                            <?= $idx + 1 ?>
                                        </span><button type="button" onclick="this.closest('.anggota-row').remove()"
                                            class="text-red-400 hover:text-red-600 text-xs">Hapus</button></div>
                                    <div class="grid grid-cols-2 md:grid-cols-3 gap-3">
                                        <input type="text" name="anggota_nama[]" value="<?= htmlspecialchars($a['nama']) ?>"
                                            placeholder="Nama" class="px-3 py-2 rounded-lg border border-slate-200 text-sm">
                                        <input type="text" name="anggota_nik[]" value="<?= htmlspecialchars($a['nik'] ?? '') ?>"
                                            placeholder="NIK" maxlength="16"
                                            class="px-3 py-2 rounded-lg border border-slate-200 text-sm">
                                        <select name="anggota_jk[]" class="px-3 py-2 rounded-lg border border-slate-200 text-sm">
                                            <option value="L" <?= $a['jenis_kelamin'] === 'L' ? 'selected' : '' ?>>Laki-laki</option>
                                            <option value="P" <?= $a['jenis_kelamin'] === 'P' ? 'selected' : '' ?>>Perempuan</option>
                                        </select>
                                        <input type="text" name="anggota_tempat_lahir[]"
                                            value="<?= htmlspecialchars($a['tempat_lahir'] ?? '') ?>" placeholder="Tempat Lahir"
                                            class="px-3 py-2 rounded-lg border border-slate-200 text-sm">
                                        <input type="date" name="anggota_tanggal_lahir[]"
                                            value="<?= htmlspecialchars($a['tanggal_lahir'] ?? '') ?>"
                                            class="px-3 py-2 rounded-lg border border-slate-200 text-sm">
                                        <input type="text" name="anggota_hubungan[]"
                                            value="<?= htmlspecialchars($a['hubungan_keluarga']) ?>" placeholder="Hubungan"
                                            class="px-3 py-2 rounded-lg border border-slate-200 text-sm">
                                        <input type="text" name="anggota_agama[]" value="<?= htmlspecialchars($a['agama'] ?? '') ?>"
                                            placeholder="Agama" class="px-3 py-2 rounded-lg border border-slate-200 text-sm">
                                        <input type="text" name="anggota_pendidikan[]"
                                            value="<?= htmlspecialchars($a['pendidikan'] ?? '') ?>" placeholder="Pendidikan"
                                            class="px-3 py-2 rounded-lg border border-slate-200 text-sm">
                                        <input type="text" name="anggota_pekerjaan[]"
                                            value="<?= htmlspecialchars($a['pekerjaan'] ?? '') ?>" placeholder="Pekerjaan"
                                            class="px-3 py-2 rounded-lg border border-slate-200 text-sm">
                                        <input type="text" name="anggota_status_perkawinan[]"
                                            value="<?= htmlspecialchars($a['status_perkawinan'] ?? '') ?>" placeholder="Status Kawin"
                                            class="px-3 py-2 rounded-lg border border-slate-200 text-sm">
                                    </div>
                                </div>
                            <?php endforeach; endif; ?>
                    </div>
                    <button type="button" onclick="addAnggota()"
                        class="flex items-center gap-2 text-sm font-medium text-primary-600 hover:text-primary-700 mt-2">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                        </svg> Tambah Anggota
                    </button>

                <?php elseif ($jenis === 'pindah'): ?>
                    <h3 class="text-lg font-bold text-slate-800 mb-1">Step 2: Data Pindah</h3>
                    <p class="text-sm text-slate-500 mb-6">Mohon lengkapi data perpindahan sesuai Formulir F-1.03.</p>

                    <!-- Jenis Permohonan -->
                    <div class="mb-6">
                        <label class="block text-sm font-semibold text-slate-700 mb-3">Jenis Permohonan <span
                                class="text-red-500">*</span></label>
                        <div class="space-y-2">
                            <?php foreach (['skp' => 'Surat Keterangan Pindah', 'skpln' => 'Surat Keterangan Pindah Luar Negeri (SKPLN)', 'sktt' => 'Surat Keterangan Tempat Tinggal (SKTT) Bagi Orang Asing Tinggal Terbatas'] as $k => $v): ?>
                                <label
                                    class="flex items-center gap-3 bg-slate-50 rounded-xl p-3.5 cursor-pointer border-2 transition-all <?= ($dataPindah['jenis_permohonan_pindah'] ?? 'skp') === $k ? 'border-primary-500 bg-primary-50' : 'border-transparent hover:bg-slate-100' ?>">
                                    <input type="radio" name="jenis_permohonan_pindah" value="<?= $k ?>"
                                        <?= ($dataPindah['jenis_permohonan_pindah'] ?? 'skp') === $k ? 'checked' : '' ?>
                                        class="w-4 h-4 text-primary-600" required
                                        onchange="document.querySelectorAll('[name=jenis_permohonan_pindah]').forEach(r=>{r.closest('label').classList.toggle('border-primary-500',r.checked);r.closest('label').classList.toggle('bg-primary-50',r.checked);r.closest('label').classList.toggle('border-transparent',!r.checked)})">
                                    <span class="text-sm font-medium text-slate-700"><?= $v ?></span>
                                </label>
                            <?php endforeach; ?>
                        </div>
                    </div>

                    <!-- Alamat Asal -->
                    <h4 class="font-semibold text-slate-700 mb-3 flex items-center gap-2"><span
                            class="w-6 h-6 rounded-full bg-red-100 text-red-600 flex items-center justify-center text-xs font-bold">A</span>
                        Alamat Asal</h4>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-6">
                        <div class="md:col-span-2"><textarea name="alamat_asal" rows="2" required
                                placeholder="Alamat lengkap (Desa/Kel)"
                                class="w-full px-4 py-3 rounded-xl border border-slate-200 focus:border-primary-500 focus:ring-2 focus:ring-primary-500/20 outline-none text-sm"><?= htmlspecialchars($dataPindah['alamat_asal'] ?? $user['alamat'] ?? '') ?></textarea>
                        </div>
                        <div><input type="text" name="rt_asal"
                                value="<?= htmlspecialchars($dataPindah['rt_asal'] ?? $user['rt'] ?? '') ?>" placeholder="RT"
                                class="w-full px-4 py-3 rounded-xl border border-slate-200 focus:border-primary-500 focus:ring-2 focus:ring-primary-500/20 outline-none text-sm">
                        </div>
                        <div><input type="text" name="rw_asal"
                                value="<?= htmlspecialchars($dataPindah['rw_asal'] ?? $user['rw'] ?? '') ?>" placeholder="RW"
                                class="w-full px-4 py-3 rounded-xl border border-slate-200 focus:border-primary-500 focus:ring-2 focus:ring-primary-500/20 outline-none text-sm">
                        </div>
                        <div><input type="text" name="kelurahan_asal"
                                value="<?= htmlspecialchars($dataPindah['kelurahan_asal'] ?? $user['kelurahan'] ?? '') ?>"
                                placeholder="Kelurahan/Desa"
                                class="w-full px-4 py-3 rounded-xl border border-slate-200 focus:border-primary-500 focus:ring-2 focus:ring-primary-500/20 outline-none text-sm">
                        </div>
                        <div><input type="text" name="kecamatan_asal"
                                value="<?= htmlspecialchars($dataPindah['kecamatan_asal'] ?? $user['kecamatan'] ?? '') ?>"
                                placeholder="Kecamatan"
                                class="w-full px-4 py-3 rounded-xl border border-slate-200 focus:border-primary-500 focus:ring-2 focus:ring-primary-500/20 outline-none text-sm">
                        </div>
                        <div><input type="text" name="kota_asal"
                                value="<?= htmlspecialchars($dataPindah['kota_asal'] ?? $user['kota'] ?? '') ?>"
                                placeholder="Kota/Kabupaten"
                                class="w-full px-4 py-3 rounded-xl border border-slate-200 focus:border-primary-500 focus:ring-2 focus:ring-primary-500/20 outline-none text-sm">
                        </div>
                        <div><input type="text" name="provinsi_asal"
                                value="<?= htmlspecialchars($dataPindah['provinsi_asal'] ?? $user['provinsi'] ?? '') ?>"
                                placeholder="Provinsi"
                                class="w-full px-4 py-3 rounded-xl border border-slate-200 focus:border-primary-500 focus:ring-2 focus:ring-primary-500/20 outline-none text-sm">
                        </div>
                    </div>

                    <!-- Klasifikasi Kepindahan -->
                    <div class="mb-6">
                        <label class="block text-sm font-semibold text-slate-700 mb-2">Klasifikasi Kepindahan</label>
                        <select name="klasifikasi_kepindahan"
                            class="w-full px-4 py-3 rounded-xl border border-slate-200 focus:border-primary-500 focus:ring-2 focus:ring-primary-500/20 outline-none text-sm">
                            <?php foreach (['dalam_desa' => 'Dalam satu desa/kelurahan', 'antar_desa' => 'Antar desa/kelurahan dalam satu kecamatan', 'antar_kecamatan' => 'Antar kecamatan dalam satu kab/kota', 'antar_kota' => 'Antar kabupaten/kota dalam satu provinsi', 'antar_provinsi' => 'Antar provinsi'] as $k => $v): ?>
                                <option value="<?= $k ?>" <?= ($dataPindah['klasifikasi_kepindahan'] ?? '') === $k ? 'selected' : '' ?>><?= $v ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>

                    <!-- Alamat Tujuan -->
                    <h4 class="font-semibold text-slate-700 mb-3 flex items-center gap-2"><span
                            class="w-6 h-6 rounded-full bg-emerald-100 text-emerald-600 flex items-center justify-center text-xs font-bold">B</span>
                        Alamat Tujuan</h4>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-6">
                        <div class="md:col-span-2"><textarea name="alamat_tujuan" rows="2" required
                                placeholder="Alamat lengkap tujuan (Desa/Kel)"
                                class="w-full px-4 py-3 rounded-xl border border-slate-200 focus:border-primary-500 focus:ring-2 focus:ring-primary-500/20 outline-none text-sm"><?= htmlspecialchars($dataPindah['alamat_tujuan'] ?? '') ?></textarea>
                        </div>
                        <div><input type="text" name="rt_tujuan" value="<?= htmlspecialchars($dataPindah['rt_tujuan'] ?? '') ?>"
                                placeholder="RT"
                                class="w-full px-4 py-3 rounded-xl border border-slate-200 focus:border-primary-500 focus:ring-2 focus:ring-primary-500/20 outline-none text-sm">
                        </div>
                        <div><input type="text" name="rw_tujuan" value="<?= htmlspecialchars($dataPindah['rw_tujuan'] ?? '') ?>"
                                placeholder="RW"
                                class="w-full px-4 py-3 rounded-xl border border-slate-200 focus:border-primary-500 focus:ring-2 focus:ring-primary-500/20 outline-none text-sm">
                        </div>
                        <div><input type="text" name="kelurahan_tujuan"
                                value="<?= htmlspecialchars($dataPindah['kelurahan_tujuan'] ?? '') ?>"
                                placeholder="Kelurahan/Desa"
                                class="w-full px-4 py-3 rounded-xl border border-slate-200 focus:border-primary-500 focus:ring-2 focus:ring-primary-500/20 outline-none text-sm">
                        </div>
                        <div><input type="text" name="kecamatan_tujuan"
                                value="<?= htmlspecialchars($dataPindah['kecamatan_tujuan'] ?? '') ?>" placeholder="Kecamatan"
                                class="w-full px-4 py-3 rounded-xl border border-slate-200 focus:border-primary-500 focus:ring-2 focus:ring-primary-500/20 outline-none text-sm">
                        </div>
                        <div><input type="text" name="kota_tujuan"
                                value="<?= htmlspecialchars($dataPindah['kota_tujuan'] ?? '') ?>" placeholder="Kota/Kabupaten"
                                class="w-full px-4 py-3 rounded-xl border border-slate-200 focus:border-primary-500 focus:ring-2 focus:ring-primary-500/20 outline-none text-sm">
                        </div>
                        <div><input type="text" name="provinsi_tujuan"
                                value="<?= htmlspecialchars($dataPindah['provinsi_tujuan'] ?? '') ?>" placeholder="Provinsi"
                                class="w-full px-4 py-3 rounded-xl border border-slate-200 focus:border-primary-500 focus:ring-2 focus:ring-primary-500/20 outline-none text-sm">
                        </div>
                    </div>

                    <!-- Alasan Pindah -->
                    <div class="mb-6">
                        <label class="block text-sm font-semibold text-slate-700 mb-3">Alasan Pindah <span
                                class="text-red-500">*</span></label>
                        <div class="grid grid-cols-2 md:grid-cols-3 gap-2">
                            <?php $alasanOptions = ['pekerjaan' => 'Pekerjaan', 'pendidikan' => 'Pendidikan', 'keamanan' => 'Keamanan', 'kesehatan' => 'Kesehatan', 'perumahan' => 'Perumahan', 'keluarga' => 'Keluarga', 'lainnya' => 'Lainnya'];
                            $currentAlasan = $dataPindah['alasan_pindah'] ?? '';
                            foreach ($alasanOptions as $ak => $av): ?>
                                <label
                                    class="flex items-center gap-2 bg-slate-50 rounded-lg p-3 cursor-pointer border transition-all <?= $currentAlasan === $ak ? 'border-primary-500 bg-primary-50' : 'border-transparent hover:bg-slate-100' ?>">
                                    <input type="radio" name="alasan_pindah" value="<?= $ak ?>" <?= $currentAlasan === $ak ? 'checked' : '' ?> class="w-4 h-4 text-primary-600"
                                        onchange="document.getElementById('alasan-lainnya-wrap').style.display=this.value==='lainnya'?'block':'none'; document.querySelectorAll('[name=alasan_pindah]').forEach(r=>{r.closest('label').classList.toggle('border-primary-500',r.checked);r.closest('label').classList.toggle('bg-primary-50',r.checked);r.closest('label').classList.toggle('border-transparent',!r.checked)})">
                                    <span class="text-sm text-slate-700"><?= $av ?></span>
                                </label>
                            <?php endforeach; ?>
                        </div>
                        <div id="alasan-lainnya-wrap" class="mt-3"
                            style="display:<?= $currentAlasan === 'lainnya' ? 'block' : 'none' ?>">
                            <input type="text" name="alasan_pindah_lainnya"
                                value="<?= htmlspecialchars($dataPindah['alasan_pindah_lainnya'] ?? '') ?>"
                                placeholder="Sebutkan alasan lainnya..."
                                class="w-full px-4 py-3 rounded-xl border border-slate-200 focus:border-primary-500 focus:ring-2 focus:ring-primary-500/20 outline-none text-sm">
                        </div>
                    </div>

                    <!-- Jenis Kepindahan -->
                    <div>
                        <label class="block text-sm font-semibold text-slate-700 mb-3">Jenis Kepindahan <span
                                class="text-red-500">*</span></label>
                        <div class="space-y-2">
                            <?php foreach (['kepala_keluarga' => 'Kepala Keluarga', 'kepala_dan_seluruh' => 'Kepala Keluarga dan Seluruh Anggota Keluarga', 'kepala_dan_sebagian' => 'Kepala Keluarga dan Sebagian Anggota Keluarga', 'anggota_keluarga' => 'Anggota Keluarga'] as $k => $v): ?>
                                <label
                                    class="flex items-center gap-3 bg-slate-50 rounded-xl p-3.5 cursor-pointer border-2 transition-all <?= ($dataPindah['jenis_kepindahan'] ?? '') === $k ? 'border-primary-500 bg-primary-50' : 'border-transparent hover:bg-slate-100' ?>">
                                    <input type="radio" name="jenis_kepindahan" value="<?= $k ?>"
                                        <?= ($dataPindah['jenis_kepindahan'] ?? '') === $k ? 'checked' : '' ?>
                                        class="w-4 h-4 text-primary-600" required
                                        onchange="document.querySelectorAll('[name=jenis_kepindahan]').forEach(r=>{r.closest('label').classList.toggle('border-primary-500',r.checked);r.closest('label').classList.toggle('bg-primary-50',r.checked);r.closest('label').classList.toggle('border-transparent',!r.checked)})">
                                    <span class="text-sm font-medium text-slate-700"><?= $v ?></span>
                                </label>
                            <?php endforeach; ?>
                        </div>
                    </div>

                <?php else: // KTP ?>
                    <h3 class="text-lg font-bold text-slate-800 mb-1">Step 2: Detail Layanan KTP-el</h3>
                    <p class="text-sm text-slate-500 mb-6">Pilih jenis permohonan KTP-el Anda.</p>
                    <div>
                        <label class="block text-sm font-semibold text-slate-700 mb-3">Jenis Permohonan <span
                                class="text-red-500">*</span></label>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-2">
                            <?php
                            $ktpOptions = [
                                'baru' => 'Pembuatan KTP Baru',
                                'pindah_datang' => 'Pindah Datang',
                                'hilang' => 'KTP Hilang',
                                'rusak' => 'KTP Rusak',
                                'perpanjangan_itap' => 'Perpanjangan ITAP',
                                'perubahan_kewarganegaraan' => 'Perubahan Kewarganegaraan',
                                'luar_domisili' => 'Luar Domisili',
                                'transmigrasi' => 'Transmigrasi',
                                'perubahan_data' => 'Perubahan Data',
                            ];
                            $currentKtp = $pengajuan['jenis_permohonan_ktp'] ?? 'baru';
                            foreach ($ktpOptions as $kk => $kv): ?>
                                <label
                                    class="flex items-center gap-3 bg-slate-50 rounded-xl p-3.5 cursor-pointer border-2 transition-all <?= $currentKtp === $kk ? 'border-primary-500 bg-primary-50' : 'border-transparent hover:bg-slate-100' ?>">
                                    <input type="radio" name="jenis_permohonan_ktp" value="<?= $kk ?>" <?= $currentKtp === $kk ? 'checked' : '' ?> class="w-4 h-4 text-primary-600" required
                                        onchange="document.querySelectorAll('[name=jenis_permohonan_ktp]').forEach(r=>{r.closest('label').classList.toggle('border-primary-500',r.checked);r.closest('label').classList.toggle('bg-primary-50',r.checked);r.closest('label').classList.toggle('border-transparent',!r.checked)})">
                                    <span class="text-sm font-medium text-slate-700">
                                        <?= $kv ?>
                                    </span>
                                </label>
                            <?php endforeach; ?>
                        </div>
                    </div>
                <?php endif; ?>
            </div>
            <div class="flex items-center justify-between">
                <a href="<?= baseUrl("form.php?id={$pengajuanId}&step=1") ?>" class="flex items-center gap-2 text-sm
                font-medium text-slate-500 hover:text-slate-700 border border-slate-200 px-5 py-3 rounded-xl">←
                    Kembali</a>
                <button type="submit"
                    class="bg-primary-600 hover:bg-primary-700 text-white font-semibold px-6 py-3 rounded-xl transition-all shadow-lg shadow-primary-500/25 flex items-center gap-2">Lanjut
                    →</button>
            </div>
        </form>

    <?php elseif ($step === 3): // STEP 3: PINDAH=Keluarga Pindah / OTHERS=Detail ?>
        <form method="POST" action="<?= baseUrl('app/Controllers/PengajuanController.php?action=save_step') ?>">
            <input type="hidden" name="pengajuan_id" value="<?= $pengajuanId ?>">
            <input type="hidden" name="step" value="3">
            <div class="bg-white rounded-2xl border border-slate-100 p-6 mb-6">

                <?php if ($jenis === 'pindah'): ?>
                    <h3 class="text-lg font-bold text-slate-800 mb-1">Step 3: Daftar Keluarga Yang Pindah</h3>
                    <p class="text-sm text-slate-500 mb-6">Masukkan data anggota keluarga yang ikut pindah (F-1.03 #12).</p>
                    <div class="bg-blue-50 rounded-xl p-4 mb-6">
                        <p class="text-sm text-blue-700">ℹ️ Tambahkan seluruh anggota keluarga yang ikut berpindah.</p>
                    </div>
                    <div id="pindah-anggota-container">
                        <?php
                        $_pindahRows = $anggotaPindah;
                        if (empty($_pindahRows)) {
                            $_jkDef = $dataPindah['jenis_kepindahan'] ?? 'kepala_keluarga';
                            if (in_array($_jkDef, ['kepala_keluarga', 'kepala_dan_seluruh', 'kepala_dan_sebagian'], true)) {
                                $_pindahRows = [['nik' => $user['nik'] ?? '', 'nama' => $user['nama_lengkap'] ?? '', 'shdk' => 'Kepala Keluarga']];
                            }
                        }
                        ?>
                        <?php if (!empty($_pindahRows)):
                            foreach ($_pindahRows as $idx => $ap): ?>
                                <div class="pindah-row bg-slate-50 rounded-xl p-4 mb-3">
                                    <div class="flex justify-between items-center mb-3"><span
                                            class="text-sm font-bold text-slate-600">Anggota #<?= $idx + 1 ?></span><button
                                            type="button" onclick="this.closest('.pindah-row').remove()"
                                            class="text-red-400 hover:text-red-600 text-xs">✕ Hapus</button></div>
                                    <div class="grid grid-cols-1 md:grid-cols-3 gap-3">
                                        <div><label
                                                class="block text-[10px] font-semibold text-slate-400 uppercase mb-1">NIK</label><input
                                                type="text" name="pindah_nik[]" value="<?= htmlspecialchars($ap['nik'] ?? '') ?>"
                                                maxlength="16" placeholder="16 digit"
                                                class="w-full px-3 py-2.5 rounded-lg border border-slate-200 text-sm font-mono"></div>
                                        <div><label class="block text-[10px] font-semibold text-slate-400 uppercase mb-1">Nama
                                                Lengkap</label><input type="text" name="pindah_nama[]"
                                                value="<?= htmlspecialchars((string) ($ap['nama'] ?? '')) ?>" required placeholder="Nama sesuai KTP"
                                                class="w-full px-3 py-2.5 rounded-lg border border-slate-200 text-sm"></div>
                                        <div><label
                                                class="block text-[10px] font-semibold text-slate-400 uppercase mb-1">SHDK</label><select
                                                name="pindah_shdk[]"
                                                class="w-full px-3 py-2.5 rounded-lg border border-slate-200 text-sm"><?php foreach (['Kepala Keluarga', 'Istri', 'Anak', 'Menantu', 'Cucu', 'Orang Tua', 'Mertua', 'Famili Lain', 'Lainnya'] as $sh): ?>
                                                    <option value="<?= $sh ?>" <?= ($ap['shdk'] ?? '') === $sh ? 'selected' : '' ?>><?= $sh ?>
                                                    </option><?php endforeach; ?>
                                            </select></div>
                                    </div>
                                </div>
                            <?php endforeach; endif; ?>
                    </div>
                    <button type="button" onclick="addPindahAnggota()"
                        class="flex items-center gap-2 text-sm font-medium text-primary-600 hover:text-primary-700 mt-2"><svg
                            class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                        </svg> Tambah Anggota Keluarga</button>

                <?php else: ?>
                    <h3 class="text-lg font-bold text-slate-800 mb-1">Step 3: Detail Permohonan</h3>
                    <p class="text-sm text-slate-500 mb-6">Lengkapi detail permohonan layanan Anda.</p>
                    <div class="space-y-5">
                        <div><label class="block text-sm font-medium text-slate-700 mb-1">Alasan Permohonan</label><textarea
                                name="alasan_permohonan" rows="3" required
                                class="w-full px-4 py-3 rounded-xl border border-slate-200 focus:border-primary-500 focus:ring-2 focus:ring-primary-500/20 outline-none text-sm"
                                placeholder="Jelaskan alasan permohonan Anda..."><?= htmlspecialchars($pengajuan['alasan_permohonan'] ?? '') ?></textarea>
                        </div>
                        <div><label class="block text-sm font-medium text-slate-700 mb-1">Metode Pengambilan</label>
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-3">
                                <label
                                    class="flex items-center gap-3 bg-slate-50 rounded-xl p-4 cursor-pointer border-2 <?= ($pengajuan['metode_pengambilan'] ?? '') !== 'dikirim' ? 'border-primary-500 bg-primary-50' : 'border-transparent' ?>">
                                    <input type="radio" name="metode_pengambilan" value="ambil_sendiri"
                                        <?= ($pengajuan['metode_pengambilan'] ?? '') !== 'dikirim' ? 'checked' : '' ?> class="w-4
                            h-4 text-primary-600">
                                    <div>
                                        <p class="text-sm font-medium text-slate-800">Ambil Sendiri</p>
                                        <p class="text-xs text-slate-500">Ambil di kantor desa</p>
                                    </div>
                                </label>
                                <label
                                    class="flex items-center gap-3 bg-slate-50 rounded-xl p-4 cursor-pointer border-2 <?= ($pengajuan['metode_pengambilan'] ?? '') === 'dikirim' ? 'border-primary-500 bg-primary-50' : 'border-transparent' ?>">
                                    <input type="radio" name="metode_pengambilan" value="dikirim"
                                        <?= ($pengajuan['metode_pengambilan'] ?? '') === 'dikirim' ? 'checked' : '' ?> class="w-4
                            h-4 text-primary-600">
                                    <div>
                                        <p class="text-sm font-medium text-slate-800">Dikirim ke Alamat</p>
                                        <p class="text-xs text-slate-500">Estimasi 3-5 hari kerja</p>
                                    </div>
                                </label>
                            </div>
                        </div>
                    </div>
                <?php endif; ?>
            </div>
            <div class="flex items-center justify-between">
                <a href="<?= baseUrl("form.php?id={$pengajuanId}&step=2") ?>" class="flex items-center gap-2 text-sm
                font-medium text-slate-500 hover:text-slate-700 border border-slate-200 px-5 py-3 rounded-xl">←
                    Kembali</a>
                <button type="submit"
                    class="bg-primary-600 hover:bg-primary-700 text-white font-semibold px-6 py-3 rounded-xl transition-all shadow-lg shadow-primary-500/25 flex items-center gap-2">Lanjut
                    →</button>
            </div>
        </form>

    <?php elseif ($step === 4): // UPLOAD DOKUMEN ?>
        <?php
        // Determine required documents based on service type
        $requiredDocs = [];
        if ($jenis === 'ktp') {
            $ktpType = $pengajuan['jenis_permohonan_ktp'] ?? 'baru';
            switch ($ktpType) {
                case 'baru':
                    $requiredDocs = [['name' => 'Kartu Keluarga (KK)', 'note' => 'Wajib', 'icon' => 'family']];
                    $ktpDocNote = 'Untuk pemula (usia 17 tahun / sudah menikah)';
                    break;
                case 'pindah_datang':
                    $requiredDocs = [['name' => 'Surat Keterangan Pindah (SKPWNI)', 'note' => 'Wajib', 'icon' => 'doc'], ['name' => 'Kartu Keluarga (KK)', 'note' => 'Wajib', 'icon' => 'family']];
                    $ktpDocNote = 'Dari daerah lain (antar kota/provinsi)';
                    break;
                case 'hilang':
                    $requiredDocs = [['name' => 'Surat Kehilangan dari Kepolisian', 'note' => 'Wajib', 'icon' => 'doc'], ['name' => 'Kartu Keluarga (KK)', 'note' => 'Wajib', 'icon' => 'family']];
                    $ktpDocNote = 'Wajib ada surat resmi polisi';
                    break;
                case 'rusak':
                    $requiredDocs = [['name' => 'KTP-el yang rusak (foto)', 'note' => 'Wajib', 'icon' => 'photo'], ['name' => 'Kartu Keluarga (KK)', 'note' => 'Wajib', 'icon' => 'family']];
                    $ktpDocNote = 'Upload foto KTP rusak sebagai bukti fisik';
                    break;
                case 'perpanjangan_itap':
                    $requiredDocs = [['name' => 'KITAP (Kartu Izin Tinggal Tetap)', 'note' => 'Wajib', 'icon' => 'id'], ['name' => 'Paspor', 'note' => 'Wajib', 'icon' => 'id'], ['name' => 'Kartu Keluarga (jika ada)', 'note' => 'Opsional', 'icon' => 'family']];
                    $ktpDocNote = 'Untuk WNA dengan izin tinggal tetap';
                    break;
                case 'perubahan_kewarganegaraan':
                    $requiredDocs = [['name' => 'SK Perubahan Kewarganegaraan', 'note' => 'Wajib', 'icon' => 'doc'], ['name' => 'Paspor Lama (jika ada)', 'note' => 'Opsional', 'icon' => 'id'], ['name' => 'Kartu Keluarga (KK)', 'note' => 'Wajib', 'icon' => 'family']];
                    $ktpDocNote = 'Dari WNA → WNI atau sebaliknya';
                    break;
                case 'luar_domisili':
                    $requiredDocs = [['name' => 'Surat Keterangan Domisili Sementara', 'note' => 'Wajib', 'icon' => 'doc'], ['name' => 'Kartu Keluarga (KK)', 'note' => 'Wajib', 'icon' => 'family']];
                    $ktpDocNote = 'Perekaman KTP tidak sesuai alamat KK';
                    break;
                case 'transmigrasi':
                    $requiredDocs = [['name' => 'Surat Keterangan Transmigrasi', 'note' => 'Wajib', 'icon' => 'doc'], ['name' => 'Kartu Keluarga (KK)', 'note' => 'Wajib', 'icon' => 'family']];
                    $ktpDocNote = 'Program resmi pemerintah';
                    break;
                case 'perubahan_data':
                    $requiredDocs = [['name' => 'KTP-el Lama', 'note' => 'Wajib', 'icon' => 'id'], ['name' => 'Dokumen Pendukung Perubahan', 'note' => 'Wajib', 'icon' => 'doc'], ['name' => 'Kartu Keluarga (KK)', 'note' => 'Wajib', 'icon' => 'family']];
                    $ktpDocNote = 'Ijazah, akta, atau dokumen sesuai perubahan';
                    break;
                default:
                    $requiredDocs = [['name' => 'Kartu Keluarga (KK)', 'note' => 'Wajib', 'icon' => 'family']];
                    $ktpDocNote = '';
            }
        } elseif ($jenis === 'pindah') {
            $requiredDocs = [
                ['name' => 'KTP Pemohon', 'note' => 'Wajib', 'icon' => 'id'],
                ['name' => 'Kartu Keluarga', 'note' => 'Wajib', 'icon' => 'family'],
                ['name' => 'Surat Pengantar RT/RW', 'note' => 'Wajib', 'icon' => 'doc'],
                ['name' => 'Pas Foto 3x4', 'note' => 'Opsional', 'icon' => 'photo'],
            ];
        } elseif ($jenis === 'kk') {
            $subKK = $dataKeluarga['sub_jenis_kk'] ?? '';
            $jenisKK = $dataKeluarga['jenis_permohonan_kk'] ?? 'baru';
            $requiredDocs = [['name' => 'KTP Pemohon', 'note' => 'Wajib', 'icon' => 'id']];

            if ($jenisKK === 'baru') {
                if ($subKK === 'membentuk_keluarga') {
                    $requiredDocs[] = ['name' => 'Buku Nikah / Akta Perkawinan', 'note' => 'Wajib', 'icon' => 'doc'];
                    $requiredDocs[] = ['name' => 'Surat Keterangan Pindah', 'note' => 'Jika pindah', 'icon' => 'doc'];
                } elseif ($subKK === 'penggantian_kk') {
                    $requiredDocs[] = ['name' => 'KK Lama', 'note' => 'Wajib', 'icon' => 'family'];
                    $requiredDocs[] = ['name' => 'Akta Kematian / Surat Pendukung', 'note' => 'Wajib', 'icon' => 'doc'];
                } elseif ($subKK === 'pisah_kk') {
                    $requiredDocs[] = ['name' => 'KK Lama', 'note' => 'Wajib', 'icon' => 'family'];
                    $requiredDocs[] = ['name' => 'Surat Pernyataan Pisah KK', 'note' => 'Wajib', 'icon' => 'doc'];
                } elseif ($subKK === 'pindah_datang') {
                    $requiredDocs[] = ['name' => 'Surat Pindah (SKPWNI)', 'note' => 'Wajib', 'icon' => 'doc'];
                } elseif ($subKK === 'wni_luar_negeri') {
                    $requiredDocs[] = ['name' => 'Paspor', 'note' => 'Wajib', 'icon' => 'id'];
                    $requiredDocs[] = ['name' => 'Surat Keterangan Datang dari LN', 'note' => 'Wajib', 'icon' => 'doc'];
                } else {
                    $requiredDocs[] = ['name' => 'Buku Nikah / Akta Perkawinan', 'note' => 'Wajib', 'icon' => 'doc'];
                }
            } elseif ($jenisKK === 'perubahan') {
                $requiredDocs[] = ['name' => 'KK Lama', 'note' => 'Wajib', 'icon' => 'family'];
                if ($subKK === 'menumpang_kk') {
                    $requiredDocs[] = ['name' => 'Akta Kelahiran', 'note' => 'Wajib', 'icon' => 'doc'];
                } elseif ($subKK === 'peristiwa_penting') {
                    $requiredDocs[] = ['name' => 'Akta Nikah / Cerai / Kematian', 'note' => 'Sesuai peristiwa', 'icon' => 'doc'];
                } elseif ($subKK === 'perubahan_elemen') {
                    $requiredDocs[] = ['name' => 'Ijazah / Dokumen Pendukung', 'note' => 'Sesuai perubahan', 'icon' => 'doc'];
                } else {
                    $requiredDocs[] = ['name' => 'Dokumen Pendukung', 'note' => 'Wajib', 'icon' => 'doc'];
                }
            } elseif ($jenisKK === 'hilang_rusak') {
                if ($subKK === 'hilang') {
                    $requiredDocs[] = ['name' => 'Surat Kehilangan dari Polisi', 'note' => 'Wajib', 'icon' => 'doc'];
                } else {
                    $requiredDocs[] = ['name' => 'KK Rusak (Foto)', 'note' => 'Wajib', 'icon' => 'photo'];
                }
            }
        }

        $iconSvg = [
            'id' => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V8a2 2 0 00-2-2h-5m-4 0V5a2 2 0 114 0v1m-4 0a2 2 0 104 0m-5 8a2 2 0 100-4 2 2 0 000 4zm0 0c1.306 0 2.417.835 2.83 2M9 14a3.001 3.001 0 00-2.83 2M15 11h3m-3 4h2" />',
            'doc' => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />',
            'family' => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z" />',
            'photo' => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />',
        ];

        // Group uploaded documents by their jenis_dokumen
        $uploadedDocsGrouped = [];
        foreach ($dokumen as $doc) {
            $uploadedDocsGrouped[$doc['jenis_dokumen']] = $doc;
        }
        ?>
        <div class="bg-white rounded-2xl border border-slate-100 p-6 mb-6">
            <div class="flex items-center justify-between mb-4">
                <div>
                    <h3 class="text-lg font-bold text-slate-800">Step 4: Unggah Dokumen Pendukung</h3>
                    <p class="text-sm text-slate-500">Kategorikan dan unggah berkas administrasi sesuai persyaratan.</p>
                </div>
                <span class="px-3 py-1 rounded-full text-xs font-semibold bg-amber-100 text-amber-700">Wajib diisi</span>
            </div>

            <?php if (!empty($ktpDocNote)): ?>
                <div class="bg-blue-50 rounded-xl p-4 mb-6">
                    <p class="text-sm font-semibold text-blue-800 flex items-center gap-2"><span>💡</span> Catatan Khusus:</p>
                    <p class="text-xs text-blue-600 mt-1"><?= $ktpDocNote ?></p>
                </div>
            <?php endif; ?>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <?php foreach ($requiredDocs as $idx => $rd):
                    $docName = $rd['name'];
                    $isUploaded = isset($uploadedDocsGrouped[$docName]);
                    ?>
                    <div class="border <?= $isUploaded ? 'border-primary-500 bg-primary-50' : 'border-slate-200 bg-white' ?> rounded-xl p-4 flex flex-col justify-between"
                        id="doc-container-<?= md5($docName) ?>" data-doc-name="<?= htmlspecialchars($docName, ENT_QUOTES, 'UTF-8') ?>">
                        <div class="flex gap-4 items-start mb-4">
                            <div
                                class="w-10 h-10 rounded-lg <?= $isUploaded ? 'bg-primary-100 text-primary-600' : 'bg-slate-50 text-slate-400' ?> flex items-center justify-center flex-shrink-0">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24"><?= $iconSvg[$rd['icon']] ?></svg>
                            </div>
                            <div class="flex-1">
                                <h4 class="text-sm font-bold text-slate-800"><?= htmlspecialchars($docName) ?></h4>
                                <p class="text-xs text-slate-500 mt-0.5"><?= $rd['note'] ?></p>
                            </div>
                            <?php if ($isUploaded): ?>
                                <span class="bg-emerald-100 text-emerald-600 p-1.5 rounded-full flex-shrink-0">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                                    </svg>
                                </span>
                            <?php endif; ?>
                        </div>

                        <div class="doc-action-area">
                            <?php if ($isUploaded):
                                $ud = $uploadedDocsGrouped[$docName];
                                ?>
                                <div class="flex items-center justify-between p-2 mb-2 bg-white rounded-lg border border-primary-100">
                                    <div class="truncate text-xs font-semibold text-primary-700 max-w-[150px]"
                                        title="<?= htmlspecialchars($ud['nama_asli']) ?>">
                                        <?= htmlspecialchars($ud['nama_asli']) ?>
                                    </div>
                                    <div class="text-[10px] text-slate-400"><?= round($ud['ukuran_file'] / 1024) ?> KB</div>
                                </div>
                                <button type="button" onclick="deleteCategorizedDoc('<?= $ud['id'] ?>', '<?= md5($docName) ?>')"
                                    class="mt-auto w-full py-2 bg-red-50 text-red-600 hover:bg-red-100 rounded-lg text-xs font-bold transition-colors">
                                    Hapus Berkas
                                </button>
                            <?php else: ?>
                                <input type="file" id="file-<?= md5($docName) ?>" accept=".pdf,.jpg,.jpeg,.png" class="hidden"
                                    onchange="uploadCategorizedFile(this.files[0], '<?= addslashes($docName) ?>', '<?= md5($docName) ?>')">
                                <button type="button" onclick="document.getElementById('file-<?= md5($docName) ?>').click()"
                                    class="mt-auto w-full py-3 border border-dashed border-slate-300 text-slate-500 hover:text-primary-600 hover:border-primary-400 hover:bg-slate-50 rounded-lg text-xs font-bold transition-all flex justify-center items-center gap-2">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0l-4 4m4-4v12" />
                                    </svg>
                                    Pilih File
                                </button>
                            <?php endif; ?>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
            <div class="mt-4">
                <p class="text-[11px] text-slate-400">Pastikan format file adalah PDF, JPG, atau PNG dengan ukuran maksimal
                    5MB per file.</p>
            </div>
        </div>
        <div class="flex items-center justify-between">
            <a href="<?= baseUrl("form.php?id={$pengajuanId}&step=3") ?>" class="flex items-center gap-2 text-sm
            font-medium text-slate-500 hover:text-slate-700 border border-slate-200 px-5 py-3 rounded-xl">← Kembali</a>
            <a href="<?= baseUrl("form.php?id={$pengajuanId}&step=5") ?>" class="bg-primary-600 hover:bg-primary-700
            text-white font-semibold px-6 py-3 rounded-xl transition-all shadow-lg shadow-primary-500/25 flex
            items-center gap-2">Lanjut ke Konfirmasi →</a>
        </div>

    <?php elseif ($step === 5): // REVIEW & SUBMIT ?>
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 mb-6">
            <div class="lg:col-span-2 space-y-6">
                <!-- Data Pribadi -->
                <div class="bg-white rounded-2xl border border-slate-100 p-6">
                    <div class="flex items-center justify-between mb-4">
                        <h3 class="font-bold text-slate-800 flex items-center gap-2"><svg class="w-5 h-5 text-primary-500"
                                fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                    d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                            </svg> Data Pribadi</h3><a href="<?= baseUrl("form.php?id={$pengajuanId}&step=1") ?>"
                            class="text-sm text-primary-600 hover:text-primary-700">Ubah</a>
                    </div>
                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <p class="text-xs font-semibold text-slate-400 uppercase">Nama Lengkap</p>
                            <p class="text-sm text-slate-800 font-medium">
                                <?= htmlspecialchars($user['nama_lengkap']) ?>
                            </p>
                        </div>
                        <div>
                            <p class="text-xs font-semibold text-slate-400 uppercase">NIK</p>
                            <p class="text-sm text-slate-800 font-medium">
                                <?= htmlspecialchars($user['nik']) ?>
                            </p>
                        </div>
                        <div>
                            <p class="text-xs font-semibold text-slate-400 uppercase">Tempat, Tanggal Lahir</p>
                            <p class="text-sm text-slate-800">
                                <?= htmlspecialchars(($user['tempat_lahir'] ?? '-') . ', ' . ($user['tanggal_lahir'] ? date('d M Y', strtotime($user['tanggal_lahir'])) : '-')) ?>
                            </p>
                        </div>
                        <div>
                            <p class="text-xs font-semibold text-slate-400 uppercase">Alamat Domisili</p>
                            <p class="text-sm text-slate-800">
                                <?= htmlspecialchars($user['alamat'] ?? '-') ?>
                            </p>
                        </div>
                    </div>
                </div>
                <!-- Dynamic Data -->
                <?php if ($jenis === 'kk' && $dataKeluarga): ?>
                    <div class="bg-white rounded-2xl border border-slate-100 p-6">
                        <div class="flex items-center justify-between mb-4">
                            <h3 class="font-bold text-slate-800">👨‍👩‍👧‍👦 Data Keluarga</h3><a
                                href="<?= baseUrl("form.php?id={$pengajuanId}&step=2") ?>"
                                class="text-sm text-primary-600">Ubah</a>
                        </div>
                        <div class="grid grid-cols-2 gap-4">
                            <div>
                                <p class="text-xs font-semibold text-slate-400 uppercase">No KK</p>
                                <p class="text-sm text-slate-800 font-medium">
                                    <?php $rn = formValueFromDraftOrUser($dataKeluarga, $user, 'no_kk'); ?>
                                    <?= htmlspecialchars($rn !== '' ? $rn : '-') ?>
                                </p>
                            </div>
                            <div>
                                <p class="text-xs font-semibold text-slate-400 uppercase">Kepala Keluarga</p>
                                <p class="text-sm text-slate-800 font-medium">
                                    <?php $rk = formValueFromDraftOrUser($dataKeluarga, $user, 'nama_kepala_keluarga', 'nama_kepala_keluarga', 'nama_lengkap'); ?>
                                    <?= htmlspecialchars($rk !== '' ? $rk : '-') ?>
                                </p>
                            </div>
                            <div>
                                <p class="text-xs font-semibold text-slate-400 uppercase">Jumlah Anggota</p>
                                <p class="text-sm text-slate-800">
                                    <?= count($anggotaKeluarga) ?> Orang
                                </p>
                            </div>
                        </div>
                    </div>
                <?php elseif ($jenis === 'pindah' && $dataPindah): ?>
                    <?php
                    $jpLabels = ['skp' => 'Surat Keterangan Pindah', 'skpln' => 'SKPLN', 'sktt' => 'SKTT'];
                    $alLabels = ['pekerjaan' => 'Pekerjaan', 'pendidikan' => 'Pendidikan', 'keamanan' => 'Keamanan', 'kesehatan' => 'Kesehatan', 'perumahan' => 'Perumahan', 'keluarga' => 'Keluarga', 'lainnya' => 'Lainnya'];
                    $jkLabels = ['kepala_keluarga' => 'Kepala Keluarga', 'kepala_dan_seluruh' => 'KK dan Seluruh Anggota', 'kepala_dan_sebagian' => 'KK dan Sebagian Anggota', 'anggota_keluarga' => 'Anggota Keluarga'];
                    ?>
                    <div class="bg-white rounded-2xl border border-slate-100 p-6">
                        <div class="flex items-center justify-between mb-4">
                            <h3 class="font-bold text-slate-800">📍 Data Pindah</h3><a
                                href="<?= baseUrl("form.php?id={$pengajuanId}&step=2") ?>"
                                class="text-sm text-primary-600">Ubah</a>
                        </div>
                        <div class="grid grid-cols-2 gap-4">
                            <div>
                                <p class="text-xs font-semibold text-slate-400 uppercase">Jenis Permohonan</p>
                                <p class="text-sm text-slate-800 font-medium">
                                    <?= $jpLabels[$dataPindah['jenis_permohonan_pindah'] ?? 'skp'] ?>
                                </p>
                            </div>
                            <div>
                                <p class="text-xs font-semibold text-slate-400 uppercase">Alasan Pindah</p>
                                <p class="text-sm text-slate-800">
                                    <?= $alLabels[$dataPindah['alasan_pindah'] ?? ''] ?? '-' ?>
                                    <?= ($dataPindah['alasan_pindah'] === 'lainnya' && !empty($dataPindah['alasan_pindah_lainnya'])) ? ' (' . htmlspecialchars($dataPindah['alasan_pindah_lainnya']) . ')' : '' ?>
                                </p>
                            </div>
                            <div>
                                <p class="text-xs font-semibold text-slate-400 uppercase">Jenis Kepindahan</p>
                                <p class="text-sm text-slate-800"><?= $jkLabels[$dataPindah['jenis_kepindahan']] ?? '-' ?></p>
                            </div>
                            <div>
                                <p class="text-xs font-semibold text-slate-400 uppercase">Jumlah Pindah</p>
                                <p class="text-sm text-slate-800"><?= $dataPindah['jumlah_keluarga_pindah'] ?? 1 ?> Orang</p>
                            </div>
                            <div>
                                <p class="text-xs font-semibold text-slate-400 uppercase">Alamat Asal</p>
                                <p class="text-sm text-slate-800"><?= htmlspecialchars($dataPindah['alamat_asal']) ?></p>
                            </div>
                            <div>
                                <p class="text-xs font-semibold text-slate-400 uppercase">Alamat Tujuan</p>
                                <p class="text-sm text-slate-800"><?= htmlspecialchars($dataPindah['alamat_tujuan']) ?></p>
                            </div>
                        </div>
                    </div>
                    <?php if (!empty($anggotaPindah)): ?>
                        <div class="bg-white rounded-2xl border border-slate-100 p-6">
                            <div class="flex items-center justify-between mb-4">
                                <h3 class="font-bold text-slate-800">👨‍👩‍👧‍👦 Daftar Keluarga Pindah</h3><a
                                    href="<?= baseUrl("form.php?id={$pengajuanId}&step=3") ?>"
                                    class="text-sm text-primary-600">Ubah</a>
                            </div>
                            <table class="w-full text-sm">
                                <thead class="text-xs uppercase text-slate-400 border-b">
                                    <tr>
                                        <th class="py-2 text-left">No</th>
                                        <th class="py-2 text-left">NIK</th>
                                        <th class="py-2 text-left">Nama</th>
                                        <th class="py-2 text-left">SHDK</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($anggotaPindah as $i => $ap): ?>
                                        <tr class="border-b border-slate-50">
                                            <td class="py-2"><?= $i + 1 ?></td>
                                            <td class="py-2 font-mono text-xs"><?= htmlspecialchars($ap['nik'] ?? '-') ?></td>
                                            <td class="py-2"><?= htmlspecialchars($ap['nama']) ?></td>
                                            <td class="py-2"><?= htmlspecialchars($ap['shdk'] ?? '-') ?></td>
                                        </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                        </div>
                    <?php endif; ?>
                <?php endif; ?>
                <!-- Detail Permohonan -->
                <div class="bg-white rounded-2xl border border-slate-100 p-6">
                    <div class="flex items-center justify-between mb-4">
                        <h3 class="font-bold text-slate-800">📋 Detail Permohonan</h3><a
                            href="<?= baseUrl("form.php?id={$pengajuanId}&step=3") ?>"
                            class="text-sm text-primary-600">Ubah</a>
                    </div>
                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <p class="text-xs font-semibold text-slate-400 uppercase">Jenis Layanan</p>
                            <p class="text-sm text-slate-800 font-medium">
                                <?= $jenisLabels[$jenis] ?>
                            </p>
                        </div>
                        <div>
                            <p class="text-xs font-semibold text-slate-400 uppercase">Alasan</p>
                            <p class="text-sm text-slate-800">
                                <?= htmlspecialchars($pengajuan['alasan_permohonan'] ?? '-') ?>
                            </p>
                        </div>
                        <div>
                            <p class="text-xs font-semibold text-slate-400 uppercase">Metode Pengambilan</p>
                            <p class="text-sm text-slate-800">
                                <?= ($pengajuan['metode_pengambilan'] ?? 'ambil_sendiri') === 'dikirim' ? '🚚 Dikirim ke Alamat' : '🏢 Ambil Sendiri' ?>
                            </p>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Right: Documents + Submit -->
            <div class="space-y-6">
                <div class="bg-white rounded-2xl border border-slate-100 p-6">
                    <h3 class="font-bold text-slate-800 mb-4">📎 List Dokumen</h3>
                    <?php if (empty($dokumen)): ?>
                        <p class="text-sm text-slate-400 text-center py-4">Belum ada dokumen</p>
                    <?php else:
                        foreach ($dokumen as $doc): ?>
                            <div class="flex items-center gap-3 py-2 border-b border-slate-50 last:border-0">
                                <div class="w-8 h-8 rounded-lg bg-primary-50 flex items-center justify-center"><svg
                                        class="w-4 h-4 text-primary-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                            d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                    </svg></div>
                                <div class="flex-1 min-w-0">
                                    <p class="text-sm font-medium text-slate-700 truncate">
                                        <?= htmlspecialchars($doc['nama_asli']) ?>
                                    </p>
                                    <p class="text-xs text-slate-400">
                                        <?= round($doc['ukuran_file'] / 1024) ?> KB
                                    </p>
                                </div>
                                <span class="text-emerald-500"><svg class="w-5 h-5" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                                    </svg></span>
                            </div>
                        <?php endforeach; endif; ?>
                </div>
                <!-- Submit -->
                <div class="bg-white rounded-2xl border border-slate-100 p-6">
                    <form method="POST" action="<?= baseUrl('app/Controllers/PengajuanController.php?action=submit') ?>"
                        onsubmit="return document.getElementById('agree').checked || (alert('Anda harus menyetujui pernyataan.'),false)">
                        <input type="hidden" name="pengajuan_id" value="<?= $pengajuanId ?>">
                        <label class="flex items-start gap-3 cursor-pointer mb-4">
                            <input type="checkbox" id="agree" class="w-4 h-4 mt-0.5 text-primary-600 rounded">
                            <span class="text-xs text-slate-600 leading-relaxed">Saya menyatakan bahwa seluruh data yang
                                saya masukkan adalah benar dan dapat dipertanggungjawabkan sesuai hukum yang berlaku.</span>
                        </label>
                        <button type="submit"
                            class="w-full bg-primary-900 hover:bg-primary-950 text-white font-bold py-3 rounded-xl transition-all">Kirim
                            Pengajuan</button>
                        <p class="text-xs text-slate-400 text-center mt-3">Pengajuan akan diproses oleh administrator desa
                            dalam waktu maksimal 2x24 jam hari kerja.</p>
                    </form>
                </div>
            </div>
        </div>
        <div class="flex items-center justify-start mb-4">
            <a href="<?= baseUrl("form.php?id={$pengajuanId}&step=4") ?>" class="flex items-center gap-2 text-sm
            font-medium text-slate-500 hover:text-slate-700 border border-slate-200 px-5 py-3 rounded-xl">← Kembali</a>
        </div>
    <?php endif; ?>

</div>

<?php if ($step === 2 && $jenis === 'kk'): ?>
    <script>
        let anggotaCount = <?= max(count($anggotaKeluarga), 0) ?>;
        function addAnggota() {
            anggotaCount++;
            const html = `<div class="anggota-row bg-slate-50 rounded-xl p-4 mb-3"><div class="flex justify-between items-center mb-3"><span class="text-sm font-semibold text-slate-600">Anggota #${anggotaCount}</span><button type="button" onclick="this.closest('.anggota-row').remove()" class="text-red-400 hover:text-red-600 text-xs">Hapus</button></div><div class="grid grid-cols-2 md:grid-cols-3 gap-3"><input type="text" name="anggota_nama[]" placeholder="Nama" class="px-3 py-2 rounded-lg border border-slate-200 text-sm"><input type="text" name="anggota_nik[]" placeholder="NIK" maxlength="16" class="px-3 py-2 rounded-lg border border-slate-200 text-sm"><select name="anggota_jk[]" class="px-3 py-2 rounded-lg border border-slate-200 text-sm"><option value="L">Laki-laki</option><option value="P">Perempuan</option></select><input type="text" name="anggota_tempat_lahir[]" placeholder="Tempat Lahir" class="px-3 py-2 rounded-lg border border-slate-200 text-sm"><input type="date" name="anggota_tanggal_lahir[]" class="px-3 py-2 rounded-lg border border-slate-200 text-sm"><input type="text" name="anggota_hubungan[]" placeholder="Hubungan" class="px-3 py-2 rounded-lg border border-slate-200 text-sm"><input type="text" name="anggota_agama[]" placeholder="Agama" class="px-3 py-2 rounded-lg border border-slate-200 text-sm"><input type="text" name="anggota_pendidikan[]" placeholder="Pendidikan" class="px-3 py-2 rounded-lg border border-slate-200 text-sm"><input type="text" name="anggota_pekerjaan[]" placeholder="Pekerjaan" class="px-3 py-2 rounded-lg border border-slate-200 text-sm"><input type="text" name="anggota_status_perkawinan[]" placeholder="Status Kawin" class="px-3 py-2 rounded-lg border border-slate-200 text-sm"></div></div>`;
            document.getElementById('anggota-container').insertAdjacentHTML('beforeend', html);
        }

        // KK Type selector
        document.querySelectorAll('.kk-type-card').forEach(card => {
            card.addEventListener('click', function () {
                const type = this.dataset.type;
                this.querySelector('input').checked = true;
                document.querySelectorAll('.kk-type-card').forEach(c => {
                    c.classList.toggle('border-primary-500', c.dataset.type === type);
                    c.classList.toggle('bg-primary-50', c.dataset.type === type);
                    c.classList.toggle('border-transparent', c.dataset.type !== type);
                });
                document.querySelectorAll('.kk-sub-group').forEach(g => {
                    g.style.display = g.dataset.parent === type ? 'block' : 'none';
                });
                // Uncheck other sub-radios
                document.querySelectorAll('.kk-sub-group:not([data-parent="' + type + '"]) input[type=radio]').forEach(r => r.checked = false);
            });
        });
        document.querySelectorAll('.kk-sub-card input[type=radio]').forEach(r => {
            r.addEventListener('change', function () {
                document.querySelectorAll('.kk-sub-card').forEach(c => {
                    c.classList.toggle('border-primary-500', c.querySelector('input').checked);
                    c.classList.toggle('bg-primary-50', c.querySelector('input').checked);
                    c.classList.toggle('border-slate-200', !c.querySelector('input').checked);
                });
            });
        });
    </script>
<?php endif; ?>

<?php if ($step === 3 && $jenis === 'pindah'): ?>
    <script>
        let pindahCount = <?= max(count($anggotaPindah ?? []), 0) ?>;
        function addPindahAnggota() {
            pindahCount++;
            const shdkOpts = ['Kepala Keluarga', 'Istri', 'Anak', 'Menantu', 'Cucu', 'Orang Tua', 'Mertua', 'Famili Lain', 'Lainnya'].map(s => `<option value="${s}">${s}</option>`).join('');
            const html = `<div class="pindah-row bg-slate-50 rounded-xl p-4 mb-3"><div class="flex justify-between items-center mb-3"><span class="text-sm font-bold text-slate-600">Anggota #${pindahCount}</span><button type="button" onclick="this.closest('.pindah-row').remove()" class="text-red-400 hover:text-red-600 text-xs">✕ Hapus</button></div><div class="grid grid-cols-1 md:grid-cols-3 gap-3"><div><label class="block text-[10px] font-semibold text-slate-400 uppercase mb-1">NIK</label><input type="text" name="pindah_nik[]" maxlength="16" placeholder="16 digit" class="w-full px-3 py-2.5 rounded-lg border border-slate-200 text-sm font-mono"></div><div><label class="block text-[10px] font-semibold text-slate-400 uppercase mb-1">Nama Lengkap</label><input type="text" name="pindah_nama[]" required placeholder="Nama sesuai KTP" class="w-full px-3 py-2.5 rounded-lg border border-slate-200 text-sm"></div><div><label class="block text-[10px] font-semibold text-slate-400 uppercase mb-1">SHDK</label><select name="pindah_shdk[]" class="w-full px-3 py-2.5 rounded-lg border border-slate-200 text-sm">${shdkOpts}</select></div></div></div>`;
            document.getElementById('pindah-anggota-container').insertAdjacentHTML('beforeend', html);
        }
    </script>
<?php endif; ?>

<?php if ($step === 4): ?>
    <script>
        const pengajuanId = <?= $pengajuanId ?>;
        const uploadUrl = '<?= baseUrl("app/Controllers/PengajuanController.php?action=upload_dokumen") ?>';
        const deleteUrl = '<?= baseUrl("app/Controllers/PengajuanController.php?action=delete_dokumen") ?>';

        function setContainerLoading(container, isLoading) {
            container.style.opacity = isLoading ? '0.6' : '1';
            container.style.pointerEvents = isLoading ? 'none' : 'auto';
        }

        function buildUploadButtonMarkup(hashClass, docName) {
            const escapedDocName = docName.replace(/'/g, "\\'");
            return `
                <input type="file" id="file-${hashClass}" accept=".pdf,.jpg,.jpeg,.png" class="hidden"
                    onchange="uploadCategorizedFile(this.files[0], '${escapedDocName}', '${hashClass}')">
                <button type="button" onclick="document.getElementById('file-${hashClass}').click()"
                    class="mt-auto w-full py-3 border border-dashed border-slate-300 text-slate-500 hover:text-primary-600 hover:border-primary-400 hover:bg-slate-50 rounded-lg text-xs font-bold transition-all flex justify-center items-center gap-2">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0l-4 4m4-4v12" />
                    </svg>
                    Pilih File
                </button>
            `;
        }

        function buildUploadedMarkup(dokumen, hashClass) {
            const sizeKB = Math.round((Number(dokumen.ukuran_file) || 0) / 1024);
            return `
                <div class="flex items-center justify-between p-2 mb-2 bg-white rounded-lg border border-primary-100">
                    <div class="truncate text-xs font-semibold text-primary-700 max-w-[150px]" title="${dokumen.nama_asli}">
                        ${dokumen.nama_asli}
                    </div>
                    <div class="text-[10px] text-slate-400">${sizeKB} KB</div>
                </div>
                <button type="button" onclick="deleteCategorizedDoc('${dokumen.id}', '${hashClass}')"
                    class="mt-auto w-full py-2 bg-red-50 text-red-600 hover:bg-red-100 rounded-lg text-xs font-bold transition-colors">
                    Hapus Berkas
                </button>
            `;
        }

        function uploadCategorizedFile(file, docName, hashClass) {
            if (!file) return;

            const container = document.getElementById('doc-container-' + hashClass);
            if (!container) return;

            const oldActionArea = container.querySelector('.doc-action-area');
            if (oldActionArea) {
                oldActionArea.innerHTML = '<div class="text-xs text-primary-600 font-semibold">Mengunggah file...</div>';
            }
            setContainerLoading(container, true);

            const fd = new FormData();
            fd.append('file', file);
            fd.append('pengajuan_id', pengajuanId);
            fd.append('jenis_dokumen', docName);

            fetch(uploadUrl, { method: 'POST', body: fd })
                .then(r => r.json())
                .then(data => {
                    if (!data.success) {
                        throw new Error(data.message || 'Upload gagal.');
                    }

                    container.classList.remove('border-slate-200', 'bg-white');
                    container.classList.add('border-primary-500', 'bg-primary-50');

                    const actionArea = container.querySelector('.doc-action-area');
                    if (actionArea && data.dokumen) {
                        actionArea.innerHTML = buildUploadedMarkup(data.dokumen, hashClass);
                    }
                })
                .catch(err => {
                    alert(err.message || 'Terjadi kesalahan saat mengunggah.');
                    const actionArea = container.querySelector('.doc-action-area');
                    if (actionArea) {
                        actionArea.innerHTML = buildUploadButtonMarkup(hashClass, docName);
                    }
                })
                .finally(() => {
                    setContainerLoading(container, false);
                });
        }

        function deleteCategorizedDoc(id, hashClass) {
            if (!confirm('Hapus dokumen pendukung ini?')) return;

            const container = document.getElementById('doc-container-' + hashClass);
            if (!container) return;
            const docName = container.dataset.docName || '';
            setContainerLoading(container, true);

            const fd = new FormData();
            fd.append('dokumen_id', id);

            fetch(deleteUrl, { method: 'POST', body: fd })
                .then(r => r.json())
                .then(data => {
                    if (!data.success) {
                        throw new Error(data.message || 'Gagal menghapus dokumen.');
                    }
                    container.classList.remove('border-primary-500', 'bg-primary-50');
                    container.classList.add('border-slate-200', 'bg-white');
                    const actionArea = container.querySelector('.doc-action-area');
                    if (actionArea) {
                        actionArea.innerHTML = buildUploadButtonMarkup(hashClass, docName);
                    }
                })
                .catch(err => {
                    alert(err.message || 'Terjadi kesalahan saat menghapus.');
                })
                .finally(() => {
                    setContainerLoading(container, false);
                });
        }
    </script>
<?php endif; ?>
