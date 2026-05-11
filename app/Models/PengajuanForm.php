<?php

namespace App\Models;

/**
 * Loads form wizard context for multi-step pengajuan (KK / KTP / Pindah).
 */
class PengajuanForm
{
    /**
     * @return array<string, mixed>
     */
    public static function loadPageContext(): array
    {
        requireLogin();

        $db = getDB();
        $pengajuanId = intval($_GET['id'] ?? 0);
        $step = intval($_GET['step'] ?? 1);
        $maxSteps = 5;
        if ($step < 1 || $step > $maxSteps) {
            $step = 1;
        }

        $stmt = $db->prepare('SELECT * FROM pengajuan_layanan WHERE id = ? AND user_id = ?');
        $stmt->execute([$pengajuanId, $_SESSION['user_id']]);
        $pengajuan = $stmt->fetch();
        if (!$pengajuan) {
            header('Location: ' . baseUrl('layanan.php'));
            exit;
        }

        $user = currentUser();
        $jenis = $pengajuan['jenis_layanan'];
        $jenisLabels = ['kk' => 'Kartu Keluarga (KK)', 'ktp' => 'KTP-el', 'pindah' => 'Surat Pindah'];

        $dataKeluarga = null;
        $anggotaKeluarga = [];
        $dataPindah = null;
        $anggotaPindah = [];
        $dokumen = [];

        if ($jenis === 'kk') {
            $stmt = $db->prepare('SELECT * FROM data_keluarga WHERE pengajuan_id = ?');
            $stmt->execute([$pengajuanId]);
            $dataKeluarga = $stmt->fetch();
            if ($dataKeluarga) {
                $stmt = $db->prepare('SELECT * FROM anggota_keluarga WHERE data_keluarga_id = ?');
                $stmt->execute([$dataKeluarga['id']]);
                $anggotaKeluarga = $stmt->fetchAll();
            }
        } elseif ($jenis === 'pindah') {
            $stmt = $db->prepare('SELECT * FROM data_pindah WHERE pengajuan_id = ?');
            $stmt->execute([$pengajuanId]);
            $dataPindah = $stmt->fetch();
            if ($dataPindah) {
                $stmt = $db->prepare('SELECT * FROM anggota_pindah WHERE data_pindah_id = ?');
                $stmt->execute([$dataPindah['id']]);
                $anggotaPindah = $stmt->fetchAll();
            }
        }

        $stmt = $db->prepare('SELECT * FROM dokumen WHERE pengajuan_id = ?');
        $stmt->execute([$pengajuanId]);
        $dokumen = $stmt->fetchAll();

        if ($jenis === 'pindah') {
            $stepNames = ['Data Pribadi', 'Data Pindah', 'Keluarga Pindah', 'Unggah Dokumen', 'Review'];
        } else {
            $stepNames = ['Data Pribadi', 'Data ' . ($jenis === 'kk' ? 'Keluarga' : 'Layanan'), 'Detail Layanan', 'Unggah Dokumen', 'Review'];
        }

        return [
            'pengajuanId' => $pengajuanId,
            'step' => $step,
            'maxSteps' => $maxSteps,
            'pengajuan' => $pengajuan,
            'user' => $user,
            'jenis' => $jenis,
            'jenisLabels' => $jenisLabels,
            'dataKeluarga' => $dataKeluarga,
            'anggotaKeluarga' => $anggotaKeluarga,
            'dataPindah' => $dataPindah,
            'anggotaPindah' => $anggotaPindah,
            'dokumen' => $dokumen,
            'stepNames' => $stepNames,
        ];
    }
}
