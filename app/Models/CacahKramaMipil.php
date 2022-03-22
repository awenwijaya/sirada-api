<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class CacahKramaMipil extends Model
{
    use HasFactory;

    protected $table = 'tb_cacah_krama_mipil';

    protected $fillable = [
        'cacah_krama_mipil_id',
        'nomor_cacah_krama_mipil',
        'banjar_dinas_id',
        'banjar_adat_id',
        'penduduk_id',
        'jenis_kependudukan',
        'status',
        'created_at',
        'updated_at'
    ];
}
