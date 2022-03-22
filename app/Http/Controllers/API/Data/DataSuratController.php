<?php

namespace App\Http\Controllers\API\Data;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\SuratKeluar;
use App\Models\SuratMasuk;

class DataSuratController extends Controller
{
    public function __construct() {
        $this->SuratMasuk = new SuratMasuk();
        $this->SuratKeluar = new SuratKeluar();
    }

    public function show_list_surat_keluar_sedang_proses($id) {
        $data = SuratKeluar::where('desa_adat_id', $id)
                            ->where('status', ['Belum Dikirim', 'Menunggu Dikonfirmasi'])
                            ->get();
        $data_cek = SuratKeluar::where('desa_adat_id', $id)
                                ->where('status', ['Belum Dikirim', 'Menunggu Dikonfirmasi'])
                                ->first();
        if($data_cek == null) {
            return response()->json([
                'status' => 'Failed',
                'message' => 'Data Surat Tidak Ditemukan!'
            ], 501);
        }else{
            return response()->json($data, 200);
        }
    }

    public function show_list_surat_keluar_dikonfirmasi($id) {
        $data = SuratKeluar::where('desa_adat_id', $id)
                            ->where('status', 'Telah Dikonfirmasi')
                            ->get();
        $data_cek = SuratKeluar::where('desa_adat_id', $id)
                                ->where('status', 'Telah Dikonfirmasi')
                                ->first();
        if($data_cek == null) {
            return response()->json([
                'status' => 'Failed',
                'message' => 'Data Surat Tidak Ditemukan!'
            ], 501);
        }else{
            return response()->json($data, 200);
        }
    }

    public function show_list_surat_dibatalkan($id) {
        $data = SuratKeluar::where('desa_adat_id', $id)
                            ->where('status', 'Dibatalkan')
                            ->get();
        $data_cek = SuratKeluar::where('desa_adat_id', $id)
                                ->where('status', 'Dibatalkan')
                                ->first();
        if($data_cek == null) {
            return response()->json([
                'status' => 'Failed',
                'message' => 'Data Surat Tidak Ditemukan!'
            ], 501);
        }else{
            return response()->json($data, 200);
        }
    }

    public function show_list_surat_masuk_sedang_proses($id) {
        $data = SuratMasuk::where('desa_adat_id', $id)->get();
        $data_cek = SuratMasuk::where('desa_adat_id', $id)->first();
        if($data_cek == null) {
            return response()->json([
                'status' => 'Failed',
                'message' => 'Data Surat Tidak Ditemukan!'
            ], 501);
        }else{
            return response()->json($data, 200);
        }
    }
}