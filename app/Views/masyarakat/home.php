<!-- Welcome Banner -->
<div
  class="bg-gradient-to-r from-primary-800 via-primary-700 to-primary-600 rounded-3xl p-6 lg:p-8 text-white mb-8 animate-fade-in relative overflow-hidden">
  <div class="absolute right-0 top-0 w-64 h-64 bg-white/5 rounded-full -translate-y-1/2 translate-x-1/4"></div>
  <div class="absolute right-20 bottom-0 w-40 h-40 bg-white/5 rounded-full translate-y-1/2"></div>
  <div class="relative">
    <h2 class="text-2xl lg:text-3xl font-bold mb-2">Selamat Datang,
      <?= htmlspecialchars($user['nama_lengkap']) ?>
    </h2>
    <p class="text-primary-100 max-w-xl mb-5">Urus dokumen kependudukan Anda dengan lebih mudah, cepat, dan transparan
      langsung dari rumah.</p>
    <a href="<?= baseUrl('layanan.php') ?>"
      class="inline-flex items-center gap-2 bg-white text-primary-700 font-semibold px-5 py-2.5 rounded-xl hover:bg-primary-50 transition-all duration-200 shadow-lg shadow-black/10">
      <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
      </svg>
      Ajukan Layanan
    </a>
  </div>
</div>

<!-- Statistics Cards -->
<div class="grid grid-cols-2 lg:grid-cols-4 gap-4 mb-8">
  <!-- Menunggu -->
  <div class="bg-white rounded-2xl border border-slate-100 p-5 card-hover animate-fade-in animate-delay-1">
    <div class="w-10 h-10 rounded-xl bg-amber-50 flex items-center justify-center mb-3">
      <svg class="w-5 h-5 text-amber-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
          d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
      </svg>
    </div>
    <p class="text-xs font-semibold text-slate-400 uppercase tracking-wider">Menunggu</p>
    <p class="text-3xl font-bold text-slate-800 mt-1">
      <?= str_pad($stats['pending'], 2, '0', STR_PAD_LEFT) ?>
    </p>
  </div>

  <!-- Diproses -->
  <div class="bg-white rounded-2xl border border-slate-100 p-5 card-hover animate-fade-in animate-delay-2">
    <div class="w-10 h-10 rounded-xl bg-blue-50 flex items-center justify-center mb-3">
      <svg class="w-5 h-5 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
          d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15" />
      </svg>
    </div>
    <p class="text-xs font-semibold text-slate-400 uppercase tracking-wider">Diproses</p>
    <p class="text-3xl font-bold text-slate-800 mt-1">
      <?= str_pad($stats['diproses'], 2, '0', STR_PAD_LEFT) ?>
    </p>
  </div>

  <!-- Selesai -->
  <div class="bg-white rounded-2xl border border-slate-100 p-5 card-hover animate-fade-in animate-delay-3">
    <div class="w-10 h-10 rounded-xl bg-emerald-50 flex items-center justify-center mb-3">
      <svg class="w-5 h-5 text-emerald-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
          d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
      </svg>
    </div>
    <p class="text-xs font-semibold text-slate-400 uppercase tracking-wider">Selesai</p>
    <p class="text-3xl font-bold text-slate-800 mt-1">
      <?= str_pad($stats['disetujui'], 2, '0', STR_PAD_LEFT) ?>
    </p>
  </div>

  <!-- Ditolak -->
  <div class="bg-white rounded-2xl border border-slate-100 p-5 card-hover animate-fade-in animate-delay-4">
    <div class="w-10 h-10 rounded-xl bg-red-50 flex items-center justify-center mb-3">
      <svg class="w-5 h-5 text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
          d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z" />
      </svg>
    </div>
    <p class="text-xs font-semibold text-slate-400 uppercase tracking-wider">Ditolak</p>
    <p class="text-3xl font-bold text-slate-800 mt-1">
      <?= str_pad($stats['ditolak'], 2, '0', STR_PAD_LEFT) ?>
    </p>
  </div>
</div>

<!-- Recent Submissions -->
<div class="bg-white rounded-2xl border border-slate-100 animate-fade-in">
  <div class="flex items-center justify-between p-6 border-b border-slate-100">
    <h3 class="text-lg font-bold text-slate-800">Riwayat Pengajuan Saya</h3>
    <a href="<?= baseUrl('riwayat.php') ?>" class="text-sm text-primary-600 font-medium hover:text-primary-700">Lihat
      Semua →</a>
  </div>

  <?php if (empty($recentSubmissions)): ?>
    <div class="p-12 text-center">
      <div class="w-16 h-16 rounded-full bg-slate-100 flex items-center justify-center mx-auto mb-4">
        <svg class="w-8 h-8 text-slate-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
            d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
        </svg>
      </div>
      <p class="text-slate-400 mb-4">Belum ada pengajuan</p>
      <a href="<?= baseUrl('layanan.php') ?>"
        class="inline-flex items-center gap-2 text-sm font-medium text-primary-600 hover:text-primary-700">
        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
        </svg>
        Buat Pengajuan Pertama
      </a>
    </div>
  <?php else: ?>
    <div class="overflow-x-auto">
      <table class="w-full">
        <thead>
          <tr class="text-left">
            <th class="px-6 py-3 text-xs font-semibold text-slate-400 uppercase tracking-wider">Tanggal</th>
            <th class="px-6 py-3 text-xs font-semibold text-slate-400 uppercase tracking-wider">Jenis Layanan</th>
            <th class="px-6 py-3 text-xs font-semibold text-slate-400 uppercase tracking-wider">No. Registrasi</th>
            <th class="px-6 py-3 text-xs font-semibold text-slate-400 uppercase tracking-wider">Status</th>
            <th class="px-6 py-3 text-xs font-semibold text-slate-400 uppercase tracking-wider">Aksi</th>
          </tr>
        </thead>
        <tbody class="divide-y divide-slate-50">
          <?php foreach ($recentSubmissions as $sub): ?>
            <tr class="hover:bg-slate-50/50 transition-colors">
              <td class="px-6 py-4 text-sm text-slate-600">
                <?= date('d M Y', strtotime($sub['tanggal_pengajuan'])) ?>
              </td>
              <td class="px-6 py-4 text-sm font-medium text-slate-800">
                <?= $jenisLabels[$sub['jenis_layanan']] ?? $sub['jenis_layanan'] ?>
              </td>
              <td class="px-6 py-4">
                <code
                  class="text-sm text-slate-600 bg-slate-50 px-2 py-1 rounded-lg"><?= htmlspecialchars($sub['no_registrasi']) ?></code>
              </td>
              <td class="px-6 py-4">
                <span
                  class="inline-flex items-center gap-1 px-2.5 py-1 rounded-full text-xs font-semibold <?= $statusColors[$sub['status']] ?>">
                  <?= $statusLabels[$sub['status']] ?>
                </span>
              </td>
              <td class="px-6 py-4">
                <a href="<?= baseUrl('detail.php?id=' . $sub['id']) ?>"
                  class="text-sm font-medium text-primary-600 hover:text-primary-700">Detail</a>
              </td>
            </tr>
          <?php endforeach; ?>
        </tbody>
      </table>
    </div>
    <div class="px-6 py-4 border-t border-slate-100">
      <p class="text-xs text-slate-400">Menampilkan
        <?= count($recentSubmissions) ?> dari
        <?= $totalSubmissions ?> pengajuan
      </p>
    </div>
  <?php endif; ?>
</div>
