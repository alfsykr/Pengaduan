# Web Pengaduan

Aplikasi layanan pengaduan/permohonan berbasis PHP dengan frontend SB Admin.

## Prasyarat

- PHP 8.x (disarankan lewat Laragon/XAMPP)
- MySQL / MariaDB
- Node.js dan npm

## Cara Menjalankan Setelah Clone

1. Clone repository:
   ```bash
   git clone https://github.com/USERNAME/NAMA_REPO.git
   cd NAMA_REPO
   ```

2. Install dependency frontend:
   ```bash
   npm install
   ```

3. Generate library statis ke folder `vendor/` (karena `vendor/` tidak di-push):
   ```bash
   npx gulp vendor
   ```

4. (Opsional) Build asset lain:
   ```bash
   npx gulp
   ```

5. Import database:
   - Buat database baru (misal: `web_pengaduan`).
   - Import file SQL yang tersedia di folder `database/` sesuai kebutuhan project.

6. Atur koneksi database di:
   - `config/database.php`

7. Jalankan project di web server lokal:
   - Letakkan project di folder web server (contoh Laragon: `www/`).
   - Akses dari browser, contoh:
     - `http://localhost/web_pengaduan/login.php`

## Catatan Penting

- Folder `vendor/`, `bootstrap/`, dan `node_modules/` diabaikan oleh Git (`.gitignore`), jadi wajib digenerate ulang setelah clone.
- Jika tampilan berantakan atau asset tidak terbaca, jalankan ulang:
  ```bash
  npx gulp vendor
  ```

## Perintah Development

- Jalankan watcher:
  ```bash
  npm start
  ```
- Build CSS/JS:
  ```bash
  npx gulp
  ```
