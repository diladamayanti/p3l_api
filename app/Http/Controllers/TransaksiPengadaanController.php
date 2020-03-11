<?php

namespace App\Http\Controllers;

use App\TransaksiPengadaan;
use Illuminate\Http\Request;
use Carbon\Carbon;

class TransaksiPengadaanController extends Controller
{
    public function index()
    {
        $transaksiPengadaan = TransaksiPengadaan::all();
        $response = [
            'status' => 'Success',
            'data' => $transaksiPengadaan
        ];
        return response()->json($response, 200);
    }

    public function cariPengadaan($noPO)
    {
        $transaksiPengadaan = TransaksiPengadaan::where('noPO', 'like', '%' . $noPO . '%')
            ->where('deleted_at', null)->get();

        if (sizeof($transaksiPengadaan) == 0) {
            $status = 404;
            $response = [
                'status' => 'Data Not Found',
                'data' => []
            ];
        } else {

            $status = 200;
            $response = [
                'status' => 'Success',
                'data' => $transaksiPengadaan
            ];
        }
        return response()->json($response, $status);
    }

    public function tambah(Request $request, $id)
    {
        $pengadaan = TransaksiPengadaan::find($id);

        $transaksiPengadaan = new TransaksiPengadaan;
        $transaksiPengadaan->noPO = $this->generateNoPO();
        $transaksiPengadaan->tglPengadaan = Carbon::now();
        $transaksiPengadaan->totalHarga = $request['totalHarga'];
        $transaksiPengadaan->idSupplier = $request['idSupplier'];
        $transaksiPengadaan->status = $request['status'];
        $transaksiPengadaan->created_at = Carbon::now();
        $transaksiPengadaan->updated_at = Carbon::now();

        try {
            $success = $transaksiPengadaan->save();
            $status = 200;
            $response = [
                'status' => 'Success',
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
        $transaksiPengadaan = TransaksiPengadaan::find($id);

        if ($transaksiPengadaan == NULL) {
            $status = 404;
            $response = [
                'status' => 'Data Not Found',
                'data' => []
            ];
        } else {
            $transaksiPengadaan->totalHarga = $request['totalHarga'];
            $transaksiPengadaan->idSupplier = $request['idSupplier'];
            $transaksiPengadaan->status = $request['status'];
            $transaksiPengadaan->updated_at = Carbon::now();

            try {
                $success = $transaksiPengadaan->save();
                $status = 200;
                $response = [
                    'status' => 'Success',
                    'data' => $transaksiPengadaan
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
        $transaksiPengadaan = TransaksiPengadaan::find($id);

        if ($transaksiPengadaan == NULL || $transaksiPengadaan->deleted_at != NULL) {
            $status = 404;
            $response = [
                'status' => 'Data Not Found',
                'data' => []
            ];
        } else {
            $transaksiPengadaan->delete();
            $status = 200;
            $response = [
                'status' => 'Success',
                'data' => $transaksiPengadaan
            ];
        }
        return response()->json($response, $status);
    }

    public function generateNoPO()
    {
        $transaksiPengadaan = TransaksiPengadaan::whereDate('created_at', date('Y-m-d'))
            ->orderBy('created_at', 'desc')->first();

        if (isset($transaksiPengadaan)) {
            $noTerakhir = substr($transaksiPengadaan->noPO, 14);
            if ($noTerakhir < 9)
                return 'PO-' . date('Y-m-d') . '-0' . ($noTerakhir + 1);
            else
                return 'PO-' . date('Y-m-d') . '-' . ($noTerakhir + 1);
        } else {
            return 'PO-' . date('Y-m-d') . '-01';
        }
    }
}
