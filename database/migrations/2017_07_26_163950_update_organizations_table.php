<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UpdateOrganizationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('organizations', function (Blueprint $table) {
            $table->string('identification_number')->after('apartment')->nullable();
            $table->string('bank_account_number')->after('identification_number')->nullable();
            $table->string('phone')->after('bank_account_number')->nullable();
            $table->string('image')->nullable();
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
            $table->dropColumn('identification_number');
            $table->dropColumn('bank_account_number');
            $table->dropColumn('phone');
            $table->dropColumn('image');
        });
    }
}
