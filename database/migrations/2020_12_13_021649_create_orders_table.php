<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOrdersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('order_no');
            $table->integer('userId');
            $table->integer('paymentId');
            $table->integer('shipId');
            $table->double('totalPrices');
            $table->dateTime('orderDate')->default(\DB::raw('CURRENT_TIMESTAMP'));
            $table->tinyInteger('orderStatus');
            $table->timestamps();
            $table->index(['order_no']);

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('orders');
    }
}
