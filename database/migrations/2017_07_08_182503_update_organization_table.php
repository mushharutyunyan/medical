<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UpdateOrganizationTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('organizations', function (Blueprint $table) {
            $table->string('director')->nullable()->after('admin_id');
            $table->tinyInteger('status')->nullable()->after('director')->comment = ' 0 - superadmin ,1 - whole sale, 2 - pharmacy, 3 - other';
            $table->string('email')->nullable()->after('status');
            $table->string('city')->nullable()->after('email');
            $table->string('street')->nullable()->after('city');
            $table->string('apartment')->nullable()->after('street');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('organizations', function (Blueprint $table) {
            $table->dropColumn('director');
            $table->dropColumn('status');
            $table->dropColumn('email');
            $table->dropColumn('city');
            $table->dropColumn('street');
            $table->dropColumn('apartment');
        });
    }
}
