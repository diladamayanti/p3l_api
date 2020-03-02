<?php

namespace App\Http\Controllers;

use App\Produk;
use Illuminate\Http\Request;
use Carbon\Carbon;
use finfo;

class ProdukController extends Controller
{
    public function index()
    {
        $produk = Produk::all('idProduk','namaProduk','harga','stok','jumlahMinimal','created_at','updated_at','deleted_at')->where('deleted_at',null);
        $response = [
            'status' => 'Success',
            'data' => $produk
        ];
        return response()->json($response,200);
    }

    public function tampilSoftDelete()
    {
        $produk = Produk::all('idProduk','namaProduk','harga','stok','jumlahMinimal','created_at','updated_at','deleted_at')->where('created_at',null);
        $response = [
            'status' => 'Success',
            'data' => $produk
        ];

        return response()->json($response,200);
    }

    public function cariProduk($cari)
    {
        $produk = Produk::select('idProduk','namaProduk','harga','stok','jumlahMinimal','created_at','updated_at','deleted_at')
        ->where('id','like','%'.$cari.'%','or','namaProduk','like','%'.$cari.'%')
        ->where('deleted_at',null)->get();

        if(sizeof($produk)==0)
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
                'data' => $produk
            ];
        }
        return response()->json($response,$status); 
    }

    public function tambah(Request $request)
    {
        $produk = new Produk;
        $produk->idProduk = $this->generateIdProduk();
        $produk->namaProduk = $request['namaProduk'];
        $produk->harga = $request['harga'];
        $produk->stok = $request['stok'];
        $produk->jumlahMinimal = $request['jumlahMinimal'];
        $produk->gambar = $this->upload();
        $produk->created_at = Carbon::now();
        $produk->updated_at = Carbon::now();

        
        if($produk->gambar == 1)
        {
            $status = 500;
            $response =[
                'status' => 'Error',
                'data' => [],
                'message' =>  "Gambar harus memiliki format jpg or jpeg or png or gif..."
            ];
        }
        else
        {
       
            try{
                $success = $produk->save();
                $status = 200;
                $response = [
                    'status' => 'Success',
                    'data' => [
                        'idProduk'=>$produk->idProduk,
                        'namaProduk'=>$produk->namaProduk,
                        'harga'=>$produk->harga,
                        'stok'=>$produk->stok,
                        'jumlahMinimal'=>$produk->jumlahMinimal,
                        'created_at'=>$produk->created_at,
                        'updated_at'=>$produk->updated_at,
                    ]
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

    public function edit(Request $request, $id)
    {
        $produk = Produk::find($id);

        if($produk==NULL){
            $status=404;
            $response = [
                'status' => 'Data Not Found',
                'data' => []
            ];
        }
        else{
            $produk->namaProduk = $request['namaProduk'];
            $produk->harga = $request['harga'];
            $produk->stok = $request['stok'];
            $produk->jumlahMinimal = $request['jumlahMinimal'];
            $produk->updated_at = Carbon::now();

            if($_FILES['gambar']['error'] != 4){
                $produk->gambar= $this->upload();
            }
            
            try{
                $success = $produk->save();
                $status = 200;
                $response = [
                    'status' => 'Success',
                    'data' => [
                        'idProduk'=>$produk->idProduk,
                        'namaProduk'=>$produk->namaProduk,
                        'harga'=>$produk->harga,
                        'stok'=>$produk->stok,
                        'jumlahMinimal'=>$produk->jumlahMinimal,
                        'created_at'=>$produk->created_at,
                        'updated_at'=>$produk->updated_at,
                    ]
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
        $produk = Produk::find($id);

        if($produk==NULL || $produk->deleted_at != NULL){
            $status=404;
            $response = [
                'status' => 'Data Not Found',
                'data' => []
            ];
        }
        else
        {
            $produk->created_at = NULL;
            $produk->updated_at = NULL;
            $produk->deleted_at = Carbon::now();
            $produk->save();
            $status=200;
            $response = [
                'status' => 'Success',
                'data' => [
                    'idProduk'=>$produk->idProduk,
                    'namaProduk'=>$produk->namaProduk,
                    'harga'=>$produk->harga,
                    'stok'=>$produk->stok,
                    'jumlahMinimal'=>$produk->jumlahMinimal,
                    'created_at'=>$produk->created_at,
                    'updated_at'=>$produk->updated_at,
                    'deleted_at'=>$produk->deleted_at,
                ]
            ];
        }
        return response()->json($response,$status); 
    }

    public function restore($id)
    {
        $produk = Produk::find($id);

        if($produk==NULL){
            $status=404;
            $response = [
                'status' => 'Data Not Found',
                'data' => []
            ];
        }
        else
        {
            $produk->created_at = Carbon::now();
            $produk->updated_at = Carbon::now();
            $produk->deleted_at = NULL;
            $produk->save();
            $status=200;
            $response = [
                'status' => 'Success',
                'data' => [
                    'idProduk'=>$produk->idProduk,
                    'namaProduk'=>$produk->namaProduk,
                    'harga'=>$produk->harga,
                    'stok'=>$produk->stok,
                    'jumlahMinimal'=>$produk->jumlahMinimal,
                    'created_at'=>$produk->created_at,
                    'updated_at'=>$produk->updated_at,
                    'deleted_at'=>$produk->deleted_at,
                ]
            ];
        }
        return response()->json($response,$status); 
    }

    public function hapusPermanen($id)
    {
        $produk = Produk::find($id);

        if($produk==NULL || $produk->deleted_at != NULL){
            $status=404;
            $response = [
                'status' => 'Data Not Found',
                'data' => []
            ];
        }
        else
        {
            $produk->delete();
            $status=200;
            $response = [
                'status' => 'Success',
                'data' => [
                    'idProduk'=>$produk->idProduk,
                    'namaProduk'=>$produk->namaProduk,
                    'harga'=>$produk->harga,
                    'stok'=>$produk->stok,
                    'jumlahMinimal'=>$produk->jumlahMinimal,
                    'created_at'=>$produk->created_at,
                    'updated_at'=>$produk->updated_at,
                    'deleted_at'=>$produk->deleted_at,
                ]
            ];
        }
        return response()->json($response,$status); 
    }

    public function tampilGambar($id){
        $produk = Produk::find($id);

        if($produk==NULL || $produk->deleted_at != NULL){
            $status=404;
            $response = [
                'status' => 'Data Not Found',
                'data' => []
            ];
            return response()->json($response,$status); 
        }
        else{
            return response()->make($produk->gambar, 200, array(
                'Content-Type' => (new finfo(FILEINFO_MIME))->buffer($produk->gambar)));
        }
    }

    function upload(){

        $namaFile = $_FILES['gambar']['name'];
        $ukuranFile = $_FILES['gambar']['size'];
        $error = $_FILES['gambar']['error'];
        $tmpName = $_FILES['gambar']['tmp_name'];

         //mengecek file gambar atau bukan
        $ekstensiGambarValid = ['jpg','jpeg','png','gif'];
        $ekstensiGambar = explode('.',$namaFile);
        $ekstensiGambar = strtolower(end($ekstensiGambar));
        if(!in_array($ekstensiGambar, $ekstensiGambarValid)){
            return 1;
        }
        
        $gambar=$this->scaleImageFileToBlob($tmpName);
    
        return $gambar;
    }

    function scaleImageFileToBlob($file) {

        $source_pic = $file;
        $max_width = 200;
        $max_height = 200;
    
        list($width, $height, $image_type) = getimagesize($file);
    
        switch ($image_type)
        {
            case 1: $src = imagecreatefromgif($file); break;
            case 2: $src = imagecreatefromjpeg($file);  break;
            case 3: $src = imagecreatefrompng($file); break;
            default: return '';  break;
        }
    
        $x_ratio = $max_width / $width;
        $y_ratio = $max_height / $height;
    
        if( ($width <= $max_width) && ($height <= $max_height) ){
            $tn_width = $width;
            $tn_height = $height;
            }elseif (($x_ratio * $height) < $max_height){
                $tn_height = ceil($x_ratio * $height);
                $tn_width = $max_width;
            }else{
                $tn_width = ceil($y_ratio * $width);
                $tn_height = $max_height;
        }
    
        $tmp = imagecreatetruecolor($tn_width,$tn_height);
    
        /* Check if this image is PNG or GIF, then set if Transparent*/
        if(($image_type == 1) OR ($image_type==3))
        {
            imagealphablending($tmp, false);
            imagesavealpha($tmp,true);
            $transparent = imagecolorallocatealpha($tmp, 255, 255, 255, 127);
            imagefilledrectangle($tmp, 0, 0, $tn_width, $tn_height, $transparent);
        }
        imagecopyresampled($tmp,$src,0,0,0,0,$tn_width, $tn_height,$width,$height);
    
        ob_start();
    
        switch ($image_type)
        {
            case 1: imagegif($tmp); break;
            case 2: imagejpeg($tmp, NULL, 100);  break; // best quality
            case 3: imagepng($tmp, NULL, 0); break; // no compression
            default: echo ''; break;
        }
    
        $final_image = ob_get_contents();
    
        ob_end_clean();
    
        return $final_image;
    }

    public function generateIdProduk()
    {
        $produk = Produk::orderBy('created_at', 'desc')->first();

        if (isset($produk)) 
        {
            $noTerakhir=substr($produk->idProduk,2);
            if($noTerakhir<9)
                return 'PR' . '000' . ($noTerakhir + 1);
            else if($noTerakhir<99)
                return 'PR' . '00' . ($noTerakhir + 1);
            else if($noTerakhir<999)
                return 'PR' . '0' . ($noTerakhir + 1);
            else
                return 'PR' . ($noTerakhir + 1);
        } 
        else 
        {
            return 'PR' . '0001';
        }
    }
}
