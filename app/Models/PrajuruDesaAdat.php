<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use DateTimeInterface;

class PrajuruDesaAdat extends Model
{
    use HasFactory;

    protected $table = 'tb_prajuru_desa_adat';

    protected $dates = [
        'tanggal_mulai_menjabat',
        'tanggal_akhir_menjabat',
        'tanggal_lahir'
    ];

    protected $fillable = [
        'prajuru_banjar_adat',
        'desa_adat_id',
        'krama_mipil_id',
        'jabatan',
        'status_prajuru_desa_adat',
        'tanggal_mulai_menjabat',
        'tanggal_akhir_menjabat',
        'created_at',
        'updated_at',
        'deleted_at'
    ];

    protected function serializeDate(DateTimeInterface $date) {
      return $date->format('d-M-Y');
    }

    public function AddPrajuruDesaAdat($data) {
      DB::table('tb_prajuru_desa_adat')->insert($data);
    }

    public function HapusPrajuruDesaAdat($id) {
      DB::table('tb_prajuru_desa_adat')
      ->where('prajuru_desa_adat_id', $id)
      ->delete();
    }

    public function EditPrajuruDesaAdat($id, $data) {
      DB::table('tb_prajuru_desa_adat')
      ->where('prajuru_desa_adat_id', $id)
      ->update($data);
    }
}
