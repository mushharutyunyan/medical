<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDrugsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('drugs', function (Blueprint $table) {
            $table->increments('id');
            $table->string('trade_name')->comment = 'торговое название (Առևտրային անվանում)';
            $table->string('generic_name')->comment = 'вещество (Ազդող նյութ)';
            $table->string('dosage_form')->comment = 'форма (Դեղաձև)';
            $table->string('dosage_strength')->comment = 'дозировка (Դեղաչափ)';
            $table->string('code');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('drugs');
    }
}
