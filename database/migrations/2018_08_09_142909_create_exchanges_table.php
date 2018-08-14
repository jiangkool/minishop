<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateExchangesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('exchanges', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('user_id');
            $table->integer('total')->comment('总计');
            $table->integer('amount')->comment('兑换|付款');
            $table->integer('current')->comment('目前');
            $table->string('model');
            $table->integer('status')->comment('1=积分 2=M币');
            $table->integer('type')->comment('方式 1=增加 2=减少');
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
        Schema::dropIfExists('exchanges');
    }
}
