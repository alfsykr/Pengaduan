<?php
if ($adminPage === 'dashboard'):
    // Recent activity
    $stmt = $db->prepare("SELECT p.*, u.nama_lengkap, u.avatar AS user_avatar FROM pengajuan_layanan p JOIN users u ON p.user_id = u.id WHERE p.status != 'draft' ORDER BY p.tanggal_pengajuan DESC LIMIT 6");
    $stmt->execute();
    $recentActivity = $stmt->fetchAll();

    // Weekly data for chart (last 7 days)
    $chartData = [];
    for ($i = 6; $i >= 0; $i--) {
        $date = date('Y-m-d', strtotime("-{$i} days"));
        $dayName = ['Minggu', 'Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu'][date('w', strtotime($date))];
        $stmt = $db->prepare("SELECT COUNT(*) as c FROM pengajuan_layanan WHERE DATE(tanggal_pengajuan) = ? AND status != 'draft'");
        $stmt->execute([$date]);
        $chartData[] = ['day' => $dayName, 'count' => $stmt->fetch()['c']];
    }
    ?>

    <div class="animate-fade-in space-y-8">
    <!-- Greeting -->
    <div class="mb-6">
        <h2 class="text-2xl font-bold text-slate-800"><?= $greeting ?>,
            <?= htmlspecialchars($user['nama_lengkap'] ?? 'Admin') ?>
        </h2>
        <p class="text-slate-500 text-sm mt-1">Berikut adalah ringkasan permohonan kependudukan hari ini.</p>
    </div>

    <!-- Stats Cards -->
    <div class="grid grid-cols-2 lg:grid-cols-4 gap-4 mb-8">
        <!-- Permohonan Baru -->
        <div class="bg-white rounded-2xl border border-slate-100 p-5 card-hover">
            <div class="flex items-center justify-between mb-3">
                <p class="text-xs font-semibold text-amber-600 uppercase tracking-wider">Permohonan Baru</p>
                <span class="px-2 py-0.5 rounded-md bg-amber-100 text-amber-600 text-[10px] font-bold">NEW</span>
            </div>
            <p class="text-3xl font-bold text-slate-800"><?= str_pad($totalPending, 2, '0', STR_PAD_LEFT) ?></p>
            <p class="text-xs text-slate-400 mt-1 flex items-center gap-1">
                <svg class="w-3 h-3 text-emerald-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6" />
                </svg>
                dari kemarin
            </p>
        </div>
        <!-- Sedang Diproses -->
        <div class="bg-white rounded-2xl border border-slate-100 p-5 card-hover">
            <div class="flex items-center justify-between mb-3">
                <p class="text-xs font-semibold text-blue-600 uppercase tracking-wider">Sedang Diproses</p>
                <svg class="w-5 h-5 text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15" />
                </svg>
            </div>
            <p class="text-3xl font-bold text-slate-800"><?= str_pad($totalProses, 2, '0', STR_PAD_LEFT) ?></p>
            <p class="text-xs text-slate-400 mt-1">Stabil hari ini</p>
        </div>
        <!-- Selesai -->
        <div class="bg-white rounded-2xl border border-slate-100 p-5 card-hover">
            <div class="flex items-center justify-between mb-3">
                <p class="text-xs font-semibold text-emerald-600 uppercase tracking-wider">Selesai</p>
                <svg class="w-5 h-5 text-emerald-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
            </div>
            <p class="text-3xl font-bold text-slate-800"><?= str_pad($totalSetuju, 2, '0', STR_PAD_LEFT) ?></p>
            <p class="text-xs text-slate-400 mt-1 flex items-center gap-1">
                <svg class="w-3 h-3 text-emerald-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6" />
                </svg>
                Total minggu ini
            </p>
        </div>
        <!-- Ditolak -->
        <div class="bg-white rounded-2xl border border-slate-100 p-5 card-hover">
            <div class="flex items-center justify-between mb-3">
                <p class="text-xs font-semibold text-red-600 uppercase tracking-wider">Ditolak</p>
                <svg class="w-5 h-5 text-red-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
            </div>
            <p class="text-3xl font-bold text-slate-800"><?= str_pad($totalTolak, 2, '0', STR_PAD_LEFT) ?></p>
            <p class="text-xs text-slate-400 mt-1">Verifikasi dokumen</p>
        </div>
    </div>

    <!-- Chart + Activity -->
    <div class="grid grid-cols-1 lg:grid-cols-5 gap-6">
        <!-- Tren Permohonan Chart -->
        <div class="lg:col-span-3 bg-white rounded-2xl border border-slate-100 p-6">
            <div class="flex items-center justify-between mb-6">
                <div>
                    <h3 class="font-bold text-slate-800">Tren Permohonan</h3>
                    <p class="text-xs text-slate-400 mt-0.5">Statistik 7 hari terakhir</p>
                </div>
                <span class="text-xs text-slate-400 px-3 py-1 bg-slate-50 rounded-lg">Minggu Ini</span>
            </div>
            <div class="relative h-52">
                <canvas id="trendChart"></canvas>
            </div>
        </div>

        <!-- Aktivitas Terbaru -->
        <div class="lg:col-span-2 bg-white rounded-2xl border border-slate-100 p-6">
            <div class="flex items-center justify-between mb-5">
                <h3 class="font-bold text-slate-800">Aktivitas Terbaru</h3>
                <svg class="w-5 h-5 text-slate-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                        d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
            </div>
            <div class="space-y-4 max-h-[220px] overflow-y-auto">
                <?php if (empty($recentActivity)): ?>
                    <p class="text-sm text-slate-400 text-center py-4">Belum ada aktivitas.</p>
                <?php else:
                    foreach ($recentActivity as $act):
                        ?>
                        <div class="flex items-start gap-3">
                            <div class="mt-0.5 flex-shrink-0">
                                <?= htmlUserAvatarRing([
                                    'id' => (int) ($act['user_id'] ?? 0),
                                    'nama_lengkap' => $act['nama_lengkap'] ?? '',
                                    'avatar' => $act['user_avatar'] ?? '',
                                ]) ?>
                            </div>
                            <div class="flex-1 min-w-0">
                                <div class="flex items-center justify-between">
                                    <p class="text-sm font-semibold text-slate-700 truncate">
                                        <?= htmlspecialchars($act['nama_lengkap']) ?>
                                    </p>
                                    <span class="text-[10px] text-slate-400 whitespace-nowrap ml-2"><?php
                                    $__tpa = strtotime((string) ($act['tanggal_pengajuan'] ?? ''));
                                    $diff = $__tpa ? (time() - $__tpa) : 0;
                                    if ($diff < 3600) {
                                        echo '1 jam lalu';
                                    } elseif ($diff < 86400) {
                                        echo floor($diff / 3600) . ' jam lalu';
                                    } else {
                                        echo ($diff > 0 ? floor($diff / 86400) : 0) . ' hari lalu';
                                    }
                                    ?></span>
                                </div>
                                <p class="text-xs text-slate-400 truncate">
                                    <?= $jenisLabels[$act['jenis_layanan']] ?? $act['jenis_layanan'] ?>
                                </p>
                                <span
                                    class="inline-flex items-center mt-1 px-2 py-0.5 rounded text-[10px] font-bold <?= $statusBadge[$act['status'] ?? ''] ?? '' ?>"><?= htmlspecialchars($statusLabels[$act['status'] ?? ''] ?? ucfirst((string) ($act['status'] ?? ''))) ?></span>
                            </div>
                        </div>
                    <?php endforeach; endif; ?>
            </div>
            <a href="<?= baseUrl('admin.php?page=permohonan') ?>"
                class="block text-center text-sm font-medium text-primary-600 hover:text-primary-700 mt-4">Lihat Semua
                Aktivitas</a>
        </div>
    </div>
    </div>

    <!-- Chart.js CDN -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.0/dist/chart.umd.min.js"></script>
    <script>
        const ctx = document.getElementById('trendChart').getContext('2d');
        new Chart(ctx, {
            type: 'line',
            data: {
                labels: <?= json_encode(array_column($chartData, 'day')) ?>,
                datasets: [{
                    data: <?= json_encode(array_column($chartData, 'count')) ?>,
                    borderColor: '#4338ca',
                    backgroundColor: 'rgba(67, 56, 202, 0.05)',
                    borderWidth: 2.5,
                    tension: 0.4,
                    fill: true,
                    pointBackgroundColor: '#4338ca',
                    pointBorderColor: '#fff',
                    pointBorderWidth: 2,
                    pointRadius: 5,
                    pointHoverRadius: 7,
                }]
            },
            options: {
                responsive: true, maintainAspectRatio: false,
                plugins: { legend: { display: false } },
                scales: {
                    y: { beginAtZero: true, ticks: { stepSize: 1, font: { size: 11 } }, grid: { color: 'rgba(0,0,0,0.04)' } },
                    x: { grid: { display: false }, ticks: { font: { size: 11 } } }
                }
            }
        });
    </script>

<?php endif; ?>

<?php if ($adminPage === 'permohonan'):
    $statusFilter = $_GET['status'] ?? '';
    $jenisFilter = $_GET['jenis'] ?? '';
    $search = $_GET['search'] ?? '';

    $where = "WHERE p.status IN ('pending','diproses')";
    $params = [];
    if ($statusFilter && in_array($statusFilter, ['pending', 'diproses'])) {
        $where .= " AND p.status = ?";
        $params[] = $statusFilter;
    }
    if ($jenisFilter && in_array($jenisFilter, ['kk', 'ktp', 'pindah'])) {
        $where .= " AND p.jenis_layanan = ?";
        $params[] = $jenisFilter;
    }
    if ($search) {
        $where .= " AND (u.nama_lengkap LIKE ? OR p.no_registrasi LIKE ? OR u.nik LIKE ?)";
        $params[] = "%$search%";
        $params[] = "%$search%";
        $params[] = "%$search%";
    }

    $page = max(1, intval($_GET['p'] ?? 1));
    $perPage = 10;
    $offset = ($page - 1) * $perPage;

    $stmt = $db->prepare("SELECT COUNT(*) as total FROM pengajuan_layanan p JOIN users u ON p.user_id = u.id $where");
    $stmt->execute($params);
    $total = $stmt->fetch()['total'];
    $totalPages = max(1, ceil($total / $perPage));

    $stmt = $db->prepare("SELECT p.*, u.nama_lengkap, u.nik, u.avatar FROM pengajuan_layanan p JOIN users u ON p.user_id = u.id $where ORDER BY p.tanggal_pengajuan DESC LIMIT $perPage OFFSET $offset");
    $stmt->execute($params);
    $submissions = $stmt->fetchAll();
    ?>

    <div class="animate-fade-in space-y-6">
    <div class="flex flex-col md:flex-row md:items-center justify-between gap-4 mb-6">
        <div>
            <h2 class="text-2xl font-bold text-slate-800">Permohonan Masuk</h2>
            <p class="text-sm text-slate-500 mt-1">Kelola dan tinjau berkas kependudukan warga secara real-time.</p>
        </div>
    </div>

    <!-- Mini Stats -->
    <div class="grid grid-cols-2 lg:grid-cols-4 gap-4 mb-6">
        <div class="bg-white rounded-xl border border-slate-100 p-4 flex items-center gap-3">
            <div class="w-10 h-10 rounded-xl bg-amber-50 flex items-center justify-center"><svg
                    class="w-5 h-5 text-amber-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg></div>
            <div>
                <p class="text-[10px] text-slate-400 font-medium">Total Pending</p>
                <p class="text-lg font-bold text-slate-800"><?= $totalPending ?> Berkas</p>
            </div>
        </div>
        <div class="bg-white rounded-xl border border-slate-100 p-4 flex items-center gap-3">
            <div class="w-10 h-10 rounded-xl bg-blue-50 flex items-center justify-center"><svg class="w-5 h-5 text-blue-500"
                    fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                </svg></div>
            <div>
                <p class="text-[10px] text-slate-400 font-medium">Dalam Review</p>
                <p class="text-lg font-bold text-slate-800"><?= $totalProses ?> Berkas</p>
            </div>
        </div>
        <div class="bg-white rounded-xl border border-slate-100 p-4 flex items-center gap-3">
            <div class="w-10 h-10 rounded-xl bg-emerald-50 flex items-center justify-center"><svg
                    class="w-5 h-5 text-emerald-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg></div>
            <div>
                <p class="text-[10px] text-slate-400 font-medium">Selesai</p>
                <p class="text-lg font-bold text-slate-800"><?= $totalSetuju ?> Berkas</p>
            </div>
        </div>
        <div class="bg-white rounded-xl border border-slate-100 p-4 flex items-center gap-3">
            <div class="w-10 h-10 rounded-xl bg-red-50 flex items-center justify-center"><svg class="w-5 h-5 text-red-500"
                    fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg></div>
            <div>
                <p class="text-[10px] text-slate-400 font-medium">Ditolak</p>
                <p class="text-lg font-bold text-slate-800"><?= $totalTolak ?> Berkas</p>
            </div>
        </div>
    </div>

    <!-- Filters -->
    <form method="GET" action="<?= baseUrl('admin.php') ?>" class="bg-white rounded-2xl border border-slate-100 p-4 mb-6">
        <input type="hidden" name="page" value="permohonan">
        <div class="grid grid-cols-1 md:grid-cols-4 gap-4 items-end">
            <div>
                <label class="text-xs font-semibold text-slate-400 uppercase tracking-wider mb-1.5 block">Jenis
                    Layanan</label>
                <select name="jenis" class="w-full px-3 py-2.5 rounded-xl border border-slate-200 text-sm bg-white">
                    <option value="">Semua Layanan</option>
                    <option value="kk" <?= $jenisFilter === 'kk' ? 'selected' : '' ?>>Kartu Keluarga</option>
                    <option value="ktp" <?= $jenisFilter === 'ktp' ? 'selected' : '' ?>>KTP-el</option>
                    <option value="pindah" <?= $jenisFilter === 'pindah' ? 'selected' : '' ?>>Surat Pindah</option>
                </select>
            </div>
            <div>
                <label class="text-xs font-semibold text-slate-400 uppercase tracking-wider mb-1.5 block">Status
                    Permohonan</label>
                <select name="status" class="w-full px-3 py-2.5 rounded-xl border border-slate-200 text-sm bg-white">
                    <option value="">Semua Status</option>
                    <option value="pending" <?= $statusFilter === 'pending' ? 'selected' : '' ?>>Pending</option>
                    <option value="diproses" <?= $statusFilter === 'diproses' ? 'selected' : '' ?>>Diproses</option>
                </select>
            </div>
            <div>
                <label class="text-xs font-semibold text-slate-400 uppercase tracking-wider mb-1.5 block">Cari</label>
                <input type="text" name="search" value="<?= htmlspecialchars($search) ?>" placeholder="Nama / NIK / No Reg"
                    class="w-full px-3 py-2.5 rounded-xl border border-slate-200 text-sm">
            </div>
            <div class="flex gap-2">
                <button type="submit"
                    class="flex-1 bg-primary-600 hover:bg-primary-700 text-white font-semibold py-2.5 rounded-xl text-sm flex items-center justify-center gap-1">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.293A1 1 0 013 6.586V4z" />
                    </svg> Terapkan
                </button>
                <a href="<?= baseUrl('admin.php?page=permohonan') ?>"
                    class="px-4 py-2.5 rounded-xl border border-slate-200 text-sm text-slate-600 hover:bg-slate-50 flex items-center gap-1">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15" />
                    </svg> Reset
                </a>
            </div>
        </div>
    </form>

    <!-- Table -->
    <div class="bg-white rounded-2xl border border-slate-100">
        <div class="flex items-center justify-between px-6 py-4 border-b border-slate-100">
            <h3 class="font-bold text-slate-800">Daftar Antrean Berkas</h3>
            <span class="text-xs text-slate-400">Menampilkan <?= $offset + 1 ?>-<?= min($offset + $perPage, $total) ?> dari
                <?= $total ?> entri</span>
        </div>
        <?php if (empty($submissions)): ?>
            <div class="p-12 text-center">
                <p class="text-slate-400">Tidak ada permohonan masuk.</p>
            </div>
        <?php else: ?>
            <div class="overflow-x-auto">
                <table class="w-full">
                    <thead>
                        <tr class="text-left border-b border-slate-100">
                            <th class="px-6 py-3 text-xs font-semibold text-slate-400 uppercase">No. Registrasi</th>
                            <th class="px-6 py-3 text-xs font-semibold text-slate-400 uppercase">Nama Pemohon</th>
                            <th class="px-6 py-3 text-xs font-semibold text-slate-400 uppercase">Jenis Layanan</th>
                            <th class="px-6 py-3 text-xs font-semibold text-slate-400 uppercase">Tanggal Masuk</th>
                            <th class="px-6 py-3 text-xs font-semibold text-slate-400 uppercase">Status</th>
                            <th class="px-6 py-3 text-xs font-semibold text-slate-400 uppercase">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-50">
                        <?php foreach ($submissions as $sub):
                            $_nik = (string) ($sub['nik'] ?? '');
                            $_nikMasked = strlen($_nik) >= 9
                                ? htmlspecialchars(substr($_nik, 0, 6) . '****' . substr($_nik, -3))
                                : htmlspecialchars($_nik !== '' ? $_nik : '-');
                            ?>
                            <tr class="hover:bg-slate-50/50 transition-colors">
                                <td class="px-6 py-4"><span
                                        class="text-sm font-mono text-slate-600">#<?= htmlspecialchars($sub['no_registrasi']) ?></span>
                                </td>
                                <td class="px-6 py-4">
                                    <div class="flex items-center gap-3">
                                        <?= htmlUserAvatarRing([
                                            'id' => (int) ($sub['user_id'] ?? 0),
                                            'nama_lengkap' => $sub['nama_lengkap'] ?? '',
                                            'avatar' => $sub['avatar'] ?? '',
                                        ]) ?>
                                        <div>
                                            <p class="text-sm font-semibold text-slate-800">
                                                <?= htmlspecialchars($sub['nama_lengkap']) ?>
                                            </p>
                                            <p class="text-[11px] text-slate-400">NIK:
                                                <?= $_nikMasked ?>
                                            </p>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-6 py-4"><span
                                        class="inline-flex px-2.5 py-1 rounded-lg text-xs font-semibold border <?= $jenisBadge[$sub['jenis_layanan']] ?? '' ?>"><?= $jenisLabels[$sub['jenis_layanan']] ?? $sub['jenis_layanan'] ?></span>
                                </td>
                                <td class="px-6 py-4 text-sm text-slate-600">
                                    <?= $sub['tanggal_pengajuan'] ? date('d M Y, H:i', strtotime((string) $sub['tanggal_pengajuan'])) : '-' ?>
                                </td>
                                <td class="px-6 py-4"><span
                                        class="flex items-center gap-1.5 text-sm font-medium <?= $statusColors[$sub['status'] ?? ''] ?? '' ?>"><span
                                            class="w-2 h-2 rounded-full bg-current"></span><?= htmlspecialchars($statusLabels[$sub['status'] ?? ''] ?? ($sub['status'] ?? '-')) ?></span>
                                </td>
                                <td class="px-6 py-4"><a href="<?= baseUrl('detail.php?id=' . $sub['id'] . '&admin=1') ?>"
                                        class="text-sm font-medium text-primary-600 hover:text-primary-700 flex items-center gap-1">Detail
                                        <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M9 5l7 7-7 7" />
                                        </svg></a></td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
            <!-- Pagination -->
            <?php if ($totalPages > 1): ?>
                <div class="flex items-center justify-between px-6 py-4 border-t border-slate-100">
                    <div class="flex items-center gap-1">
                        <?php if ($page > 1): ?><a href="<?= baseUrl("admin.php?page=permohonan&p=" . ($page - 1)) ?>"
                                class="px-3 py-1.5 rounded-lg border border-slate-200 text-sm text-slate-600 hover:bg-slate-50">Previous</a><?php endif; ?>
                        <?php for ($i = 1; $i <= min($totalPages, 5); $i++): ?>
                            <a href="<?= baseUrl("admin.php?page=permohonan&p=$i") ?>"
                                class="w-8 h-8 rounded-lg flex items-center justify-center text-sm <?= $i === $page ? 'bg-primary-600 text-white' : 'text-slate-500 hover:bg-slate-100' ?>"><?= $i ?></a>
                        <?php endfor; ?>
                        <?php if ($page < $totalPages): ?><a href="<?= baseUrl("admin.php?page=permohonan&p=" . ($page + 1)) ?>"
                                class="px-3 py-1.5 rounded-lg border border-slate-200 text-sm text-slate-600 hover:bg-slate-50">Next</a><?php endif; ?>
                    </div>
                    <span class="text-xs text-slate-400">Baris per halaman: <?= $perPage ?></span>
                </div>
            <?php endif; ?>
        <?php endif; ?>
    </div>
    </div>

<?php endif; ?>

<?php if ($adminPage === 'arsip'):
    $statusFilter = $_GET['status'] ?? '';
    $jenisFilter = $_GET['jenis'] ?? '';
    $dateFilter = $_GET['date'] ?? '';

    $where = "WHERE p.status IN ('disetujui','ditolak')";
    $params = [];
    if ($statusFilter && in_array($statusFilter, ['disetujui', 'ditolak'])) {
        $where .= " AND p.status = ?";
        $params[] = $statusFilter;
    }
    if ($jenisFilter && in_array($jenisFilter, ['kk', 'ktp', 'pindah'])) {
        $where .= " AND p.jenis_layanan = ?";
        $params[] = $jenisFilter;
    }
    if ($dateFilter) {
        $where .= " AND DATE(p.tanggal_diproses) = ?";
        $params[] = $dateFilter;
    }

    $page = max(1, intval($_GET['p'] ?? 1));
    $perPage = 10;
    $offset = ($page - 1) * $perPage;

    $stmt = $db->prepare("SELECT COUNT(*) as total FROM pengajuan_layanan p JOIN users u ON p.user_id = u.id $where");
    $stmt->execute($params);
    $total = $stmt->fetch()['total'];
    $totalPages = max(1, ceil($total / $perPage));

    $stmt = $db->prepare("SELECT p.*, u.nama_lengkap, u.nik, u.avatar FROM pengajuan_layanan p JOIN users u ON p.user_id = u.id $where ORDER BY p.tanggal_diproses DESC, p.tanggal_pengajuan DESC LIMIT $perPage OFFSET $offset");
    $stmt->execute($params);
    $submissions = $stmt->fetchAll();
    ?>

    <div class="animate-fade-in space-y-6">
    <div class="mb-6">
        <h2 class="text-2xl font-bold text-slate-800">Arsip Permohonan</h2>
        <p class="text-sm text-slate-500 mt-1 max-w-xl">Kelola dan tinjau riwayat permohonan dokumen kependudukan yang telah
            selesai diproses. Gunakan filter untuk pencarian data yang lebih spesifik.</p>
    </div>

    <!-- Filters -->
    <form method="GET" action="<?= baseUrl('admin.php') ?>" class="bg-white rounded-2xl border border-slate-100 p-4 mb-6">
        <input type="hidden" name="page" value="arsip">
        <div class="grid grid-cols-1 md:grid-cols-4 gap-4 items-end">
            <div>
                <label class="text-xs font-semibold text-slate-400 uppercase tracking-wider mb-1.5 block">Rentang
                    Tanggal</label>
                <input type="date" name="date" value="<?= htmlspecialchars($dateFilter) ?>"
                    class="w-full px-3 py-2.5 rounded-xl border border-slate-200 text-sm">
            </div>
            <div>
                <label class="text-xs font-semibold text-slate-400 uppercase tracking-wider mb-1.5 block">Jenis
                    Layanan</label>
                <select name="jenis" class="w-full px-3 py-2.5 rounded-xl border border-slate-200 text-sm bg-white">
                    <option value="">Semua Layanan</option>
                    <option value="kk" <?= $jenisFilter === 'kk' ? 'selected' : '' ?>>Kartu Keluarga</option>
                    <option value="ktp" <?= $jenisFilter === 'ktp' ? 'selected' : '' ?>>KTP-el</option>
                    <option value="pindah" <?= $jenisFilter === 'pindah' ? 'selected' : '' ?>>Surat Pindah</option>
                </select>
            </div>
            <div>
                <label class="text-xs font-semibold text-slate-400 uppercase tracking-wider mb-1.5 block">Status
                    Akhir</label>
                <select name="status" class="w-full px-3 py-2.5 rounded-xl border border-slate-200 text-sm bg-white">
                    <option value="">Semua Status</option>
                    <option value="disetujui" <?= $statusFilter === 'disetujui' ? 'selected' : '' ?>>Selesai (Diterima)</option>
                    <option value="ditolak" <?= $statusFilter === 'ditolak' ? 'selected' : '' ?>>Ditolak</option>
                </select>
            </div>
            <div class="flex gap-2">
                <button type="submit"
                    class="flex-1 bg-primary-600 hover:bg-primary-700 text-white font-semibold py-2.5 rounded-xl text-sm flex items-center justify-center gap-1">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.293A1 1 0 013 6.586V4z" />
                    </svg> Terapkan
                </button>
                <a href="<?= baseUrl('admin.php?page=arsip') ?>"
                    class="px-4 py-2.5 rounded-xl border border-slate-200 text-sm text-slate-600 hover:bg-slate-50">Reset</a>
            </div>
        </div>
    </form>

    <!-- Table -->
    <div class="bg-white rounded-2xl border border-slate-100">
        <div class="overflow-x-auto">
            <table class="w-full">
                <thead>
                    <tr class="text-left border-b border-slate-100">
                        <th class="px-6 py-3 text-xs font-semibold text-slate-400 uppercase">No. Registrasi</th>
                        <th class="px-6 py-3 text-xs font-semibold text-slate-400 uppercase">Nama Penduduk</th>
                        <th class="px-6 py-3 text-xs font-semibold text-slate-400 uppercase">Jenis Layanan</th>
                        <th class="px-6 py-3 text-xs font-semibold text-slate-400 uppercase">Tgl. Selesai</th>
                        <th class="px-6 py-3 text-xs font-semibold text-slate-400 uppercase">Status</th>
                        <th class="px-6 py-3 text-xs font-semibold text-slate-400 uppercase">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-50">
                    <?php if (empty($submissions)): ?>
                        <tr>
                            <td colspan="6" class="px-6 py-12 text-center text-slate-400">Tidak ada arsip ditemukan.</td>
                        </tr>
                    <?php else:
                        foreach ($submissions as $sub):
                            ?>
                            <tr class="hover:bg-slate-50/50 transition-colors">
                                <td class="px-6 py-4"><span
                                        class="text-sm font-mono text-slate-600">#<?= htmlspecialchars($sub['no_registrasi']) ?></span>
                                </td>
                                <td class="px-6 py-4">
                                    <div class="flex items-center gap-3">
                                        <?= htmlUserAvatarRing([
                                            'id' => (int) ($sub['user_id'] ?? 0),
                                            'nama_lengkap' => $sub['nama_lengkap'] ?? '',
                                            'avatar' => $sub['avatar'] ?? '',
                                        ]) ?>
                                        <span
                                            class="text-sm font-semibold text-slate-800"><?= htmlspecialchars($sub['nama_lengkap']) ?></span>
                                    </div>
                                </td>
                                <td class="px-6 py-4"><span
                                        class="inline-flex px-2.5 py-1 rounded-lg text-xs font-semibold border <?= $jenisBadge[$sub['jenis_layanan']] ?? '' ?>"><?= $jenisLabels[$sub['jenis_layanan']] ?? $sub['jenis_layanan'] ?></span>
                                </td>
                                <td class="px-6 py-4 text-sm text-slate-600">
                                    <?php
                                    $__dip = $sub['tanggal_diproses'] ?? '';
                                    $__tsa = $__dip !== '' ? strtotime((string) $__dip) : false;
                                    echo ($__tsa !== false) ? date('d M Y', $__tsa) : '-';
                                    ?>
                                </td>
                                <td class="px-6 py-4"><span
                                        class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-xs font-semibold <?= $statusBadge[$sub['status'] ?? ''] ?? '' ?>"><span
                                            class="w-1.5 h-1.5 rounded-full bg-current"></span><?= htmlspecialchars($statusLabels[$sub['status'] ?? ''] ?? ($sub['status'] ?? '-')) ?></span>
                                </td>
                                <td class="px-6 py-4"><a href="<?= baseUrl('detail.php?id=' . $sub['id'] . '&admin=1') ?>"
                                        class="text-sm font-medium text-primary-600 hover:text-primary-700">View Details <span
                                            class="text-slate-300">›</span></a></td>
                            </tr>
                        <?php endforeach; endif; ?>
                </tbody>
            </table>
        </div>
        <?php if ($totalPages > 1): ?>
            <div class="flex items-center justify-between px-6 py-4 border-t border-slate-100">
                <span class="text-xs text-slate-400">Menampilkan <?= $offset + 1 ?>-<?= min($offset + $perPage, $total) ?> dari
                    <?= $total ?> permohonan</span>
                <div class="flex items-center gap-1">
                    <?php if ($page > 1): ?><a href="<?= baseUrl("admin.php?page=arsip&p=1") ?>"
                            class="w-8 h-8 rounded-lg flex items-center justify-center border border-slate-200 text-slate-400 hover:bg-slate-50">«</a><a
                            href="<?= baseUrl("admin.php?page=arsip&p=" . ($page - 1)) ?>"
                            class="w-8 h-8 rounded-lg flex items-center justify-center border border-slate-200 text-slate-400 hover:bg-slate-50">‹</a><?php endif; ?>
                    <?php for ($i = max(1, $page - 2); $i <= min($totalPages, $page + 2); $i++): ?>
                        <a href="<?= baseUrl("admin.php?page=arsip&p=$i") ?>"
                            class="w-8 h-8 rounded-lg flex items-center justify-center text-sm <?= $i === $page ? 'bg-primary-600 text-white' : 'text-slate-500 hover:bg-slate-100' ?>"><?= $i ?></a>
                    <?php endfor; ?>
                    <?php if ($page < $totalPages): ?><a href="<?= baseUrl("admin.php?page=arsip&p=" . ($page + 1)) ?>"
                            class="w-8 h-8 rounded-lg flex items-center justify-center border border-slate-200 text-slate-400 hover:bg-slate-50">›</a><a
                            href="<?= baseUrl("admin.php?page=arsip&p=$totalPages") ?>"
                            class="w-8 h-8 rounded-lg flex items-center justify-center border border-slate-200 text-slate-400 hover:bg-slate-50">»</a><?php endif; ?>
                </div>
            </div>
        <?php endif; ?>
    </div>

    <!-- Bottom Banner -->
    <div
        class="bg-gradient-to-r from-slate-800 to-slate-700 rounded-2xl p-6 mt-6 flex flex-col md:flex-row items-center gap-6">
        <div class="flex-1">
            <h3 class="text-lg font-bold text-white mb-1">Monitor Layanan Lebih Efektif</h3>
            <p class="text-slate-300 text-sm">Sistem kini dilengkapi dengan fitur validasi dokumen otomatis untuk
                mempercepat proses peninjauan berkas kependudukan hingga 40%.</p>
        </div>
        <a href="#"
            class="px-5 py-2.5 bg-white text-slate-800 font-semibold rounded-xl hover:bg-slate-50 transition-all text-sm whitespace-nowrap">Lihat
            Panduan Baru</a>
    </div>
    </div>

<?php endif; ?>

<?php if ($adminPage === 'users'):
    $userSearch = trim((string) ($_GET['search'] ?? ''));
    $page = max(1, (int) ($_GET['p'] ?? 1));
    $perPage = 10;
    $offset = ($page - 1) * $perPage;

    $where = 'WHERE role = ?';
    $params = ['user'];
    if ($userSearch !== '') {
        $where .= ' AND (nama_lengkap LIKE ? OR nik LIKE ? OR email LIKE ? OR IFNULL(no_hp, \'\') LIKE ?)';
        $like = '%' . $userSearch . '%';
        array_push($params, $like, $like, $like, $like);
    }

    $stmt = $db->prepare("SELECT COUNT(*) AS total FROM users $where");
    $stmt->execute($params);
    $totalUsersList = (int) $stmt->fetch()['total'];
    $totalUserPages = max(1, (int) ceil($totalUsersList / $perPage));

    $stmt = $db->prepare("SELECT id, nama_lengkap, nik, email, no_hp, avatar, created_at FROM users $where ORDER BY created_at DESC LIMIT $perPage OFFSET $offset");
    $stmt->execute($params);
    $registeredUsers = $stmt->fetchAll();

    $userSearchQs = $userSearch !== '' ? '&search=' . rawurlencode($userSearch) : '';
    ?>

    <div class="animate-fade-in space-y-6">
    <div class="flex flex-col md:flex-row md:items-center justify-between gap-4 mb-2">
        <div>
            <h2 class="text-2xl font-bold text-slate-800">Manajemen User</h2>
            <p class="text-sm text-slate-500 mt-1 max-w-xl">Daftar akun warga (role pengguna) beserta kontak dan foto profil
                yang diunggah.</p>
        </div>
        <div class="flex items-center gap-2 text-sm text-slate-500">
            <span class="font-semibold text-slate-700"><?= $totalUsersList ?></span> pengguna terdaftar
        </div>
    </div>

    <form method="GET" action="<?= baseUrl('admin.php') ?>" class="bg-white rounded-2xl border border-slate-100 p-4 mb-6">
        <input type="hidden" name="page" value="users">
        <div class="flex flex-col sm:flex-row gap-3 items-stretch sm:items-end">
            <div class="flex-1">
                <label class="text-xs font-semibold text-slate-400 uppercase tracking-wider mb-1.5 block">Cari</label>
                <input type="text" name="search" value="<?= htmlspecialchars($userSearch) ?>"
                    placeholder="Nama, NIK, email, atau nomor HP"
                    class="w-full px-3 py-2.5 rounded-xl border border-slate-200 text-sm">
            </div>
            <div class="flex gap-2">
                <button type="submit"
                    class="bg-primary-600 hover:bg-primary-700 text-white font-semibold py-2.5 px-5 rounded-xl text-sm">Cari</button>
                <a href="<?= baseUrl('admin.php?page=users') ?>"
                    class="px-4 py-2.5 rounded-xl border border-slate-200 text-sm text-slate-600 hover:bg-slate-50">Reset</a>
            </div>
        </div>
    </form>

    <div class="bg-white rounded-2xl border border-slate-100">
        <div class="flex items-center justify-between px-6 py-4 border-b border-slate-100">
            <h3 class="font-bold text-slate-800">Daftar Pengguna</h3>
            <span class="text-xs text-slate-400">Menampilkan <?= $totalUsersList ? $offset + 1 : 0 ?>-<?= min($offset + $perPage, $totalUsersList) ?> dari
                <?= $totalUsersList ?></span>
        </div>
        <?php if (empty($registeredUsers)): ?>
            <div class="p-12 text-center text-slate-400">Tidak ada pengguna yang cocok.</div>
        <?php else: ?>
            <div class="overflow-x-auto">
                <table class="w-full">
                    <thead>
                        <tr class="text-left border-b border-slate-100 bg-slate-50/80">
                            <th class="px-6 py-3 text-xs font-semibold text-slate-500 uppercase">Nama Penduduk</th>
                            <th class="px-6 py-3 text-xs font-semibold text-slate-500 uppercase">NIK</th>
                            <th class="px-6 py-3 text-xs font-semibold text-slate-500 uppercase">Email</th>
                            <th class="px-6 py-3 text-xs font-semibold text-slate-500 uppercase">No. HP</th>
                            <th class="px-6 py-3 text-xs font-semibold text-slate-500 uppercase">Tgl. Daftar</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-50">
                        <?php foreach ($registeredUsers as $ru):
                            $_nik = (string) ($ru['nik'] ?? '');
                            $_nikMasked = strlen($_nik) >= 9
                                ? htmlspecialchars(substr($_nik, 0, 6) . '****' . substr($_nik, -3))
                                : htmlspecialchars($_nik !== '' ? $_nik : '-');
                            ?>
                            <tr class="hover:bg-slate-50/50 transition-colors">
                                <td class="px-6 py-4">
                                    <div class="flex items-center gap-3">
                                        <?= htmlUserAvatarRing([
                                            'id' => (int) ($ru['id'] ?? 0),
                                            'nama_lengkap' => $ru['nama_lengkap'] ?? '',
                                            'avatar' => $ru['avatar'] ?? '',
                                        ], 'w-9 h-9', 'text-[11px]') ?>
                                        <span
                                            class="text-sm font-semibold text-slate-800"><?= htmlspecialchars($ru['nama_lengkap'] ?? '') ?></span>
                                    </div>
                                </td>
                                <td class="px-6 py-4 text-sm font-mono text-slate-600"><?= $_nikMasked ?></td>
                                <td class="px-6 py-4 text-sm text-slate-600 truncate max-w-[200px]"
                                    title="<?= htmlspecialchars((string) ($ru['email'] ?? '')) ?>"><?= htmlspecialchars((string) ($ru['email'] ?? '-')) ?></td>
                                <td class="px-6 py-4 text-sm text-slate-600"><?= htmlspecialchars((string) ($ru['no_hp'] ?? '-') ?: '-') ?></td>
                                <td class="px-6 py-4 text-sm text-slate-600">
                                    <?php
                                    $__ca = $ru['created_at'] ?? '';
                                    $__tsc = $__ca !== '' ? strtotime((string) $__ca) : false;
                                    echo ($__tsc !== false) ? date('d M Y', $__tsc) : '-';
                                    ?>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
            <?php if ($totalUserPages > 1): ?>
                <div class="flex items-center justify-between px-6 py-4 border-t border-slate-100">
                    <div class="flex items-center gap-1 flex-wrap">
                        <?php if ($page > 1): ?>
                            <a href="<?= baseUrl('admin.php?page=users&p=' . ($page - 1) . $userSearchQs) ?>"
                                class="px-3 py-1.5 rounded-lg border border-slate-200 text-sm text-slate-600 hover:bg-slate-50">Sebelumnya</a>
                        <?php endif; ?>
                        <?php for ($i = max(1, $page - 2); $i <= min($totalUserPages, $page + 2); $i++): ?>
                            <a href="<?= baseUrl('admin.php?page=users&p=' . $i . $userSearchQs) ?>"
                                class="w-8 h-8 rounded-lg flex items-center justify-center text-sm <?= $i === $page ? 'bg-primary-600 text-white' : 'text-slate-500 hover:bg-slate-100' ?>"><?= $i ?></a>
                        <?php endfor; ?>
                        <?php if ($page < $totalUserPages): ?>
                            <a href="<?= baseUrl('admin.php?page=users&p=' . ($page + 1) . $userSearchQs) ?>"
                                class="px-3 py-1.5 rounded-lg border border-slate-200 text-sm text-slate-600 hover:bg-slate-50">Berikutnya</a>
                        <?php endif; ?>
                    </div>
                    <span class="text-xs text-slate-400"><?= $perPage ?> per halaman</span>
                </div>
            <?php endif; ?>
        <?php endif; ?>
    </div>
    </div>

<?php endif; ?>

<?php if ($adminPage === 'settings'): ?>
    <div class="animate-fade-in space-y-6">
    <div class="mb-6">
        <h2 class="text-2xl font-bold text-slate-800">Pengaturan Sistem</h2>
        <p class="text-sm text-slate-500 mt-1 max-w-xl">Kelola identitas admin, keamanan, dan manajemen pengguna.</p>
    </div>

    <div class="flex flex-col lg:flex-row gap-6">
        <!-- Left Sidebar settings -->
        <div class="w-full lg:w-[320px] flex-shrink-0 space-y-4">
            <!-- Profile Card -->
            <div class="bg-white rounded-2xl border border-slate-100 overflow-hidden">
                <div class="h-24 bg-primary-600 relative relative">
                    <!-- Decor -->
                    <div
                        class="absolute inset-0 opacity-20 bg-[radial-gradient(ellipse_at_top,_var(--tw-gradient-stops))] from-white via-transparent to-transparent">
                    </div>
                </div>
                <div class="px-6 pb-6 relative">
                    <div class="w-20 h-20 rounded-2xl bg-white p-1.5 -mt-10 mb-3 shadow-sm mx-auto object-cover relative">
                        <div
                            class="w-full h-full rounded-xl overflow-hidden shadow-inner bg-gradient-to-br from-primary-400 to-primary-600 flex items-center justify-center text-white text-2xl font-bold">
                            <?php if (!empty($user['avatar'])): ?>
                                <img src="<?= baseUrl('uploads/avatars/' . rawurlencode($user['avatar'])) ?>" alt=""
                                    class="w-full h-full object-cover">
                            <?php else: ?>
                                <span
                                    class="text-2xl font-bold"><?= strtoupper(substr($user['nama_lengkap'] ?? 'A', 0, 1)) ?></span>
                            <?php endif; ?>
                        </div>
                        <label for="admin-avatar-input"
                            class="absolute -bottom-2 -right-2 w-7 h-7 bg-white rounded-full border border-slate-100 shadow-sm flex items-center justify-center text-slate-500 hover:text-primary-600 transition-colors cursor-pointer"
                            title="Ganti foto profil">
                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M3 9a2 2 0 012-2h.93a2 2 0 001.664-.89l.812-1.22A2 2 0 0110.07 4h3.86a2 2 0 011.664.89l.812 1.22A2 2 0 0018.07 7H19a2 2 0 012 2v9a2 2 0 01-2 2H5a2 2 0 01-2-2V9z">
                                </path>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M15 13a3 3 0 11-6 0 3 3 0 016 0z"></path>
                            </svg>
                        </label>
                    </div>

                    <div class="text-center mb-5">
                        <h3 class="text-lg font-bold text-slate-800">
                            <?= htmlspecialchars($user['nama_lengkap'] ?? 'Administrator') ?></h3>
                        <p class="text-xs text-slate-500 mt-1">Administrator Utama • NIP/NIK:
                            <?= htmlspecialchars($user['nik'] ?? '-') ?></p>
                    </div>

                    <div class="space-y-3 pt-4 border-t border-slate-100">
                        <div class="flex items-center gap-3 text-sm">
                            <svg class="w-4 h-4 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z">
                                </path>
                            </svg>
                            <span class="text-slate-600 truncate"
                                title="Email mengikuti akun login"><?= htmlspecialchars($user['email'] ?? '') ?></span>
                        </div>
                        <div class="flex items-center gap-3 text-sm">
                            <svg class="w-4 h-4 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z">
                                </path>
                            </svg>
                            <span class="text-slate-600 truncate">Akses Level: Super Admin</span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Vertical Tabs Navigation -->
            <div class="bg-white rounded-2xl border border-slate-100 p-2">
                <nav class="flex flex-col space-y-1">
                    <button type="button" onclick="switchTab('profil')" id="btn-profil"
                        class="tab-btn active w-full flex items-center gap-3 px-4 py-3 rounded-xl text-sm font-semibold transition-all duration-200 ease-out will-change-transform active:scale-[0.98] bg-primary-50 text-primary-700">
                        <svg class="w-[18px] h-[18px]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                        </svg>
                        Profil Admin
                    </button>
                    <button type="button" onclick="switchTab('keamanan')" id="btn-keamanan"
                        class="tab-btn w-full flex items-center gap-3 px-4 py-3 rounded-xl text-sm font-semibold transition-all duration-200 ease-out will-change-transform active:scale-[0.98] text-slate-500 hover:bg-slate-50 hover:text-slate-700">
                        <svg class="w-[18px] h-[18px]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z">
                            </path>
                        </svg>
                        Keamanan & Kata Sandi
                    </button>
                    <button type="button" onclick="switchTab('manajemen')" id="btn-manajemen"
                        class="tab-btn w-full flex items-center gap-3 px-4 py-3 rounded-xl text-sm font-semibold transition-all duration-200 ease-out will-change-transform active:scale-[0.98] text-slate-500 hover:bg-slate-50 hover:text-slate-700">
                        <svg class="w-[18px] h-[18px]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z">
                            </path>
                        </svg>
                        Manajemen Pengguna
                    </button>

                    <div class="pt-4 mt-2 border-t border-slate-100">
                        <a href="<?= baseUrl('app/Controllers/AuthController.php?action=logout') ?>"
                            class="w-full flex items-center gap-3 px-4 py-3 rounded-xl text-sm font-semibold transition-all duration-200 ease-out will-change-transform active:scale-[0.98] text-red-500 hover:bg-red-50">
                            <svg class="w-[18px] h-[18px]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1">
                                </path>
                            </svg>
                            Keluar Sign Out
                        </a>
                    </div>
                </nav>
            </div>
        </div>

        <!-- Right Content Area -->
        <div class="flex-1 space-y-6">

            <!-- TAB: Profil Admin -->
            <div id="tab-profil" class="settings-tab bg-white rounded-2xl border border-slate-100 p-6 md:p-8">
                <form id="form-admin-profil" method="POST" action="<?= baseUrl('app/Controllers/AdminController.php') ?>"
                    enctype="multipart/form-data" class="space-y-6">
                    <input type="hidden" name="action" value="update_admin_profile">

                    <div class="flex items-center gap-3 mb-6 pb-4 border-b border-slate-100">
                        <svg class="w-6 h-6 text-primary-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                        </svg>
                        <h3 class="text-lg font-bold text-slate-800">Informasi Profil</h3>
                    </div>

                    <p class="text-xs text-slate-500 -mt-2 mb-2">Klik ikon kamera di kartu profil (kiri) untuk memilih
                        foto, atau gunakan field di bawah. Email tidak dapat diubah karena terikat ke akun login.</p>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label class="block text-xs font-semibold text-slate-500 mb-2" for="admin-nama">Nama
                                Lengkap</label>
                            <input type="text" id="admin-nama" name="nama_lengkap" required
                                value="<?= htmlspecialchars((string) ($user['nama_lengkap'] ?? '')) ?>"
                                class="w-full px-4 py-2.5 rounded-xl border border-slate-200 text-sm text-slate-700 bg-white focus:outline-none focus:ring-2 focus:ring-primary-500/20 focus:border-primary-500">
                        </div>
                        <div>
                            <label class="block text-xs font-semibold text-slate-500 mb-2" for="admin-nik">Nomor Induk
                                Pegawai (NIP/NIK)</label>
                            <input type="text" id="admin-nik" name="nik" required maxlength="16"
                                value="<?= htmlspecialchars((string) ($user['nik'] ?? '')) ?>"
                                class="w-full px-4 py-2.5 rounded-xl border border-slate-200 text-sm text-slate-700 bg-white focus:outline-none focus:ring-2 focus:ring-primary-500/20 focus:border-primary-500">
                        </div>
                        <div class="md:col-span-2">
                            <label class="block text-xs font-semibold text-slate-500 mb-2">Alamat Email</label>
                            <input type="email" readonly tabindex="-1"
                                value="<?= htmlspecialchars((string) ($user['email'] ?? '')) ?>"
                                class="w-full px-4 py-2.5 rounded-xl border border-slate-200 text-sm text-slate-500 bg-slate-50 cursor-not-allowed"
                                title="Email dari akun login">
                            <p class="text-[11px] text-slate-400 mt-1">Email mengikuti akun Anda saat login dan tidak
                                dapat diedit di sini.</p>
                        </div>
                        <div class="md:col-span-2">
                            <label class="block text-xs font-semibold text-slate-500 mb-2" for="admin-avatar-input">Unggah
                                foto profil</label>
                            <input type="file" id="admin-avatar-input" name="avatar" accept="image/jpeg,image/png,image/webp"
                                class="block w-full text-sm text-slate-600 file:mr-4 file:rounded-xl file:border-0 file:bg-primary-50 file:px-4 file:py-2 file:text-sm file:font-semibold file:text-primary-700 hover:file:bg-primary-100">
                            <p class="text-[11px] text-slate-400 mt-1">Maks. 2MB — JPG, PNG, atau WebP. Klik Simpan untuk
                                menyimpan nama, NIP/NIK, dan foto sekaligus.</p>
                        </div>
                    </div>

                    <div class="flex justify-end pt-2 border-t border-slate-100">
                        <button type="submit"
                            class="px-6 py-2.5 rounded-xl bg-primary-600 hover:bg-primary-700 text-white text-sm font-semibold shadow-sm">
                            Simpan perubahan
                        </button>
                    </div>
                </form>
            </div>

            <!-- TAB: Keamanan & Kata Sandi -->
            <div id="tab-keamanan" class="settings-tab hidden bg-white rounded-2xl border border-slate-100 p-6 md:p-8">
                <div class="flex items-center gap-3 mb-6 pb-4 border-b border-slate-100">
                    <svg class="w-6 h-6 text-primary-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z">
                        </path>
                    </svg>
                    <h3 class="text-lg font-bold text-slate-800">Keamanan & Kata Sandi</h3>
                </div>

                <form>
                    <div class="space-y-5">
                        <div>
                            <label class="block text-xs font-semibold text-slate-500 mb-2">Kata Sandi Saat Ini</label>
                            <input type="password" value="********"
                                class="w-full px-4 py-2.5 rounded-xl border border-slate-200 text-sm focus:border-primary-500 focus:ring-1 focus:ring-primary-500"
                                placeholder="••••••••">
                        </div>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                            <div>
                                <label class="block text-xs font-semibold text-slate-500 mb-2">Kata Sandi Baru</label>
                                <input type="password"
                                    class="w-full px-4 py-2.5 rounded-xl border border-slate-200 text-sm focus:border-primary-500 focus:ring-1 focus:ring-primary-500"
                                    placeholder="••••••••">
                            </div>
                            <div>
                                <label class="block text-xs font-semibold text-slate-500 mb-2">Konfirmasi Kata Sandi
                                    Baru</label>
                                <input type="password"
                                    class="w-full px-4 py-2.5 rounded-xl border border-slate-200 text-sm focus:border-primary-500 focus:ring-1 focus:ring-primary-500"
                                    placeholder="••••••••">
                            </div>
                        </div>
                    </div>

                    <div class="mt-6 p-4 rounded-xl bg-slate-50 border border-slate-100 flex gap-3">
                        <svg class="w-5 h-5 text-slate-400 flex-shrink-0" fill="none" stroke="currentColor"
                            viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                        <p class="text-xs text-slate-500 leading-relaxed">Pastikan kata sandi baru terdiri dari minimal 8
                            karakter dengan kombinasi huruf besar, huruf kecil, angka, dan simbol.</p>
                    </div>

                    <div class="mt-8 flex justify-end gap-3 pt-6 border-t border-slate-100">
                        <button type="button"
                            class="px-5 py-2.5 rounded-xl text-sm font-semibold text-slate-600 border border-slate-200 hover:bg-slate-50">Batalkan</button>
                        <button type="button" onclick="alert('Demo: Kata sandi berhasil diubah')"
                            class="px-5 py-2.5 rounded-xl text-sm font-semibold text-white bg-primary-600 hover:bg-primary-700 flex items-center gap-2">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M8 7H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-3m-1 4l-3 3m0 0l-3-3m3 3V4">
                                </path>
                            </svg>
                            Simpan Perubahan
                        </button>
                    </div>
                </form>
            </div>

            <!-- TAB: Manajemen Pengguna / Reset Password -->
            <div id="tab-manajemen" class="settings-tab hidden bg-white rounded-2xl border border-slate-100 p-6 md:p-8">
                <div class="flex items-center gap-3 mb-6 pb-4 border-b border-slate-100">
                    <svg class="w-6 h-6 text-primary-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z">
                        </path>
                    </svg>
                    <h3 class="text-lg font-bold text-slate-800">Reset Kata Sandi Pengguna</h3>
                </div>

                <p class="text-sm text-slate-500 mb-6 pb-2">Fitur ini memungkinkan administrator untuk mengembalikan kata
                    sandi pengguna warga sistem menjadi kata sandi default (<code
                        class="bg-slate-100 px-1.5 py-0.5 rounded font-bold text-primary-600">user123</code>). Pengguna
                    disarankan untuk segera mengubahnya saat pertama kali berhasil login kembali.</p>

                <form action="<?= baseUrl('app/Controllers/AdminController.php') ?>" method="POST">
                    <input type="hidden" name="action" value="reset_password">
                    <div class="max-w-md">
                        <label class="block text-xs font-semibold text-slate-500 mb-2">Masukkan Email atau NIK
                            Pengguna</label>
                        <input type="text" name="user_identifier"
                            class="w-full px-4 py-2.5 rounded-xl border border-slate-200 text-sm focus:border-red-500 focus:ring-1 focus:ring-red-500"
                            placeholder="Contoh: 3201XXXXXXXX atau budi@email.com" required>
                    </div>

                    <div class="mt-8 flex justify-start gap-3 pt-6 border-t border-slate-100">
                        <button type="submit"
                            class="px-5 py-2.5 rounded-xl text-sm font-semibold text-white bg-red-600 hover:bg-red-700 flex items-center gap-2 shadow-sm shadow-red-200">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z">
                                </path>
                            </svg>
                            Reset Kata Sandi Pengguna
                        </button>
                    </div>
                </form>
            </div>

        </div>
    </div>
    </div>

    <!-- Script to toggle settings tabs -->
    <script>
        function switchTab(tabId) {
            document.querySelectorAll('.settings-tab').forEach(el => el.classList.add('hidden'));
            document.querySelectorAll('.tab-btn').forEach(el => {
                el.classList.remove('bg-primary-50', 'text-primary-700');
                el.classList.add('text-slate-500', 'hover:bg-slate-50', 'hover:text-slate-700');
            });

            const panel = document.getElementById('tab-' + tabId);
            if (panel) {
                panel.classList.remove('hidden');
                if (typeof window.uiAnimateTabPanel === 'function') {
                    window.uiAnimateTabPanel(panel);
                }
            }
            const btn = document.getElementById('btn-' + tabId);
            if (btn) {
                btn.classList.add('bg-primary-50', 'text-primary-700');
                btn.classList.remove('text-slate-500', 'hover:bg-slate-50', 'hover:text-slate-700');
            }
        }
    </script>
<?php endif; ?>

