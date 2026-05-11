<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Masuk - Layanan Kependudukan Digital</title>
    <meta name="description" content="Portal Layanan Kependudukan Digital - Akses layanan kependudukan secara mandiri.">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800;900&display=swap"
        rel="stylesheet">
    <style>
        *,
        *::before,
        *::after {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        html,
        body {
            height: 100%;
            overflow: hidden;
        }

        body {
            font-family: 'Inter', system-ui, -apple-system, sans-serif;
            background: #fff;
            color: #1e293b;
            -webkit-font-smoothing: antialiased;
            display: flex;
            flex-direction: column;
        }

        .auth-wrapper {
            display: flex;
            flex: 1;
            min-height: 0;
        }

        /* ======== LEFT PANEL ======== */
        .auth-left {
            flex: 0 0 47%;
            position: relative;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
            padding: 2.5rem;
            overflow: hidden;
        }

        /* Background Image */
        .auth-left::before {
            content: '';
            position: absolute;
            inset: 0;
            background: url('<?= baseUrl('img/sistem-pemerintahan-indonesia.jpg') ?>') center/cover no-repeat;
            z-index: 0;
        }

        /* Blue Overlay */
        .auth-left::after {
            content: '';
            position: absolute;
            inset: 0;
            background: linear-gradient(180deg, rgba(30, 42, 120, 0.88) 0%, rgba(37, 52, 148, 0.92) 40%, rgba(30, 42, 120, 0.95) 100%);
            z-index: 1;
        }

        .auth-left>* {
            position: relative;
            z-index: 2;
        }

        .brand-logo {
            display: flex;
            align-items: center;
            gap: 0.75rem;
            color: #fff;
        }

        .brand-logo svg {
            width: 26px;
            height: 26px;
            opacity: 0.9;
        }

        .brand-logo span {
            font-size: 1.05rem;
            font-weight: 700;
            letter-spacing: -0.3px;
        }

        .hero-content {
            max-width: 400px;
        }

        .hero-content h1 {
            font-size: 2.5rem;
            font-weight: 800;
            color: #fff;
            line-height: 1.15;
            letter-spacing: -1.2px;
            margin-bottom: 1rem;
        }

        .hero-content p {
            font-size: 0.9rem;
            color: rgba(255, 255, 255, 0.7);
            line-height: 1.7;
        }

        .auth-left-footer {
            display: flex;
            align-items: center;
            gap: 1.25rem;
            font-size: 0.7rem;
            color: rgba(255, 255, 255, 0.5);
        }

        .auth-left-footer span {
            display: flex;
            align-items: center;
            gap: 0.35rem;
        }

        .dot-sep {
            width: 3px;
            height: 3px;
            background: rgba(255, 255, 255, 0.3);
            border-radius: 50%;
        }

        /* ======== RIGHT PANEL ======== */
        .auth-right {
            flex: 1;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            padding: 2.5rem 3.5rem;
            background: #fff;
            overflow-y: auto;
        }

        .form-box {
            width: 100%;
            max-width: 420px;
        }

        .form-box h2 {
            font-size: 1.65rem;
            font-weight: 800;
            color: #0f172a;
            letter-spacing: -0.5px;
            margin-bottom: 0.4rem;
        }

        .form-box .sub {
            font-size: 0.85rem;
            color: #64748b;
            line-height: 1.6;
            margin-bottom: 2rem;
        }

        .fg {
            margin-bottom: 1.15rem;
        }

        .fl {
            display: block;
            font-size: 0.8rem;
            font-weight: 600;
            color: #334155;
            margin-bottom: 0.4rem;
        }

        .iw {
            position: relative;
            display: flex;
            align-items: center;
        }

        .ii {
            position: absolute;
            left: 0.9rem;
            color: #94a3b8;
            display: flex;
            z-index: 2;
        }

        .ii svg {
            width: 18px;
            height: 18px;
        }

        .fi {
            width: 100%;
            padding: 0.85rem 0.9rem 0.85rem 2.65rem;
            border: 1.5px solid #e2e8f0;
            border-radius: 0.7rem;
            font-size: 0.85rem;
            color: #1e293b;
            background: #f8fafc;
            outline: none;
            transition: all 0.2s;
            font-family: 'Inter', sans-serif;
        }

        .fi:focus {
            border-color: #3347B0;
            background: #fff;
            box-shadow: 0 0 0 3px rgba(51, 71, 176, 0.1);
        }

        .fi::placeholder {
            color: #94a3b8;
        }

        .tp {
            position: absolute;
            right: 0.9rem;
            cursor: pointer;
            background: none;
            border: none;
            color: #94a3b8;
            display: flex;
            align-items: center;
            padding: 0.2rem;
            z-index: 2;
            transition: color 0.2s;
        }

        .tp:hover {
            color: #475569;
        }

        .tp svg {
            width: 18px;
            height: 18px;
        }

        .row-between {
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin-bottom: 1.35rem;
        }

        .chk {
            display: flex;
            align-items: center;
            gap: 0.45rem;
            cursor: pointer;
        }

        .chk input {
            width: 15px;
            height: 15px;
            border: 1.5px solid #cbd5e1;
            border-radius: 3px;
            accent-color: #3347B0;
            cursor: pointer;
        }

        .chk label {
            font-size: 0.8rem;
            color: #475569;
            cursor: pointer;
        }

        .forgot {
            font-size: 0.8rem;
            font-weight: 600;
            color: #3347B0;
            text-decoration: none;
        }

        .forgot:hover {
            color: #263994;
        }

        .btn {
            width: 100%;
            padding: 0.85rem;
            border: none;
            border-radius: 0.7rem;
            font-size: 0.9rem;
            font-weight: 700;
            color: #fff;
            cursor: pointer;
            background: linear-gradient(135deg, #3347B0, #2B3DA0);
            transition: all 0.2s;
            font-family: 'Inter', sans-serif;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 0.4rem;
        }

        .btn:hover {
            background: linear-gradient(135deg, #2B3DA0, #263994);
            box-shadow: 0 6px 20px rgba(43, 61, 160, 0.35);
            transform: translateY(-1px);
        }

        .btn:active {
            transform: translateY(0);
        }

        .divider {
            border: none;
            border-top: 1px solid #e2e8f0;
            margin: 1.5rem 0;
        }

        .sw {
            text-align: center;
            font-size: 0.85rem;
            color: #64748b;
        }

        .sw a {
            color: #0f172a;
            font-weight: 700;
            text-decoration: none;
        }

        .sw a:hover {
            color: #3347B0;
        }

        .flash {
            padding: 0.7rem 1rem;
            border-radius: 0.7rem;
            font-size: 0.8rem;
            font-weight: 500;
            margin-bottom: 1.15rem;
            display: flex;
            align-items: center;
            gap: 0.4rem;
        }

        .flash-s {
            background: #ecfdf5;
            color: #065f46;
            border: 1px solid #a7f3d0;
        }

        .flash-d {
            background: #fef2f2;
            color: #991b1b;
            border: 1px solid #fecaca;
        }

        .flash-w {
            background: #fffbeb;
            color: #92400e;
            border: 1px solid #fde68a;
        }

        /* ======== FIXED FOOTER ======== */
        .auth-footer {
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 0.9rem 2.5rem;
            font-size: 0.7rem;
            color: #94a3b8;
            border-top: 1px solid #f1f5f9;
            background: #fff;
            flex-shrink: 0;
        }

        .footer-l {
            display: flex;
            align-items: center;
            gap: 0.75rem;
        }

        .footer-r {
            display: flex;
            gap: 1.25rem;
        }

        .auth-footer a {
            color: #64748b;
            text-decoration: none;
            font-weight: 500;
        }

        .auth-footer a:hover {
            color: #3347B0;
        }

        /* ======== MOBILE ======== */
        @media (max-width: 768px) {
            .auth-wrapper {
                flex-direction: column;
            }

            .auth-left {
                flex: none;
                min-height: 220px;
                padding: 1.5rem;
            }

            .hero-content h1 {
                font-size: 1.65rem;
            }

            .auth-right {
                padding: 1.5rem;
                overflow-y: auto;
            }

            .auth-footer {
                flex-direction: column;
                gap: 0.5rem;
                text-align: center;
                padding: 0.75rem 1rem;
            }

            .footer-l {
                display: none;
            }

            html,
            body {
                overflow: auto;
            }
        }
    </style>
</head>

<body>
    <div class="auth-wrapper">
        <!-- LEFT PANEL -->
        <div class="auth-left">
            <div class="brand-logo">
                <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                        d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
                </svg>
                <span>Layanan Kependudukan</span>
            </div>
            <div class="hero-content">
                <h1>Membangun Masa Depan Digital Indonesia</h1>
                <p>Akses layanan kependudukan secara mandiri, cepat, dan transparan. Dukcapil Mandiri hadir untuk
                    mempermudah urusan administrasi Anda.</p>
            </div>
            <div class="auth-left-footer">
                <span><svg width="13" height="13" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z" />
                    </svg>Terdaftar & Diawasi oleh Pemerintah</span>
                <div class="dot-sep"></div>
                <span><svg width="13" height="13" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                    </svg>Sistem Keamanan Terenkripsi</span>
            </div>
        </div>

        <!-- RIGHT PANEL -->
        <div class="auth-right">
            <div class="form-box">
                <h2>Selamat Datang Kembali</h2>
                <p class="sub">Silakan masuk ke akun Anda untuk melanjutkan akses layanan.</p>

                <?php if ($flash): ?>
                    <div
                        class="flash <?= $flash['type'] === 'success' ? 'flash-s' : ($flash['type'] === 'danger' ? 'flash-d' : 'flash-w') ?>">
                        <?= $flash['type'] === 'success' ? '✅' : ($flash['type'] === 'danger' ? '❌' : '⚠️') ?>
                        <?= htmlspecialchars($flash['message']) ?>
                    </div>
                <?php endif; ?>

                <form action="<?= baseUrl('app/Controllers/AuthController.php') ?>" method="POST">
                    <input type="hidden" name="action" value="login">

                    <div class="fg">
                        <label class="fl">NIK / Email</label>
                        <div class="iw">
                            <span class="ii"><svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                        d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                                </svg></span>
                            <input type="text" name="identifier" class="fi" placeholder="Masukkan NIK atau Email Anda"
                                required autocomplete="username">
                        </div>
                    </div>

                    <div class="fg">
                        <label class="fl">Kata Sandi</label>
                        <div class="iw">
                            <span class="ii"><svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                        d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                                </svg></span>
                            <input type="password" name="password" id="password" class="fi" placeholder="••••••••"
                                required autocomplete="current-password">
                            <button type="button" class="tp" onclick="togglePw()">
                                <svg id="eye" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                        d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                        d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                </svg>
                            </button>
                        </div>
                    </div>

                    <div class="row-between">
                        <div class="chk">
                            <input type="checkbox" id="rem" name="remember">
                            <label for="rem">Ingat Saya</label>
                        </div>
                        <a href="#" class="forgot">Lupa Kata Sandi?</a>
                    </div>

                    <button type="submit" class="btn">Masuk Ke Akun →</button>
                </form>

                <hr class="divider">
                <p class="sw">Belum punya akun? <a href="<?= baseUrl('register.php') ?>">Daftar Sekarang</a></p>
            </div>
        </div>
    </div>

    <!-- FIXED FOOTER -->
    <div class="auth-footer">
        <div class="footer-l">
            <span>Terdaftar & Diawasi oleh Pemerintah</span>
            <span style="color:#cbd5e1;">·</span>
            <span>Sistem Keamanan Terenkripsi</span>
        </div>
        <span>© <?= date('Y') ?> Portal Layanan Kependudukan Digital.</span>
        <div class="footer-r">
            <a href="#">Bantuan</a>
            <a href="#">Kebijakan Privasi</a>
            <a href="#">Syarat & Ketentuan</a>
        </div>
    </div>

    <script>
        function togglePw() { const i = document.getElementById('password'), e = document.getElementById('eye'); if (i.type === 'password') { i.type = 'text'; e.innerHTML = '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l3.59 3.59m0 0A9.953 9.953 0 0112 5c4.478 0 8.268 2.943 9.543 7a10.025 10.025 0 01-4.132 5.411m0 0L21 21" />'; } else { i.type = 'password'; e.innerHTML = '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" /><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />'; } }
    </script>
</body>
