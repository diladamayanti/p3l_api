<?php

use Illuminate\Database\Seeder;

class ProdukSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Faker::create('id_ID');
 
        $produk = ['Shampoo',''];
    	for($i = 1; $i <= 50; $i++){
 
    	      // insert data ke table pegawai menggunakan Faker
    		DB::table('produks')->insert([
    			'nama' => $faker->name,
    			'pegawai_jabatan' => $faker->jobTitle,
    			'pegawai_umur' => $faker->numberBetween(25,40),
    			'pegawai_alamat' => $faker->address
    		]);
 
    	}
    }
}
