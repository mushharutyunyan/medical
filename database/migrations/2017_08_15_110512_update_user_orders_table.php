<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UpdateUserOrdersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('user_orders', function (Blueprint $table) {
            $table->integer('pay_method')->after('status')->nullable();
            $table->integer('pay_type')->after('pay_method')->nullable();
            $table->string('delivery_address')->after('pay_type')->nullable();
            $table->datetime('take_time')->after('delivery_address')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('user_orders', function (Blueprint $table) {
            $table->dropColumn('pay_method');
            $table->dropColumn('pay_type');
            $table->dropColumn('delivery_address');
            $table->dropColumn('take_time');
        });
    }
}
