<?php

namespace App\Http\Controllers;

use App\DTLayanan;
use Illuminate\Http\Request;
use Carbon\Carbon;

class DTLayananController extends Controller
{
    public function index()
    {
        $dt_Layanan = DTLayanan::all();
        $response = [
            'status' => 'Success',
            'data' => $dt_Layanan
        ];
        return response()->json($response, 200);
    }

    public function cariDTLayanan($noTransaksi)
    {
        $dt_Layanan = DTLayanan::where('noTransaksi', 'like', '%' . $noTransaksi . '%')->get();

        if (sizeof($dt_Layanan) == 0) {
            $status = 404;
            $response = [
                'status' => 'Data Not Found',
                'data' => []
            ];
        } else {

            $status = 200;
            $response = [
                'status' => 'Success',
                'data' => $dt_Layanan
            ];
        }
        return response()->json($response, $status);
    }

    public function tambah(Request $request)
    {
        $dt_Layanan = new DTLayanan;
        $dt_Layanan->noTransaksi = $request['noTransaksi'];
        $dt_Layanan->idLayanan = $request['idLayanan'];
        $dt_Layanan->jumlah = $request['jumlah'];
        $dt_Layanan->subTotal = $request['subTotal'];

        try {
            $success = $dt_Layanan->save();
            $status = 200;
            $response = [
                'status' => 'Success',
                'data' => $dt_Layanan
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
        $dt_Layanan = DTLayanan::find($id);

        if ($dt_Layanan == NULL) {
            $status = 404;
            $response = [
                'status' => 'Data Not Found',
                'data' => []
            ];
        } else {
            $dt_Layanan->noTransaksi = $request['noTransaksi'];
            $dt_Layanan->idLayanan = $request['idLayanan'];
            $dt_Layanan->jumlah = $request['jumlah'];
            $dt_Layanan->subTotal = $request['subTotal'];

            try {
                $success = $dt_Layanan->save();
                $status = 200;
                $response = [
                    'status' => 'Success',
                    'data' => $dt_Layanan
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
        $dt_Layanan = DTLayanan::find($id);

        if ($dt_Layanan == NULL) {
            $status = 404;
            $response = [
                'status' => 'Data Not Found',
                'data' => []
            ];
        } else {
            try {
                $success = $dt_Layanan->delete();
                $status = 200;
                $response = [
                    'status' => 'Success',
                    'data' => $dt_Layanan
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
}
