<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class ValidasiPrajuruDesa extends Model
{
    use HasFactory;

    protected $table = 'tb_validasi_prajuru_desa';

    protected $fillable = [
        'validasi_prajuru_desa_id',
        'surat_keluar_id',
        'prajuru_desa_adat_id',
        'validasi'
    ];
}
