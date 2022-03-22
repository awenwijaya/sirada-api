<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class DetailMasterSurat extends Model
{
    use HasFactory;

    protected $table = 'tb_detail_master_surat';

    protected $fillable = [
        'detail_master_surat_id',
        'kode_detail_surat',
        'keterangan',
        'master_surat_id',
        'created_at',
        'updated_at'
    ];
}
