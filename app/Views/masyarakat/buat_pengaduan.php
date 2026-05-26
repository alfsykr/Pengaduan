<!-- Leaflet CSS & JS -->
<link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" integrity="sha256-p4NxAoJBhIIN+hmNHrzRCf9tD/miZyoHS5obTRR9BMY=" crossorigin="" />
<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js" integrity="sha256-20nQCchB9co0qIjJZRGuk2/Z9VM+kNiyxNV1lvTlZBo=" crossorigin=""></script>

<div class="animate-fade-in space-y-6 max-w-5xl mx-auto">
    <!-- Breadcrumbs -->
    <nav class="flex text-xs font-semibold text-slate-400 gap-2 items-center">
        <a href="<?= baseUrl('pengaduan.php') ?>" class="hover:text-primary-600 transition-colors">Pengaduan</a>
        <span>&rsaquo;</span>
        <span class="text-slate-600">Buat Laporan Baru</span>
    </nav>

    <!-- Title Header -->
    <div class="mb-4">
        <h2 class="text-3xl font-extrabold text-slate-800 leading-tight">Buat Laporan Warga</h2>
        <p class="text-slate-500 text-sm mt-1 max-w-xl">Bantu kami meningkatkan kualitas lingkungan dengan melaporkan permasalahan di sekitar Anda. Laporan Anda akan diproses secara transparan oleh petugas terkait.</p>
    </div>

    <!-- Main Form Grid -->
    <form method="POST" action="<?= baseUrl('app/Controllers/PengaduanController.php?action=create') ?>" enctype="multipart/form-data" class="grid grid-cols-1 lg:grid-cols-3 gap-6" onsubmit="return validateForm()">
        
        <!-- Left 2 Columns: Main Info & Location -->
        <div class="lg:col-span-2 space-y-6">
            <!-- Informasi Utama Card -->
            <div class="bg-white rounded-3xl border border-slate-100 p-6 space-y-6 shadow-sm">
                <div class="flex items-center gap-2 pb-4 border-b border-slate-50">
                    <span class="w-8 h-8 rounded-xl bg-indigo-50 text-indigo-600 flex items-center justify-center">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                        </svg>
                    </span>
                    <h3 class="text-base font-bold text-slate-800">Informasi Utama</h3>
                </div>

                <!-- Judul Laporan -->
                <div>
                    <label for="judul" class="block text-xs font-bold text-slate-400 uppercase tracking-wider mb-2">Judul Laporan</label>
                    <input type="text" name="judul" id="judul" required placeholder="Contoh: Lampu Jalan Mati di Jl. Anggrek" 
                           class="w-full px-4 py-3 rounded-xl border border-slate-200 text-sm focus:outline-none focus:border-primary-500 bg-slate-50/30">
                </div>

                <!-- Kategori Laporan (Clickable grid) -->
                <div>
                    <label class="block text-xs font-bold text-slate-400 uppercase tracking-wider mb-3">Kategori Laporan</label>
                    <input type="hidden" name="kategori" id="selectedKategori" required>
                    <div class="grid grid-cols-2 sm:grid-cols-3 gap-3">
                        <!-- Keamanan -->
                        <button type="button" onclick="selectKategori('Keamanan')" id="cat-Keamanan" 
                                class="flex flex-col items-center justify-center p-4 rounded-2xl border-2 border-slate-200 bg-white hover:bg-slate-50 transition-all text-center gap-2 group">
                            <span id="icon-Keamanan" class="p-2.5 bg-slate-50 text-slate-500 rounded-xl group-hover:scale-110 transition-transform">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/>
                                </svg>
                            </span>
                            <span class="text-xs font-bold text-slate-700">Keamanan</span>
                        </button>
                        <!-- Infrastruktur -->
                        <button type="button" onclick="selectKategori('Infrastruktur')" id="cat-Infrastruktur" 
                                class="flex flex-col items-center justify-center p-4 rounded-2xl border-2 border-slate-200 bg-white hover:bg-slate-50 transition-all text-center gap-2 group">
                            <span id="icon-Infrastruktur" class="p-2.5 bg-slate-50 text-slate-500 rounded-xl group-hover:scale-110 transition-transform">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/>
                                </svg>
                            </span>
                            <span class="text-xs font-bold text-slate-700">Infrastruktur</span>
                        </button>
                        <!-- Kebersihan -->
                        <button type="button" onclick="selectKategori('Kebersihan')" id="cat-Kebersihan" 
                                class="flex flex-col items-center justify-center p-4 rounded-2xl border-2 border-slate-200 bg-white hover:bg-slate-50 transition-all text-center gap-2 group">
                            <span id="icon-Kebersihan" class="p-2.5 bg-slate-50 text-slate-500 rounded-xl group-hover:scale-110 transition-transform">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                </svg>
                            </span>
                            <span class="text-xs font-bold text-slate-700">Kebersihan</span>
                        </button>
                        <!-- Sosial -->
                        <button type="button" onclick="selectKategori('Sosial')" id="cat-Sosial" 
                                class="flex flex-col items-center justify-center p-4 rounded-2xl border-2 border-slate-200 bg-white hover:bg-slate-50 transition-all text-center gap-2 group">
                            <span id="icon-Sosial" class="p-2.5 bg-slate-50 text-slate-500 rounded-xl group-hover:scale-110 transition-transform">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/>
                                </svg>
                            </span>
                            <span class="text-xs font-bold text-slate-700">Sosial</span>
                        </button>
                        <!-- Kesehatan -->
                        <button type="button" onclick="selectKategori('Kesehatan')" id="cat-Kesehatan" 
                                class="flex flex-col items-center justify-center p-4 rounded-2xl border-2 border-slate-200 bg-white hover:bg-slate-50 transition-all text-center gap-2 group">
                            <span id="icon-Kesehatan" class="p-2.5 bg-slate-50 text-slate-500 rounded-xl group-hover:scale-110 transition-transform">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M9 12h6m-3-3v6m12-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                </svg>
                            </span>
                            <span class="text-xs font-bold text-slate-700">Kesehatan</span>
                        </button>
                        <!-- Lainnya -->
                        <button type="button" onclick="selectKategori('Lainnya')" id="cat-Lainnya" 
                                class="flex flex-col items-center justify-center p-4 rounded-2xl border-2 border-slate-200 bg-white hover:bg-slate-50 transition-all text-center gap-2 group">
                            <span id="icon-Lainnya" class="p-2.5 bg-slate-50 text-slate-500 rounded-xl group-hover:scale-110 transition-transform">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M5 12h.01M12 12h.01M19 12h.01M6 12a1 1 0 11-2 0 1 1 0 012 0zm7 0a1 1 0 11-2 0 1 1 0 012 0zm7 0a1 1 0 11-2 0 1 1 0 012 0z"/>
                                </svg>
                            </span>
                            <span class="text-xs font-bold text-slate-700">Lainnya</span>
                        </button>
                    </div>
                </div>

                <!-- Deskripsi Detail -->
                <div>
                    <label for="deskripsi" class="block text-xs font-bold text-slate-400 uppercase tracking-wider mb-2">Deskripsi Detail</label>
                    <textarea name="deskripsi" id="deskripsi" rows="6" required placeholder="Ceritakan detail kejadian secara kronologis agar petugas kami dapat memahami situasi dengan baik..." 
                              class="w-full px-4 py-3 rounded-xl border border-slate-200 text-sm focus:outline-none focus:border-primary-500 bg-slate-50/30"></textarea>
                </div>
            </div>

            <!-- Lokasi Kejadian Card -->
            <div class="bg-white rounded-3xl border border-slate-100 p-6 space-y-4 shadow-sm">
                <div class="flex items-center gap-2 pb-4 border-b border-slate-50">
                    <span class="w-8 h-8 rounded-xl bg-indigo-50 text-indigo-600 flex items-center justify-center">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                        </svg>
                    </span>
                    <h3 class="text-base font-bold text-slate-800">Lokasi Kejadian</h3>
                </div>

                <!-- Alamat Lengkap -->
                <div>
                    <label for="lokasi" class="block text-xs font-bold text-slate-400 uppercase tracking-wider mb-2">Alamat Lengkap / Patokan</label>
                    <div class="relative flex gap-2">
                        <div class="relative flex-1">
                            <input type="text" name="lokasi" id="lokasi" required autocomplete="off" placeholder="Masukkan nama jalan atau lokasi spesifik kejadian..." 
                                   class="w-full pl-12 pr-4 py-3 rounded-xl border border-slate-200 text-sm focus:outline-none focus:border-primary-500 bg-slate-50/30">
                            <svg class="w-5 h-5 text-slate-400 absolute left-4 top-1/2 -translate-y-1/2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                            </svg>
                            <!-- Suggestions -->
                            <div id="map-suggestions" class="absolute left-0 right-0 z-[1000] bg-white border border-slate-200 rounded-xl shadow-lg mt-1 max-h-48 overflow-y-auto hidden"></div>
                        </div>
                        <button type="button" id="btn-cari-lokasi" onclick="searchLocationDirectly()"
                                class="px-5 py-3 rounded-xl bg-indigo-600 hover:bg-indigo-700 text-white font-bold text-sm transition-all shrink-0 flex items-center gap-1 active:scale-95 shadow-sm">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                            </svg>
                            Cari
                        </button>
                    </div>
                    <!-- Hidden lat/lng fields sent with form -->
                    <input type="hidden" name="latitude" id="input_latitude">
                    <input type="hidden" name="longitude" id="input_longitude">
                </div>

                <!-- Interactive Map -->
                <div class="rounded-2xl overflow-hidden border border-slate-200 relative h-60 bg-slate-50 group">
                    <div id="map" class="w-full h-full z-10"></div>
                </div>
            </div>
        </div>

        <!-- Right 1 Column: Photo Uploads & Action -->
        <div class="space-y-6">
            <!-- Bukti Foto Card -->
            <div class="bg-white rounded-3xl border border-slate-100 p-6 space-y-6 shadow-sm">
                <div class="flex items-center gap-2 pb-4 border-b border-slate-50">
                    <span class="w-8 h-8 rounded-xl bg-indigo-50 text-indigo-600 flex items-center justify-center">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                        </svg>
                    </span>
                    <h3 class="text-base font-bold text-slate-800">Bukti Foto</h3>
                </div>

                <!-- Drag & Drop Zone -->
                <div class="space-y-4">
                    <label for="foto_bukti" class="block cursor-pointer">
                        <div class="upload-zone rounded-2xl p-6 text-center flex flex-col items-center justify-center gap-3">
                            <div class="w-12 h-12 rounded-2xl bg-indigo-50 text-indigo-600 flex items-center justify-center shadow-inner">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12" />
                                </svg>
                            </div>
                            <div>
                                <p class="text-sm font-bold text-slate-700">Pilih atau Seret Foto</p>
                                <p class="text-xs text-slate-400 mt-1">Format JPG, PNG, atau WebP (Maks. 5MB per file)</p>
                            </div>
                        </div>
                        <input type="file" name="foto_bukti[]" id="foto_bukti" multiple accept="image/*" class="hidden" onchange="previewImages(event)">
                    </label>

                    <!-- Previews Grid -->
                    <div id="previews" class="grid grid-cols-3 gap-3">
                        <div class="aspect-square rounded-2xl border-2 border-dashed border-slate-100 bg-slate-50 flex items-center justify-center text-slate-300">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                            </svg>
                        </div>
                        <div class="aspect-square rounded-2xl border-2 border-dashed border-slate-100 bg-slate-50 flex items-center justify-center text-slate-300">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                            </svg>
                        </div>
                        <div class="aspect-square rounded-2xl border-2 border-dashed border-slate-100 bg-slate-50 flex items-center justify-center text-slate-300">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                            </svg>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Action buttons card -->
            <div class="space-y-3">
                <button type="submit" 
                        class="w-full py-4 rounded-2xl bg-primary-700 hover:bg-primary-800 text-white font-bold text-sm shadow-xl shadow-primary-500/25 transition-all duration-150 active:scale-[0.98] flex items-center justify-center gap-2">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8" />
                    </svg>
                    Kirim Laporan
                </button>
                <a href="<?= baseUrl('pengaduan.php') ?>" 
                   class="w-full py-4 rounded-2xl border border-slate-200 hover:bg-slate-50 text-slate-600 bg-white font-bold text-sm transition-all duration-150 active:scale-[0.98] flex items-center justify-center">
                    Batal
                </a>
            </div>

            <!-- Tips/Alert Box -->
            <div class="p-5 rounded-2xl bg-indigo-50 border border-indigo-100 flex gap-3 text-indigo-700">
                <svg class="w-5 h-5 shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
                <p class="text-xs leading-relaxed">
                    Laporan Anda akan bersifat anonim kecuali Anda memilih untuk menampilkannya di pengaturan profil. Pastikan data bukti dan deskripsi akurat untuk percepatan peninjauan.
                </p>
            </div>
        </div>
    </form>
</div>

<script>
// Form Validation
function validateForm() {
    const kategori = document.getElementById('selectedKategori').value;
    if (!kategori) {
        alert('Silakan pilih Kategori Laporan terlebih dahulu sebelum mengirim.');
        return false;
    }
    return true;
}

// Map Initialization
var defaultLat = -6.2088;
var defaultLng = 106.8456;
var map = L.map('map', {
    zoomControl: true,
    scrollWheelZoom: false
}).setView([defaultLat, defaultLng], 13);

L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
    maxZoom: 19,
    attribution: '© OpenStreetMap contributors'
}).addTo(map);

// Draggable Marker
var marker = L.marker([defaultLat, defaultLng], {
    draggable: true
}).addTo(map);
// Update input & hidden lat/lng when dragging marker
marker.on('dragend', function() {
    var latlng = marker.getLatLng();
    document.getElementById('input_latitude').value = latlng.lat;
    document.getElementById('input_longitude').value = latlng.lng;
    reverseGeocode(latlng.lat, latlng.lng);
});

// Helper: update hidden lat/lng inputs
function setLatLng(lat, lng) {
    document.getElementById('input_latitude').value = lat;
    document.getElementById('input_longitude').value = lng;
}

// Helper to construct a formatted Indonesian address from Photon properties
function buildPhotonAddress(properties) {
    if (!properties) return 'Lokasi Terpilih';
    var parts = [];
    
    if (properties.name) {
        parts.push(properties.name);
    }
    
    if (properties.street && properties.name !== properties.street) {
        var street = properties.street;
        if (properties.housenumber) {
            street += ' No. ' + properties.housenumber;
        }
        parts.push(street);
    }
    
    var city = properties.city || properties.town || properties.district;
    if (city && properties.name !== city) {
        parts.push(city);
    }
    
    if (properties.state && properties.name !== properties.state && city !== properties.state) {
        parts.push(properties.state);
    }
    
    return parts.join(', ');
}

function reverseGeocode(lat, lng) {
    // Using Photon Komoot Reverse Geocoding API
    var url = `https://photon.komoot.io/api/?lon=${lng}&lat=${lat}&limit=1`;
    
    fetch(url)
    .then(response => response.json())
    .then(data => {
        if (data && data.features && data.features.length > 0) {
            var props = data.features[0].properties;
            var addressText = buildPhotonAddress(props);
            document.getElementById('lokasi').value = addressText;
        }
    })
    .catch(err => console.log('Error reverse geocoding:', err));
}

// Photon Search Autocomplete with suggestions card (bold name and metadata subtitle)
var debounceTimeout;
document.getElementById('lokasi').addEventListener('input', function(e) {
    var query = e.target.value;
    clearTimeout(debounceTimeout);
    
    if (query.length < 3) {
        document.getElementById('map-suggestions').classList.add('hidden');
        return;
    }

    debounceTimeout = setTimeout(function() {
        var center = map.getCenter();
        // Photon API with geo-biasing based on current map view
        var url = `https://photon.komoot.io/api/?q=${encodeURIComponent(query)}&limit=5&lat=${center.lat}&lon=${center.lng}`;
        
        fetch(url)
        .then(response => response.json())
        .then(data => {
            var container = document.getElementById('map-suggestions');
            container.innerHTML = '';
            
            if (data && data.features && data.features.length > 0) {
                data.features.forEach(feature => {
                    var props = feature.properties;
                    var title = props.name || props.street || 'Lokasi';
                    
                    // Build subtitle parts: type, city, state, country
                    var subtitleParts = [];
                    if (props.type) subtitleParts.push(props.type);
                    var city = props.city || props.town || props.district;
                    if (city) subtitleParts.push(city);
                    if (props.state) subtitleParts.push(props.state);
                    if (props.country) subtitleParts.push(props.country);
                    var subtitle = subtitleParts.join(', ');
                    
                    var addressText = buildPhotonAddress(props);
                    var lon = feature.geometry.coordinates[0];
                    var lat = feature.geometry.coordinates[1];
                    
                    // Create card element matching the layout in the screenshot
                    var div = document.createElement('div');
                    div.className = "px-4 py-3 hover:bg-slate-50 cursor-pointer border-b border-slate-100 last:border-b-0 flex flex-col gap-0.5 text-left transition-colors";
                    div.innerHTML = `
                        <span class="text-sm font-bold text-slate-800">${title}</span>
                        <span class="text-[11px] text-slate-500 font-medium">${subtitle}</span>
                    `;
                    
                    div.addEventListener('click', function() {
                        document.getElementById('lokasi').value = addressText;
                        marker.setLatLng([lat, lon]);
                        map.setView([lat, lon], 16);
                        setLatLng(lat, lon);
                        container.classList.add('hidden');
                    });
                    container.appendChild(div);
                });
                container.classList.remove('hidden');
            } else {
                container.classList.add('hidden');
            }
        })
        .catch(err => console.log('Error searching location:', err));
    }, 400);
});

// Direct search via Search Button
function searchLocationDirectly() {
    var query = document.getElementById('lokasi').value.trim();
    if (!query) {
        alert('Silakan masukkan nama jalan atau alamat terlebih dahulu.');
        return;
    }

    var btn = document.getElementById('btn-cari-lokasi');
    var originalHTML = btn.innerHTML;
    
    // Set loading state
    btn.disabled = true;
    btn.innerHTML = `
        <svg class="animate-spin -ml-1 mr-1 h-4 w-4 text-white" fill="none" viewBox="0 0 24 24">
            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
            <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
        </svg>
        Mencari...
    `;

    var center = map.getCenter();
    var url = `https://photon.komoot.io/api/?q=${encodeURIComponent(query)}&limit=1&lat=${center.lat}&lon=${center.lng}`;

    fetch(url)
    .then(response => response.json())
    .then(data => {
        if (data && data.features && data.features.length > 0) {
            var feature = data.features[0];
            var props = feature.properties;
            var addressText = buildPhotonAddress(props);
            
            // Set normalized address into input
            document.getElementById('lokasi').value = addressText;
            
            // Get coordinates (GeoJSON is [lon, lat])
            var lon = parseFloat(feature.geometry.coordinates[0]);
            var lat = parseFloat(feature.geometry.coordinates[1]);
            
            // Move marker and pan map
            marker.setLatLng([lat, lon]);
            map.setView([lat, lon], 16);
            setLatLng(lat, lon);
            
            // Hide autocomplete suggestions if open
            document.getElementById('map-suggestions').classList.add('hidden');
        } else {
            alert('Alamat tidak ditemukan. Silakan masukkan patokan yang lebih umum atau geser langsung marker di peta.');
        }
    })
    .catch(err => {
        console.error('Error in direct search:', err);
        alert('Gagal menghubungi layanan pencarian. Silakan coba kembali atau geser marker secara manual.');
    })
    .finally(() => {
        // Restore button state
        btn.disabled = false;
        btn.innerHTML = originalHTML;
    });
}

// Close suggestions on outside click
document.addEventListener('click', function(e) {
    var input = document.getElementById('lokasi');
    var container = document.getElementById('map-suggestions');
    if (input && container && !input.contains(e.target) && !container.contains(e.target)) {
        container.classList.add('hidden');
    }
});

// Select Kategori
function selectKategori(kategori) {
    const categories = ['Keamanan', 'Infrastruktur', 'Kebersihan', 'Sosial', 'Kesehatan', 'Lainnya'];
    
    categories.forEach(cat => {
        const btn = document.getElementById('cat-' + cat);
        const icon = document.getElementById('icon-' + cat);
        
        // Reset classes to neutral
        btn.className = "flex flex-col items-center justify-center p-4 rounded-2xl border-2 border-slate-200 bg-white hover:bg-slate-50 transition-all text-center gap-2 group";
        icon.className = "p-2.5 bg-slate-50 text-slate-500 rounded-xl group-hover:scale-110 transition-transform";
    });

    // Set selected styles (indigo/primary theme)
    const selectedBtn = document.getElementById('cat-' + kategori);
    const selectedIcon = document.getElementById('icon-' + kategori);
    
    selectedBtn.className = "flex flex-col items-center justify-center p-4 rounded-2xl border-2 border-primary-500 bg-primary-50/50 transition-all text-center gap-2 group";
    selectedIcon.className = "p-2.5 bg-primary-100 text-primary-600 rounded-xl group-hover:scale-110 transition-transform";

    // Update input hidden
    document.getElementById('selectedKategori').value = kategori;
}

// Previews images handler
function previewImages(event) {
    const input = event.target;
    const files = input.files;
    const previewsContainer = document.getElementById('previews');
    
    previewsContainer.innerHTML = '';
    const maxFiles = Math.min(files.length, 3);
    
    for (let i = 0; i < maxFiles; i++) {
        const file = files[i];
        const reader = new FileReader();
        
        reader.onload = function(e) {
            previewsContainer.innerHTML += `
                <div class="aspect-square rounded-2xl overflow-hidden border border-slate-100 relative group bg-slate-50">
                    <img src="${e.target.result}" alt="Preview" class="w-full h-full object-cover">
                    <div class="absolute inset-0 bg-slate-950/40 opacity-0 group-hover:opacity-100 transition-opacity flex items-center justify-center">
                        <span class="text-[10px] font-bold text-white uppercase">${file.name.substring(0, 8)}...</span>
                    </div>
                </div>
            `;
        }
        
        reader.readAsDataURL(file);
    }
    
    for (let j = maxFiles; j < 3; j++) {
        previewsContainer.innerHTML += `
            <div class="aspect-square rounded-2xl border-2 border-dashed border-slate-100 bg-slate-50 flex items-center justify-center text-slate-300">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                </svg>
            </div>
        `;
    }
}
</script>
