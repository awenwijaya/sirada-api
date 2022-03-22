<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class DesaAdat extends Model
{
    use HasFactory;

    protected $table = 'tb_m_desa_adat';

    protected $fillable = [
        'desa_adat_id',
        'desaadat_jenis_id',
        'desadat_nama',
        'desadat_kode',
        'desadat_kantor_long',
        'desadat_kantor_lat',
        'desadat_bendesa_nama',
        'desadat_penyarikan_nama',
        'desadat_petengen',
        'desadat_nomor_register',
        'desadat_alamat_kantor',
        'desadat_telpon_kantor',
        'desadat_fax_kantor',
        'desadat_email',
        'desadat_web',
        'desadat_luas',
        'desadat_sejarah',
        'desadat_file_struktur_pem',
        'desadat_hp_kontak1',
        'desadat_hp_kontak2',
        'desadat_wa_kontak_1',
        'desadat_wa_kontak_2',
        'kecamatan_id',
        'kabkot_id',
        'desadat_ttd_lokasi',
        'desadat_punya_lpd',
        'desadat_jum_staf',
        'desadat_jum_banjar',
        'desadat_jum_kk_mipil',
        'desadat_jum_krama_mipil',
        'desadat_jum_kk_krama_tamiu',
        'desadat_jum_krama_tamiu',
        'desadat_jum_kk_tamiu',
        'desadat_jum_tamiu',
        'desadat_sebutan_pemimpin',
        'desadat_status_aktif',
        'password_temp',
        'created_at',
        'updated_at',
        'deleted_at'
    ];

    public function UpSejarahDesaAdat($id, $data) {
        DB::table('tb_m_desa_adat')
        ->where('desa_adat_id', $id)
        ->update($data);
    }
}
