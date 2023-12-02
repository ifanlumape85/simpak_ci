<?php
defined('BASEPATH') or exit('No direct script access allowed');
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

<head>
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
  <title>CATATAN KINERJA HARIAN</title>
  <style>
    body {
      font-size: 10px;
    }

    #tabel {
      font-size: 10px;
      font-family: Arial, Helvetica, sans-serif;
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
      <td width="100%" align="center"><strong>CATATAN KINERJA HARIAN</strong></td>
    </tr>
  </table>
  <p>&nbsp;</p>
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
  <p>&nbsp;</p>
  <table id="tabel" width="100%" border="1" align="center">
    <tr bgcolor="#CCCCCC">
      <td align="center"><strong>NO.</strong></td>
      <td align="center"><strong>HARI/TANGGAL</strong></td>
      <td align="center"><strong>URAIAN KERJA</strong></td>
      <td align="center"><strong>OUTPUT<br />(KEGIATAN/<br />DOKUMEN)</strong></td>
      <td align="center"><strong>JUMLAH<br />OUTPUT</strong></td>
      <td align="center"><strong>KETERANGAN<br />DESETUJUI/<br />TIDAK</strong></td>
    </tr>
    <tr>
      <td align="center">1</td>
      <td align="center">2</td>
      <td align="center">3</td>
      <td align="center">4</td>
      <td align="center">5</td>
      <td align="center">6</td>
    </tr>
    <?php
    $i = 0;
    $nomor = '';
    $tgl_kegiatan = '';
    $jml_output_bulan = 0;
    foreach ($kegiatan_harians as $kegiatan_harian) :

      if ($kegiatan_harian->tgl_kegiatan == $tgl_kegiatan) {
        $nomor = '';
        $tanggal_kegiatan = '';
      } else {
        $i++;
        $nomor = $i;
        $tgl_kegiatan = $kegiatan_harian->tgl_kegiatan;
        $tanggal_kegiatan = tgl_indonesia($tgl_kegiatan);
      }
      $kuantitas = $kegiatan_harian->kuantitas;
      $jml_output_bulan += $kuantitas;
    ?>
      <tr>
        <td align="center" valign="top"><?= $nomor ?></td>
        <td align="center" valign="top"><?= $tanggal_kegiatan ?></td>
        <td valign="top"><?= $kegiatan_harian->kegiatan ?></td>
        <td align="center" valign="top"><?= $kegiatan_harian->nama_jenis_kuantitas ?></td>
        <td align="center" valign="top"><?= $kuantitas ?></td>
        <td></td>
      </tr>
    <?php endforeach; ?>
    <tr>
      <td colspan="4" align="center">JUMLAH OUTPUT BULAN</td>
      <td align="center"><?= $jml_output_bulan ?></td>
      <td></td>
    </tr>
  </table>
  <table width="100%" align="center">
    <tr>
      <td align="center">Mengetahui</td>
      <td align="center">Lolak, <?= tgl_indonesia2(date('Y-m-d')) ?></td>
    </tr>
    <tr>
      <td align="center"><?= strtoupper($jabatan_atasan) ?></td>
      <td align="center">Yang bersangkutan</td>
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
      <td align="center"> <?= strtoupper($nip_atasan) ?></td>
      <td align="center"><?= strtoupper($nip) ?></td>
    </tr>
  </table>
</body>

</html>