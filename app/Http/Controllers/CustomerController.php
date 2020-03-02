<?php

namespace App\Http\Controllers;

use App\Customer;
use Illuminate\Http\Request;
use Carbon\Carbon;

class CustomerController extends Controller
{
    public function index()
    {
        $customer = Customer::where('deleted_at',null);
        $response = [
            'status' => 'Success',
            'data' => $customer
        ];
        return response()->json($response,200);
    }

    public function tampilSoftDelete(){
        $customer = Customer::where('created_at',null);
        $response = [
            'status' => 'Success',
            'data' => $customer
        ];
        return response()->json($response,200);
    }

    public function cariCustomer($cari)
    {
        $customer = Customer::where('id','like','%'.$cari.'%','or','namaCustomer','like','%'.$cari.'%')
        ->where('deleted_at',null)->get();

        if(sizeof($customer)==0)
        {
            $status=404;
            $response = [
                'status' => 'Data Not Found',
                'data' => []
            ];
        }
        else{
                
            $status=200;
            $response = [
                'status' => 'Success',
                'data' => $customer
            ];
        }
        return response()->json($response,$status); 
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

        try{
            $success = $customer->save();
            $status = 200;
            $response = [
                'status' => 'Success',
                'data' => $customer
            ];   
        }
        catch(\Illuminate\Database\QueryException $e){
            $status = 500;
            $response = [
                'status' => 'Error',
                'data' => [],
                'message' => $e
            ];
        }
        return response()->json($response,$status);
    }

    public function edit(Request $request, $id)
    {
        $customer = Customer::find($id);

        if($customer==NULL){
            $status=404;
            $response = [
                'status' => 'Data Not Found',
                'data' => []
            ];
        }
        else{
            $customer->namaCustomer = $request['namaCustomer'];
            $customer->alamat = $request['alamat'];
            $customer->tglLahir = $request['tglLahir'];
            $customer->noHp = $request['noHp'];
            $customer->updated_at = Carbon::now();
            $customer->idPegawaiLog = $request['idPegawaiLog'];
            
            try{
                $success = $customer->save();
                $status = 200;
                $response = [
                    'status' => 'Success',
                    'data' => $customer
                ];  
            }
            catch(\Illuminate\Database\QueryException $e){
                $status = 500;
                $response = [
                    'status' => 'Error',
                    'data' => [],
                    'message' => $e
                ];
            }
        }
        return response()->json($response,$status); 
    }

    public function hapus($id)
    {
        $customer = Customer::find($id);

        if($customer==NULL || $customer->deleted_at != NULL){
            $status=404;
            $response = [
                'status' => 'Data Not Found',
                'data' => []
            ];
        }
        else
        {
            $customer->created_at = NULL;
            $customer->updated_at = NULL;
            $customer->deleted_at = Carbon::now();
            $customer->save();
            $status=200;
            $response = [
                'status' => 'Success',
                'data' => $customer
            ];
        }
        return response()->json($response,$status); 
    }

    public function restore($id)
    {
        $customer = Customer::find($id);

        if($customer==NULL){
            $status=404;
            $response = [
                'status' => 'Data Not Found',
                'data' => []
            ];
        }
        else
        {
            $customer->created_at = Carbon::now();
            $customer->updated_at = Carbon::now();
            $customer->deleted_at = NULL;
            $customer->save();
            $status=200;
            $response = [
                'status' => 'Success',
                'data' => $customer
            ];
        }
        return response()->json($response,$status); 
    }

    public function hapusPermanen($id)
    {
        $customer = Customer::find($id);

        if($customer==NULL || $customer->deleted_at != NULL){
            $status=404;
            $response = [
                'status' => 'Data Not Found',
                'data' => []
            ];
        }
        else
        {
            $customer->delete();
            $status=200;
            $response = [
                'status' => 'Success',
                'data' => $customer
            ];
        }
        return response()->json($response,$status); 
    }
}