<?php

namespace App\Http\Controllers;

use App\TransaksiLayanan;
use Illuminate\Http\Request;
use Carbon\Carbon;

class TransaksiLayananController extends Controller
{
    public function index()
    {
        $transaksiLayanan = TransaksiLayanan::where('deleted_at',null);
        $response = [
            'status' => 'Success',
            'data' => $transaksiLayanan
        ];
        return response()->json($response,200);
    }

    public function tampilSoftDelete()
    {
        $transaksiLayanan = TransaksiLayanan::where('created_at',null);
        $response = [
            'status' => 'Success',
            'data' => $transaksiLayanan
        ];

        return response()->json($response,200);
    }

    public function cariTransaksiLayanan($noTransaksi)
    {
        $transaksiLayanan = TransaksiLayanan::where('noTransaksi','like','%'.$noTransaksi.'%')
        ->where('deleted_at',null)->get();

        if(sizeof($transaksiLayanan)==0)
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
                'data' => $transaksiLayanan
            ];
        }
        return response()->json($response,$status); 
    }

    public function tambah(Request $request)
    {
        $transaksiLayanan = new TransaksiLayanan;
        $transaksiLayanan->noTransaksi = $this->generateNoTransaksi();
        $transaksiLayanan->totalBiaya = $request['totalBiaya'];
        $transaksiLayanan->statusLayanan = $request['statusLayanan'];
        $transaksiLayanan->statusPembayaran = $request['statusPembayaran'];
        $transaksiLayanan->idCustomer = $request['idCustomer'];
        $transaksiLayanan->idCustomerService = $request['idCustomerService'];
        $transaksiLayanan->idKasir = $request['idKasir'];
        $transaksiLayanan->created_at = Carbon::now();
        $transaksiLayanan->updated_at = Carbon::now();

        try{
            $success = $transaksiLayanan->save();
            $status = 200;
            $response = [
                'status' => 'Success',
                'data' => $transaksiLayanan
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
        $transaksiLayanan = TransaksiLayanan::find($id);

        if($transaksiLayanan==NULL){
            $status=404;
            $response = [
                'status' => 'Data Not Found',
                'data' => []
            ];
        }
        else{
            $transaksiLayanan->totalBiaya = $request['totalBiaya'];
            $transaksiLayanan->statusLayanan = $request['statusLayanan'];
            $transaksiLayanan->statusPembayaran = $request['statusPembayaran'];
            $transaksiLayanan->idCustomer = $request['idCustomer'];
            $transaksiLayanan->idCustomerService = $request['idCustomerService'];
            $transaksiLayanan->idKasir = $request['idKasir'];
            $transaksiLayanan->updated_at = Carbon::now();
            
            try{
                $success = $transaksiLayanan->save();
                $status = 200;
                $response = [
                    'status' => 'Success',
                    'data' => $transaksiLayanan
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
        $transaksiLayanan = TransaksiLayanan::find($id);

        if($transaksiLayanan==NULL || $transaksiLayanan->deleted_at != NULL){
            $status=404;
            $response = [
                'status' => 'Data Not Found',
                'data' => []
            ];
        }
        else
        {
            $transaksiLayanan->created_at = NULL;
            $transaksiLayanan->updated_at = NULL;
            $transaksiLayanan->deleted_at = Carbon::now();
            $transaksiLayanan->save();
            $status=200;
            $response = [
                'status' => 'Success',
                'data' => $transaksiLayanan
            ];
        }
        return response()->json($response,$status); 
    }

    public function restore($id)
    {
        $transaksiLayanan = TransaksiLayanan::find($id);

        if($transaksiLayanan==NULL){
            $status=404;
            $response = [
                'status' => 'Data Not Found',
                'data' => []
            ];
        }
        else
        {
            $transaksiLayanan->created_at = Carbon::now();
            $transaksiLayanan->updated_at = Carbon::now();
            $transaksiLayanan->deleted_at = NULL;
            $transaksiLayanan->save();
            $status=200;
            $response = [
                'status' => 'Success',
                'data' => $transaksiLayanan
            ];
        }
        return response()->json($response,$status); 
    }

    public function hapusPermanen($id)
    {
        $transaksiLayanan = TransaksiLayanan::find($id);

        if($transaksiLayanan==NULL || $transaksiLayanan->deleted_at != NULL){
            $status=404;
            $response = [
                'status' => 'Data Not Found',
                'data' => []
            ];
        }
        else
        {
            $transaksiLayanan->delete();
            $status=200;
            $response = [
                'status' => 'Success',
                'data' => $transaksiLayanan
            ];
        }
        return response()->json($response,$status); 
    }

    public function generateNoTransaksi()
    {
        $transaksiLayanan = TransaksiLayanan::whereDate('created_at', date('Y-m-d'))
        ->orderBy('created_at', 'desc')->first();

        if (isset($transaksiLayanan)) 
        {
            $noTerakhir=substr($transaksiLayanan->noTransaksi,10);
            if($noTerakhir<9)
                return 'LY-' . date('ymd') . '-0' . ($noTerakhir + 1);
            else
                return 'LY-' . date('ymd') . '-' . ($noTerakhir + 1);
        } 
        else 
        {
            return 'LY-' . date('ymd') . '-01';
        }
    }
}
