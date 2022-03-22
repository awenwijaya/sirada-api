<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use DateTimeInterface;

class PrajuruBanjarAdat extends Model
{
    use HasFactory;

    protected $table = 'tb_prajuru_banjar_adat';

    protected $fillable = [
        'prajuru_banjar_adat',
        'banjar_adat_id',
        'krama_mipil_id',
        'jabatan',
        'status_prajuru_banjar_adat',
        'tanggal_mulai_menjabat',
        'tanggal_akhir_menjabat',
        'created_at',
        'updated_at',
        'deleted_at'
    ];

    protected $dates = [
        'tanggal_mulai_menjabat',
        'tanggal_akhir_menjabat'
    ];

    protected function serializeDate(DateTimeInterface $date){
      return $date->format('d-M-Y');
    }

    public function AddPrajuruBanjarAdat($data) {
      DB::table('tb_prajuru_banjar_adat')->insert($data);
    }

    public function EditPrajuruBanjarAdat($id, $data) {
      DB::table('tb_prajuru_banjar_adat')
      ->where('prajuru_banjar_adat_id', $id)
      ->update($data);
    }

    public function HapusPrajuruBanjarAdat($id) {
      DB::table('tb_prajuru_banjar_adat')
      ->where('prajuru_banjar_adat_id', $id)
      ->delete();
    }
}
