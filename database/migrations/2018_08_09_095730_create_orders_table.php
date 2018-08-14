<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

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
            $table->increments('id');
            $table->integer('user_id');
            $table->string('pay_id');
            $table->string('consignee')->comment('收件人');
            $table->string('phone');
            $table->string('address')->comment('收件地址');
            $table->decimal('tradetotal',10,2)->comment('订单总金额');
            $table->decimal('preferentialtotal',10,2)->comment('订单优惠金额');
            $table->decimal('customerfreightfee',10,2)->comment('邮费');
            $table->decimal('total',10,2)->comment('订单实付金额（实际应付）');
            $table->string('out_trade_no')->comment('订单编号');
            $table->string('freightbillno')->comment('物流单号');
            $table->smallInteger('status')->comment('订单状态 0=待付,1=失效,2=已付,3=发货,4=已收（待评),5=完成');
            $table->smallInteger('type')->comment('付款方式 0=微信支付，1=M币支付');
            $table->text('remark')->comment('备注：买家留言');
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
        Schema::dropIfExists('orders');
    }
}
