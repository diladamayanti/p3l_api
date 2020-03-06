<?php

namespace App\Http\Controllers;

use App\JenisHewan;
use Illuminate\Http\Request;
use Carbon\Carbon;

class JenisHewanController extends Controller
{
    public function index()
    {
        $jenisHewan = JenisHewan::where('deleted_at',null);
        $response = [
            'status' => 'Success',
            'data' => $jenisHewan
        ];
        return response()->json($response,200);
    }

    public function tampilSoftDelete(){
        $jenisHewan = JenisHewan::where('deleted_at',!null);
        $response = [
            'status' => 'Success',
            'data' => $jenisHewan
        ];
        return response()->json($response,200);
    }

    public function cariJenis($cari)
    {
        $jenisHewan = JenisHewan::where('id','like','%'.$cari.'%','or','namaJenis','like','%'.$cari.'%')
        ->where('deleted_at',null)->get();

        if(sizeof($jenisHewan)==0)
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
                'data' => $jenisHewan
            ];
        }
        return response()->json($response,$status); 
    }

    public function tambah(Request $request)
    {
        $jenisHewan = new JenisHewan;
        $jenisHewan->namaJenis = $request['namaJenis'];
        $jenisHewan->created_at = Carbon::now();
        $jenisHewan->updated_at = Carbon::now();
        $jenisHewan->idPegawaiLog = $request['idPegawaiLog'];

        try{
            $success = $jenisHewan->save();
            $status = 200;
            $response = [
                'status' => 'Success',
                'data' => $jenisHewan
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
        $jenisHewan = JenisHewan::find($id);
        if($jenisHewan==NULL){
            $status=404;
            $response = [
                'status' => 'Data Not Found',
                'data' => []
            ];
        }
        else{
            $jenisHewan->namaJenis = $request['namaJenis'];
            $jenisHewan->updated_at = Carbon::now();
            $jenisHewan->idPegawaiLog = $request['idPegawaiLog'];
            
            try{
                $success = $jenisHewan->save();
                $status = 200;
                $response = [
                    'status' => 'Success',
                    'data' => $jenisHewan
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
        $jenisHewan = JenisHewan::find($id);

        if($jenisHewan==NULL || $jenisHewan->deleted_at != NULL){
            $status=404;
            $response = [
                'status' => 'Data Not Found',
                'data' => []
            ];
        }
        else
        {
            $jenisHewan->deleted_at = Carbon::now();
            $jenisHewan->save();
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
        $jenisHewan = JenisHewan::find($id);

        if($jenisHewan==NULL){
            $status=404;
            $response = [
                'status' => 'Data Not Found',
                'data' => []
            ];
        }
        else
        {
            $jenisHewan->updated_at = Carbon::now();
            $jenisHewan->deleted_at = NULL;
            $jenisHewan->idPegawaiLog = $request['idPegawaiLog'];

            $jenisHewan->save();
            $status=200;
            $response = [
                'status' => 'Success',
                'data' => $jenisHewan
            ];
        }
        return response()->json($response,$status); 
    }

    public function hapusPermanen($id)
    {
        $jenisHewan = JenisHewan::find($id);

        if($jenisHewan==NULL || $jenisHewan->deleted_at != NULL){
            $status=404;
            $response = [
                'status' => 'Data Not Found',
                'data' => []
            ];
        }
        else
        {
            $jenisHewan->delete();
            $status=200;
            $response = [
                'status' => 'Success',
                'data' => $jenisHewan
            ];
        }
        return response()->json($response,$status); 
    }
}
