<?php

namespace App\Http\Controllers\API\Data;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\SuratKeluar;
use App\Models\SuratMasuk;
use App\Models\DesaAdat;
use App\Models\MasterSurat;
use App\Models\ValidasiPanitia;
use App\Models\Penduduk;
use App\Models\ValidasiPrajuruDesa;
use Carbon\Carbon;
use App\Models\PrajuruDesaAdat;

class DataSuratController extends Controller
{
    public function __construct() {
        $this->SuratMasuk = new SuratMasuk();
        $this->SuratKeluar = new SuratKeluar();
        $this->DesaAdat = new DesaAdat();
        $this->MasterSurat = new MasterSurat();
        $this->ValidasiPanitia = new ValidasiPanitia();
        $this->Penduduk = new Penduduk();
        $this->ValidasiPrajuruDesa = new ValidasiPrajuruDesa();
        $this->PrajuruDesaAdat = new PrajuruDesaAdat();
    }

    public function show_list_surat_keluar_menunggu($id) {
        Request()->validate([
            'desa_adat_id' => 'required'
        ]);
        $data = SuratKeluar::where('master_surat_id', $id)
                    ->where('desa_adat_id', Request()->desa_adat_id)
                    ->where('status', 'Menunggu Respons')
                    ->get();
        $data_cek = SuratKeluar::where('master_surat_id', $id)
                                ->where('desa_adat_id', Request()->desa_adat_id)
                                ->where('status', 'Menunggu Respons')
                                ->first();
        if($data_cek == null) {
            return response()->json([
                'status' => 'Failed',
                'message' => 'Data Surat Keluar Tidak Ditemukan!'
            ], 500);
        }else{
            return response()->json($data, 200);
        }
    }

    public function show_list_surat_keluar_sedang_direspons($id) {
        Request()->validate([
            'desa_adat_id' => 'required'
        ]);
        $data = SuratKeluar::where('master_surat_id', $id)
                            ->where('desa_adat_id', Request()->desa_adat_id)
                            ->where('status', 'Sedang Diproses')
                            ->get();
        $data_cek = SuratKeluar::where('master_surat_id', $id)
                                ->where('desa_adat_id', Request()->desa_adat_id)
                                ->where('status', 'Sedang Diproses')
                                ->first();
        if($data_cek == null) {
            return response()->json([
                'status' => 'Failed',
                'message' => 'Data Surat Keluar Tidak Ditemukan!'
            ], 500);
        }else{
            return response()->json($data, 200);
        }
    }

    public function show_list_surat_keluar_telah_dikonfirmasi($id) {
        Request()->validate([
            'desa_adat_id' => 'required'
        ]);
        $data = SuratKeluar::where('master_surat_id', $id)
                            ->where('desa_adat_id', Request()->desa_adat_id)
                            ->where('status', 'Telah Dikonfirmasi')
                            ->get();
        $data_cek = SuratKeluar::where('master_surat_id', $id)
                            ->where('desa_adat_id', Request()->desa_adat_id)
                            ->where('status', 'Telah Dikonfirmasi')
                            ->first();
        if($data_cek == null) {
            return response()->json([
                'status' => 'Failed',
                'message' => 'Data Surat Keluar Tidak Ditemukan!'
            ], 500);
        }else{
            return response()->json($data, 200);
        }
    }

    public function show_list_surat_keluar_dibatalkan($id) {
        Request()->validate([
            'desa_adat_id' => 'required'
        ]);
        $data = SuratKeluar::where('master_surat_id', $id)
                            ->where('desa_adat_id', Request()->desa_adat_id)
                            ->where('status', 'Telah Dikonfirmasi')
                            ->get();
        $data_cek = SuratKeluar::where('master_surat_id', $id)
                            ->where('desa_adat_id', Request()->desa_adat_id)
                            ->where('status', 'Telah Dikonfirmasi')
                            ->first();
        if($data_cek == null) {
            return response()->json([
                'status' => 'Failed',
                'message' => 'Data Surat Keluar Tidak Ditemukan!'
            ], 500);
        }else{
            return response()->json($data, 200);
        }
    }

    public function up_surat_keluar(Request $request) {
        $surat_keluar = new SuratKeluar();
        $validasi_panitia = new ValidasiPanitia();
        $validasi_prajuru = new ValidasiPrajuruDesa();
        $kode_desa = DesaAdat::select('desadat_kode_surat')->where('desa_adat_id', $request->desa_adat_id)->first();
        $bulan_romawi = array("", "I", "II", "III", "IV", "V", "VII", "VIII", "IX", "X", "XI", "XII");
        $nomor_surat = SuratKeluar::max('surat_keluar_id');
        $nomor = 1;
        $master_surat = MasterSurat::where('master_surat_id', $request->master_surat_id)->first();
        $master_surat_decode = json_decode($master_surat);
        $kode_surat = json_decode($kode_desa);
        $tanggal_sekarang = Carbon::now()->toDateTimeString();
        if($kode_surat->desadat_kode_surat == "") {
            return response()->json([
                'status' => 'Failed',
                'message' => 'Kode Desa Tidak Ditemukan!'
            ], 500);
        }else{
            if($nomor_surat) {
                $kode_surat_keluar = sprintf("%03s", abs($nomor_surat + 1)).'/'.$master_surat_decode->kode_nomor_surat.'-'.$kode_surat->desadat_kode_surat.'/'.$bulan_romawi[date('n')].'/'.date('Y');
            }else{
                $kode_surat_keluar = sprintf("%03s", $nomor).'/'.$master_surat_decode->kode_nomor_surat.'-'.$kode_surat->desadat_kode_surat.'/'.$bulan_romawi[date('n')].'/'.date('Y');
            }
            $surat_keluar->master_surat_id = $request->master_surat_id;
            $surat_keluar->desa_adat_id = $request->desa_adat_id;
            $surat_keluar->lepihan = $request->lepihan;
            $surat_keluar->parindikan = $request->parindikan;
            $surat_keluar->pemahbah_surat = $request->pemahbah_surat;
            $surat_keluar->daging_surat = $request->daging_surat ? : NULL;
            $surat_keluar->pamuput_surat = $request->pamuput_surat ? : NULL;
            $surat_keluar->tanggal_kegiatan = $request->tanggal_kegiatan ? : NULL;
            $surat_keluar->busana = $request->busana ? : NULL;
            $surat_keluar->tempat_kegiatan = $request->tempat_kegiatan ? : NULL;
            $surat_keluar->waktu_kegiatan = $request->waktu_kegiatan ? : NULL;
            $surat_keluar->tim_kegiatan = $request->tim_kegiatan ? : NULL;
            $surat_keluar->pihak_penerima = $request->pihak_penerima;
            $surat_keluar->lampiran = $request->lampiran ? : NULL;  
            $surat_keluar->nomor_surat = $kode_surat_keluar;
            $surat_keluar->status = "Menunggu Respons";
            $surat_keluar->tanggal_surat = $tanggal_sekarang;
            $surat_keluar->save();
            $last_surat_keluar_id = $surat_keluar->id;
            if($request->master_surat_id == "1") {
                $bendesa_krama_mipil_id = Penduduk::select('tb_krama_mipil.krama_mipil_id')
                                                    ->join('tb_cacah_krama_mipil', 'tb_cacah_krama_mipil.penduduk_id', '=', 'tb_penduduk.penduduk_id')
                                                    ->join('tb_krama_mipil', 'tb_cacah_krama_mipil.cacah_krama_mipil_id', '=', 'tb_krama_mipil.cacah_krama_mipil_id')
                                                    ->where('tb_penduduk.nama', $request->nama_bendesa)
                                                    ->first();
                $bendesa_decode = json_decode($bendesa_krama_mipil_id);
                $validasi_array = array($request->krama_mipil_ketua_id, $request->krama_mipil_sekretaris_id);
                for($i = 0;$i < 2; $i++) {
                    $data = [
                        'krama_mipil_id' => $validasi_array[$i],
                        'surat_keluar_id' => $last_surat_keluar_id
                    ];
                    $validasi_panitia->TambahDataValidasiPanitia($data);
                }
                $data_krama_mipil_bendesa = PrajuruDesaAdat::select('prajuru_desa_adat_id')->where('krama_mipil_id', $bendesa_decode->krama_mipil_id)->first();
                $bendesa_krama_decode = json_decode($data_krama_mipil_bendesa);
                $validasi_prajuru->prajuru_desa_adat_id = $bendesa_krama_decode->prajuru_desa_adat_id;
                $validasi_prajuru->surat_keluar_id = $last_surat_keluar_id;
                $validasi_prajuru->save();
                return response()->json([
                    'status' => 'OK',
                    'message' => 'Data Surat Keluar Berhasil Disimpan!'
                ], 200);
            }else{
                $data_krama_mipil_bendesa = PrajuruDesaAdat::select('prajuru_desa_adat_id')->where('krama_mipil_id', $bendesa_decode->krama_mipil_id)->first();
                $bendesa_krama_decode = json_decode($data_krama_mipil_bendesa);
                $validasi_prajuru->prajuru_desa_adat_id = $bendesa_krama_decode->prajuru_desa_adat_id;
                $validasi_prajuru->surat_keluar_id = $last_surat_keluar_id;
                $validasi_prajuru->save();
            }
        }
    }
}