<?php

namespace App\Http\Controllers;

use App\DTProduk;
use Illuminate\Http\Request;
use Carbon\Carbon;

class DTProdukController extends Controller
{
    public function index()
    {
        $dt_Produk = DTProduk::all();
        $response = [
            'status' => 'Success',
            'data' => $dt_Produk
        ];
        return response()->json($response,200);
    }

    public function cariDTProduk($noTransaksi)
    {
        $dt_Produk = DTProduk::where('noTransaksi','like','%'.$noTransaksi.'%')->get();

        if(sizeof($dt_Produk)==0)
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
                'data' => $dt_Produk
            ];
        }
        return response()->json($response,$status); 
    }

    public function tambah(Request $request)
    {
        $dt_Produk = new DTProduk;
        $dt_Produk->noTransaksi = $request['noTransaksi'];
        $dt_Produk->idProduk = $request['idProduk'];
        $dt_Produk->jumlah = $request['jumlah'];
        $dt_Produk->subTotal = $request['subTotal'];
        $dt_Produk->tglTransaksi = Carbon::now();

        try{
            $success = $dt_Produk->save();
            $status = 200;
            $response = [
                'status' => 'Success',
                'data' => $dt_Produk
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
        $dt_Produk = DTProduk::find($id);

        if($dt_Produk==NULL){
            $status=404;
            $response = [
                'status' => 'Data Not Found',
                'data' => []
            ];
        }
        else{
            $dt_Produk->noTransaksi = $request['noTransaksi'];
            $dt_Produk->idProduk = $request['idProduk'];
            $dt_Produk->jumlah = $request['jumlah'];
            $dt_Produk->subTotal = $request['subTotal'];
            
            try{
                $success = $dt_Produk->save();
                $status = 200;
                $response = [
                    'status' => 'Success',
                    'data' => $dt_Produk
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
        $dt_Produk = DTProduk::find($id);

        if($dt_Produk==NULL){
            $status=404;
            $response = [
                'status' => 'Data Not Found',
                'data' => []
            ];
        }
        else{
            try{
                $success = $dt_Produk->delete();
                $status = 200;
                $response = [
                    'status' => 'Success',
                    'data' => $dt_Produk
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
}
