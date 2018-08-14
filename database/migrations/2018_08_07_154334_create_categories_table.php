<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCategoriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('categories', function (Blueprint $table) {
            $table->increments('id');
            $table->string('title')->comment('分类名');
            $table->string('icon')->nullable()->comment('图标');
            $table->integer('parent_id')->default(0)->comment('父级id');
            $table->integer('sort')->default(0)->comment('排序');
            $table->integer('status')->default(0)->comment('0 禁用 1 启用');
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
        Schema::dropIfExists('categories');
    }
}
