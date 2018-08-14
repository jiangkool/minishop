<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUsersAppend extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->string('nickname')->nullable()->after('name');
            $table->smallInteger('gender')->nullable()->after('nickname');
            $table->string('avatar')->after('gender');
            $table->string('phone')->nullable()->after('avatar');
            $table->string('weixin_openid')->after('phone');
            $table->string('weixin_session_key')->nullable()->after('weixin_openid');
            $table->decimal('victory_total',10,2)->after('weixin_session_key')->comment('个人总业绩');
            $table->decimal('victory_current',10,2)->after('victory_total')->comment('当月业绩');
            $table->decimal('spend_total',10,2)->after('victory_current')->comment('个人总消费');
            $table->decimal('spend_current',10,2)->after('spend_total')->comment('当月消费');
            $table->decimal('integral_total',10,2)->after('spend_current')->comment('个人总积分');
            $table->decimal('integral_current',10,2)->after('integral_total')->comment('当前积分');
            $table->decimal('m_total',10,2)->after('integral_current')->comment('个人总M币');
            $table->decimal('m_current',10,2)->after('m_total')->comment('当前M币');
            $table->smallInteger('status')->after('m_current')->comment('身份 0=游客，1=申请会员， 2=会员');
            $table->string('session_id')->nullable()->after('status');
            $table->string('parent_id')->after('session_id')->comment('身份 0=游客，1=申请会员， 2=会员');
            $table->string('wechat')->nullable()->after('parent_id');
            $table->string('areas')->nullable()->after('wechat');
            $table->string('address')->nullable()->after('areas');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn('nickname');
            $table->dropColumn('gender');
            $table->dropColumn('avatar');
            $table->dropColumn('phone');
            $table->dropColumn('weixin_openid');
            $table->dropColumn('weixin_session_key');
            $table->dropColumn('victory_total');
            $table->dropColumn('victory_current');
            $table->dropColumn('spend_total');
            $table->dropColumn('spend_current');
            $table->dropColumn('integral_total');
            $table->dropColumn('integral_current');
            $table->dropColumn('m_total');
            $table->dropColumn('m_current');
            $table->dropColumn('status');
            $table->dropColumn('session_id');
            $table->dropColumn('parent_id');
            $table->dropColumn('wechat');
            $table->dropColumn('areas');
            $table->dropColumn('address');

        });
    }
}
