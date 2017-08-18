<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UpdateOrderInfosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('order_infos', function (Blueprint $table) {
            $table->dropForeign(['drug_id']);
            $table->dropColumn('drug_id');
            $table->dropColumn('drug_settings');
            $table->integer('storage_id')->after('order_id')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('order_infos', function (Blueprint $table) {
            $table->integer('drug_id')->after('order_id');
            $table->text('drug_settings')->after('drug_id');
            $table->dropColumn('storage_id');
        });
    }
}
