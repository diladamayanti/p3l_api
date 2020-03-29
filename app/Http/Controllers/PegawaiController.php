<?php

namespace App\Http\Controllers;

use App\Pegawai;
use Illuminate\Http\Request;
use Carbon\Carbon;
use finfo;
use Illuminate\Support\Facades\Auth;

class PegawaiController extends Controller
{
    public function index()
    {
        //$pegawai = Pegawai::where('deleted_at', null)->get();
        $pegawai = Pegawai::all('NIP', 'namaPegawai', 'alamat', 'tglLahir', 'noHp', 'jabatan', 'idPegawaiLog')->where('deleted_at', null);
        $response = [
            'status' => 'Success',
            'data' => $pegawai
        ];
        return response()->json($response, 200);
    }

    public function tampilSoftDelete()
    {
        $pegawai = Pegawai::onlyTrashed()->get();
        $response = [
            'status' => 'Success',
            'data' => $pegawai
        ];

        return response()->json($response, 200);
    }

    public function cariPegawai($cari)
    {
        $pegawai = Pegawai::where('NIP', 'like', '%' . $cari . '%', 'or', 'namaPegawai', 'like', '%' . $cari . '%')
            ->where('deleted_at', null)->get();

        if (sizeof($pegawai) == 0) {
            $status = 404;
            $response = [
                'status' => 'Data Not Found',
                'data' => []
            ];
        } else {
            $status = 200;
            $response = [
                'status' => 'Success',
                'data' => $pegawai
            ];
        }
        return response()->json($response, $status);
    }

    public function tambah(Request $request)
    {
        $pegawai = new Pegawai;
        $pegawai->NIP = $this->generateNIP();
        $pegawai->namaPegawai = $request['namaPegawai'];
        $pegawai->alamat = $request['alamat'];
        $pegawai->tglLahir = $request['tglLahir'];
        $pegawai->noHp = $request['noHp'];
        $pegawai->jabatan = $request['jabatan'];
        $pegawai->kataSandi = md5($request['kataSandi']);
        $pegawai->gambar = $this->upload();
        $pegawai->created_at = Carbon::now();
        $pegawai->updated_at = Carbon::now();
        $pegawai->idPegawaiLog = $request['idPegawaiLog'];

        if ($pegawai->gambar == 1) {
            $status = 500;
            $response = [
                'status' => 'Error',
                'data' => [],
                'message' =>  "Gambar harus memiliki format jpg or jpeg or png or gif..."
            ];
        } else {

            try {
                $success = $pegawai->save();
                $status = 200;
                $response = [
                    'status' => 'Success',
                    'data' => [
                        'NIP' => $pegawai->NIP,
                        'namaPegawai' => $pegawai->namaPegawai,
                        'alamat' => $pegawai->alamat,
                        'tglLahir' => $pegawai->tglLahir,
                        'noHp' => $pegawai->noHp,
                        'jabatan' => $pegawai->jabatan,
                        'kataSandi' => $pegawai->kataSandi,
                        'created_at' => $pegawai->created_at,
                        'updated_at' => $pegawai->updated_at,
                    ]
                ];
            } catch (\Illuminate\Database\QueryException $e) {
                $status = 500;
                $response = [
                    'status' => 'Error',
                    'data' => [],
                    'message' => $e
                ];
            }
        }
        return response()->json($response, $status);
    }

    public function edit(Request $request, $NIP)
    {
        $pegawai = Pegawai::find($NIP);

        if ($pegawai == NULL) {
            $status = 404;
            $response = [
                'status' => 'Data Not Found',
                'data' => []
            ];
        } else {
            $pegawai->namaPegawai = $request['namaPegawai'];
            $pegawai->alamat = $request['alamat'];
            $pegawai->tglLahir = $request['tglLahir'];
            $pegawai->noHp = $request['noHp'];
            $pegawai->jabatan = $request['jabatan'];
            $pegawai->kataSandi =  md5($request['kataSandi']);
            $pegawai->updated_at = Carbon::now();
            $pegawai->idPegawaiLog = $request['idPegawaiLog'];

            if ($_FILES['gambar']['error'] != 4) {
                $pegawai->gambar = $this->upload();
            }

            try {
                $success = $pegawai->save();
                $status = 200;
                $response = [
                    'status' => 'Success',
                    'data' => [
                        'NIP' => $pegawai->getKey(),
                        'namaPegawai' => $pegawai->namaPegawai,
                        'alamat' => $pegawai->alamat,
                        'tglLahir' => $pegawai->tglLahir,
                        'noHp' => $pegawai->noHp,
                        'jabatan' => $pegawai->jabatan,
                        'kataSandi' => $pegawai->kataSandi,
                        'created_at' => $pegawai->created_at,
                        'updated_at' => $pegawai->updated_at,
                    ]
                ];
            } catch (\Illuminate\Database\QueryException $e) {
                $status = 500;
                $response = [
                    'status' => 'Error',
                    'data' => [],
                    'message' => $e
                ];
            }
        }
        return response()->json($response, $status);
    }

    public function hapus($NIP)
    {
        $pegawai = Pegawai::find($NIP);

        if ($pegawai == NULL || $pegawai->deleted_at != NULL) {
            $status = 404;
            $response = [
                'status' => 'Data Not Found',
                'data' => []
            ];
        } else {
            $pegawai->deleted_at = Carbon::now();
            $pegawai->save();
            $status = 200;
            $response = [
                'status' => 'Success',
                'data' => [
                    'NIP' => $pegawai->getKey(),
                    'namaPegawai' => $pegawai->namaPegawai,
                    'alamat' => $pegawai->alamat,
                    'tglLahir' => $pegawai->tglLahir,
                    'noHp' => $pegawai->noHp,
                    'jabatan' => $pegawai->jabatan,
                    'kataSandi' => $pegawai->kataSandi,
                    'created_at' => $pegawai->created_at,
                    'updated_at' => $pegawai->updated_at,
                ]
            ];
        }
        return response()->json($response, $status);
    }

    public function restore(Request $request, $NIP)
    {
        $pegawai = Pegawai::find($NIP);

        if ($pegawai == NULL) {
            $status = 404;
            $response = [
                'status' => 'Data Not Found',
                'data' => []
            ];
        } else {
            $pegawai->updated_at = Carbon::now();
            $pegawai->deleted_at = NULL;
            $pegawai->idPegawaiLog = $request['idPegawaiLog'];

            $pegawai->save();
            $status = 200;
            $response = [
                'status' => 'Success',
                'data' => [
                    'NIP' => $pegawai->getKey(),
                    'namaPegawai' => $pegawai->namaPegawai,
                    'alamat' => $pegawai->alamat,
                    'tglLahir' => $pegawai->tglLahir,
                    'noHp' => $pegawai->noHp,
                    'jabatan' => $pegawai->jabatan,
                    'kataSandi' => $pegawai->kataSandi,
                    'created_at' => $pegawai->created_at,
                    'updated_at' => $pegawai->updated_at,
                ]
            ];
        }
        return response()->json($response, $status);
    }

    public function hapusPermanen($NIP)
    {
        $pegawai = Pegawai::find($NIP);

        if ($pegawai == NULL || $pegawai->deleted_at != NULL) {
            $status = 404;
            $response = [
                'status' => 'Data Not Found',
                'data' => []
            ];
        } else {
            $pegawai->delete();
            $status = 200;
            $response = [
                'status' => 'Success',
                'data' => [
                    'NIP' => $pegawai->getKey(),
                    'namaPegawai' => $pegawai->namaPegawai,
                    'alamat' => $pegawai->alamat,
                    'tglLahir' => $pegawai->tglLahir,
                    'noHp' => $pegawai->noHp,
                    'jabatan' => $pegawai->jabatan,
                    'kataSandi' => $pegawai->kataSandi,
                    'created_at' => $pegawai->created_at,
                    'updated_at' => $pegawai->updated_at,
                ]
            ];
        }
        return response()->json($response, $status);
    }

    public function tampilGambar($NIP)
    {
        $pegawai = Pegawai::find($NIP);

        if ($pegawai == NULL || $pegawai->deleted_at != NULL) {
            $status = 404;
            $response = [
                'status' => 'Data Not Found',
                'data' => []
            ];
            return response()->json($response, $status);
        } else {
            return response()->make($pegawai->gambar, 200, array(
                'Content-Type' => (new finfo(FILEINFO_MIME))->buffer($pegawai->gambar)
            ));
        }
    }

    public function login(Request $request)
    {
        $pegawai = Pegawai::find($request['NIP']);

        if (isset($pegawai)) {
            if ($pegawai->kataSandi == md5($request->kataSandi)) {
                $status = 200;
                $response = [
                    'message' => 'Success',
                    'data' => [
                        'NIP' => $pegawai->getKey(),
                        'namaPegawai' => $pegawai->namaPegawai,
                        'alamat' => $pegawai->alamat,
                        'tglLahir' => $pegawai->tglLahir,
                        'noHp' => $pegawai->noHp,
                        'jabatan' => $pegawai->jabatan,
                        'kataSandi' => $pegawai->kataSandi,
                        'created_at' => $pegawai->created_at,
                        'updated_at' => $pegawai->updated_at,
                    ]
                ];
            } else {
                $status = 500;
                $response = [
                    'status' => 'Kata sandi tidak cocok.',
                    'data' => []
                ];
            }
        } else {
            $status = 404;
            $response = [
                'status' => 'Pegawai Not Found',
                'data' => []
            ];
        }
        return response()->json($response, $status);
    }

    function upload()
    {

        $namaFile = $_FILES['gambar']['name'];
        $ukuranFile = $_FILES['gambar']['size'];
        $error = $_FILES['gambar']['error'];
        $tmpName = $_FILES['gambar']['tmp_name'];

        //mengecek file gambar atau bukan
        $ekstensiGambarValid = ['jpg', 'jpeg', 'png', 'gif'];
        $ekstensiGambar = explode('.', $namaFile);
        $ekstensiGambar = strtolower(end($ekstensiGambar));
        if (!in_array($ekstensiGambar, $ekstensiGambarValid)) {
            return 1;
        }

        $gambar = $this->scaleImageFileToBlob($tmpName);

        return $gambar;
    }

    function scaleImageFileToBlob($file)
    {

        $source_pic = $file;
        $max_width = 200;
        $max_height = 200;

        list($width, $height, $image_type) = getimagesize($file);

        switch ($image_type) {
            case 1:
                $src = imagecreatefromgif($file);
                break;
            case 2:
                $src = imagecreatefromjpeg($file);
                break;
            case 3:
                $src = imagecreatefrompng($file);
                break;
            default:
                return '';
                break;
        }

        $x_ratio = $max_width / $width;
        $y_ratio = $max_height / $height;

        if (($width <= $max_width) && ($height <= $max_height)) {
            $tn_width = $width;
            $tn_height = $height;
        } elseif (($x_ratio * $height) < $max_height) {
            $tn_height = ceil($x_ratio * $height);
            $tn_width = $max_width;
        } else {
            $tn_width = ceil($y_ratio * $width);
            $tn_height = $max_height;
        }

        $tmp = imagecreatetruecolor($tn_width, $tn_height);

        /* Check if this image is PNG or GIF, then set if Transparent*/
        if (($image_type == 1) or ($image_type == 3)) {
            imagealphablending($tmp, false);
            imagesavealpha($tmp, true);
            $transparent = imagecolorallocatealpha($tmp, 255, 255, 255, 127);
            imagefilledrectangle($tmp, 0, 0, $tn_width, $tn_height, $transparent);
        }
        imagecopyresampled($tmp, $src, 0, 0, 0, 0, $tn_width, $tn_height, $width, $height);

        ob_start();

        switch ($image_type) {
            case 1:
                imagegif($tmp);
                break;
            case 2:
                imagejpeg($tmp, NULL, 100);
                break; // best quality
            case 3:
                imagepng($tmp, NULL, 0);
                break; // no compression
            default:
                echo '';
                break;
        }

        $final_image = ob_get_contents();

        ob_end_clean();

        return $final_image;
    }

    public function generateNIP()
    {
        $pegawai = Pegawai::orderBy('created_at', 'desc')->first();

        if (isset($pegawai)) {
            if ($pegawai->NIP == "Owner") {
                return 'P' . date('y') . '1';
            }
            $noTerakhir = substr($pegawai->NIP, 2);
            return 'P' . date('y') . ($noTerakhir + 1);
        } else {
            return 'Owner';
        }
    }

    public function uploadImage(Request $request)
    {
        $pegawai = new Pegawai;
        $pegawai->NIP = $this->generateNIP();
        $pegawai->gambar = $this->upload();
        $pegawai->created_at = Carbon::now();
        $pegawai->updated_at = Carbon::now();

        if ($pegawai->gambar == 1) {
            $status = 500;
            $response = [
                'status' => 'Error',
                'data' => [],
                'message' =>  "Gambar harus memiliki format jpg or jpeg or png or gif..."
            ];
        } else {

            try {
                $success = $pegawai->save();
                $status = 200;
                $response = [
                    'status' => 'Success',
                    'data' => [
                        'NIP' => $pegawai->NIP,
                        'namaPegawai' => $pegawai->namaPegawai,
                        'alamat' => $pegawai->alamat,
                        'tglLahir' => $pegawai->tglLahir,
                        'noHp' => $pegawai->noHp,
                        'jabatan' => $pegawai->jabatan,
                        'kataSandi' => $pegawai->kataSandi,
                        'created_at' => $pegawai->created_at,
                        'updated_at' => $pegawai->updated_at,
                    ]
                ];
            } catch (\Illuminate\Database\QueryException $e) {
                $status = 500;
                $response = [
                    'status' => 'Error',
                    'data' => [],
                    'message' => $e
                ];
            }
        }
        return response()->json($response, $status);
    }

    // public function login(Request $request)
    // {
    //     $credentials = $request->only('NIP', 'kataSandi');
    //     if ($token = $this->guard()->attempt($credentials)) {
    //         return response()->json(['status' => 'success'], 200)->header('Authorization', $token);
    //     }
    //     return response()->json(['error' => 'login_error'], 401);
    // }


    public function logout()
    {
        $this->guard()->logout();
        return response()->json([
            'status' => 'success',
            'message' => 'Logged out Successfully.'
        ], 200);
    }

    public function admin(Request $request)
    {
        $admin = Pegawai::find(Auth::admin()->id);
        return response()->json([
            'status' => 'success',
            'data' => $admin
        ]);
    }

    private function guard()
    {
        return Auth::guard();
    }
}
