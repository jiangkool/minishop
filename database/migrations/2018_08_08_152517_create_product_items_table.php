<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProductItemsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('product_items', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('product_id');
            $table->string('norm')->comment('规格参数');
            $table->decimal('unit_price')->comment('单价');
            $table->integer('quantity')->comment('库存总数');
            $table->smallInteger('status')->comment('上架?');
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
        Schema::dropIfExists('product_items');
    }
}
