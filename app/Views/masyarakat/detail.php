<!-- Back + Title -->
<div class="flex items-center gap-4 mb-6">
    <a href="<?= baseUrl($isAdminView ? 'admin.php?page=' . $adminBackPage : 'riwayat.php') ?>"
        class="w-9 h-9 rounded-lg border border-slate-200 flex items-center justify-center hover:bg-slate-50 transition-colors">
        <svg class="w-4 h-4 text-slate-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
        </svg>
    </a>
    <div class="flex-1">
        <h2 class="text-xl font-bold text-slate-800">Detail <?= $jenisLabels[$jenis] ?></h2>
    </div>
    <span class="px-3 py-1 rounded-lg bg-slate-100 text-slate-600 text-xs font-mono font-semibold">Form
        <?= htmlspecialchars($pengajuan['no_registrasi']) ?></span>
</div>

<div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
    <!-- Left: Data -->
    <div class="lg:col-span-2 space-y-6">

        <!-- Data Pemohon -->
        <div class="bg-white rounded-2xl border border-slate-100 p-6">
            <h3 class="text-base font-bold text-slate-800 mb-4 flex items-center gap-2">
                <svg class="w-5 h-5 text-primary-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                        d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                </svg>
                Data Pemohon
            </h3>
            <div class="flex flex-col sm:flex-row gap-5 mb-6 pb-6 border-b border-slate-100">
                <div class="shrink-0">
                    <?= htmlUserAvatarRing([
                        'id' => (int) ($pengajuan['user_id'] ?? 0),
                        'nama_lengkap' => $pengajuan['nama_lengkap'] ?? '',
                        'avatar' => $pengajuan['pemohon_avatar'] ?? '',
                    ], 'w-20 h-20', 'text-lg') ?>
                </div>
                <div class="min-w-0">
                    <p class="text-[10px] font-semibold text-slate-400 uppercase tracking-wider mb-1">Nama Lengkap</p>
                    <p class="text-lg font-bold text-slate-800 uppercase leading-snug">
                        <?= htmlspecialchars($pengajuan['nama_lengkap']) ?>
                    </p>
                    <p class="text-xs text-slate-500 mt-1 font-mono">NIK <?= htmlspecialchars($pengajuan['nik']) ?></p>
                </div>
            </div>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-y-5 gap-x-8">
                <div>
                    <p class="text-[10px] font-semibold text-slate-400 uppercase tracking-wider mb-1">Tempat / Tanggal
                        Lahir</p>
                    <p class="text-sm text-slate-700">
                        <?= htmlspecialchars(($pengajuan['tempat_lahir'] ?? '-') . ', ' . ($pengajuan['tanggal_lahir'] ? date('d M Y', strtotime($pengajuan['tanggal_lahir'])) : '-')) ?>
                    </p>
                </div>
                <div>
                    <p class="text-[10px] font-semibold text-slate-400 uppercase tracking-wider mb-1">No. HP / Email</p>
                    <p class="text-sm text-slate-700"><?= htmlspecialchars($pengajuan['no_hp'] ?? '-') ?> /
                        <?= htmlspecialchars($pengajuan['email']) ?>
                    </p>
                </div>
                <div class="md:col-span-2">
                    <p class="text-[10px] font-semibold text-slate-400 uppercase tracking-wider mb-1">Alamat</p>
                    <p class="text-sm text-slate-700"><?= htmlspecialchars($pengajuan['alamat'] ?? '-') ?></p>
                </div>
            </div>
        </div>

        <?php if ($jenis === 'kk' && $dataKeluarga): ?>
            <!-- Data Keluarga -->
            <div class="bg-white rounded-2xl border border-slate-100 p-6">
                <div class="flex items-center justify-between mb-4">
                    <h3 class="text-base font-bold text-slate-800 flex items-center gap-2">
                        <svg class="w-5 h-5 text-primary-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z" />
                        </svg>
                        Anggota Keluarga Yang Terdaftar
                    </h3>
                    <span class="text-xs text-slate-400"><?= count($anggota) ?> Orang Terdaftar</span>
                </div>
                <div class="grid grid-cols-2 gap-4 mb-5 p-3 bg-slate-50 rounded-xl">
                    <?php
                    $pemohonProfilKk = [
                        'no_kk' => $pengajuan['pemohon_no_kk'] ?? '',
                        'nama_kepala_keluarga' => $pengajuan['pemohon_nama_kepala_keluarga'] ?? '',
                        'nama_lengkap' => $pengajuan['nama_lengkap'] ?? '',
                    ];
                    $dispNoKk = formValueFromDraftOrUser($dataKeluarga, $pemohonProfilKk, 'no_kk');
                    $dispKkNama = formValueFromDraftOrUser($dataKeluarga, $pemohonProfilKk, 'nama_kepala_keluarga', 'nama_kepala_keluarga', 'nama_lengkap');
                    ?>
                    <div>
                        <p class="text-[10px] text-slate-400 uppercase font-semibold">No KK</p>
                        <p class="text-sm font-bold text-slate-800 font-mono">
                            <?= htmlspecialchars($dispNoKk !== '' ? $dispNoKk : '-') ?>
                        </p>
                    </div>
                    <div>
                        <p class="text-[10px] text-slate-400 uppercase font-semibold">Kepala Keluarga</p>
                        <p class="text-sm font-bold text-slate-800">
                            <?= htmlspecialchars($dispKkNama !== '' ? $dispKkNama : '-') ?>
                        </p>
                    </div>
                </div>
                <?php if (!empty($anggota)): ?>
                    <div class="overflow-x-auto">
                        <table class="w-full text-sm">
                            <thead>
                                <tr class="border-b border-slate-100">
                                    <th class="text-left py-3 px-3 text-[10px] text-slate-400 font-semibold uppercase">No</th>
                                    <th class="text-left py-3 px-3 text-[10px] text-slate-400 font-semibold uppercase">NIK</th>
                                    <th class="text-left py-3 px-3 text-[10px] text-slate-400 font-semibold uppercase">Nama
                                        Lengkap</th>
                                    <th class="text-left py-3 px-3 text-[10px] text-slate-400 font-semibold uppercase">SHDK</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-slate-50">
                                <?php foreach ($anggota as $idx => $a): ?>
                                    <tr class="hover:bg-slate-50/50">
                                        <td class="py-3 px-3 text-slate-500"><?= str_pad($idx + 1, 2, '0', STR_PAD_LEFT) ?></td>
                                        <td class="py-3 px-3 font-mono text-slate-700"><?= htmlspecialchars($a['nik'] ?? '-') ?>
                                        </td>
                                        <td class="py-3 px-3 font-semibold text-slate-800 uppercase">
                                            <?= htmlspecialchars($a['nama']) ?>
                                        </td>
                                        <td class="py-3 px-3 text-slate-600"><?= htmlspecialchars($a['hubungan_keluarga']) ?></td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                <?php endif; ?>
            </div>

        <?php elseif ($jenis === 'pindah' && $dataPindah): ?>
            <!-- Data Pindah Inline -->
            <div class="bg-white rounded-2xl border border-slate-100 p-6">
                <h3 class="text-base font-bold text-slate-800 mb-4 flex items-center gap-2">📍 Data Alamat Pindah</h3>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div class="p-4 bg-red-50/50 rounded-xl border border-red-100">
                        <p class="text-[10px] font-semibold text-red-400 uppercase mb-2">Alamat Asal</p>
                        <p class="text-sm text-slate-800"><?= htmlspecialchars($dataPindah['alamat_asal']) ?></p>
                        <p class="text-xs text-slate-500 mt-1">RT <?= htmlspecialchars($dataPindah['rt_asal'] ?? '-') ?> /
                            RW <?= htmlspecialchars($dataPindah['rw_asal'] ?? '-') ?>,
                            <?= htmlspecialchars($dataPindah['kelurahan_asal'] ?? '') ?>,
                            <?= htmlspecialchars($dataPindah['kecamatan_asal'] ?? '') ?>
                        </p>
                    </div>
                    <div class="p-4 bg-emerald-50/50 rounded-xl border border-emerald-100">
                        <p class="text-[10px] font-semibold text-emerald-400 uppercase mb-2">Alamat Tujuan</p>
                        <p class="text-sm text-slate-800"><?= htmlspecialchars($dataPindah['alamat_tujuan']) ?></p>
                        <p class="text-xs text-slate-500 mt-1">RT <?= htmlspecialchars($dataPindah['rt_tujuan'] ?? '-') ?> /
                            RW <?= htmlspecialchars($dataPindah['rw_tujuan'] ?? '-') ?>,
                            <?= htmlspecialchars($dataPindah['kelurahan_tujuan'] ?? '') ?>,
                            <?= htmlspecialchars($dataPindah['kecamatan_tujuan'] ?? '') ?>
                        </p>
                    </div>
                </div>
            </div>
        <?php endif; ?>

        <!-- Admin Notes -->
        <?php if ($pengajuan['catatan_admin']): ?>
            <div class="bg-amber-50 rounded-2xl border border-amber-200 p-5">
                <h3 class="font-bold text-amber-800 text-sm mb-2 flex items-center gap-2">📝 Catatan Admin</h3>
                <p class="text-sm text-amber-700"><?= nl2br(htmlspecialchars($pengajuan['catatan_admin'])) ?></p>
            </div>
        <?php endif; ?>

        <?php if ($isAdminView):
            $__admSt = $pengajuan['status'];
            $__terminal = $__admSt === 'disetujui' || $__admSt === 'ditolak';
            $__showMarkProcessed = !$__terminal && $__admSt === 'pending';
            $__showDecide = !$__terminal && $__admSt === 'diproses';
            ?>
            <!-- Action Bar (Admin) -->
            <div
                class="bg-white rounded-2xl border border-slate-100 p-5 flex flex-col sm:flex-row items-center justify-between gap-4">
                <div class="flex items-center gap-3">
                    <div class="w-10 h-10 rounded-full bg-slate-100 flex items-center justify-center">
                        <svg class="w-5 h-5 text-slate-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                    </div>
                    <div>
                        <p class="text-[10px] text-slate-400 uppercase font-semibold">Status Terakhir</p>
                        <p class="text-sm font-bold text-slate-800">
                            <?= $statusLabels[$pengajuan['status']] ?? ucfirst($pengajuan['status']) ?>
                        </p>
                    </div>
                </div>
                <?php if ($__terminal): ?>
                    <div
                        class="text-sm text-slate-600 bg-slate-50 border border-slate-100 rounded-xl px-4 py-3 max-w-xl text-center sm:text-right">
                        <?php if ($__admSt === 'disetujui'): ?>
                            Permohonan ini sudah <strong class="text-emerald-700">diterima dan diselesaikan</strong>. Tombol
                            tindakan dinonaktifkan.
                        <?php else: ?>
                            Permohonan ini sudah <strong class="text-red-700">ditolak</strong>. Tombol tindakan
                            dinonaktifkan.
                        <?php endif; ?>
                    </div>
                <?php else: ?>
                    <div class="flex items-center gap-3 flex-wrap justify-end">
                        <?php if ($__showMarkProcessed): ?>
                            <form method="POST" action="<?= baseUrl('app/Controllers/AdminController.php?action=update_status') ?>"
                                class="flex items-center gap-2">
                                <input type="hidden" name="pengajuan_id" value="<?= $pengajuan['id'] ?>">
                                <input type="hidden" name="status" value="diproses">
                                <input type="hidden" name="redirect"
                                    value="<?= baseUrl('detail.php?id=' . $pengajuan['id'] . '&admin=1') ?>">
                                <button type="submit"
                                    class="inline-flex items-center gap-2 px-5 py-3 rounded-xl border-2 border-blue-200 text-blue-700 font-semibold text-sm hover:bg-blue-50 transition-all">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                                    </svg>
                                    Tandai Diproses
                                </button>
                            </form>
                        <?php endif; ?>
                        <?php if ($__showDecide): ?>
                            <form method="POST" action="<?= baseUrl('app/Controllers/AdminController.php?action=update_status') ?>"
                                class="flex items-center gap-2" id="rejectForm">
                                <input type="hidden" name="pengajuan_id" value="<?= $pengajuan['id'] ?>">
                                <input type="hidden" name="status" value="ditolak">
                                <input type="hidden" name="redirect"
                                    value="<?= baseUrl('detail.php?id=' . $pengajuan['id'] . '&admin=1') ?>">
                                <button type="submit" onclick="return confirm('Yakin ingin menolak permohonan ini?')"
                                    class="inline-flex items-center gap-2 px-5 py-3 rounded-xl border-2 border-red-200 text-red-600 font-semibold text-sm hover:bg-red-50 transition-all">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z" />
                                    </svg>
                                    Tolak
                                </button>
                            </form>
                            <form method="POST" action="<?= baseUrl('app/Controllers/AdminController.php?action=update_status') ?>">
                                <input type="hidden" name="pengajuan_id" value="<?= $pengajuan['id'] ?>">
                                <input type="hidden" name="status" value="disetujui">
                                <input type="hidden" name="redirect"
                                    value="<?= baseUrl('detail.php?id=' . $pengajuan['id'] . '&admin=1') ?>">
                                <button type="submit"
                                    class="inline-flex items-center gap-2 px-6 py-3 rounded-xl bg-primary-700 hover:bg-primary-800 text-white font-semibold text-sm shadow-lg shadow-primary-500/25 transition-all">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                                    </svg>
                                    Terima & Selesaikan
                                </button>
                            </form>
                        <?php endif; ?>
                        <?php if (!$__showMarkProcessed && !$__showDecide): ?>
                            <p class="text-sm text-slate-500 italic">Tidak ada tindakan untuk status ini.</p>
                        <?php endif; ?>
                    </div>
                <?php endif; ?>
            </div>
        <?php endif; ?>
    </div>

    <!-- Right Sidebar -->
    <div class="space-y-6">
        <?php if ($jenis === 'pindah' && $dataPindah): ?>
            <!-- Detail Pindah Card -->
            <div class="bg-white rounded-2xl border border-slate-100 p-5">
                <h3 class="font-bold text-slate-800 mb-4 flex items-center gap-2">
                    <svg class="w-5 h-5 text-primary-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                            d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                    </svg>
                    Detail Pindah
                </h3>
                <div class="space-y-4">
                    <div>
                        <p class="text-[10px] text-slate-400 uppercase font-semibold mb-1">Klasifikasi Pindah</p>
                        <div class="flex items-center gap-2 bg-primary-50 text-primary-700 px-3 py-2 rounded-lg">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                    d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16" />
                            </svg>
                            <span
                                class="text-sm font-semibold"><?= ucwords(str_replace('_', ' ', $dataPindah['jenis_kepindahan'])) ?></span>
                        </div>
                    </div>
                    <div>
                        <p class="text-[10px] text-slate-400 uppercase font-semibold mb-1">Alasan Pindah</p>
                        <p class="text-sm font-semibold text-slate-700">
                            <?= htmlspecialchars($dataPindah['alasan_pindah'] ?? '-') ?>
                        </p>
                    </div>
                    <div>
                        <p class="text-[10px] text-slate-400 uppercase font-semibold mb-1">Jumlah Pindah</p>
                        <div class="flex items-center gap-2">
                            <svg class="w-4 h-4 text-emerald-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4" />
                            </svg>
                            <span class="text-sm text-slate-700"><?= $dataPindah['jumlah_keluarga_pindah'] ?? 1 ?>
                                Orang</span>
                        </div>
                    </div>
                </div>
            </div>
        <?php endif; ?>

        <!-- Info Card -->
        <div class="bg-white rounded-2xl border border-slate-100 p-5">
            <h3 class="font-bold text-slate-800 mb-3">ℹ️ Informasi</h3>
            <div class="space-y-3 text-sm">
                <div>
                    <p class="text-[10px] text-slate-400 uppercase font-semibold">Jenis Layanan</p>
                    <p class="font-medium text-slate-700"><?= $jenisLabels[$jenis] ?></p>
                </div>
                <div>
                    <p class="text-[10px] text-slate-400 uppercase font-semibold">Tanggal Pengajuan</p>
                    <p class="font-medium text-slate-700">
                        <?= date('d M Y, H:i', strtotime($pengajuan['tanggal_pengajuan'])) ?>
                    </p>
                </div>
                <div>
                    <p class="text-[10px] text-slate-400 uppercase font-semibold">Metode Pengambilan</p>
                    <p class="font-medium text-slate-700">
                        <?= ($pengajuan['metode_pengambilan'] ?? 'ambil_sendiri') === 'dikirim' ? '🚚 Dikirim' : '🏢 Ambil Sendiri' ?>
                    </p>
                </div>
                <?php if ($pengajuan['tanggal_diproses']): ?>
                    <div>
                        <p class="text-[10px] text-slate-400 uppercase font-semibold">Tanggal Diproses</p>
                        <p class="font-medium text-slate-700">
                            <?= date('d M Y, H:i', strtotime($pengajuan['tanggal_diproses'])) ?>
                        </p>
                    </div>
                <?php endif; ?>
            </div>
        </div>

        <!-- Documents -->
        <div class="bg-white rounded-2xl border border-slate-100 p-5">
            <h3 class="font-bold text-slate-800 mb-4 flex items-center gap-2">📎 Lampiran Dokumen</h3>
            <?php if (empty($dokumen)): ?>
                <p class="text-sm text-slate-400 text-center py-4">Tidak ada dokumen pendukung.</p>
            <?php else: ?>
                <div class="space-y-3">
                    <?php foreach ($dokumen as $doc): ?>
                        <a href="<?= baseUrl('uploads/dokumen/' . htmlspecialchars($doc['nama_file'])) ?>" target="_blank"
                            class="flex items-center gap-3 p-3 bg-slate-50 hover:bg-primary-50 rounded-xl transition-colors border border-transparent hover:border-primary-100 group">
                            <div
                                class="w-10 h-10 rounded-lg bg-white border border-slate-200 group-hover:border-primary-200 flex items-center justify-center flex-shrink-0 shadow-sm">
                                <?php if (strpos($doc['tipe_file'], 'image') !== false): ?>
                                    <svg class="w-5 h-5 text-primary-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                            d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                    </svg>
                                <?php else: ?>
                                    <svg class="w-5 h-5 text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                            d="M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v14a2 2 0 002 2z" />
                                    </svg>
                                <?php endif; ?>
                            </div>
                            <div class="flex-1 min-w-0">
                                <p class="text-xs font-bold text-primary-700 mb-0.5 truncate">
                                    <?= htmlspecialchars($doc['jenis_dokumen'] ?? 'Dokumen') ?></p>
                                <p class="text-xs font-medium text-slate-700 truncate">
                                    <?= htmlspecialchars($doc['nama_asli']) ?></p>
                                <p class="text-[10px] text-slate-400 mt-0.5">
                                    <?= round($doc['ukuran_file'] / 1024) ?> KB •
                                    <?= strtoupper(explode('/', $doc['tipe_file'])[1] ?? 'FILE') ?>
                                </p>
                            </div>
                            <div
                                class="w-8 h-8 rounded-full bg-white flex items-center justify-center opacity-0 group-hover:opacity-100 transition-opacity drop-shadow-sm text-primary-600">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                </svg>
                            </div>
                        </a>
                    <?php endforeach; ?>
                </div>
                <p class="text-xs text-slate-400 mt-4 text-center">Semua Dokumen (<?= count($dokumen) ?>)</p>
            <?php endif; ?>
        </div>

        <?php if ($isAdminView): ?>
            <!-- Admin Quick Note -->
            <div class="bg-white rounded-2xl border border-slate-100 p-5">
                <h3 class="font-bold text-slate-800 mb-3">✏️ Catatan Admin</h3>
                <form method="POST" action="<?= baseUrl('app/Controllers/AdminController.php?action=update_status') ?>">
                    <input type="hidden" name="pengajuan_id" value="<?= $pengajuan['id'] ?>">
                    <input type="hidden" name="status" value="<?= $pengajuan['status'] ?>">
                    <input type="hidden" name="redirect"
                        value="<?= baseUrl('detail.php?id=' . $pengajuan['id'] . '&admin=1') ?>">
                    <textarea name="catatan_admin" rows="3" placeholder="Tambahkan catatan..."
                        class="w-full px-3 py-2.5 rounded-xl border border-slate-200 text-sm mb-3 focus:outline-none focus:border-primary-400"><?= htmlspecialchars($pengajuan['catatan_admin'] ?? '') ?></textarea>
                    <button type="submit"
                        class="w-full bg-slate-700 hover:bg-slate-800 text-white font-semibold py-2 rounded-xl text-sm transition-all">Simpan
                        Catatan</button>
                </form>
            </div>
        <?php endif; ?>
    </div>
</div>
