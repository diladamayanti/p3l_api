<?php

use Illuminate\Http\Request;

Route::get('/user', function (Request $request) {return $request->user();})->middleware('auth:api');

//Produk
Route::get('produk','ProdukController@index');
Route::get('produk/{id}/gambar','ProdukController@tampilGambar');
Route::get('produk/softDelete','ProdukController@tampilSoftDelete');
Route::get('produk/cariProduk/{cari}','ProdukController@cariProduk');
Route::post('produk','ProdukController@tambah');
Route::post('produk/{id}/restore','ProdukController@restore');
Route::post('produk/update/{id}','ProdukController@edit');
Route::delete('produk/{id}','ProdukController@hapus');
Route::delete('produk/{id}/permanen','ProdukController@hapusPermanen');
Route::post('produk/uploadImage','ProdukController@uploadImage');

//jenisHewan
Route::get('jenisHewan','JenisHewanController@index');
Route::get('jenisHewan/softDelete','JenisHewanController@tampilSoftDelete');
Route::get('jenisHewan/cariJenis/{cari}','JenisHewanController@cariJenis');
Route::post('jenisHewan','JenisHewanController@tambah');
Route::post('jenisHewan/{id}/restore','JenisHewanController@restore');
Route::put('jenisHewan/{id}','JenisHewanController@edit');
Route::delete('jenisHewan/{id}','JenisHewanController@hapus');
Route::delete('jenisHewan/{id}/permanen','JenisHewanController@hapusPermanen');


//ukuranHewan
Route::get('ukuranHewan','UkuranHewanController@index');
Route::get('ukuranHewan/softDelete','UkuranHewanController@tampilSoftDelete');
Route::get('ukuranHewan/cariUkuran/{cari}','UkuranHewanController@cariUkuran');
Route::post('ukuranHewan','UkuranHewanController@tambah');
Route::post('ukuranHewan/{id}/restore','UkuranHewanController@restore');
Route::put('ukuranHewan/{id}','UkuranHewanController@edit');
Route::delete('ukuranHewan/{id}','UkuranHewanController@hapus');
Route::delete('ukuranHewan/{id}/permanen','UkuranHewanController@hapusPermanen');

//Layanan
Route::get('layanan','LayananController@index');
Route::get('layanan/softDelete','LayananController@tampilSoftDelete');
Route::get('layanan/cariLayanan/{cari}','LayananController@cariLayanan');
Route::post('layanan','LayananController@tambah');
Route::post('layanan/{id}/restore','LayananController@restore');
Route::put('layanan/{id}','LayananController@edit');
Route::delete('layanan/{id}','LayananController@hapus');
Route::delete('layanan/{id}/permanen','LayananController@hapusPermanen');

//Pegawai
Route::get('pegawai','PegawaiController@index');
Route::get('pegawai/{NIP}/gambar','PegawaiController@tampilGambar');
Route::get('pegawai/softDelete','PegawaiController@tampilSoftDelete');
Route::get('pegawai/cariPegawai/{cari}','PegawaiController@cariPegawai');
Route::post('pegawai/login','PegawaiController@login');
Route::post('pegawai','PegawaiController@tambah');
Route::post('pegawai/{NIP}/restore','PegawaiController@restore');
Route::post('pegawai/update/{NIP}','PegawaiController@edit');
Route::delete('pegawai/{NIP}','PegawaiController@hapus');
Route::delete('pegawai/{NIP}/permanen','PegawaiController@hapusPermanen');

//Customer
Route::get('customer','CustomerController@index');
Route::get('customer/softDelete','CustomerController@tampilSoftDelete');
Route::get('customer/cariCustomer/{cari}','CustomerController@cariCustomer');
Route::post('customer','CustomerController@tambah');
Route::post('customer/{id}/restore','CustomerController@restore');
Route::put('customer/{id}','CustomerController@edit');
Route::delete('customer/{id}','CustomerController@hapus');
Route::delete('customer/{id}/permanen','CustomerController@hapusPermanen');

//Hewan
Route::get('hewan','HewanController@index');
Route::get('hewan/softDelete','HewanController@tampilSoftDelete');
Route::get('hewan/cariHewan/{cari}','HewanController@cariHewan');
Route::post('hewan','HewanController@tambah');
Route::post('hewan/{id}/restore','HewanController@restore');
Route::put('hewan/{id}','HewanController@edit');
Route::delete('hewan/{id}','HewanController@hapus');
Route::delete('hewan/{id}/permanen','HewanController@hapusPermanen');

//Supplier
Route::get('supplier','SupplierController@index');
Route::get('supplier/softDelete','SupplierController@tampilSoftDelete');
Route::get('supplier/cariSupplier/{cari}','SupplierController@cariSupplier');
Route::post('supplier','SupplierController@tambah');
Route::post('supplier/{id}/restore','SupplierController@restore');
Route::put('supplier/{id}','SupplierController@edit');
Route::delete('supplier/{id}','SupplierController@hapus');
Route::delete('supplier/{id}/permanen','SupplierController@hapusPermanen');

//Pengadaan
Route::get('transaksiPengadaan','TransaksiPengadaanController@index');
Route::get('transaksiPengadaan/cariPengadaan/{cari}','TransaksiPengadaanController@cariPengadaan');
Route::post('transaksiPengadaan','TransaksiPengadaanController@tambah');
Route::put('transaksiPengadaan/{id}','TransaksiPengadaanController@edit');
Route::delete('transaksiPengadaan/{id}','TransaksiPengadaanController@hapus');

//TransaksiProduk
Route::get('transaksiProduk','TransaksiProdukController@index');
Route::get('transaksiProduk/cariTransaksiProduk/{cari}','TransaksiProdukController@cariTransaksiProduk');
Route::post('transaksiProduk','TransaksiProdukController@tambah');
Route::put('transaksiProduk/{id}','TransaksiProdukController@edit');
Route::delete('transaksiProduk/{id}','TransaksiProdukController@hapus');

//TransaksiLayanan
Route::get('transaksiLayanan','TransaksiLayananController@index');
Route::get('transaksiLayanan/cariTransaksiLayanan/{cari}','TransaksiLayananController@cariTransaksiLayanan');
Route::post('transaksiLayanan','TransaksiLayananController@tambah');
Route::put('transaksiLayanan/{id}','TransaksiLayananController@edit');
Route::delete('transaksiLayanan/{id}','TransaksiLayananController@hapus');

//Detail Transaksi Layanan
Route::get('dtLayanan','DTLayananController@index');
Route::get('dtLayanan/cariDTLayanan/{noTransaksi}','DTLayananController@cariDTLayanan');
Route::post('dtLayanan','DTLayananController@tambah');
Route::put('dtLayanan/{id}','DTLayananController@edit');
Route::delete('dtLayanan/{id}','DTLayananController@hapus');

//Detail Transaksi Pengadaan
Route::get('dtPengadaan','DTPengadaanController@index');
Route::get('dtPengadaan/cariDTPengadaan/{noPO}','DTPengadaanController@cariDTPengadaan');
Route::post('dtPengadaan','DTPengadaanController@tambah');
Route::put('dtPengadaan/{id}','DTPengadaanController@edit');
Route::delete('dtPengadaan/{id}','DTPengadaanController@hapus');

//Detail Transaksi Produk
Route::get('dtProduk','DTProdukController@index');
Route::get('dtProduk/cariDTProduk/{noTransaksi}','DTProdukController@cariDTProduk');
Route::post('dtProduk','DTProdukController@tambah');
Route::put('dtProduk/{id}','DTProdukController@edit');
Route::delete('dtProduk/{id}','DTProdukController@hapus');