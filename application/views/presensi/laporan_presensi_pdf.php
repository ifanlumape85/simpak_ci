<?php
defined('BASEPATH') or exit('No direct script access allowed');
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>CATATAN PRESENSI HARIAN</title>
    <style>
        body {
            font-size: 10px;
            /* font-family: Arial, Helvetica, sans-serif; */
        }

        #tabel {
            font-family: "Trebuchet MS", Arial, Helvetica, sans-serif;
            border-collapse: collapse;
            width: 100%;
        }

        #tabel td,
        #tabel th {
            border: 1px solid;
            padding: 8px;
        }

        #tabel th {
            padding-top: 12px;
            padding-bottom: 12px;
            text-align: left;
            color: white;
        }
    </style>
</head>

<body>
    <table width="100%" align="center">
        <tr>
            <td width="100%" align="center"><strong>CATATAN PRESENSI HARIAN</strong></td>
        </tr>
    </table>
    <table>
        <tr>
            <td>NAMA</td>
            <td>:</td>
            <td>&nbsp;<?= strtoupper($nama_pegawai) ?></td>
        </tr>
        <tr>
            <td>NIP</td>
            <td>:</td>
            <td>&nbsp;<?= strtoupper($nip) ?></td>
        </tr>
        <tr>
            <td>JABATAN</td>
            <td>:</td>
            <td>&nbsp;<?= strtoupper($nama_jabatan) ?></td>
        </tr>
        <tr>
            <td>UNIT KERJA</td>
            <td>:</td>
            <td>&nbsp;<?= strtoupper($nama_instansi) ?></td>
        </tr>
        <tr>
            <td>BULAN</td>
            <td>:</td>
            <td>&nbsp;<?= strtoupper($tahun_anggaran) ?></td>
        </tr>
    </table>
    <table id="tabel" width="100%" border="1" align="center">
        <tr bgcolor="#CCCCCC">
            <td align="center"><strong>NO.</strong></td>
            <td align="center"><strong>HARI/TANGGAL</strong></td>
            <td align="center"><strong>JAM</strong></td>
            <td align="center"><strong>PRESENSI</strong></td>
        </tr>
        <?php
        $i = 0;
        $nomor = '';
        $tgl_presensi = '';
        foreach ($presensis as $presensi) :

            if ($presensi->tgl_presensi == $tgl_presensi) {
                $nomor = '';
                $tanggal_presensi = '';
            } else {
                $i++;
                $nomor = $i;
                $tgl_presensi = $presensi->tgl_presensi;
                $tanggal_presensi = tgl_indonesia($tgl_presensi);
            }
        ?>
            <tr>
                <td><?= $nomor ?></td>
                <td><?= $tanggal_presensi ?></td>
                <td><?= $presensi->jam_presensi ?></td>
                <td><?= $presensi->nama_jenis_presensi ?></td>
            </tr>

        <?php endforeach; ?>
    </table>
    <table width="100%" align="center">
        <tr>
            <td align="center">Mengetahui Atasan Langusng</td>
            <td align="center">Lolak, <?= tgl_indonesia2(date('Y-m-d')) ?></td>
        </tr>
        <tr>
            <td align="center"><?= strtoupper($jabatan_atasan) ?></td>
            <td align="center">Yang Membuat Laporan</td>
        </tr>
        <tr>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
        </tr>
        <tr>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
        </tr>
        <tr>
            <td align="center"><strong><u><?= strtoupper($nama_atasan) ?></u></strong></td>
            <td align="center"><strong><u><?= strtoupper($nama_pegawai) ?></u></strong></td>
        </tr>
        <tr>
            <td align="center">NIP. <?= strtoupper($nip_atasan) ?></td>
            <td align="center"><?= strtoupper($nip) ?></td>
        </tr>
    </table>
</body>

</html>