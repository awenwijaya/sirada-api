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
use PDF;

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
                            ->where('status', 'Dibatalkan')
                            ->get();
        $data_cek = SuratKeluar::where('master_surat_id', $id)
                            ->where('desa_adat_id', Request()->desa_adat_id)
                            ->where('status', 'Dibatalkan')
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
            $surat_keluar->tanggal_mulai = $request->tanggal_mulai ? : NULL;
            $surat_keluar->tanggal_selesai = $request->tanggal_selesai ? : NULL;
            $surat_keluar->busana = $request->busana ? : NULL;
            $surat_keluar->tempat_kegiatan = $request->tempat_kegiatan ? : NULL;
            $surat_keluar->waktu_mulai = $request->waktu_mulai ? : NULL;
            $surat_keluar->waktu_selesai = $request->waktu_selesai ? : NULL;
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
                $data_ketua_panitia = [
                    'krama_mipil_id' => $request->krama_mipil_ketua_id,
                    'surat_keluar_id' => $last_surat_keluar_id,
                    'jabatan' => 'Ketua Panitia'
                ];
                $validasi_panitia->TambahDataValidasiPanitia($data_ketua_panitia);
                $data_sekretaris_panitia = [
                    'krama_mipil_id' => $request->krama_mipil_sekretaris_id,
                    'surat_keluar_id' => $last_surat_keluar_id,
                    'jabatan' => 'Sekretaris Panitia'
                ];
                $validasi_panitia->TambahDataValidasiPanitia($data_sekretaris_panitia);
                $bendesa_decode = json_decode($bendesa_krama_mipil_id);
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

    public function show_detail_surat_keluar($id) {
        $data = SuratKeluar::where('surat_keluar_id', $id)->first();
        return response()->json($data, 200);
    }

    public function show_surat_keluar($id) {
        $data = SuratKeluar::join('tb_m_desa_adat', 'tb_surat_keluar.desa_adat_id', '=', 'tb_m_desa_adat.desa_adat_id')
                            ->join('tb_m_kecamatan', 'tb_m_desa_adat.kecamatan_id', '=', 'tb_m_kecamatan.kecamatan_id')
                            ->join('tb_m_kabupaten', 'tb_m_kecamatan.kabupaten_id', '=', 'tb_m_kabupaten.kabupaten_id')
                            ->where('tb_surat_keluar.surat_keluar_id', $id)
                            ->first();
        return response()->json($data, 200);
    }

    public function show_nomor_surat_data($id) {
        $kode_desa = DesaAdat::select('desadat_kode_surat')->where('desa_adat_id', $id)->first();
        $bulan_romawi = array("", "I", "II", "III", "IV", "V", "VII", "VIII", "IX", "X", "XI", "XII");
        $nomor_surat_id = SuratKeluar::max('surat_keluar_id');
        $nomor = 1;
        $kode_surat = json_decode($kode_desa);
        if($nomor_surat_id) {
            $nomor_surat = sprintf("%03s", abs($nomor_surat_id + 1));
        }else{
            $nomor_surat = sprintf("%03s", $nomor);
        }
        $data = [
            'nomor_urut_surat' => $nomor_surat,
            'kode_desa' => $kode_surat->desadat_kode_surat,
            'bulan' => $bulan_romawi[date('n')],
            'tahun' => date('Y')
        ];
        return response()->json($data, 200);
    }

    public function show_kode_surat_non_panitia($id) {
        $data = MasterSurat::where('desa_adat_id', $id)
                    ->where('keterangan', 'not like', '%Panitia%')
                    ->get();
        $data_cek = MasterSurat::where('desa_adat_id', $id)
                    ->where('keterangan', 'not like', '%Panitia%')
                    ->first();
        if($data_cek == null) {
            return response()->json([
                'status' => 'Failed',
                'message' => 'Kode Surat Tidak Ditemukan!'
            ], 500);
        }else{
            return response()->json($data, 200);
        }
    }

    public function index_surat_keluar($id) {
        $data = SuratKeluar::join('tb_m_desa_adat', 'tb_surat_keluar.desa_adat_id', '=', 'tb_m_desa_adat.desa_adat_id')
        ->join('tb_m_kecamatan', 'tb_m_desa_adat.kecamatan_id', '=', 'tb_m_kecamatan.kecamatan_id')
        ->join('tb_m_kabupaten', 'tb_m_kecamatan.kabupaten_id', '=', 'tb_m_kabupaten.kabupaten_id')
        ->where('tb_surat_keluar.surat_keluar_id', $id)
        ->first();
        return view('surat-keluar', ['data' => $data]);
    }

    public function show_detail_panitia_surat_keluar($id) {
        Request()->validate([
            'jabatan' => 'required'
        ]);
        $data = ValidasiPanitia::join('tb_krama_mipil', 'tb_validasi_panitia.krama_mipil_id', '=', 'tb_krama_mipil.krama_mipil_id')
                                ->join('tb_cacah_krama_mipil', 'tb_cacah_krama_mipil.cacah_krama_mipil_id', 'tb_krama_mipil.cacah_krama_mipil_id')
                                ->join('tb_penduduk', 'tb_penduduk.penduduk_id', '=', 'tb_cacah_krama_mipil.penduduk_id')
                                ->where('jabatan', Request()->jabatan)
                                ->where('surat_keluar_id', $id)
                                ->first();
        return response()->json($data, 200);
    }

    public function show_detail_prajuru_surat_keluar($id) {
        Request()->validate([
            'jabatan' => 'required'
        ]);
        $data = ValidasiPrajuruDesa::join('tb_prajuru_desa_adat', 'tb_validasi_prajuru_desa.prajuru_desa_adat_id', 'tb_prajuru_desa_adat.prajuru_desa_adat_id')
                                    ->join('tb_krama_mipil', 'tb_prajuru_desa_adat.krama_mipil_id', '=', 'tb_krama_mipil.krama_mipil_id')
                                    ->join('tb_cacah_krama_mipil', 'tb_cacah_krama_mipil.cacah_krama_mipil_id', 'tb_krama_mipil.cacah_krama_mipil_id')
                                    ->join('tb_penduduk', 'tb_penduduk.penduduk_id', '=', 'tb_cacah_krama_mipil.penduduk_id')
                                    ->where('jabatan', Request()->jabatan)
                                    ->where('surat_keluar_id', $id)
                                    ->first();
        return response()->json($data, 200);
    }

    public function print_pdf_surat_keluar($id) {
        $data = SuratKeluar::join('tb_m_desa_adat', 'tb_surat_keluar.desa_adat_id', '=', 'tb_m_desa_adat.desa_adat_id')
        ->join('tb_m_kecamatan', 'tb_m_desa_adat.kecamatan_id', '=', 'tb_m_kecamatan.kecamatan_id')
        ->join('tb_m_kabupaten', 'tb_m_kecamatan.kabupaten_id', '=', 'tb_m_kabupaten.kabupaten_id')
        ->where('tb_surat_keluar.surat_keluar_id', $id)
        ->first();
        $pdf = PDF::loadview('surat-keluar', ['data' => $data]);
        $file = $pdf->download('surat-keluar.pdf');
        return response()->json([
            'status' => 'OK'
        ], 200);
    }

    public function up_surat_keluar_non_panitia(Request $request) {
        $surat_keluar = new SuratKeluar();
        $validasi_panitia = new ValidasiPanitia();
        $validasi_prajuru = new ValidasiPrajuruDesa();
        $master_surat = MasterSurat::where('kode_nomor_surat', $request->master_surat)->first();
        $master_surat_decode = json_decode($master_surat);
        $tanggal_sekarang = Carbon::now()->toDateTimeString();
        $surat_keluar->master_surat_id = $master_surat_decode->master_surat_id;
        $surat_keluar->desa_adat_id = $request->desa_adat_id;
        $surat_keluar->lepihan = $request->lepihan;
        $surat_keluar->parindikan = $request->parindikan;
        $surat_keluar->pemahbah_surat = $request->pemahbah_surat;
        $surat_keluar->daging_surat = $request->daging_surat ? : NULL;
        $surat_keluar->pamuput_surat = $request->pamuput_surat ? : NULL;
        $surat_keluar->tanggal_mulai = $request->tanggal_mulai ? : NULL;
        $surat_keluar->tanggal_selesai = $request->tanggal_selesai ? : NULL;
        $surat_keluar->busana = $request->busana ? : NULL;
        $surat_keluar->tempat_kegiatan = $request->tempat_kegiatan ? : NULL;
        $surat_keluar->waktu_mulai = $request->waktu_mulai ? : NULL;
        $surat_keluar->waktu_selesai = $request->waktu_selesai ? : NULL;
        $surat_keluar->tim_kegiatan = $request->tim_kegiatan ? : NULL;
        $surat_keluar->pihak_penerima = $request->pihak_penerima;
        $surat_keluar->lampiran = $request->lampiran ? : NULL;  
        $surat_keluar->nomor_surat = $request->nomor_surat;
        $surat_keluar->status = "Menunggu Respons";
        $surat_keluar->tanggal_surat = $tanggal_sekarang;
        $surat_keluar->save();
        $last_surat_keluar_id = $surat_keluar->id;

        $data_bendesa = [
            'prajuru_desa_adat_id' => $request->bendesa_adat_id,
            'surat_keluar_id' => $last_surat_keluar_id
        ];
        $validasi_prajuru->TambahDataValidasiPrajuru($data_bendesa);
        $data_penyarikan = [
            'prajuru_desa_adat_id' => $request->penyarikan_id,
            'surat_keluar_id' => $last_surat_keluar_id
        ];
        $validasi_prajuru->TambahDataValidasiPrajuru($data_penyarikan);
        return response()->json([
            'status' => 'OK',
            'message' => 'Data Surat Keluar Berhasil Disimpan!'
        ], 200);
    }

    public function show_surat_keluar_non_panitia($id) {
        Request()->validate([
            'status' => 'required'
        ]);

        $data_cek = SuratKeluar::join('tb_master_surat', 'tb_surat_keluar.master_surat_id', '=', 'tb_master_surat.master_surat_id')
                            ->where('tb_master_surat.keterangan', 'not like', '%Panitia%')
                            ->where('tb_master_surat.keterangan', 'not like', '%Panitia')
                            ->where('tb_master_surat.keterangan', 'not like', 'Panitia%')
                            ->where('tb_surat_keluar.desa_adat_id', $id)
                            ->where('tb_surat_keluar.status', Request()->status)
                            ->first();

        $data = SuratKeluar::join('tb_master_surat', 'tb_surat_keluar.master_surat_id', '=', 'tb_master_surat.master_surat_id')
                            ->where('tb_master_surat.keterangan', 'not like', '%Panitia%')
                            ->where('tb_master_surat.keterangan', 'not like', '%Panitia')
                            ->where('tb_master_surat.keterangan', 'not like', 'Panitia%')
                            ->where('tb_surat_keluar.desa_adat_id', $id)
                            ->where('tb_surat_keluar.status', Request()->status)
                            ->get();

        if($data_cek == null) {
            return response()->json([
                'status' => 'Failed',
                'message' => 'Data Surat Keluar Tidak Ditemukan!'
            ], 500);
        }else{
            return response()->json($data, 200);
        }
        
    }
}