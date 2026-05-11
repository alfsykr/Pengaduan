<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar Akun - Layanan Kependudukan Digital</title>
    <meta name="description" content="Buat akun baru untuk mengakses layanan kependudukan digital.">
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
            flex: 0 0 42%;
            position: relative;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
            padding: 2rem 2.5rem;
            overflow: hidden;
        }

        .auth-left::before {
            content: '';
            position: absolute;
            inset: 0;
            background: url('<?= baseUrl('img/sistem-pemerintahan-indonesia.jpg') ?>') center/cover no-repeat;
            z-index: 0;
        }

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
            max-width: 380px;
        }

        .hero-content h1 {
            font-size: 2.25rem;
            font-weight: 800;
            color: #fff;
            line-height: 1.15;
            letter-spacing: -1.2px;
            margin-bottom: 0.85rem;
        }

        .hero-content p {
            font-size: 0.875rem;
            color: rgba(255, 255, 255, 0.7);
            line-height: 1.7;
        }

        .features {
            margin-top: 1.25rem;
            display: flex;
            flex-direction: column;
            gap: 0.6rem;
        }

        .feat {
            display: flex;
            align-items: center;
            gap: 0.6rem;
            color: rgba(255, 255, 255, 0.8);
            font-size: 0.8rem;
        }

        .feat-i {
            width: 28px;
            height: 28px;
            border-radius: 6px;
            background: rgba(255, 255, 255, 0.12);
            display: flex;
            align-items: center;
            justify-content: center;
            flex-shrink: 0;
            font-size: 0.85rem;
        }

        .auth-left-footer {
            display: flex;
            align-items: center;
            gap: 1rem;
            font-size: 0.68rem;
            color: rgba(255, 255, 255, 0.45);
        }

        .auth-left-footer span {
            display: flex;
            align-items: center;
            gap: 0.3rem;
        }

        /* ======== RIGHT PANEL ======== */
        .auth-right {
            flex: 1;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            padding: 1.5rem 3rem;
            background: #fff;
            overflow-y: auto;
        }

        .form-box {
            width: 100%;
            max-width: 480px;
        }

        .form-box h2 {
            font-size: 1.5rem;
            font-weight: 800;
            color: #0f172a;
            letter-spacing: -0.4px;
            margin-bottom: 0.35rem;
        }

        .form-box .sub {
            font-size: 0.8rem;
            color: #64748b;
            line-height: 1.5;
            margin-bottom: 1.25rem;
        }

        .fg {
            margin-bottom: 0.85rem;
        }

        .fl {
            display: block;
            font-size: 0.75rem;
            font-weight: 600;
            color: #334155;
            margin-bottom: 0.3rem;
        }

        .req {
            color: #ef4444;
        }

        .iw {
            position: relative;
            display: flex;
            align-items: center;
        }

        .ii {
            position: absolute;
            left: 0.85rem;
            color: #94a3b8;
            display: flex;
            z-index: 2;
        }

        .ii svg {
            width: 16px;
            height: 16px;
        }

        .fi {
            width: 100%;
            padding: 0.7rem 0.85rem 0.7rem 2.4rem;
            border: 1.5px solid #e2e8f0;
            border-radius: 0.6rem;
            font-size: 0.8rem;
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

        .fi-ni {
            padding-left: 0.85rem;
        }

        .row2 {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 0.6rem;
        }

        .sel {
            width: 100%;
            padding: 0.7rem 0.85rem;
            border: 1.5px solid #e2e8f0;
            border-radius: 0.6rem;
            font-size: 0.8rem;
            color: #1e293b;
            background: #f8fafc;
            outline: none;
            font-family: 'Inter', sans-serif;
            cursor: pointer;
            appearance: none;
            background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='10' height='10' fill='%2394a3b8' viewBox='0 0 16 16'%3E%3Cpath d='M8 11L3 6h10l-5 5z'/%3E%3C/svg%3E");
            background-repeat: no-repeat;
            background-position: right 0.85rem center;
        }

        .sel:focus {
            border-color: #3347B0;
            background-color: #fff;
            box-shadow: 0 0 0 3px rgba(51, 71, 176, 0.1);
        }

        .tp {
            position: absolute;
            right: 0.85rem;
            cursor: pointer;
            background: none;
            border: none;
            color: #94a3b8;
            display: flex;
            padding: 0.15rem;
            z-index: 2;
        }

        .tp:hover {
            color: #475569;
        }

        .tp svg {
            width: 16px;
            height: 16px;
        }

        .btn {
            width: 100%;
            padding: 0.75rem;
            border: none;
            border-radius: 0.6rem;
            font-size: 0.85rem;
            font-weight: 700;
            color: #fff;
            cursor: pointer;
            background: linear-gradient(135deg, #3347B0, #2B3DA0);
            transition: all 0.2s;
            font-family: 'Inter', sans-serif;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 0.35rem;
            margin-top: 0.35rem;
        }

        .btn:hover {
            background: linear-gradient(135deg, #2B3DA0, #263994);
            box-shadow: 0 6px 20px rgba(43, 61, 160, 0.35);
            transform: translateY(-1px);
        }

        .terms {
            font-size: 0.68rem;
            color: #94a3b8;
            text-align: center;
            margin-top: 0.75rem;
            line-height: 1.5;
        }

        .terms a {
            color: #3347B0;
            text-decoration: none;
            font-weight: 500;
        }

        .divider {
            border: none;
            border-top: 1px solid #e2e8f0;
            margin: 1rem 0;
        }

        .sw {
            text-align: center;
            font-size: 0.8rem;
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
            padding: 0.6rem 0.85rem;
            border-radius: 0.6rem;
            font-size: 0.75rem;
            font-weight: 500;
            margin-bottom: 1rem;
            display: flex;
            align-items: center;
            gap: 0.35rem;
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

        /* ======== FIXED FOOTER ======== */
        .auth-footer {
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 0.75rem 2.5rem;
            font-size: 0.68rem;
            color: #94a3b8;
            border-top: 1px solid #f1f5f9;
            background: #fff;
            flex-shrink: 0;
        }

        .auth-footer a {
            color: #64748b;
            text-decoration: none;
            font-weight: 500;
        }

        .auth-footer a:hover {
            color: #3347B0;
        }

        .footer-r {
            display: flex;
            gap: 1.25rem;
        }

        @media (max-width: 768px) {
            .auth-wrapper {
                flex-direction: column;
            }

            .auth-left {
                flex: none;
                min-height: 180px;
                padding: 1.25rem;
            }

            .hero-content h1 {
                font-size: 1.35rem;
            }

            .features {
                display: none;
            }

            .auth-right {
                padding: 1.25rem;
                overflow-y: auto;
            }

            .row2 {
                grid-template-columns: 1fr;
            }

            .auth-footer {
                flex-direction: column;
                gap: 0.35rem;
                text-align: center;
                padding: 0.6rem 1rem;
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
                <h1>Bergabung dengan Layanan Digital</h1>
                <p>Buat akun untuk mengakses semua layanan kependudukan secara online.</p>
                <div class="features">
                    <div class="feat">
                        <div class="feat-i">📋</div>KTP, KK, Surat Pindah dalam satu portal
                    </div>
                    <div class="feat">
                        <div class="feat-i">⚡</div>Proses cepat & status real-time
                    </div>
                    <div class="feat">
                        <div class="feat-i">🔒</div>Data aman & terenkripsi
                    </div>
                </div>
            </div>
            <div class="auth-left-footer">
                <span><svg width="12" height="12" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z" />
                    </svg>Terdaftar & Diawasi oleh Pemerintah</span>
                <span style="color:rgba(255,255,255,.3)">·</span>
                <span><svg width="12" height="12" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                    </svg>Sistem Keamanan Terenkripsi</span>
            </div>
        </div>

        <!-- RIGHT PANEL -->
        <div class="auth-right">
            <div class="form-box">
                <h2>Buat Akun Baru</h2>
                <p class="sub">Lengkapi data berikut untuk mendaftarkan akun Anda.</p>

                <?php if ($flash): ?>
                    <div class="flash <?= $flash['type'] === 'success' ? 'flash-s' : 'flash-d' ?>">
                        <?= $flash['type'] === 'success' ? '✅' : '❌' ?>
                        <?= htmlspecialchars($flash['message']) ?>
                    </div>
                <?php endif; ?>

                <form action="<?= baseUrl('app/Controllers/AuthController.php') ?>" method="POST">
                    <input type="hidden" name="action" value="register">

                    <div class="fg">
                        <label class="fl">Nama Lengkap <span class="req">*</span></label>
                        <div class="iw">
                            <span class="ii"><svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                        d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                                </svg></span>
                            <input type="text" name="nama_lengkap" class="fi" placeholder="Sesuai KTP" required>
                        </div>
                    </div>

                    <div class="fg">
                        <label class="fl">NIK (16 Digit) <span class="req">*</span></label>
                        <div class="iw">
                            <span class="ii"><svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                        d="M10 6H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V8a2 2 0 00-2-2h-5m-4 0V5a2 2 0 114 0v1m-4 0a2 2 0 104 0m-5 8a2 2 0 100-4 2 2 0 000 4zm0 0c1.306 0 2.417.835 2.83 2M9 14a3.001 3.001 0 00-2.83 2M15 11h3m-3 4h2" />
                                </svg></span>
                            <input type="text" name="nik" class="fi" placeholder="3201XXXXXXXXXXXX" maxlength="16"
                                required style="letter-spacing:1px;">
                        </div>
                    </div>

                    <div class="row2">
                        <div class="fg">
                            <label class="fl">Email <span class="req">*</span></label>
                            <div class="iw">
                                <span class="ii"><svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                            d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                                    </svg></span>
                                <input type="email" name="email" class="fi" placeholder="nama@email.com" required>
                            </div>
                        </div>
                        <div class="fg">
                            <label class="fl">No. HP</label>
                            <div class="iw">
                                <span class="ii"><svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                            d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z" />
                                    </svg></span>
                                <input type="text" name="no_hp" class="fi" placeholder="08XXXXXXXXXX">
                            </div>
                        </div>
                    </div>

                    <div class="row2">
                        <div class="fg">
                            <label class="fl">Tempat Lahir</label>
                            <input type="text" name="tempat_lahir" class="fi fi-ni" placeholder="Jakarta">
                        </div>
                        <div class="fg">
                            <label class="fl">Tanggal Lahir</label>
                            <input type="date" name="tanggal_lahir" class="fi fi-ni">
                        </div>
                    </div>

                    <div class="fg">
                        <label class="fl">Jenis Kelamin</label>
                        <select name="jenis_kelamin" class="sel">
                            <option value="">-- Pilih --</option>
                            <option value="L">Laki-laki</option>
                            <option value="P">Perempuan</option>
                        </select>
                    </div>

                    <div class="row2">
                        <div class="fg">
                            <label class="fl">Kata Sandi <span class="req">*</span></label>
                            <div class="iw">
                                <span class="ii"><svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                            d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                                    </svg></span>
                                <input type="password" name="password" id="pw" class="fi" placeholder="Min. 6 karakter"
                                    required minlength="6">
                                <button type="button" class="tp" onclick="t('pw')"><svg fill="none"
                                        stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                            d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                            d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                    </svg></button>
                            </div>
                        </div>
                        <div class="fg">
                            <label class="fl">Konfirmasi <span class="req">*</span></label>
                            <div class="iw">
                                <span class="ii"><svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                            d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z" />
                                    </svg></span>
                                <input type="password" name="confirm_password" id="cpw" class="fi"
                                    placeholder="Ulangi sandi" required>
                            </div>
                        </div>
                    </div>

                    <button type="submit" class="btn">Daftar Akun →</button>
                    <p class="terms">Dengan mendaftar, Anda menyetujui <a href="#">Syarat & Ketentuan</a> serta <a
                            href="#">Kebijakan Privasi</a> kami.</p>
                </form>

                <hr class="divider">
                <p class="sw">Sudah punya akun? <a href="<?= baseUrl('login.php') ?>">Masuk Sekarang</a></p>
            </div>
        </div>
    </div>

    <!-- FIXED FOOTER -->
    <div class="auth-footer">
        <span>© <?= date('Y') ?> Portal Layanan Kependudukan Digital.</span>
        <div class="footer-r">
            <a href="#">Bantuan</a>
            <a href="#">Kebijakan Privasi</a>
            <a href="#">Syarat & Ketentuan</a>
        </div>
    </div>

    <script>function t(id) { const i = document.getElementById(id); i.type = i.type === 'password' ? 'text' : 'password'; }</script>
</body>

</html>
