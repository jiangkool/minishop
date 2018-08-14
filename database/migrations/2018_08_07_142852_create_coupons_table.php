<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCouponsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('coupons', function (Blueprint $table) {
            $table->increments('id');
            $table->decimal('par_value',10,2)->comment('面值|单位:元');
            $table->decimal('more_value',10,2)->comment('满多少可用|单位:元');
            $table->string('title')->comment('描述');
            $table->integer('quantum')->comment('限量人数');
            $table->integer('receive')->default(0)->comment('领取人数');
            $table->dateTime('start_at');
            $table->dateTime('end_at');
            $table->integer('status');
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
        Schema::dropIfExists('coupons');
    }
}
