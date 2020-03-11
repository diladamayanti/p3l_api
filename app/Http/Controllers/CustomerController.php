<?php

namespace App\Http\Controllers;

use App\Customer;
use Illuminate\Http\Request;
use Carbon\Carbon;

class CustomerController extends Controller
{
    public function index()
    {
        $customer = Customer::where('deleted_at', null)->get();
        $response = [
            'status' => 'Success',
            'data' => $customer
        ];
        return response()->json($response, 200);
    }

    public function tampilSoftDelete()
    {
        $customer = Customer::where('deleted_at', !null)->get();
        $response = [
            'status' => 'Success',
            'data' => $customer
        ];
        return response()->json($response, 200);
    }

    public function cariCustomer($cari)
    {
        $customer = Customer::where('idCustomer', 'like', '%' . $cari . '%', 'or', 'namaCustomer', 'like', '%' . $cari . '%')
            ->where('deleted_at', null)->get();

        if (sizeof($customer) == 0) {
            $status = 404;
            $response = [
                'status' => 'Data Not Found',
                'data' => []
            ];
        } else {

            $status = 200;
            $response = [
                'status' => 'Success',
                'data' => $customer
            ];
        }
        return response()->json($response, $status);
    }

    public function tambah(Request $request)
    {
        $customer = new Customer;
        $customer->namaCustomer = $request['namaCustomer'];
        $customer->alamat = $request['alamat'];
        $customer->tglLahir = $request['tglLahir'];
        $customer->noHp = $request['noHp'];
        $customer->created_at = Carbon::now();
        $customer->updated_at = Carbon::now();
        $customer->idPegawaiLog = $request['idPegawaiLog'];

        try {
            $success = $customer->save();
            $status = 200;
            $response = [
                'status' => 'Success',
                'data' => $customer
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
        $customer = Customer::find($id);

        if ($customer == NULL) {
            $status = 404;
            $response = [
                'status' => 'Data Not Found',
                'data' => []
            ];
        } else {
            $customer->namaCustomer = $request['namaCustomer'];
            $customer->alamat = $request['alamat'];
            $customer->tglLahir = $request['tglLahir'];
            $customer->noHp = $request['noHp'];
            $customer->updated_at = Carbon::now();
            $customer->idPegawaiLog = $request['idPegawaiLog'];

            try {
                $success = $customer->save();
                $status = 200;
                $response = [
                    'status' => 'Success',
                    'data' => $customer
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
        $customer = Customer::find($id);

        if ($customer == NULL || $customer->deleted_at != NULL) {
            $status = 404;
            $response = [
                'status' => 'Data Not Found',
                'data' => []
            ];
        } else {
            $customer->deleted_at = Carbon::now();
            $customer->save();
            $status = 200;
            $response = [
                'status' => 'Success',
                'data' => $customer
            ];
        }
        return response()->json($response, $status);
    }

    public function restore(Request $request, $id)
    {
        $customer = Customer::find($id);

        if ($customer == NULL) {
            $status = 404;
            $response = [
                'status' => 'Data Not Found',
                'data' => []
            ];
        } else {
            $customer->updated_at = Carbon::now();
            $customer->deleted_at = NULL;
            $customer->idPegawaiLog = $request['idPegawaiLog'];

            $customer->save();
            $status = 200;
            $response = [
                'status' => 'Success',
                'data' => $customer
            ];
        }
        return response()->json($response, $status);
    }

    public function hapusPermanen($id)
    {
        $customer = Customer::find($id);

        if ($customer == NULL || $customer->deleted_at != NULL) {
            $status = 404;
            $response = [
                'status' => 'Data Not Found',
                'data' => []
            ];
        } else {
            $customer->delete();
            $status = 200;
            $response = [
                'status' => 'Success',
                'data' => $customer
            ];
        }
        return response()->json($response, $status);
    }
}
