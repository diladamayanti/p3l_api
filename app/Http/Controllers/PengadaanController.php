<?php

namespace App\Http\Controllers;

use App\Pengadaan;
use Illuminate\Http\Request;
use Carbon\Carbon;

class PengadaanController extends Controller
{
    public function index()
    {
        $pengadaan = Pengadaan::all();
        $response = [
            'status' => 'Success',
            'data' => $pengadaan
        ];
        return response()->json($response, 200);
    }

    public function tampilSoftDelete()
    {
        $pengadaan = Pengadaan::onlyTrashed();
        $response = [
            'status' => 'Success',
            'data' => $pengadaan
        ];

        return response()->json($response, 200);
    }

    public function cariPengadaan($noPO)
    {
        $pengadaan = Pengadaan::where('noPO', 'like', '%' . $noPO . '%')
            ->where('deleted_at', null)->get();

        if (sizeof($pengadaan) == 0) {
            $status = 404;
            $response = [
                'status' => 'Data Not Found',
                'data' => []
            ];
        } else {

            $status = 200;
            $response = [
                'status' => 'Success',
                'data' => $pengadaan
            ];
        }
        return response()->json($response, $status);
    }

    public function tambah(Request $request)
    {
        $pengadaan = new Pengadaan;
        $pengadaan->noPO = $this->generateNoPO();
        $pengadaan->tglPengadaan = Carbon::now();
        $pengadaan->totalHarga = $request['totalHarga'];
        $pengadaan->idSupplier = $request['idSupplier'];
        $pengadaan->status = $request['status'];
        $pengadaan->created_at = Carbon::now();
        $pengadaan->updated_at = Carbon::now();

        try {
            $success = $pengadaan->save();
            $status = 200;
            $response = [
                'message' => 'Success',
                'data' => $pengadaan
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
        $pengadaan = Pengadaan::find($id);

        if ($pengadaan == NULL) {
            $status = 404;
            $response = [
                'status' => 'Data Not Found',
                'data' => []
            ];
        } else {
            $pengadaan->totalHarga = $request['totalHarga'];
            $pengadaan->idSupplier = $request['idSupplier'];
            $pengadaan->status = $request['status'];
            $pengadaan->updated_at = Carbon::now();

            try {
                $success = $pengadaan->save();
                $status = 200;
                $response = [
                    'message' => 'Success',
                    'data' => $pengadaan
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
        $pengadaan = Pengadaan::find($id);

        if ($pengadaan == NULL || $pengadaan->deleted_at != NULL) {
            $status = 404;
            $response = [
                'status' => 'Data Not Found',
                'data' => []
            ];
        } else {
            $pengadaan->created_at = NULL;
            $pengadaan->updated_at = NULL;
            $pengadaan->deleted_at = Carbon::now();
            $pengadaan->save();
            $status = 200;
            $response = [
                'message' => 'Success',
                'data' => $pengadaan
            ];
        }
        return response()->json($response, $status);
    }

    public function restore($id)
    {
        $pengadaan = Pengadaan::onlyTrashed()->find($id);

        if ($pengadaan == NULL) {
            $status = 404;
            $response = [
                'status' => 'Data Not Found',
                'data' => []
            ];
        } else {
            $pengadaan->created_at = Carbon::now();
            $pengadaan->updated_at = Carbon::now();
            $pengadaan->deleted_at = NULL;
            $pengadaan->save();
            $status = 200;
            $response = [
                'message' => 'Success',
                'data' => $pengadaan
            ];
        }
        return response()->json($response, $status);
    }

    public function hapusPermanen($id)
    {
        $pengadaan = Pengadaan::onlyTrashed()->find($id);

        if ($pengadaan == NULL) {
            $status = 404;
            $response = [
                'status' => 'Data Not Found',
                'data' => []
            ];
        } else {
            $pengadaan->delete();
            $status = 200;
            $response = [
                'message' => 'Success',
                'data' => $pengadaan
            ];
        }
        return response()->json($response, $status);
    }

    public function generateNoPO()
    {
        $pengadaan = Pengadaan::whereDate('created_at', date('Y-m-d'))
            ->orderBy('created_at', 'desc')->first();

        if (isset($pengadaan)) {
            $noTerakhir = substr($pengadaan->noPO, 14);
            if ($noTerakhir < 9)
                return 'PO-' . date('Y-m-d') . '-0' . ($noTerakhir + 1);
            else
                return 'PO-' . date('Y-m-d') . '-' . ($noTerakhir + 1);
        } else {
            return 'PO-' . date('Y-m-d') . '-01';
        }
    }
}
