<?php

namespace App\Http\Controllers;

use App\UkuranHewan;
use Illuminate\Http\Request;
use Carbon\Carbon;

class UkuranHewanController extends Controller
{
    public function index()
    {
        $ukuranHewan = UkuranHewan::where('deleted_at',null);
        $response = [
            'status' => 'Success',
            'data' => $ukuranHewan
        ];
        return response()->json($response,200);
    }

    public function tampilSoftDelete(){
        $ukuranHewan = UkuranHewan::where('deleted_at',!null);
        $response = [
            'status' => 'Success',
            'data' => $ukuranHewan
        ];
        return response()->json($response,200);
    }

    public function cariUkuran($cari)
    {
        $ukuranHewan = UkuranHewan::where('id','like','%'.$cari.'%','or','namaUkuran','like','%'.$cari.'%')
        ->where('deleted_at',null)->get();

        if(sizeof($ukuranHewan)==0)
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
                'data' => $ukuranHewan
            ];
        }
        return response()->json($response,$status); 
    }

    public function tambah(Request $request)
    {
        $ukuranHewan = new UkuranHewan;
        $ukuranHewan->namaUkuran = $request['namaUkuran'];
        $ukuranHewan->created_at = Carbon::now();
        $ukuranHewan->updated_at = Carbon::now();
        $ukuranHewan->idPegawaiLog = $request['idPegawaiLog'];

        try{
            $success = $ukuranHewan->save();
            $status = 200;
            $response = [
                'status' => 'Success',
                'data' => $ukuranHewan
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
        $ukuranHewan = UkuranHewan::find($id);

        if($ukuranHewan==NULL){
            $status=404;
            $response = [
                'status' => 'Data Not Found',
                'data' => []
            ];
        }
        else{
            $ukuranHewan->namaUkuran = $request['namaUkuran'];
            $ukuranHewan->updated_at = Carbon::now();
            $ukuranHewan->idPegawaiLog = $request['idPegawaiLog'];
            
            try{
                $success = $ukuranHewan->save();
                $status = 200;
                $response = [
                    'status' => 'Success',
                    'data' => $ukuranHewan
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
        $ukuranHewan = UkuranHewan::find($id);

        if($ukuranHewan==NULL || $ukuranHewan->deleted_at != NULL){
            $status=404;
            $response = [
                'status' => 'Data Not Found',
                'data' => []
            ];
        }
        else
        {
            $ukuranHewan->deleted_at = Carbon::now();
            $ukuranHewan->save();
            $status=200;
            $response = [
                'status' => 'Success',
                'data' => $jenisHewan
            ];
        }
        return response()->json($response,$status); 
    }

    public function restore($id)
    {
        $ukuranHewan = UkuranHewan::find($id);

        if($ukuranHewan==NULL){
            $status=404;
            $response = [
                'status' => 'Data Not Found',
                'data' => []
            ];
        }
        else
        {
            $ukuranHewan->updated_at = Carbon::now();
            $ukuranHewan->deleted_at = NULL;
            $ukuranHewan->idPegawaiLog = $request['idPegawaiLog'];

            $ukuranHewan->save();
            $status=200;
            $response = [
                'status' => 'Success',
                'data' => $ukuranHewan
            ];
        }
        return response()->json($response,$status); 
    }

    public function hapusPermanen($id)
    {
        $ukuranHewan = UkuranHewan::find($id);

        if($ukuranHewan==NULL || $ukuranHewan->deleted_at != NULL){
            $status=404;
            $response = [
                'status' => 'Data Not Found',
                'data' => []
            ];
        }
        else
        {
            $ukuranHewan->delete();
            $status=200;
            $response = [
                'status' => 'Success',
                'data' => $ukuranHewan
            ];
        }
        return response()->json($response,$status); 
    }
}
