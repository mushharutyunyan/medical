<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UpdateUserOrderTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('user_orders', function (Blueprint $table) {
            $table->dateTime('delivery_time')->after('delivery_address')->nullable();
            $table->double('stars')->after('take_time')->nullable();
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
            $table->dropColumn('delivery_time');
            $table->dropColumn('stars');
        });
    }
}
