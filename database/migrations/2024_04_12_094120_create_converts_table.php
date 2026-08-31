<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateConvertsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('converts', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('convert_id_product');
            $table->string('converted_product_name',255);
            $table->unsignedBigInteger('id_product');
            $table->string('satuan_barang');
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
        Schema::dropIfExists('converts');
    }
}
