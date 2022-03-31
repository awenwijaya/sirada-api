<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use DateTimeInterface;

class SuratKeluar extends Model
{
    use HasFactory;

    protected $table = 'tb_surat_keluar';

    protected $fillable = [
        'surat_keluar_id',
        'master_surat_id',
        'desa_adat_id',
        'tanggal_keluar',
        'prajuru_banjar_id',
        'parindikan',
        'tanggal_kegiatan',
        'busana',
        'tempat_kegiatan',
        'waktu_kegiatan',
        'file',
        'tanggal_surat',
        'status',
        'pihak_penerima'
    ];

    protected $dates = [
        'tanggal_keluar',
        'tanggal_kegiatan',
        'tanggal_surat',
        'created_at',
        'updated_at'
    ];

    protected function serializeDate(DateTimeInterface $date){
        return $date->format('d-M-Y');
    }
}
