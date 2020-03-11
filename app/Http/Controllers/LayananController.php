<?php

namespace App\Http\Controllers;

use App\Layanan;
use Illuminate\Http\Request;
use Carbon\Carbon;

class LayananController extends Controller
{
    public function index()
    {
        $layanan = Layanan::all('idLayanan', 'namaLayanan', 'harga', 'idJenis', 'idUkuran', 'created_at', 'updated_at')
        ->where('deleted_at',null);
        $response = [
            'status' => 'Success',
            'data' => $layanan
        ];
        return response()->json($response, 200);
    }

    public function tampilSoftDelete()
    {
        $layanan = Layanan::where('deleted_at', !null)->get();
        $response = [
            'status' => 'Success',
            'data' => $layanan
        ];

        return response()->json($response, 200);
    }

    public function cariLayanan($cari)
    {
        $layanan = Layanan::where('id', 'like', '%' . $cari . '%', 'or', 'namaLayanan', 'like', '%' . $cari . '%')
            ->where('deleted_at', null)->get();

        if (sizeof($layanan) == 0) {
            $status = 404;
            $response = [
                'status' => 'Data Not Found',
                'data' => []
            ];
<<<<<<< HEAD
        }
        else{

            $status=200;
=======
        } else {

            $status = 200;
>>>>>>> ee4e1684d12fd237df605ac25e7ae8c91777a5e1
            $response = [
                'status' => 'Success',
                'data' => $layanan
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
        $layanan = new Layanan;
        $layanan->idLayanan = $this->generateIdLayanan();
        $layanan->namaLayanan = $request['namaLayanan'];
        $layanan->harga = $request['harga'];
        $layanan->idJenis = $request['idJenis'];
        $layanan->idUkuran = $request['idUkuran'];
        $layanan->created_at = Carbon::now();
        $layanan->updated_at = Carbon::now();
        $layanan->idPegawaiLog = $request['idPegawaiLog'];

        try {
            $success = $layanan->save();
            $status = 200;
            $response = [
                'status' => 'Success',
                'data' => $layanan
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
        return response()->json($response, $status);
    }

    public function edit(Request $request, $id)
    {
        $layanan = Layanan::find($id);

        if ($layanan == NULL) {
            $status = 404;
            $response = [
                'status' => 'Data Not Found',
                'data' => []
            ];
        } else {
            $layanan->namaLayanan = $request['namaLayanan'];
            $layanan->harga = $request['harga'];
            $layanan->idJenis = $request['idJenis'];
            $layanan->idUkuran = $request['idUkuran'];
            $layanan->updated_at = Carbon::now();
            $layanan->idPegawaiLog = $request['idPegawaiLog'];

<<<<<<< HEAD
            try{
=======
            try {
>>>>>>> ee4e1684d12fd237df605ac25e7ae8c91777a5e1
                $success = $layanan->save();
                $status = 200;
                $response = [
                    'status' => 'Success',
                    'data' => $layanan
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

    public function hapus($id)
    {
        $layanan = Layanan::find($id);

        if ($layanan == NULL || $layanan->deleted_at != NULL) {
            $status = 404;
            $response = [
                'status' => 'Data Not Found',
                'data' => []
            ];
        } else {
            $layanan->deleted_at = Carbon::now();
            $layanan->save();
            $status = 200;
            $response = [
                'status' => 'Success',
                'data' => $layanan
            ];
        }
<<<<<<< HEAD
        return response()->json($response,$status);
=======
        return response()->json($response, $status);
>>>>>>> ee4e1684d12fd237df605ac25e7ae8c91777a5e1
    }

    public function restore(Request $request, $id)
    {
        $layanan = Layanan::find($id);

        if ($layanan == NULL) {
            $status = 404;
            $response = [
                'status' => 'Data Not Found',
                'data' => []
            ];
        } else {
            $layanan->updated_at = Carbon::now();
            $layanan->deleted_at = NULL;
            $layanan->idPegawaiLog = $request['idPegawaiLog'];

            $layanan->save();
            $status = 200;
            $response = [
                'status' => 'Success',
                'data' => $layanan
            ];
        }
<<<<<<< HEAD
        return response()->json($response,$status);
=======
        return response()->json($response, $status);
>>>>>>> ee4e1684d12fd237df605ac25e7ae8c91777a5e1
    }

    public function hapusPermanen($id)
    {
        $layanan = Layanan::find($id);

        if ($layanan == NULL || $layanan->deleted_at != NULL) {
            $status = 404;
            $response = [
                'status' => 'Data Not Found',
                'data' => []
            ];
        } else {
            $layanan->delete();
            $status = 200;
            $response = [
                'status' => 'Success',
                'data' => $layanan
            ];
        }
<<<<<<< HEAD
        return response()->json($response,$status);
=======
        return response()->json($response, $status);
>>>>>>> ee4e1684d12fd237df605ac25e7ae8c91777a5e1
    }

    public function generateIdLayanan()
    {
        $layanan = Layanan::orderBy('created_at', 'desc')->first();

<<<<<<< HEAD
        if (isset($layanan))
        {
            $noTerakhir=substr($layanan->idLayanan,2);
            if($noTerakhir<9)
=======
        if (isset($layanan)) {
            $noTerakhir = substr($layanan->idLayanan, 2);
            if ($noTerakhir < 9)
>>>>>>> ee4e1684d12fd237df605ac25e7ae8c91777a5e1
                return 'LY' . '00' . ($noTerakhir + 1);
            else if ($noTerakhir < 99)
                return 'LY' . '0' . ($noTerakhir + 1);
            else
                return 'LY' . ($noTerakhir + 1);
<<<<<<< HEAD
        }
        else
        {
=======
        } else {
>>>>>>> ee4e1684d12fd237df605ac25e7ae8c91777a5e1
            return 'LY' . '001';
        }
    }
}
