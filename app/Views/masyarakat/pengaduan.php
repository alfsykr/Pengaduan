<!-- Leaflet CSS & JS -->
<link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" integrity="sha256-p4NxAoJBhIIN+hmNHrzRCf9tD/miZyoHS5obTRR9BMY=" crossorigin="" />
<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js" integrity="sha256-20nQCchB9co0qIjJZRGuk2/Z9VM+kNiyxNV1lvTlZBo=" crossorigin=""></script>

<div class="animate-fade-in space-y-6">
    <!-- Header -->
    <div class="flex flex-col md:flex-row md:items-center justify-between gap-4">
        <div>
            <h2 class="text-2xl font-bold text-slate-800">Daftar Pengaduan Warga</h2>
            <p class="text-sm text-slate-500 mt-1">Pantau status laporan dan aspirasi Anda secara real-time.</p>
        </div>
        <a href="<?= baseUrl('buat_pengaduan.php') ?>" 
           class="inline-flex items-center gap-2 px-5 py-3 rounded-xl bg-primary-700 hover:bg-primary-800 text-white font-semibold text-sm shadow-lg shadow-primary-500/25 transition-all duration-150 active:scale-95">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
            </svg>
            Buat Laporan Baru
        </a>
    </div>

    <!-- Stats Cards -->
    <div class="grid grid-cols-2 lg:grid-cols-4 gap-4">
        <!-- Total Laporan -->
        <div class="bg-white rounded-2xl border border-slate-200 p-5 shadow-sm">
            <p class="text-xs font-medium text-slate-500">Total Laporan</p>
            <p class="text-4xl font-bold text-slate-950 mt-2"><?= $stats['total'] ?></p>
        </div>
        <!-- Dalam Proses -->
        <div class="bg-white rounded-2xl border border-slate-200 border-l-4 border-l-blue-600 p-5 shadow-sm">
            <p class="text-xs font-medium text-slate-500">Dalam Proses</p>
            <p class="text-4xl font-bold text-slate-950 mt-2"><?= $stats['proses'] ?></p>
        </div>
        <!-- Selesai -->
        <div class="bg-white rounded-2xl border border-slate-200 border-l-4 border-l-teal-700 p-5 shadow-sm">
            <p class="text-xs font-medium text-slate-500">Selesai</p>
            <p class="text-4xl font-bold text-slate-950 mt-2"><?= $stats['selesai'] ?></p>
        </div>
        <!-- Ditolak -->
        <div class="bg-white rounded-2xl border border-slate-200 border-l-4 border-l-red-600 p-5 shadow-sm">
            <p class="text-xs font-medium text-slate-500">Ditolak</p>
            <p class="text-4xl font-bold text-slate-950 mt-2"><?= $stats['ditolak'] ?></p>
        </div>
    </div>

    <!-- Filter & List Area -->
    <div class="bg-white rounded-2xl border border-slate-100 overflow-hidden">
        <!-- Top bar filtering -->
        <div class="p-6 border-b border-slate-100 bg-slate-50/50">
            <form method="GET" action="<?= baseUrl('pengaduan.php') ?>" class="flex flex-col md:flex-row gap-4 items-stretch md:items-center justify-between">
                <div class="flex-1 relative">
                    <svg class="w-5 h-5 text-slate-400 absolute left-4 top-1/2 -translate-y-1/2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                    </svg>
                    <input type="text" name="search" value="<?= htmlspecialchars($search) ?>" placeholder="Cari laporan berdasarkan judul, deskripsi atau lokasi..." 
                           class="w-full pl-12 pr-4 py-3 rounded-xl border border-slate-200 text-sm focus:outline-none focus:border-primary-500 bg-white">
                </div>
                <div class="flex gap-3">
                    <select name="status" class="px-4 py-3 rounded-xl border border-slate-200 text-sm bg-white focus:outline-none focus:border-primary-500">
                        <option value="">Semua Status</option>
                        <option value="proses" <?= $statusFilter === 'proses' ? 'selected' : '' ?>>Proses</option>
                        <option value="selesai" <?= $statusFilter === 'selesai' ? 'selected' : '' ?>>Selesai</option>
                        <option value="ditolak" <?= $statusFilter === 'ditolak' ? 'selected' : '' ?>>Ditolak</option>
                    </select>
                    <button type="submit" class="px-5 py-3 rounded-xl bg-slate-800 hover:bg-slate-900 text-white font-semibold text-sm transition-all duration-150">
                        Cari
                    </button>
                    <?php if ($search !== '' || $statusFilter !== ''): ?>
                        <a href="<?= baseUrl('pengaduan.php') ?>" class="px-4 py-3 rounded-xl border border-slate-200 text-sm text-slate-600 hover:bg-slate-100 flex items-center justify-center">
                            Reset
                        </a>
                    <?php endif; ?>
                </div>
            </form>
        </div>

        <!-- Table / List -->
        <?php if (empty($items)): ?>
            <div class="p-16 text-center">
                <div class="w-16 h-16 bg-slate-50 rounded-full flex items-center justify-center mx-auto mb-4">
                    <svg class="w-8 h-8 text-slate-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z" />
                    </svg>
                </div>
                <h3 class="text-base font-bold text-slate-700">Belum ada aduan</h3>
                <p class="text-sm text-slate-400 mt-1 max-w-sm mx-auto">Silakan kirimkan aspirasi atau aduan situasi desa Anda dengan mengeklik tombol buat laporan baru.</p>
            </div>
        <?php else: ?>
            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse">
                    <thead>
                        <tr class="bg-slate-50/50 border-b border-slate-100 text-xs font-semibold text-slate-400 uppercase">
                            <th class="px-6 py-4">Tanggal</th>
                            <th class="px-6 py-4">Jenis Laporan</th>
                            <th class="px-6 py-4">Ringkasan</th>
                            <th class="px-6 py-4">Status</th>
                            <th class="px-6 py-4 text-right">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100 text-sm text-slate-600">
                        <?php foreach ($items as $item): ?>
                            <tr class="hover:bg-slate-50/30 transition-colors">
                                <td class="px-6 py-5 whitespace-nowrap text-slate-500 font-medium">
                                    <?= date('d M Y', strtotime($item['created_at'])) ?>
                                </td>
                                <td class="px-6 py-5 whitespace-nowrap">
                                    <div class="flex items-center gap-3">
                                        <?= $categoryIcons[$item['kategori']] ?? $categoryIcons['Lainnya'] ?>
                                        <span class="font-semibold text-slate-800"><?= htmlspecialchars($item['kategori']) ?></span>
                                    </div>
                                </td>
                                <td class="px-6 py-5 max-w-xs md:max-w-md truncate">
                                    <p class="font-semibold text-slate-800 truncate mb-0.5"><?= htmlspecialchars($item['judul']) ?></p>
                                    <p class="text-xs text-slate-400 truncate"><?= htmlspecialchars($item['deskripsi']) ?></p>
                                </td>
                                <td class="px-6 py-5 whitespace-nowrap">
                                    <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-semibold border <?= $statusColors[$item['status']] ?>">
                                        <span class="w-1.5 h-1.5 rounded-full bg-current"></span>
                                        <?= $statusText[$item['status']] ?>
                                    </span>
                                </td>
                                <td class="px-6 py-5 whitespace-nowrap text-right">
                                    <button type="button" onclick="showDetail(<?= $item['id'] ?>)" 
                                            class="text-sm font-semibold text-primary-600 hover:text-primary-800 hover:underline">
                                        Detail
                                    </button>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>

            <!-- Pagination -->
            <?php if ($totalPages > 1): ?>
                <div class="flex items-center justify-between px-6 py-4 border-t border-slate-100 bg-slate-50/30">
                    <span class="text-xs text-slate-400">Menampilkan <?= (($page - 1) * $perPage) + 1 ?>-<?= min($page * $perPage, $total) ?> dari <?= $total ?> laporan</span>
                    <div class="flex items-center gap-1">
                        <?php if ($page > 1): ?>
                            <a href="<?= baseUrl('pengaduan.php?page=' . ($page - 1) . '&search=' . urlencode($search) . '&status=' . urlencode($statusFilter)) ?>" 
                               class="px-3 py-1.5 rounded-lg border border-slate-200 text-xs text-slate-600 hover:bg-slate-50 font-medium">Sebelumnya</a>
                        <?php endif; ?>
                        <?php for ($i = 1; $i <= $totalPages; $i++): ?>
                            <a href="<?= baseUrl('pengaduan.php?page=' . $i . '&search=' . urlencode($search) . '&status=' . urlencode($statusFilter)) ?>" 
                               class="w-8 h-8 rounded-lg flex items-center justify-center text-xs font-semibold <?= $i === $page ? 'bg-primary-600 text-white' : 'text-slate-500 hover:bg-slate-100' ?>"><?= $i ?></a>
                        <?php endfor; ?>
                        <?php if ($page < $totalPages): ?>
                            <a href="<?= baseUrl('pengaduan.php?page=' . ($page + 1) . '&search=' . urlencode($search) . '&status=' . urlencode($statusFilter)) ?>" 
                               class="px-3 py-1.5 rounded-lg border border-slate-200 text-xs text-slate-600 hover:bg-slate-50 font-medium">Berikutnya</a>
                        <?php endif; ?>
                    </div>
                </div>
            <?php endif; ?>
        <?php endif; ?>
    </div>
</div>

<!-- Modal Detail Pengaduan -->
<div id="detailModal" class="fixed inset-0 z-50 overflow-y-auto hidden" aria-labelledby="modal-title" role="dialog" aria-modal="true">
    <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
        <!-- Backdrop -->
        <div class="fixed inset-0 bg-slate-900/60 backdrop-blur-sm transition-opacity" onclick="closeModal()"></div>

        <!-- Center modal content -->
        <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>
        
        <div class="inline-block align-bottom bg-white rounded-3xl text-left overflow-hidden shadow-2xl transform transition-all sm:my-8 sm:align-middle sm:max-w-2xl sm:w-full border border-slate-100">
            <!-- Header -->
            <div class="px-6 py-5 bg-slate-50 border-b border-slate-100 flex items-center justify-between">
                <div>
                    <h3 class="text-lg font-bold text-slate-800" id="modal-title">Detail Laporan Pengaduan</h3>
                    <p class="text-xs text-slate-400 mt-0.5" id="modal-noreg">#NO_REG</p>
                </div>
                <button type="button" onclick="closeModal()" class="p-1.5 rounded-lg text-slate-400 hover:bg-slate-100 hover:text-slate-600 transition-colors">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>

            <!-- Body -->
            <div class="px-6 py-6 space-y-6 max-h-[70vh] overflow-y-auto">
                <!-- Info Status -->
                <div class="flex flex-wrap items-center justify-between gap-4 p-4 rounded-2xl border bg-slate-50/50" id="modal-status-card">
                    <div class="flex items-center gap-3">
                        <div class="w-10 h-10 rounded-full flex items-center justify-center" id="modal-status-icon-bg">
                            <!-- Icon will be injected -->
                        </div>
                        <div>
                            <p class="text-[10px] text-slate-400 uppercase font-bold tracking-wider">Status Laporan</p>
                            <p class="text-sm font-extrabold text-slate-800" id="modal-status-text">Proses</p>
                        </div>
                    </div>
                    <div class="text-xs text-slate-400" id="modal-date">
                        12 Okt 2023
                    </div>
                </div>

                <!-- Judul & Kategori -->
                <div>
                    <div class="inline-flex px-2.5 py-1 rounded-lg text-xs font-bold bg-primary-50 text-primary-700 border border-primary-100 mb-2" id="modal-category">
                        Kategori
                    </div>
                    <h4 class="text-xl font-bold text-slate-800" id="modal-judul">Judul Pengaduan</h4>
                </div>

                <!-- Deskripsi -->
                <div>
                    <p class="text-xs font-bold text-slate-400 uppercase tracking-wider mb-2">Deskripsi Laporan</p>
                    <p class="text-sm text-slate-600 leading-relaxed whitespace-pre-line" id="modal-deskripsi">Isi deskripsi...</p>
                </div>

                <!-- Lokasi Kejadian -->
                <div>
                    <p class="text-xs font-bold text-slate-400 uppercase tracking-wider mb-2">📍 Lokasi Kejadian</p>
                    <div class="p-4 bg-slate-50 rounded-2xl border border-slate-100 flex flex-col gap-4">
                        <div class="flex items-start gap-3">
                            <svg class="w-5 h-5 text-slate-400 mt-0.5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                            </svg>
                            <p class="text-sm text-slate-600 leading-snug font-semibold text-slate-800" id="modal-lokasi">Alamat...</p>
                        </div>
                        <!-- Mini Map -->
                        <div class="rounded-xl overflow-hidden border border-slate-200 h-48 bg-slate-100 relative shadow-sm">
                            <div id="detail-map" class="w-full h-full z-10"></div>
                        </div>
                    </div>
                </div>

                <!-- Bukti Foto -->
                <div>
                    <p class="text-xs font-bold text-slate-400 uppercase tracking-wider mb-3">🖼️ Bukti Foto Kejadian</p>
                    <div class="grid grid-cols-3 gap-3" id="modal-photos-grid">
                        <!-- Photos will be injected -->
                    </div>
                </div>

                <!-- Catatan Tindak Lanjut Admin -->
                <div class="bg-amber-50 rounded-2xl border border-amber-200 p-5 hidden" id="modal-catatan-admin-container">
                    <h5 class="font-bold text-amber-800 text-sm mb-2 flex items-center gap-2">📝 Catatan Petugas</h5>
                    <p class="text-sm text-amber-700 leading-relaxed" id="modal-catatan-admin">Catatan...</p>
                </div>
            </div>

            <!-- Footer -->
            <div class="px-6 py-4 bg-slate-50 border-t border-slate-100 flex justify-end">
                <button type="button" onclick="closeModal()" class="px-5 py-2.5 rounded-xl border border-slate-200 text-sm font-semibold text-slate-600 bg-white hover:bg-slate-50 transition-colors">
                    Tutup
                </button>
            </div>
        </div>
    </div>
</div>

<script>
var detailMap = null;
var detailMarker = null;

function initDetailMap(lat, lng) {
    if (!detailMap) {
        detailMap = L.map('detail-map', {
            zoomControl: true,
            scrollWheelZoom: false
        }).setView([lat, lng], 16);
        
        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            maxZoom: 19,
            attribution: '© OpenStreetMap contributors'
        }).addTo(detailMap);
        
        detailMarker = L.marker([lat, lng]).addTo(detailMap);
    } else {
        detailMarker.setLatLng([lat, lng]);
        detailMap.setView([lat, lng], 16);
    }
    
    setTimeout(function() {
        if (detailMap) {
            detailMap.invalidateSize();
        }
    }, 250);
}

function showDetail(id) {
    // Fetch data using fetch API
    fetch('<?= baseUrl("pengaduan.php") ?>?action=ajax_detail&id=' + id)
        .then(response => response.json())
        .then(data => {
            if (!data.success) {
                alert('Gagal memuat detail laporan.');
                return;
            }
            
            const p = data.complaint;
            const photos = data.photos;

            document.getElementById('modal-noreg').innerText = p.no_pengaduan;
            document.getElementById('modal-judul').innerText = p.judul;
            document.getElementById('modal-category').innerText = p.kategori;
            document.getElementById('modal-deskripsi').innerText = p.deskripsi;
            document.getElementById('modal-lokasi').innerText = p.lokasi;
            document.getElementById('modal-date').innerText = new Date(p.created_at).toLocaleDateString('id-ID', {day: 'numeric', month: 'long', year: 'numeric'});

            // Status Styling
            const statusCard = document.getElementById('modal-status-card');
            const statusIconBg = document.getElementById('modal-status-icon-bg');
            const statusText = document.getElementById('modal-status-text');

            statusCard.className = "flex flex-wrap items-center justify-between gap-4 p-4 rounded-2xl border ";
            statusText.innerText = p.status.toUpperCase();

            if (p.status === 'proses') {
                statusCard.classList.add('bg-indigo-50/50', 'border-indigo-100');
                statusIconBg.className = "w-10 h-10 rounded-full flex items-center justify-center bg-indigo-100 text-indigo-600";
                statusIconBg.innerHTML = '<svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>';
            } else if (p.status === 'selesai') {
                statusCard.classList.add('bg-emerald-50/50', 'border-emerald-100');
                statusIconBg.className = "w-10 h-10 rounded-full flex items-center justify-center bg-emerald-100 text-emerald-600";
                statusIconBg.innerHTML = '<svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>';
            } else {
                statusCard.classList.add('bg-rose-50/50', 'border-rose-100');
                statusIconBg.className = "w-10 h-10 rounded-full flex items-center justify-center bg-rose-100 text-rose-600";
                statusIconBg.innerHTML = '<svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>';
            }

            // Catatan Admin
            const notesContainer = document.getElementById('modal-catatan-admin-container');
            if (p.catatan_admin && p.catatan_admin.trim() !== '') {
                document.getElementById('modal-catatan-admin').innerText = p.catatan_admin;
                notesContainer.classList.remove('hidden');
            } else {
                notesContainer.classList.add('hidden');
            }

            // Photos Grid
            const photosGrid = document.getElementById('modal-photos-grid');
            photosGrid.innerHTML = '';
            if (photos && photos.length > 0) {
                photos.forEach(photo => {
                    const imgUrl = '<?= baseUrl("uploads/pengaduan/") ?>' + photo.nama_file;
                    photosGrid.innerHTML += `
                        <a href="${imgUrl}" target="_blank" class="block aspect-square rounded-2xl overflow-hidden border border-slate-100 bg-slate-50 hover:opacity-90 transition-opacity">
                            <img src="${imgUrl}" alt="Bukti Foto" class="w-full h-full object-cover">
                        </a>
                    `;
                });
            } else {
                photosGrid.innerHTML = '<p class="text-sm text-slate-400 col-span-3 italic">Tidak ada lampiran foto.</p>';
            }

            // Open Modal
            document.getElementById('detailModal').classList.remove('hidden');
            document.body.style.overflow = 'hidden';

            // Map handling
            var lat = parseFloat(p.latitude);
            var lng = parseFloat(p.longitude);
            
            if (!isNaN(lat) && !isNaN(lng)) {
                initDetailMap(lat, lng);
            } else {
                // Fallback to geocoding the address using Photon API
                var geocodeUrl = `https://photon.komoot.io/api/?q=${encodeURIComponent(p.lokasi)}&limit=1`;
                fetch(geocodeUrl)
                    .then(r => r.json())
                    .then(geoData => {
                        if (geoData && geoData.features && geoData.features.length > 0) {
                            var pt = geoData.features[0].geometry.coordinates;
                            initDetailMap(pt[1], pt[0]);
                        } else {
                            // Defaults if geocoding fails
                            initDetailMap(-6.2088, 106.8456);
                        }
                    })
                    .catch(() => {
                        initDetailMap(-6.2088, 106.8456);
                    });
            }
        });
}

function closeModal() {
    document.getElementById('detailModal').classList.add('hidden');
    document.body.style.overflow = '';
}
</script>
