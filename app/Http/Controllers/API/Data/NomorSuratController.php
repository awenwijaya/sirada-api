<?php

namespace App\Http\Controllers\API\Data;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\MasterSurat;
use App\Models\DetailMasterSurat;

class NomorSuratController extends Controller
{
    public function __construct() {
        $this->MasterSurat = new MasterSurat();
        $this->DetailMasterSurat = new DetailMasterSurat();
    }

    public function show_list_master_surat($id) {
        $data = MasterSurat::select()
                ->where('desa_adat_id', $id)
                ->get();
        $data_cek = MasterSurat::select()
                    ->where('desa_adat_id', $id)
                    ->first();
        if($data_cek == null) {
            return response()->json([
                'status' => 'Failed',
                'message' => 'Data Nomor Surat Tidak Ditemukan'
            ], 501);
        }else{
            return response()->json($data, 200);
        }
    }

    public function show_list_detail_master_surat($id) {
        $data = DetailMasterSurat::select()->where('master_surat_id', $id)->get();
        $data_cek = DetailMasterSurat::select()->where('master_surat_id', $id)->first();
        if($data_cek == null) {
            return response()->json([
                'status' => 'Failed',
                'message' => 'Data Detail List Nomor Surat Tidak Ditemukan'
            ], 501);
        }else{
            return response()->json($data, 200);
        }
    }

    public function proses_add_nomor_surat() {
        Request()->validate([
            'kode_nomor_surat' => 'required',
            'keterangan' => 'required',
            'desa_adat_id' => 'required'
        ]);
        $cek_kode_nomor_surat = MasterSurat::select('kode_nomor_surat')->where('kode_nomor_surat', Request()->kode_nomor_surat)->first();
        $cek_keterangan = MasterSurat::select('keterangan')->where('keterangan', Request()->keterangan)->first();
        $data = [
            'kode_nomor_surat' => Request()->kode_nomor_surat,
            'keterangan' => Request()->keterangan,
            'desa_adat_id' => Request()->desa_adat_id
        ];
        if($cek_keterangan != null || $cek_kode_nomor_surat != null) {
            return response()->json([
                'status' => 'Failed',
                'message' => 'Kode surat atau keterangan sudah terdaftar sebelumnya'
            ], 501);
        }else{
            $this->MasterSurat->TambahNomorSurat($data);
            return response()->json([
                'status' => 'OK',
                'message' => 'Data nomor surat berhasil ditambahkan!'
            ], 200);
        }
    }

    public function proses_edit_nomor_surat() {
        Request()->validate([
            'kode_nomor_surat' => 'required',
            'keterangan' => 'required',
            'id' => 'required'
        ]);
        $data_nomor_surat = MasterSurat::select()->where('master_surat_id', Request()->id)->first();
        $data_decode = json_decode($data_nomor_surat);
        $data = [
            "kode_nomor_surat" => Request()->kode_nomor_surat,
            "keterangan" => Request()->keterangan
        ];
        if($data_decode->kode_nomor_surat == Request()->kode_nomor_surat) {
            $cek = MasterSurat::select()->where('keterangan', Request()->keterangan)->first();
            if($cek != null) {
                return response()->json([
                    'status' => 'Failed',
                    'message' => 'Keterangan sudah terdaftar sebelumnya'
                ], 501);
            }else{
                $this->MasterSurat->EditNomorSurat($data, Request()->id);
                return response()->json([
                    'status' => 'OK',
                    'message' => 'Kode surat berhasil diperbaharui!'
                ], 200);
            }
        }else if($data_decode->keterangan == Request()->keterangan) {
            $cek_nomor = MasterSurat::select('kode_nomor_surat')->where('kode_nomor_surat', Request()->kode_nomor_surat)->first();
            if($cek_nomor != null) {
                return response()->json([
                    'status' => 'Failed',
                    'message' => 'Kode nomor surat sudah terdaftar sebelumnya'
                ], 501);
            }else{
                $this->MasterSurat->EditNomorSurat($data, Request()->id);
                return response()->json([
                    'status' => 'OK',
                    'message' => 'Kode surat berhasil diperbaharui!'
                ], 200);
            }
        }else{
            $cek_keterangan = MasterSurat::select('keterangan')->where('keterangan', Request()->keterangan)->first();
            $cek_kode_surat = MasterSurat::select('kode_nomor_surat')->where('kode_nomor_surat', Request()->kode_nomor_surat)->first();
            if($cek_keterangan != null || $cek_kode_surat != null) {
                return response()->json([
                    'status' => 'Failed',
                    'message' => 'Kode surat sudah terdaftar sebelumnya'
                ], 501);
            }else{
                $this->MasterSurat->EditNomorSurat($data, Request()->id);
                return response()->json([
                    'status' => 'OK',
                    'message' => 'Kode surat berhasil diperbaharui!'
                ], 200);
            } 
        }
    }

    public function proses_delete_nomor_surat() {
        Request()->validate([
            'id' => 'required'
        ]);
        $this->MasterSurat->HapusNomorSurat(Request()->id);
        return response()->json([
            'status' => 'OK',
            'message' => 'Data Kode Surat Berhasil Dihapus!'
        ], 200);
    }
}
