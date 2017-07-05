<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDrugTypeBelongingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('drug_type_belongings', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('drug_id')->unsigned();
            $table->string('name')->comment = '(տեսակային պատկանելիություն)';
            $table->timestamps();
            $table->softDeletes();
            $table->foreign('drug_id')->references('id')->on('drugs');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('drug_type_belongings');
    }
}
