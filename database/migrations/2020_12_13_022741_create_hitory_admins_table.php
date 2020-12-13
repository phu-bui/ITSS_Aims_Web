<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateHitoryAdminsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('historyAdmins', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('adminId');
            $table->string('act');
            $table->date('createDate');
            $table->integer('productId');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('historyAdmins');
    }
}
