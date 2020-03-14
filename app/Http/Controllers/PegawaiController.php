<?php

namespace App\Http\Controllers;

use App\Pegawai;
use Illuminate\Http\Request;
use Carbon\Carbon;
use finfo;

class PegawaiController extends Controller
{
    public function index()
    {
        $pegawai = Pegawai::all('NIP', 'namaPegawai', 'alamat', 'tglLahir', 'noHp', 'jabatan', 'kataSandi', 'created_at', 'updated_at', 'deleted_at')
            ->where('deleted_at', null);
        $response = [
            'status' => 'Success',
            'data' => $pegawai
        ];
        return response()->json($response, 200);
    }

    public function tampilSoftDelete()
    {
        $pegawai = Pegawai::all('NIP', 'namaPegawai', 'alamat', 'tglLahir', 'noHp', 'jabatan', 'kataSandi', 'created_at', 'updated_at', 'deleted_at')
            ->where('deleted_at', !null);
        $response = [
            'status' => 'Success',
            'data' => $pegawai
        ];

        return response()->json($response, 200);
    }

    public function cariPegawai($cari)
    {
        $pegawai = Pegawai::all('NIP', 'namaPegawai', 'alamat', 'tglLahir', 'noHp', 'jabatan', 'kataSandi', 'created_at', 'updated_at', 'deleted_at')
            ->where('NIP', 'like', '%' . $cari . '%', 'or', 'namaPegawai', 'like', '%' . $cari . '%')
            ->where('deleted_at', null)->get();

        if (sizeof($pegawai) == 0) {
            $status = 404;
            $response = [
                'status' => 'Data Not Found',
                'data' => []
            ];
        }
        else{

            $status=200;
=======
        } else {

            $status = 200;
>>>>>>> ee4e1684d12fd237df605ac25e7ae8c91777a5e1
            $response = [
                'status' => 'Success',
                'data' => $pegawai
            ];
        }
<<<<<<< HEAD
        return response()->json($response,$status);
=======
        return response()->json($response, $status);
>>>>>>> ee4e1684d12fd237df605ac25e7ae8c91777a5e1
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
<<<<<<< HEAD
        }
        else
        {

            try{
=======
        } else {

            try {
>>>>>>> ee4e1684d12fd237df605ac25e7ae8c91777a5e1
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
<<<<<<< HEAD
            }
            catch(\Illuminate\Database\QueryException $e){
=======
            } catch (\Illuminate\Database\QueryException $e) {
>>>>>>> ee4e1684d12fd237df605ac25e7ae8c91777a5e1
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

<<<<<<< HEAD
            if($_FILES['gambar']['error'] != 4){
=======
            if ($_FILES['gambar']['error'] != 4) {
>>>>>>> ee4e1684d12fd237df605ac25e7ae8c91777a5e1
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
<<<<<<< HEAD
            }
            catch(\Illuminate\Database\QueryException $e){
=======
            } catch (\Illuminate\Database\QueryException $e) {
>>>>>>> ee4e1684d12fd237df605ac25e7ae8c91777a5e1
                $status = 500;
                $response = [
                    'status' => 'Error',
                    'data' => [],
                    'message' => $e
                ];
            }
        }
<<<<<<< HEAD
        return response()->json($response,$status);
=======
        return response()->json($response, $status);
>>>>>>> ee4e1684d12fd237df605ac25e7ae8c91777a5e1
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
<<<<<<< HEAD
        return response()->json($response,$status);
=======
        return response()->json($response, $status);
>>>>>>> ee4e1684d12fd237df605ac25e7ae8c91777a5e1
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
<<<<<<< HEAD
        return response()->json($response,$status);
=======
        return response()->json($response, $status);
>>>>>>> ee4e1684d12fd237df605ac25e7ae8c91777a5e1
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
<<<<<<< HEAD
        return response()->json($response,$status);
=======
        return response()->json($response, $status);
>>>>>>> ee4e1684d12fd237df605ac25e7ae8c91777a5e1
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
<<<<<<< HEAD
            return response()->json($response,$status);
        }
        else{
=======
            return response()->json($response, $status);
        } else {
>>>>>>> ee4e1684d12fd237df605ac25e7ae8c91777a5e1
            return response()->make($pegawai->gambar, 200, array(
                'Content-Type' => (new finfo(FILEINFO_MIME))->buffer($pegawai->gambar)
            ));
        }
    }

    public function login(Request $request)
    {
        $pegawai = Pegawai::find($request['NIP']);

<<<<<<< HEAD
        if(isset($pegawai))
        {
            if($pegawai->kataSandi == md5($request->kataSandi))
            {
                $status=200;
=======
        if (isset($pegawai)) {
            if ($pegawai->kataSandi == md5($request->kataSandi)) {
                $status = 200;
>>>>>>> ee4e1684d12fd237df605ac25e7ae8c91777a5e1
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
<<<<<<< HEAD
            }
            else
            {
                $status=500;
=======
            } else {
                $status = 500;
>>>>>>> ee4e1684d12fd237df605ac25e7ae8c91777a5e1
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
<<<<<<< HEAD
        return response()->json($response,$status);
=======
        return response()->json($response, $status);
>>>>>>> ee4e1684d12fd237df605ac25e7ae8c91777a5e1
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

<<<<<<< HEAD
        $gambar=$this->scaleImageFileToBlob($tmpName);
=======
        $gambar = $this->scaleImageFileToBlob($tmpName);
>>>>>>> ee4e1684d12fd237df605ac25e7ae8c91777a5e1

        return $gambar;
    }

    function scaleImageFileToBlob($file)
    {

        $source_pic = $file;
        $max_width = 200;
        $max_height = 200;

        list($width, $height, $image_type) = getimagesize($file);

<<<<<<< HEAD
        switch ($image_type)
        {
            case 1: $src = imagecreatefromgif($file); break;
            case 2: $src = imagecreatefromjpeg($file);  break;
            case 3: $src = imagecreatefrompng($file); break;
            default: return '';  break;
=======
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
>>>>>>> ee4e1684d12fd237df605ac25e7ae8c91777a5e1
        }

        $x_ratio = $max_width / $width;
        $y_ratio = $max_height / $height;

<<<<<<< HEAD
        if( ($width <= $max_width) && ($height <= $max_height) ){
=======
        if (($width <= $max_width) && ($height <= $max_height)) {
>>>>>>> ee4e1684d12fd237df605ac25e7ae8c91777a5e1
            $tn_width = $width;
            $tn_height = $height;
        } elseif (($x_ratio * $height) < $max_height) {
            $tn_height = ceil($x_ratio * $height);
            $tn_width = $max_width;
        } else {
            $tn_width = ceil($y_ratio * $width);
            $tn_height = $max_height;
        }

<<<<<<< HEAD
        $tmp = imagecreatetruecolor($tn_width,$tn_height);
=======
        $tmp = imagecreatetruecolor($tn_width, $tn_height);
>>>>>>> ee4e1684d12fd237df605ac25e7ae8c91777a5e1

        /* Check if this image is PNG or GIF, then set if Transparent*/
        if (($image_type == 1) or ($image_type == 3)) {
            imagealphablending($tmp, false);
            imagesavealpha($tmp, true);
            $transparent = imagecolorallocatealpha($tmp, 255, 255, 255, 127);
            imagefilledrectangle($tmp, 0, 0, $tn_width, $tn_height, $transparent);
        }
<<<<<<< HEAD
        imagecopyresampled($tmp,$src,0,0,0,0,$tn_width, $tn_height,$width,$height);

        ob_start();

        switch ($image_type)
        {
            case 1: imagegif($tmp); break;
            case 2: imagejpeg($tmp, NULL, 100);  break; // best quality
            case 3: imagepng($tmp, NULL, 0); break; // no compression
            default: echo ''; break;
=======
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
>>>>>>> ee4e1684d12fd237df605ac25e7ae8c91777a5e1
        }

        $final_image = ob_get_contents();

        ob_end_clean();

        return $final_image;
    }

    public function generateNIP()
    {
        $pegawai = Pegawai::orderBy('created_at', 'desc')->first();

<<<<<<< HEAD
        if (isset($pegawai))
        {
            if($pegawai->NIP=="Owner")
            {
                return 'P'.date('y').'1';
            }
            $noTerakhir=substr($pegawai->NIP,2);
            return 'P' . date('y') .($noTerakhir + 1);
        }
        else
        {
=======
        if (isset($pegawai)) {
            if ($pegawai->NIP == "Owner") {
                return 'P' . date('y') . '1';
            }
            $noTerakhir = substr($pegawai->NIP, 2);
            return 'P' . date('y') . ($noTerakhir + 1);
        } else {
>>>>>>> ee4e1684d12fd237df605ac25e7ae8c91777a5e1
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
<<<<<<< HEAD
        }
        else
        {

            try{
=======
        } else {

            try {
>>>>>>> ee4e1684d12fd237df605ac25e7ae8c91777a5e1
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
<<<<<<< HEAD
            }
            catch(\Illuminate\Database\QueryException $e){
=======
            } catch (\Illuminate\Database\QueryException $e) {
>>>>>>> ee4e1684d12fd237df605ac25e7ae8c91777a5e1
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
}
