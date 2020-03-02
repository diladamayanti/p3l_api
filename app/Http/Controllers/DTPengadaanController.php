<?php

namespace App\Http\Controllers;

use App\DTPengadaan;
use Illuminate\Http\Request;
use Carbon\Carbon;

class DTPengadaanController extends Controller
{
    public function index()
    {
        $dt_Pengadaan = DTPengadaan::all();
        $response = [
            'status' => 'Success',
            'data' => $dt_Pengadaan
        ];
        return response()->json($response,200);
    }

    public function cariDTPengadaan($noPO)
    {
        $dt_Pengadaan = DTPengadaan::where('noPO','like','%'.$noPO.'%')->get();

        if(sizeof($dt_Pengadaan)==0)
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
                'data' => $dt_Pengadaan
            ];
        }
        return response()->json($response,$status); 
    }

    public function tambah(Request $request)
    {
        $dt_Pengadaan = new DTPengadaan;
        $dt_Pengadaan->noPO = $request['noPO'];
        $dt_Pengadaan->idProduk = $request['idProduk'];
        $dt_Pengadaan->jumlah = $request['jumlah'];
        $dt_Pengadaan->satuan = $request['satuan'];
        $dt_Pengadaan->subTotal = $request['subTotal'];

        try{
            $success = $dt_Pengadaan->save();
            $status = 200;
            $response = [
                'status' => 'Success',
                'data' => $dt_Pengadaan
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
        $dt_Pengadaan = DTPengadaan::find($id);

        if($dt_Pengadaan==NULL){
            $status=404;
            $response = [
                'status' => 'Data Not Found',
                'data' => []
            ];
        }
        else{
            $dt_Pengadaan->noPO = $request['noPO'];
            $dt_Pengadaan->idProduk = $request['idProduk'];
            $dt_Pengadaan->jumlah = $request['jumlah'];
            $dt_Pengadaan->satuan = $request['satuan'];
            $dt_Pengadaan->subTotal = $request['subTotal'];
            
            try{
                $success = $dt_Pengadaan->save();
                $status = 200;
                $response = [
                    'status' => 'Success',
                    'data' => $dt_Pengadaan
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
        $dt_Pengadaan = DTPengadaan::find($id);

        if($dt_Pengadaan==NULL){
            $status=404;
            $response = [
                'status' => 'Data Not Found',
                'data' => []
            ];
        }
        else{
            try{
                $success = $dt_Pengadaan->delete();
                $status = 200;
                $response = [
                    'status' => 'Success',
                    'data' => $dt_Pengadaan
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
