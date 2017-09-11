<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UpdateUserOrdersTable2 extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('user_orders', function (Blueprint $table) {
            $table->string('unknown_user_email')->after('stars')->nullable();
            $table->string('unknown_user_phone')->after('unknown_user_email')->nullable();
            $table->string('unknown_user_name')->after('unknown_user_phone')->nullable();
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
            $table->dropColumn('unknown_user_email')->nullable();
            $table->dropColumn('unknown_user_phone')->nullable();
            $table->dropColumn('unknown_user_name')->nullable();
        });
    }
}
