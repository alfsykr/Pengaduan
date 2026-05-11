</main>

<!-- Footer -->
<footer class="mt-auto px-4 lg:px-8 py-6 border-t border-slate-100">
    <div class="flex flex-col md:flex-row items-center justify-between gap-4">
        <p class="text-sm text-slate-400">&copy;
            <?= date('Y') ?> Desa Digital - Layanan Kependudukan Dukcapil Mandiri
        </p>
        <div class="flex items-center gap-1 text-sm text-slate-400">
            <svg class="w-4 h-4 text-emerald-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z" />
            </svg>
            Data Anda dilindungi oleh enkripsi standar pemerintah
        </div>
    </div>
</footer>
</div>

<!-- Sidebar Toggle Script -->
<script>
    function toggleSidebar() {
        const sidebar = document.getElementById('sidebar');
        const overlay = document.getElementById('sidebar-overlay');
        sidebar.classList.toggle('-translate-x-full');
        overlay.classList.toggle('active');
    }

    // Close sidebar on escape
    document.addEventListener('keydown', (e) => {
        if (e.key === 'Escape') {
            const sidebar = document.getElementById('sidebar');
            if (!sidebar.classList.contains('-translate-x-full')) {
                toggleSidebar();
            }
        }
    });
</script>
</body>

</html>