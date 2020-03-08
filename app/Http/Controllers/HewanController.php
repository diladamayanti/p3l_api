<?php

namespace App\Http\Controllers;

use App\Hewan;
use Illuminate\Http\Request;
use Carbon\Carbon;

class HewanController extends Controller
{
    public function index()
    {
        $hewan = Hewan::where('deleted_at',null)->get();
        $response = [
            'status' => 'Success',
            'data' => $hewan
        ];
        return response()->json($response,200);
    }

    public function tampilSoftDelete()
    {
        $hewan = Hewan::where('deleted_at',!null)->get();
        $response = [
            'status' => 'Success',
            'data' => $hewan
        ];

        return response()->json($response,200);
    }

    public function cariHewan($cari)
    {
        $hewan = Hewan::where('idHewan','like','%'.$cari.'%','or','namaHewan','like','%'.$cari.'%')
        ->where('deleted_at',null)->get();

        if(sizeof($hewan)==0)
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
                'data' => $hewan
            ];
        }
        return response()->json($response,$status); 
    }

    public function tambah(Request $request)
    {
        $hewan = new Hewan;
        $hewan->namaHewan = $request['namaHewan'];
        $hewan->tglLahir = $request['tglLahir'];
        $hewan->idJenis = $request['idJenis'];
        $hewan->idCustomer = $request['idCustomer'];
        $hewan->created_at = Carbon::now();
        $hewan->updated_at = Carbon::now();
        $hewan->idPegawaiLog = $request['idPegawaiLog'];

        try{
            $success = $hewan->save();
            $status = 200;
            $response = [
                'status' => 'Success',
                'data' => $hewan
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
        $hewan = Hewan::find($id);

        if($hewan==NULL){
            $status=404;
            $response = [
                'status' => 'Data Not Found',
                'data' => []
            ];
        }
        else{
            $hewan->namaHewan = $request['namaHewan'];
            $hewan->tglLahir = $request['tglLahir'];
            $hewan->idJenis = $request['idJenis'];
            $hewan->idCustomer = $request['idCustomer'];
            $hewan->updated_at = Carbon::now();
            $hewan->idPegawaiLog = $request['idPegawaiLog'];
            
            try{
                $success = $hewan->save();
                $status = 200;
                $response = [
                    'status' => 'Success',
                    'data' => $hewan
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
        $hewan = Hewan::find($id);

        if($hewan==NULL || $hewan->deleted_at != NULL){
            $status=404;
            $response = [
                'status' => 'Data Not Found',
                'data' => []
            ];
        }
        else
        {
            $hewan->deleted_at = Carbon::now();
            $hewan->save();
            $status=200;
            $response = [
                'status' => 'Success',
                'data' => $hewan
            ];
        }
        return response()->json($response,$status); 
    }

    public function restore($id)
    {
        $hewan = Hewan::find($id);

        if($hewan==NULL){
            $status=404;
            $response = [
                'status' => 'Data Not Found',
                'data' => []
            ];
        }
        else
        {
            $hewan->updated_at = Carbon::now();
            $hewan->deleted_at = NULL;
            $hewan->idPegawaiLog = $request['idPegawaiLog'];

            $hewan->save();
            $status=200;
            $response = [
                'status' => 'Success',
                'data' => $hewan
            ];
        }
        return response()->json($response,$status); 
    }

    public function hapusPermanen($id)
    {
        $hewan = Hewan::find($id);

        if($hewan==NULL || $hewan->deleted_at != NULL){
            $status=404;
            $response = [
                'status' => 'Data Not Found',
                'data' => []
            ];
        }
        else
        {
            $hewan->delete();
            $status=200;
            $response = [
                'status' => 'Success',
                'data' => $hewan
            ];
        }
        return response()->json($response,$status); 
    }
}