<?php
/**
 * Application bootstrap – base path, autoload, and shared config.
 * Require this once at the top of entry scripts (public/*.php or controllers/*.php shims).
 */
declare(strict_types=1);

if (!defined('BASE_PATH')) {
    define('BASE_PATH', dirname(__DIR__));
}

require_once BASE_PATH . '/config/auth.php';

spl_autoload_register(static function (string $class): void {
    $prefix = 'App\\';
    if (strncmp($class, $prefix, strlen($prefix)) !== 0) {
        return;
    }
    $relative = substr($class, strlen($prefix));
    $path = BASE_PATH . '/app/' . str_replace('\\', DIRECTORY_SEPARATOR, $relative) . '.php';
    if (is_file($path)) {
        require_once $path;
    }
});

/**
 * Render a view file under app/Views/ (e.g. masyarakat/form_pengajuan).
 */
function app_view(string $relativePath, array $data = []): void
{
    extract($data, EXTR_SKIP);
    $full = BASE_PATH . '/app/Views/' . $relativePath . '.php';
    if (!is_file($full)) {
        throw new RuntimeException('View not found: ' . $relativePath);
    }
    require $full;
}

/**
 * Include a layout partial from app/Views/partials/.
 */
function partial(string $name): void
{
    $full = BASE_PATH . '/app/Views/partials/' . $name . '.php';
    if (!is_file($full)) {
        throw new RuntimeException('Partial not found: ' . $name);
    }
    require $full;
}

/**
 * Nilai untuk form KK: isi dari draft pengajuan jika ada; jika kosong/null gunakan kolom profil (Data Diri).
 *
 * @param array|null $draftRow Baris data_keluarga atau null
 * @param array<string, mixed> $user Baris user dari session / DB
 * @param string $draftField Nama kolom di data_keluarga
 * @param string|null $userField Kolom users (default sama dengan $draftField)
 * @param string|null $altUserField Fallback kedua (mis. nama_lengkap untuk kepala keluarga)
 */
function formValueFromDraftOrUser(?array $draftRow, array $user, string $draftField, ?string $userField = null, ?string $altUserField = null): string
{
    $draft = $draftRow !== null ? trim((string) ($draftRow[$draftField] ?? '')) : '';
    if ($draft !== '') {
        return $draft;
    }
    $uk = $userField ?? $draftField;
    $fromUser = trim((string) ($user[$uk] ?? ''));
    if ($fromUser !== '') {
        return $fromUser;
    }
    if ($altUserField !== null) {
        return trim((string) ($user[$altUserField] ?? ''));
    }

    return '';
}

/**
 * Avatar lingkaran: foto unggahan jika ada, atau inisial berwarna (untuk tabel admin / detail).
 *
 * @param array<string, mixed> $row Minimal: id?, nama_lengkap, avatar?
 */
function htmlUserAvatarRing(array $row, string $sizeClass = 'w-8 h-8', string $textClass = 'text-xs'): string
{
    $nama = trim((string) ($row['nama_lengkap'] ?? ''));
    $avatar = trim((string) ($row['avatar'] ?? ''));
    $uid = (int) ($row['id'] ?? 0);

    if ($avatar !== '') {
        $src = baseUrl('uploads/avatars/' . rawurlencode($avatar));

        return '<span class="' . htmlspecialchars($sizeClass) . ' rounded-full overflow-hidden border border-slate-200 bg-slate-100 flex-shrink-0 shadow-sm ring-1 ring-slate-100/80 inline-flex"><img src="' . htmlspecialchars($src) . '" alt="" class="w-full h-full object-cover" loading="lazy" decoding="async"></span>';
    }

    $_parts = array_slice(preg_split('/\s+/', $nama) ?: [], 0, 2);
    $initials = '';
    foreach ($_parts as $_w) {
        if ($_w !== '') {
            $initials .= strtoupper(substr($_w, 0, 1));
        }
    }
    if ($initials === '') {
        $initials = '?';
    }
    $colors = ['bg-blue-500', 'bg-emerald-500', 'bg-violet-500', 'bg-amber-500', 'bg-rose-500', 'bg-cyan-500'];
    $color = $colors[$uid > 0 ? ($uid % count($colors)) : (abs(crc32($nama)) % count($colors))];

    return '<span class="' . htmlspecialchars($sizeClass) . ' rounded-full ' . $color . ' flex items-center justify-center text-white ' . htmlspecialchars($textClass) . ' font-bold flex-shrink-0">' . htmlspecialchars($initials) . '</span>';
}

/** Escape tampilan field profil (kosong → "-"). */
function displayField($value): string
{
    $v = is_string($value) ? trim($value) : $value;
    if ($v === null) {
        return '-';
    }
    if (is_string($v) && $v === '') {
        return '-';
    }
    return htmlspecialchars((string) $v);
}
