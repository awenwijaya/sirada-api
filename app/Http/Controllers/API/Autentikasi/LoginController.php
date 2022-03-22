<?php

namespace App\Http\Controllers\API\Autentikasi;
use Illuminate\Support\Facades\Hash;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Pengguna;

class LoginController extends Controller
{

    public function __construct() {
        $this->Pengguna = new Pengguna;
    }

    public function login(){
        Request()->validate(
            [
                'email' => 'required',
                'password' => 'required'
            ]
        );
        $password = Pengguna::select('password')->where('email', Request()->email)->first();
        $data_pengguna = Pengguna::select()
                                ->join('tb_m_desa_adat', 'tb_m_desa_adat.desa_adat_id', '=', 'tb_sso.desa_adat_id')
                                ->where('email', Request()->email)
                                ->first();
        $password_decode = json_decode($password);
        if($password != ""){
            if(Hash::check(Request()->password, $password_decode->password)) {
                return response()->json($data_pengguna, 200);
            } else {
                return response()->json([
                    'status' => 'Failed',
                    'message' => 'Password salah'
                ], 500) ;
            }
        } else {
            return response()->json([
                'status' => 'Failed',
                'message' => 'Email salah'
            ], 500);
        }
    }
}
