<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class MasterSurat extends Model
{
    use HasFactory;

    protected $table = 'tb_master_surat';

    protected $fillable = [
        'master_surat_id',
        'kode_nomor_surat',
        'keterangan',
        'created_at',
        'updated_at'
    ];

    public function TambahNomorSurat($data) {
        DB::table('tb_master_surat')
        ->insert($data);
    }

    public function EditNomorSurat($data, $id) {
        DB::table('tb_master_surat')
        ->where('master_surat_id', $id)
        ->update($data);
    }

    public function HapusNomorSurat($id) {
        DB::table('tb_master_surat')
        ->where('master_surat_id', $id)
        ->delete();
    }
}
