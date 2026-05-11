<!-- Breadcrumb / konteks halaman (sama seperti Layanan) -->
<nav class="flex items-center gap-2 text-sm mb-6 animate-fade-in">
    <a href="<?= baseUrl('index.php') ?>" class="text-slate-400 hover:text-slate-600">Beranda</a>
    <svg class="w-4 h-4 text-slate-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
    </svg>
    <span class="text-primary-600 font-medium">Riwayat</span>
</nav>

<div class="animate-fade-in animate-delay-1">
    <h2 class="text-2xl font-bold text-slate-800 mb-2">Riwayat Pengajuan</h2>
    <p class="text-slate-500 mb-6">Pantau status semua pengajuan layanan kependudukan Anda.</p>
</div>

<!-- Filter -->
<div class="flex flex-wrap gap-2 mb-6 animate-fade-in animate-delay-2">
    <a href="<?= baseUrl('riwayat.php') ?>"
        class="px-4 py-2 rounded-xl text-sm font-medium <?= !$statusFilter ? 'bg-primary-600 text-white' : 'bg-white border border-slate-200 text-slate-600 hover:bg-slate-50' ?>">Semua</a>
    <?php foreach ($statusLabels as $key => $label): ?>
        <a href="<?= baseUrl('riwayat.php?status=' . $key) ?>"
            class="px-4 py-2 rounded-xl text-sm font-medium <?= $statusFilter === $key ? 'bg-primary-600 text-white' : 'bg-white border border-slate-200 text-slate-600 hover:bg-slate-50' ?>">
            <?= $label ?>
        </a>
    <?php endforeach; ?>
</div>

<div class="bg-white rounded-2xl border border-slate-100 animate-fade-in animate-delay-3">
    <?php if (empty($submissions)): ?>
        <div class="p-12 text-center">
            <p class="text-slate-400">Tidak ada pengajuan ditemukan.</p>
        </div>
    <?php else: ?>
        <div class="overflow-x-auto">
            <table class="w-full">
                <thead>
                    <tr class="text-left border-b border-slate-100">
                        <th class="px-6 py-4 text-xs font-semibold text-slate-400 uppercase tracking-wider">Tanggal</th>
                        <th class="px-6 py-4 text-xs font-semibold text-slate-400 uppercase tracking-wider">Jenis Layanan
                        </th>
                        <th class="px-6 py-4 text-xs font-semibold text-slate-400 uppercase tracking-wider">No. Registrasi
                        </th>
                        <th class="px-6 py-4 text-xs font-semibold text-slate-400 uppercase tracking-wider">Status</th>
                        <th class="px-6 py-4 text-xs font-semibold text-slate-400 uppercase tracking-wider">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-50">
                    <?php foreach ($submissions as $sub): ?>
                        <tr class="hover:bg-slate-50/50 transition-colors">
                            <td class="px-6 py-4 text-sm text-slate-600">
                                <?= date('d M Y', strtotime($sub['tanggal_pengajuan'])) ?>
                            </td>
                            <td class="px-6 py-4 text-sm font-medium text-slate-800">
                                <?= $jenisLabels[$sub['jenis_layanan']] ?? $sub['jenis_layanan'] ?>
                            </td>
                            <td class="px-6 py-4"><code
                                    class="text-sm text-slate-600 bg-slate-50 px-2 py-1 rounded-lg"><?= htmlspecialchars($sub['no_registrasi']) ?></code>
                            </td>
                            <td class="px-6 py-4"><span
                                    class="inline-flex px-2.5 py-1 rounded-full text-xs font-semibold <?= $statusColors[$sub['status']] ?? 'bg-slate-100 text-slate-600' ?>">
                                    <?= $statusLabels[$sub['status']] ?? $sub['status'] ?>
                                </span></td>
                            <td class="px-6 py-4"><a href="<?= baseUrl('detail.php?id=' . $sub['id']) ?>"
                                    class="text-sm font-medium text-primary-600 hover:text-primary-700">Detail</a></td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
        <!-- Pagination -->
        <?php if ($totalPages > 1): ?>
            <div class="flex items-center justify-between px-6 py-4 border-t border-slate-100">
                <p class="text-xs text-slate-400">Menampilkan
                    <?= $offset + 1 ?>-
                    <?= min($offset + $perPage, $total) ?> dari
                    <?= $total ?> pengajuan
                </p>
                <div class="flex items-center gap-1">
                    <?php for ($i = 1; $i <= $totalPages; $i++): ?>
                        <a href="<?= baseUrl('riwayat.php?page=' . $i . ($statusFilter ? '&status=' . $statusFilter : '')) ?>"
                            class="w-8 h-8 rounded-lg flex items-center justify-center text-sm <?= $i === $page ? 'bg-primary-600 text-white' : 'text-slate-500 hover:bg-slate-100' ?>">
                            <?= $i ?>
                        </a>
                    <?php endfor; ?>
                </div>
            </div>
        <?php endif; ?>
    <?php endif; ?>
</div>
