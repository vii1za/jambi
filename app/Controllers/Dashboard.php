<?php

namespace App\Controllers;

use App\Models\KabupatenModel;
use App\Models\KecamatanModel;
use App\Models\SekolahModel;

class Dashboard extends BaseController
{
    public function index() //method index otomatis dipanggil oleh controller
    {
        $kabupaten = new KabupatenModel();

        $data['kabupaten'] = $kabupaten->find(1);
        $sekolah = new SekolahModel();
        $query = $sekolah->findAll();

        $lokasi = '';
        $label_lokasi = '';

        foreach ($query as $data_sekolah) {
            $lokasi .= '["' . $data_sekolah->npsn . '" , "' . $data_sekolah->nama_sekolah . '","' . $data_sekolah->
                alamat_sekolah . '","' . $data_sekolah->jenjang_pendidikan . '","' . $data_sekolah->status . '", ' . $data_sekolah->koordinat . '],';
        }

        $data['marker'] = $lokasi;
        echo view('dashboard', $data); //menampilkan file views/dashboard.php
    }
    public function getData()
    {
        $kecamatan = new KecamatanModel();
        $kode_kecamatan = $this->request->getGet('kode_kecamatan');
        $data = $kecamatan->find($kode_kecamatan);

        if (!empty($data)) {
            $hasil = '<tr><td width="45%">Kode Kecamatan</td><td>:</td><td>' . $data->kode_kecamatan . '</td></tr>' .
            '<tr><td>Nama Kecamatan</td><td>:</td><td>' . $data->nama_kecamatan . '</td></tr>' .
            '<tr><td>Jumlah Penduduk</td><td>:</td><td>' . number_format($data->jumlah_penduduk, 0, ',', '.') . ' Jiwa</td></tr>' .
            '<tr><td>Luas Wilayah</td><td>:</td><td>' . number_format($data->luas_wilayah, 0, ',', '.') . ' Km<sup>2</sup></td></tr>';
        } else {
            $hasil = '<tr><td class="text-center" colspan="3">DATA TIDAK ADA !</td></tr>';
        }

        $respon = ['hasil' => $hasil];

        return $this->response->setJSON($respon);
    }
}
