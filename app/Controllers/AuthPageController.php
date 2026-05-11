<?php

namespace App\Controllers;

/**
 * Halaman auth full-page (bukan POST ke AuthController).
 */
class AuthPageController
{
    public static function login(): void
    {
        redirectIfLoggedIn();
        $flash = getFlash();
        require BASE_PATH . '/app/Views/auth/login.php';
    }

    public static function register(): void
    {
        redirectIfLoggedIn();
        $flash = getFlash();
        require BASE_PATH . '/app/Views/auth/register.php';
    }
}
