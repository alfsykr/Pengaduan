<?php

namespace App\Controllers;

class LayananController
{
    public static function index(): void
    {
        requireCitizen();
        $pageTitle = 'Layanan';
        partial('header');
        partial('sidebar');
        app_view('masyarakat/layanan', []);
        partial('footer');
    }
}
