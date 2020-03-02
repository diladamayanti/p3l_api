<?php

namespace App\Http\Controllers;

use App\TransaksiProduk;
use Illuminate\Http\Request;
use Carbon\Carbon;

class TransaksiProdukController extends Controller
{
    public function index()
    {
        $transaksiProduk = TransaksiProduk::where('deleted_at',null);
        $response = [
            'status' => 'Success',
            'data' => $transaksiProduk
        ];
        return response()->json($response,200);
    }

    public function tampilSoftDelete()
    {
        $transaksiProduk = TransaksiProduk::where('created_at',null);
        $response = [
            'status' => 'Success',
            'data' => $transaksiProduk
        ];

        return response()->json($response,200);
    }

    public function cariTransaksiProduk($noTransaksi)
    {
        $transaksiProduk = TransaksiProduk::where('noTransaksi','like','%'.$noTransaksi.'%')
        ->where('deleted_at',null)->get();

        if(sizeof($transaksiProduk)==0)
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
                'data' => $transaksiProduk
            ];
        }
        return response()->json($response,$status); 
    }

    public function tambah(Request $request)
    {
        $transaksiProduk = new TransaksiProduk;
        $transaksiProduk->noTransaksi = $this->generateNoTransaksi();
        $transaksiProduk->totalBiaya = $request['totalBiaya'];
        $transaksiProduk->statusPembayaran = $request['statusPembayaran'];
        $transaksiProduk->idCustomer = $request['idCustomer'];
        $transaksiProduk->idCustomerService = $request['idCustomerService'];
        $transaksiProduk->idKasir = $request['idKasir'];
        $transaksiProduk->created_at = Carbon::now();
        $transaksiProduk->updated_at = Carbon::now();
        $transaksiProduk->idPegawaiLog = $request['idPegawaiLog'];

        try{
            $success = $transaksiProduk->save();
            $status = 200;
            $response = [
                'status' => 'Success',
                'data' => $transaksiProduk
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
        $transaksiProduk = TransaksiProduk::find($id);

        if($transaksiProduk==NULL){
            $status=404;
            $response = [
                'status' => 'Data Not Found',
                'data' => []
            ];
        }
        else{
            $transaksiProduk->totalBiaya = $request['totalBiaya'];
            $transaksiProduk->statusPembayaran = $request['statusPembayaran'];
            $transaksiProduk->idCustomer = $request['idCustomer'];
            $transaksiProduk->idCustomerService = $request['idCustomerService'];
            $transaksiProduk->idKasir = $request['idKasir'];
            $transaksiProduk->updated_at = Carbon::now();
            $transaksiProduk->idPegawaiLog = $request['idPegawaiLog'];
            
            try{
                $success = $transaksiProduk->save();
                $status = 200;
                $response = [
                    'status' => 'Success',
                    'data' => $transaksiProduk
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
        $transaksiProduk = TransaksiProduk::find($id);

        if($transaksiProduk==NULL || $transaksiProduk->deleted_at != NULL){
            $status=404;
            $response = [
                'status' => 'Data Not Found',
                'data' => []
            ];
        }
        else
        {
            $transaksiProduk->created_at = NULL;
            $transaksiProduk->updated_at = NULL;
            $transaksiProduk->deleted_at = Carbon::now();
            $transaksiProduk->save();
            $status=200;
            $response = [
                'status' => 'Success',
                'data' => $transaksiProduk
            ];
        }
        return response()->json($response,$status); 
    }

    public function restore($id)
    {
        $transaksiProduk = TransaksiProduk::find($id);

        if($transaksiProduk==NULL){
            $status=404;
            $response = [
                'status' => 'Data Not Found',
                'data' => []
            ];
        }
        else
        {
            $transaksiProduk->created_at = Carbon::now();
            $transaksiProduk->updated_at = Carbon::now();
            $transaksiProduk->deleted_at = NULL;
            $transaksiProduk->save();
            $status=200;
            $response = [
                'status' => 'Success',
                'data' => $transaksiProduk
            ];
        }
        return response()->json($response,$status); 
    }

    public function hapusPermanen($id)
    {
        $transaksiProduk = TransaksiProduk::find($id);

        if($transaksiProduk==NULL || $transaksiProduk->deleted_at != NULL){
            $status=404;
            $response = [
                'status' => 'Data Not Found',
                'data' => []
            ];
        }
        else
        {
            $transaksiProduk->delete();
            $status=200;
            $response = [
                'status' => 'Success',
                'data' => $transaksiProduk
            ];
        }
        return response()->json($response,$status); 
    }

    public function generateNoTransaksi()
    {
        $transaksiProduk = TransaksiProduk::whereDate('created_at', date('Y-m-d'))
        ->orderBy('created_at', 'desc')->first();

        if (isset($transaksiProduk)) 
        {
            $noTerakhir=substr($transaksiProduk->noTransaksi,10);
            if($noTerakhir<9)
                return 'PR-' . date('ymd') . '-0' . ($noTerakhir + 1);
            else
                return 'PR-' . date('ymd') . '-' . ($noTerakhir + 1);
        } 
        else 
        {
            return 'PR-' . date('ymd') . '-01';
        }
    }
}
