<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePhysicalGoodDetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('physicalGoodDetails', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('productId');
            $table->integer('categoryId');
            $table->integer('idGood');
            $table->string('barCode');
            $table->string('dimensions');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('physicalGoodDetails');
    }
}
