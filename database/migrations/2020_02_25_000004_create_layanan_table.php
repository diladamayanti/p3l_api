<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateLayananTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('layanan', function (Blueprint $table) {
            $table->string('idLayanan');
            $table->primary('idLayanan');
            $table->string('namaLayanan');
            $table->double('harga');
            $table->integer('idJenis')->unsigned();
            $table->foreign('idJenis')->references('idJenis')->on('jenisHewan');
            $table->integer('idUkuran')->unsigned();
            $table->foreign('idUkuran')->references('idUkuran')->on('ukuranHewan');
            $table->dateTime('created_at')->nullable();
            $table->dateTime('updated_at')->nullable();
            $table->dateTime('deleted_at')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('layanan');
    }
}
