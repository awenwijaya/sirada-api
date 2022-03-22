<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use DateTimeInterface;

class Penduduk extends Model
{
    use HasFactory;

    protected $table = 'tb_penduduk';

    protected $dates = [
        'tanggal_lahir',
        'tanggal_kematian'
    ];

    protected $fillable = [
        'penduduk_id',
        'desa_id',
        'nomor_induk_cacah_krama',
        'profesi_id',
        'agama',
        'nik',
        'gelar_depan',
        'agama',
        'nik',
        'gelar_depan',
        'nama',
        'gelar_belakang',
        'nama_alias',
        'tempat_lahir',
        'tanggal_lahir',
        'jenis_kelamin',
        'golongan_darah',
        'alamat',
        'telepon',
        'tanggal_kematian',
        'status_perkawinan',
        'pendidikan_terakhir',
        'ayah_kandung_id',
        'ibu_kandung_id'
    ];
}
