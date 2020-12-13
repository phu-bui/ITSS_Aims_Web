<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProductsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('products', function (Blueprint $table) {
            $table->bigIncrements('productId');
            $table->integer('categoryId');
            $table->integer('idGood');
            $table->string('title');
            $table->double('value');
            $table->string('image');
            $table->double('price');
            $table->string('description');
            $table->integer('quantity');
            $table->string('language');
            $table->date('inputDay');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('products');
    }
}
