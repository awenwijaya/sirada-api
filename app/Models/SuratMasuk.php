<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use DateTimeInterface;

class SuratMasuk extends Model
{
    use HasFactory;

    protected $table = 'tb_surat_masuk';

    protected  $primaryKey = 'surat_masuk_id';

    protected $fillable = [
        'surat_masuk_id',
        'prajuru_banjar_adat_id',
        'perihal',
        'asal_surat',
        'tanggal_surat',
        'tanggal_diterima',
        'tanggal_diteruskan',
        'tanggal_kegiatan',
        'waktu_kegiatan',
        'detail_master_surat_id',
        'file',
        'desa_adat_id'
    ];

    protected $dates = [
        'tanggal_surat',
        'tanggal_diterima',
        'tanggal_kegiatan_mulai',
        'tanggal_kegiatan_berakhir',
        'created_at',
        'updated_at'
    ];

    protected function serializeDate(DateTimeInterface $date){
        return $date->format('d-M-Y');
    }

    public function HapusSuratMasuk($id) {
        DB::table('tb_surat_masuk')
        ->where('surat_masuk_id', $id)
        ->delete();
    }
}
