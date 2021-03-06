<?php

namespace App\Http\Controllers;

use App\Layanan;
use App\UkuranHewan;
use Illuminate\Http\Request;
use Carbon\Carbon;

class LayananController extends Controller
{
    public function index()
    {
        $layanan = Layanan::join('ukuranhewan', 'layanan.idUkuran', '=', 'ukuranhewan.idUkuran')
            ->select('layanan.*', 'ukuranhewan.namaUkuran')
            ->get();
        $response = [
            'status' => 'Success',
            'data' => $layanan
        ];
        return response()->json($response, 200);
    }

    public function tampilSoftDelete()
    {
        $layanan = Layanan::join('ukuranhewan', 'layanan.idUkuran', '=', 'ukuranhewan.idUkuran')
            ->select('layanan.*', 'ukuranhewan.namaUkuran')
            ->onlyTrashed()->get();
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
        } else {

            $status = 200;
            $response = [
                'status' => 'Success',
                'data' => $layanan
            ];
        }
        return response()->json($response, $status);
    }

    public function tambah(Request $request)
    {
        $layanan = new Layanan;
        $layanan->idLayanan = $this->generateIdLayanan();
        $layanan->namaLayanan = $request['namaLayanan'];
        $layanan->harga = $request['harga'];
        $layanan->idUkuran = $request['idUkuran'];
        $layanan->created_at = Carbon::now();
        $layanan->updated_at = Carbon::now();
        $layanan->idPegawaiLog = $request['idPegawaiLog'];

        try {
            $success = $layanan->save();
            $status = 200;
            $response = [
                'message' => 'Success',
                'data' => $layanan
            ];
        } catch (\Illuminate\Database\QueryException $e) {
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
            $layanan->idUkuran = $request['idUkuran'];
            $layanan->updated_at = Carbon::now();
            $layanan->idPegawaiLog = $request['idPegawaiLog'];

            try {
                $success = $layanan->save();
                $status = 200;
                $response = [
                    'message' => 'Success',
                    'data' => $layanan
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
                'message' => 'Success',
                'data' => $layanan
            ];
        }
        return response()->json($response, $status);
    }

    public function restore(Request $request, $id)
    {
        $layanan = Layanan::onlyTrashed()->find($id);

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
                'message' => 'Success',
                'data' => $layanan
            ];
        }
        return response()->json($response, $status);
    }

    public function hapusPermanen($id)
    {
        $layanan = Layanan::onlyTrashed()->find($id);

        if ($layanan == NULL) {
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
        return response()->json($response, $status);
    }

    public function generateIdLayanan()
    {
        $layanan = Layanan::orderBy('created_at', 'desc')->first();

        if (isset($layanan)) {
            $noTerakhir = substr($layanan->idLayanan, 2);
            if ($noTerakhir < 9)
                return 'LY' . '00' . ($noTerakhir + 1);
            else if ($noTerakhir < 99)
                return 'LY' . '0' . ($noTerakhir + 1);
            else
                return 'LY' . ($noTerakhir + 1);
        } else {
            return 'LY' . '001';
        }
    }
}
