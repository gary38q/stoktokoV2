<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePengirimenTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pengirimen', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('id_history_transaksi');
            $table->string('nama_penerima');
            $table->string('total_harga');
            $table->string('alamat_penerima')->nullable();
            $table->string('patokan_penerima')->nullable();
            $table->string('status_pengiriman');
            $table->date('created_date');
            $table->time('created_time');
            $table->date('send_date');
            $table->time('send_time');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('pengirimen');
    }
}
