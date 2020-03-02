<?php

namespace App\Http\Controllers;

use App\Layanan;
use Illuminate\Http\Request;
use Carbon\Carbon;

class LayananController extends Controller
{
    public function index()
    {
        $layanan = Layanan::where('deleted_at',null);
        $response = [
            'status' => 'Success',
            'data' => $layanan
        ];
        return response()->json($response,200);
    }

    public function tampilSoftDelete()
    {
        $layanan = Layanan::where('created_at',null);
        $response = [
            'status' => 'Success',
            'data' => $layanan
        ];

        return response()->json($response,200);
    }

    public function cariLayanan($cari)
    {
        $layanan = Layanan::where('id','like','%'.$cari.'%','or','namaLayanan','like','%'.$cari.'%')
        ->where('deleted_at',null)->get();

        if(sizeof($layanan)==0)
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
                'data' => $layanan
            ];
        }
        return response()->json($response,$status); 
    }

    public function tambah(Request $request)
    {
        $layanan = new Layanan;
        $layanan->idLayanan = $this->generateIdLayanan();
        $layanan->namaLayanan = $request['namaLayanan'];
        $layanan->harga = $request['harga'];
        $layanan->idJenis = $request['idJenis'];
        $layanan->idUkuran = $request['idUkuran'];
        $layanan->created_at = Carbon::now();
        $layanan->updated_at = Carbon::now();

        try{
            $success = $layanan->save();
            $status = 200;
            $response = [
                'status' => 'Success',
                'data' => $layanan
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
        $layanan = Layanan::where('idLayanan',$id)->get();

        if($layanan==NULL){
            $status=404;
            $response = [
                'status' => 'Data Not Found',
                'data' => []
            ];
        }
        else{
            $layanan[0]->namaLayanan = $request['namaLayanan'];
            $layanan[0]->harga = $request['harga'];
            $layanan[0]->idJenis = $request['idJenis'];
            $layanan[0]->idUkuran = $request['idUkuran'];
            $layanan[0]->updated_at = Carbon::now();
            
            try{
                $success = $layanan->save();
                $status = 200;
                $response = [
                    'status' => 'Success',
                    'data' => $layanan
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
        $layanan = Layanan::where('idLayanan',$id)->get();

        if($layanan==NULL || $layanan->deleted_at != NULL){
            $status=404;
            $response = [
                'status' => 'Data Not Found',
                'data' => []
            ];
        }
        else
        {
            $layanan[0]->created_at = NULL;
            $layanan[0]->updated_at = NULL;
            $layanan[0]->deleted_at = Carbon::now();
            $layanan->save();
            $status=200;
            $response = [
                'status' => 'Success',
                'data' => $layanan
            ];
        }
        return response()->json($response,$status); 
    }

    public function restore($id)
    {
        $layanan = Layanan::where('idLayanan',$id)->get();

        if($layanan==NULL){
            $status=404;
            $response = [
                'status' => 'Data Not Found',
                'data' => []
            ];
        }
        else
        {
            $layanan[0]->created_at = Carbon::now();
            $layanan[0]->updated_at = Carbon::now();
            $layanan[0]->deleted_at = NULL;
            $layanan->save();
            $status=200;
            $response = [
                'status' => 'Success',
                'data' => $layanan
            ];
        }
        return response()->json($response,$status); 
    }

    public function hapusPermanen($id)
    {
        $layanan = Layanan::where('idLayanan',$id)->get();

        if($layanan==NULL || $layanan[0]->deleted_at != NULL){
            $status=404;
            $response = [
                'status' => 'Data Not Found',
                'data' => []
            ];
        }
        else
        {
            $layanan->delete();
            $status=200;
            $response = [
                'status' => 'Success',
                'data' => $layanan
            ];
        }
        return response()->json($response,$status); 
    }

    public function generateIdLayanan()
    {
        $layanan = Layanan::orderBy('created_at', 'desc')->first();

        if (isset($layanan)) 
        {
            $noTerakhir=substr($layanan->idLayanan,2);
            if($noTerakhir<9)
                return 'LY' . '00' . ($noTerakhir + 1);
            else if($noTerakhir<99)
                return 'LY' . '0' . ($noTerakhir + 1);
            else
                return 'LY' . ($noTerakhir + 1);
        } 
        else 
        {
            return 'LY' . '001';
        }
    }
}