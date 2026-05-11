</main>

<!-- Admin Footer -->
<footer class="px-4 lg:px-6 py-4 border-t border-slate-100 mt-auto">
    <div class="flex flex-col md:flex-row items-center justify-between gap-3">
        <div class="flex items-center gap-2 text-xs text-slate-400">
            <span class="w-2 h-2 rounded-full bg-emerald-400"></span>
            <span>Sistem Operasional: Normal</span>
            <span class="text-slate-300">•</span>
            <span>Terakhir Sinkronisasi:
                <?= date('H:i') ?>
            </span>
        </div>
        <div class="flex items-center gap-4 text-xs text-slate-400">
            <a href="#" class="hover:text-primary-600">Panduan Admin</a>
            <a href="#" class="hover:text-primary-600">Laporkan Masalah</a>
        </div>
    </div>
</footer>
</div>

<!-- Sidebar Toggle -->
<script>
    function toggleSidebar() {
        document.getElementById('sidebar').classList.toggle('-translate-x-full');
        document.getElementById('sidebar-overlay').classList.toggle('active');
    }
    document.addEventListener('keydown', e => { if (e.key === 'Escape') { const s = document.getElementById('sidebar'); if (!s.classList.contains('-translate-x-full')) toggleSidebar(); } });
</script>
</body>

</html>