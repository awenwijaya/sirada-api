<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\Autentikasi\RegistrasiController;
use App\Http\Controllers\API\Autentikasi\LupaPasswordController;
use App\Http\Controllers\API\Autentikasi\LoginController;
use App\Http\Controllers\EmailController;
use App\Http\Controllers\API\Data\UserDataController;
use App\Http\Controllers\API\Admin\DataDesaController;
use App\Http\Controllers\API\Data\NomorSuratController;
use App\Http\Controllers\API\Admin\DataStaffController;
use App\Http\Controllers\API\Data\PendudukDataController;
use App\Http\Controllers\API\Data\BanjarAdatDataController;
use App\Http\Controllers\API\Data\DataSuratController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

//registrasi
Route::post('autentikasi/registrasi/cek_nik', [RegistrasiController::class, "cek_nik_penduduk"]);
Route::post('autentikasi/registrasi/post', [RegistrasiController::class, "proses_registrasi"]);
Route::post('autentikasi/registrasi/konfirmasi_email', [EmailController::class, 'index']);
Route::get('verifyemail/{email}', [EmailController::class, 'konfirmasiemail']);
Route::post('autentikasi/lupapassword/cek_email', [LupaPasswordController::class, 'cek_email']);
Route::post('autentikasi/lupapassword/send_email', [EmailController::class, 'kirimEmailLupaPassword']);
Route::post('autentikasi/login', [LoginController::class, 'login']);
Route::get('autentikasi/login/status/prajuru_desa_adat/{id}', [LoginController::class, 'cek_status_admin']);

//data
Route::get('data/userdata/{id}', [UserDataController::class, 'show_user_data']);
Route::post('data/userdata/edit', [UserDataController::class, 'edit_profile']);
Route::get('data/userdata/desa/{id}', [UserDataController::class, 'show_data_desa_by_id']);
Route::get('data/nomorsurat', [NomorSuratController::class, 'show_list_master_surat']);
Route::get('data/nomorsurat/detail/{id}', [NomorSuratController::class, 'show_list_detail_master_surat']);
Route::get('data/staff/prajuru_desa_adat/aktif/{id}', [DataStaffController::class, 'show_list_prajuru_desa_adat_aktif']);
Route::get('data/staff/prajuru_desa_adat/tidak_aktif/{id}', [DataStaffController::class, 'show_list_prajuru_desa_adat_tidak_aktif']);
Route::get('data/staff/prajuru_banjar_adat/aktif/{id}', [DataStaffController::class, 'show_list_prajuru_banjar_adat_aktif']);
Route::get('data/staff/prajuru_banjar_adat/tidak_aktif/{id}', [DataStaffController::class, 'show_list_prajuru_banjar_adat_tidak_aktif']);
Route::get('data/staff/prajuru_desa_adat/detail/{id}', [DataStaffController::class, 'show_detail_prajuru_desa_adat']);
Route::get('data/staff/prajuru_banjar_adat/detail/{id}', [DataStaffController::class, 'show_detail_prajuru_banjar_adat']);
Route::get('data/penduduk/desa_adat/{id}', [PendudukDataController::class, 'show_penduduk_by_desa_id']);
Route::get('data/penduduk/banjar_adat/{id}', [PendudukDataController::class, 'show_penduduk_by_banjar_id']);
Route::get('data/staff/prajuru_desa_adat/edit/{id}', [DataStaffController::class, 'show_detail_prajuru_desa_adat_edit']);
Route::get('data/banjar/{id}', [BanjarAdatDataController::class, 'show_list_banjar_adat_by_desa_id']);
Route::get('data/staff/prajuru_banjar_adat/edit/{id}', [DataStaffController::class, 'show_detail_prajuru_banjar_adat_edit']);
Route::get('data/staff/prajuru/desa_adat/bendesa/{id}', [DataStaffController::class, 'show_list_bendesa_adat_by_desa_id']);

//admin
Route::post('admin/desa/up_sejarah_desa', [DataDesaController::class, 'up_sejarah_desa']);
Route::post('admin/nomor_surat/up_nomor_surat', [NomorSuratController::class, 'proses_add_nomor_surat']);
Route::post('admin/nomor_surat/edit_nomor_surat', [NomorSuratController::class, 'proses_edit_nomor_surat']);
Route::post('admin/nomor_surat/delete_nomor_surat', [NomorSuratController::class, 'proses_delete_nomor_surat']);
Route::post('admin/prajuru/desa_adat/up', [DataStaffController::class, 'add_prajuru_desa_adat']);
Route::post('admin/prajuru/desa_adat/edit/up', [DataStaffController::class, 'edit_prajuru_desa_adat']);
Route::post('admin/prajuru/desa_adat/delete', [DataStaffController::class, 'delete_prajuru_desa_adat']);
Route::post('admin/prajuru/desa_adat/set_tidak_aktif', [DataStaffController::class, 'set_staff_tidak_aktif']);
Route::post('admin/prajuru/banjar_adat/up', [DataStaffController::class, 'add_prajuru_banjar_adat']);
Route::post('admin/prajuru/banjar_adat/edit/up', [DataStaffController::class, 'edit_prajuru_banjar_adat']);
Route::post('admin/prajuru/banjar_adat/set_tidak_aktif', [DataStaffController::class, 'set_prajuru_banjar_adat_tidak_aktif']);
Route::post('admin/prajuru/banjar_adat/delete', [DataStaffController::class, 'delete_prajuru_banjar_adat']);
Route::post('admin/surat/keluar/up', [DataSuratController::class, 'up_surat_keluar']);