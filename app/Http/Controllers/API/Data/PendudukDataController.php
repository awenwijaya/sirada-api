<?php

namespace App\Http\Controllers\API\Data;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Penduduk;

class PendudukDataController extends Controller
{
    public function __construct() {
        $this->Penduduk = new Penduduk();
    }

    public function show_penduduk_by_desa_id($id) {
        $data = Penduduk::select('tb_penduduk.nik', 'tb_penduduk.nama', 'tb_krama_mipil.krama_mipil_id', 'tb_penduduk.penduduk_id')
                        ->join('tb_cacah_krama_mipil', 'tb_cacah_krama_mipil.penduduk_id', '=', 'tb_penduduk.penduduk_id')
                        ->join('tb_krama_mipil', 'tb_cacah_krama_mipil.cacah_krama_mipil_id', '=', 'tb_krama_mipil.cacah_krama_mipil_id')
                        ->join('tb_m_banjar_adat', 'tb_krama_mipil.banjar_adat_id', '=', 'tb_m_banjar_adat.banjar_adat_id')
                        ->where('tb_m_banjar_adat.desa_adat_id', $id)
                        ->get();
        return response()->json($data, 200);
    }

    public function show_penduduk_by_banjar_id($id) {
        $data = Penduduk::select('tb_penduduk.nik', 'tb_penduduk.nama', 'tb_krama_mipil.krama_mipil_id', 'tb_penduduk.penduduk_id')
                        ->join('tb_cacah_krama_mipil', 'tb_cacah_krama_mipil.penduduk_id', '=', 'tb_penduduk.penduduk_id')
                        ->join('tb_krama_mipil', 'tb_cacah_krama_mipil.cacah_krama_mipil_id', '=', 'tb_krama_mipil.cacah_krama_mipil_id')
                        ->join('tb_m_banjar_adat', 'tb_krama_mipil.banjar_adat_id', '=', 'tb_m_banjar_adat.banjar_adat_id')
                        ->where('tb_m_banjar_adat.banjar_adat_id', $id)
                        ->get();
        return response()->json($data, 200);
    }
}
