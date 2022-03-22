<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class BanjarAdat extends Model
{
    use HasFactory;

    protected $table = 'tb_m_banjar_adat';

    protected $fillable = [
        'banjar_adat_id',
        'desa_adat_id',
        'kode_banjar_adat',
        'nama_banjar_adat',
        'created_at',
        'updated_at',
        'deleted_at'
    ];
}
