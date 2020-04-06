<?php

namespace App\Http\Controllers;

use App\Supplier;
use Illuminate\Http\Request;
use Carbon\Carbon;

class SupplierController extends Controller
{
    public function index()
    {
        $supplier = Supplier::all();
        $response = [
            'message' => 'Success',
            'data' => $supplier
        ];
        return response()->json($response, 200);
    }

    public function tampilSoftDelete()
    {
        $supplier = Supplier::onlyTrashed()->get();
        $response = [
            'status' => 'Success',
            'data' => $supplier
        ];
        return response()->json($response, 200);
    }

    public function cariSupplier($cari)
    {
        $supplier = Supplier::where('idSupplier', 'like', '%' . $cari . '%', 'or', 'namaSupplier', 'like', '%' . $cari . '%')
            ->where('deleted_at', null)->get();

        if (sizeof($supplier) == 0) {
            $status = 404;
            $response = [
                'status' => 'Data Not Found',
                'data' => []
            ];
        } else {

            $status = 200;
            $response = [
                'status' => 'Berhasil',
                'data' => $supplier
            ];
        }
        return response()->json($response, $status);
    }

    public function tambah(Request $request)
    {
        $supplier = new Supplier;
        $supplier->namaSupplier = $request['namaSupplier'];
        $supplier->alamat = $request['alamat'];
        $supplier->noHp = $request['noHp'];
        $supplier->created_at = Carbon::now();
        $supplier->updated_at = Carbon::now();
        $supplier->idPegawaiLog = $request['idPegawaiLog'];

        try {
            $success = $supplier->save();
            $status = 200;
            $response = [
                'message' => 'Success',
                'data' => $supplier
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
        $supplier = Supplier::find($id);

        if ($supplier == NULL) {
            $status = 404;
            $response = [
                'status' => 'Data Not Found',
                'data' => []
            ];
        } else {
            $supplier->namaSupplier = $request['namaSupplier'];
            $supplier->alamat = $request['alamat'];
            $supplier->noHp = $request['noHp'];
            $supplier->updated_at = Carbon::now();
            $supplier->idPegawaiLog = $request['idPegawaiLog'];

            try {
                $success = $supplier->save();
                $status = 200;
                $response = [
                    'message' => 'Success',
                    'data' => $supplier
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
        $supplier = Supplier::find($id);

        if ($supplier == NULL || $supplier->deleted_at != NULL) {
            $status = 404;
            $response = [
                'status' => 'Data Not Found',
                'data' => []
            ];
        } else {
            $supplier->deleted_at = Carbon::now();
            $supplier->save();
            $status = 200;
            $response = [
                'message' => 'Success',
                'data' => $supplier
            ];
        }
        return response()->json($response, $status);
    }

    public function restore(Request $request, $id)
    {
        $supplier = Supplier::onlyTrashed()->find($id);

        if ($supplier == NULL) {
            $status = 404;
            $response = [
                'status' => 'Data Not Found',
                'data' => []
            ];
        } else {
            $supplier->updated_at = Carbon::now();
            $supplier->deleted_at = NULL;
            $supplier->idPegawaiLog = $request['idPegawaiLog'];

            $supplier->save();
            $status = 200;
            $response = [
                'message' => 'Success',
                'data' => $supplier
            ];
        }
        return response()->json($response, $status);
    }

    public function hapusPermanen($id)
    {
        $supplier = Supplier::onlyTrashed()->find($id);

        if ($supplier == NULL) {
            $status = 404;
            $response = [
                'status' => 'Data Not Found',
                'data' => []
            ];
        } else {
            $supplier->forceDelete();
            $status = 200;
            $response = [
                'message' => 'Success',
                'data' => $supplier
            ];
        }
        return response()->json($response, $status);
    }
}
