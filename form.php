<?php

declare(strict_types=1);

require_once __DIR__ . '/app/bootstrap.php';

$pageTitle = 'Form Pengajuan';
$data = \App\Models\PengajuanForm::loadPageContext();

partial('header');
partial('sidebar');
app_view('masyarakat/form_pengajuan', $data);
partial('footer');
