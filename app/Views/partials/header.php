<?php
if (!defined('BASE_PATH')) {
    define('BASE_PATH', dirname(__DIR__, 3));
}
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
require_once BASE_PATH . '/config/auth.php';
$currentPage = basename($_SERVER['PHP_SELF'], '.php');
$user = currentUser();
$flash = getFlash();
?>
<!DOCTYPE html>
<html lang="id" class="scroll-smooth">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>
        <?= $pageTitle ?? 'Dukcapil Mandiri' ?> - Desa Digital
    </title>
    <meta name="description"
        content="Layanan Kependudukan Digital - Urus dokumen kependudukan dengan mudah, cepat, dan transparan.">

    <!-- TailwindCSS -->
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        primary: { 50: '#edf0fa', 100: '#d4daf2', 200: '#aab5e5', 300: '#7f90d8', 400: '#556bcb', 500: '#3347B0', 600: '#2B3DA0', 700: '#263994', 800: '#1e2a78', 900: '#1a2468', 950: '#111845' },
                        accent: { 50: '#ecfeff', 100: '#cffafe', 200: '#a5f3fc', 300: '#67e8f9', 400: '#22d3ee', 500: '#06b6d4', 600: '#0891b2', 700: '#0e7490', 800: '#155e75', 900: '#164e63' },
                    },
                    fontFamily: {
                        sans: ['Inter', 'system-ui', 'sans-serif'],
                    }
                }
            }
        }
    </script>

    <!-- Google Fonts - Inter -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap"
        rel="stylesheet">

    <!-- Custom CSS -->
    <style>
        body {
            font-family: 'Inter', system-ui, sans-serif;
        }

        /* Sidebar: hover geser + klik scale (transform digabung agar tidak saling timpa) */
        .sidebar-link {
            transition: transform 0.15s ease-out, background-color 0.2s ease, border-color 0.2s ease;
        }

        .sidebar-link:hover {
            background: rgba(255, 255, 255, 0.1);
            transform: translateX(4px);
        }

        .sidebar-link:active {
            transform: scale(0.97);
        }

        .sidebar-link:hover:active {
            transform: translateX(4px) scale(0.97);
        }

        .sidebar-link.active {
            background: rgba(255, 255, 255, 0.15);
            border-right: 3px solid #556bcb;
        }

        .sidebar-link.active:hover {
            transform: translateX(4px);
        }

        .sidebar-link.active:hover:active {
            transform: translateX(4px) scale(0.97);
        }

        /* Sidebar admin: geser hover + ringkasan klik seperti menu warga */
        .admin-sidebar-link {
            transition: transform 0.15s ease-out, background-color 0.2s ease, color 0.2s ease;
        }

        .admin-sidebar-link:hover {
            transform: translateX(4px);
        }

        .admin-sidebar-link:active {
            transform: scale(0.97);
        }

        .admin-sidebar-link:hover:active {
            transform: translateX(4px) scale(0.97);
        }

        .admin-sidebar-link.is-active:hover {
            transform: translateX(4px);
        }

        .admin-sidebar-link.is-active:hover:active {
            transform: translateX(4px) scale(0.97);
        }

        /* Navbar atas (Beranda, Layanan, …): klik konsisten */
        .app-topnav-link {
            transition: transform 0.15s ease-out, color 0.2s ease;
        }

        .app-topnav-link:active {
            transform: scale(0.96);
        }

        /* Card hover */
        .card-hover {
            transition: all 0.3s ease;
        }

        .card-hover:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 40px rgba(0, 0, 0, 0.08);
        }

        /* Fade in animation */
        @keyframes fadeInUp {
            from {
                opacity: 0;
                transform: translateY(20px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .animate-fade-in {
            animation: fadeInUp 0.5s ease forwards;
        }

        .animate-delay-1 {
            animation-delay: 0.1s;
            opacity: 0;
        }

        .animate-delay-2 {
            animation-delay: 0.2s;
            opacity: 0;
        }

        .animate-delay-3 {
            animation-delay: 0.3s;
            opacity: 0;
        }

        .animate-delay-4 {
            animation-delay: 0.4s;
            opacity: 0;
        }

        /* Stepper */
        .stepper-line {
            height: 3px;
            transition: background 0.3s ease;
        }

        .step-circle {
            transition: all 0.3s ease;
        }

        /* Toast notification */
        .toast-enter {
            animation: slideInRight 0.3s ease forwards;
        }

        @keyframes slideInRight {
            from {
                transform: translateX(100%);
                opacity: 0;
            }

            to {
                transform: translateX(0);
                opacity: 1;
            }
        }

        /* Scrollbar */
        ::-webkit-scrollbar {
            width: 6px;
        }

        ::-webkit-scrollbar-track {
            background: #f1f5f9;
        }

        ::-webkit-scrollbar-thumb {
            background: #cbd5e1;
            border-radius: 3px;
        }

        ::-webkit-scrollbar-thumb:hover {
            background: #94a3b8;
        }

        /* Mobile sidebar */
        .sidebar-overlay {
            background: rgba(0, 0, 0, 0.5);
            opacity: 0;
            transition: opacity 0.3s ease;
            pointer-events: none;
        }

        .sidebar-overlay.active {
            opacity: 1;
            pointer-events: all;
        }

        /* Pulse animation for status */
        .pulse-dot {
            animation: pulse 2s infinite;
        }

        @keyframes pulse {

            0%,
            100% {
                opacity: 1;
            }

            50% {
                opacity: 0.5;
            }
        }

        /* Upload zone */
        .upload-zone {
            border: 2px dashed #cbd5e1;
            transition: all 0.3s ease;
        }

        .upload-zone:hover,
        .upload-zone.drag-over {
            border-color: #3347B0;
            background: #edf0fa;
        }

        /* Transisi panel tab (seragam: Data Diri, Pengaturan, Admin) */
        @keyframes uiTabPanelIn {
            from {
                opacity: 0.65;
                transform: translateY(8px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .ui-tab-panel-enter {
            animation: uiTabPanelIn 0.24s ease-out forwards;
        }
    </style>
    <script>
        (function () {
            window.uiAnimateTabPanel = function (el) {
                if (!el) return;
                el.classList.remove('ui-tab-panel-enter');
                void el.offsetWidth;
                el.classList.add('ui-tab-panel-enter');
            };
        })();
    </script>
</head>

<body class="bg-slate-50 min-h-screen">

    <!-- Flash Messages -->
    <?php if ($flash): ?>
        <div id="flash-toast" class="fixed top-4 right-4 z-[100] toast-enter">
            <div
                class="flex items-center gap-3 px-5 py-3 rounded-xl shadow-lg <?= $flash['type'] === 'success' ? 'bg-emerald-500' : ($flash['type'] === 'danger' ? 'bg-red-500' : ($flash['type'] === 'warning' ? 'bg-amber-500' : 'bg-primary-600')) ?> text-white">
                <span>
                    <?= htmlspecialchars($flash['message']) ?>
                </span>
                <button onclick="this.parentElement.parentElement.remove()" class="ml-2 hover:opacity-70">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
        </div>
        <script>setTimeout(() => { const t = document.getElementById('flash-toast'); if (t) t.remove() }, 4000);</script>
    <?php endif; ?>
