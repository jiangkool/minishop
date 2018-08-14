<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAppliesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('applies', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('user_id');
            $table->integer('parent_id');
            $table->string('username')->comment('姓名');
            $table->string('phone')->comment('手机号');
            $table->string('wechat')->comment('微信号');
            $table->string('areas')->comment('省市区');
            $table->string('details')->comment('详细地址');
            $table->integer('status')->comment('申请状态 0=待审核，1=通过，2=拒绝');
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
        Schema::dropIfExists('applies');
    }
}
