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
            $table->string('identification_number')->after('apartment');
            $table->string('bank_account_number')->after('identification_number');
            $table->string('phone')->after('bank_account_number');
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
            $table->dropIfExists('identification_number');
            $table->dropIfExists('bank_account_number');
            $table->dropIfExists('phone');
        });
    }
}
