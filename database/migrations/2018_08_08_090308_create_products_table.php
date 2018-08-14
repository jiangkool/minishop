<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

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
            $table->increments('id');
            $table->integer('category_id');
            $table->string('title')->comment('商品名称');
            $table->json('images');
            $table->decimal('pre_price', 10, 2)->comment('商品基础价格');
            $table->decimal('diff_price', 10, 2)->comment('商品差价和会员价之差');
            $table->decimal('share_price', 10, 2)->comment('分享赚');
            $table->integer('sale_num')->default(0)->comment('销量');
            $table->string('description')->comment('简述');
            $table->string('content')->comment('商品详情');
            $table->smallInteger('type')->comment('0=普通商品,1=今日推荐,2=独家定制,3=限时秒杀,4=M币专区');
             $table->smallInteger('status')->comment('状态0=下架,1=在售');
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
        Schema::dropIfExists('products');
    }
}
