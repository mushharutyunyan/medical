<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDrugPackCountsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('drug_pack_counts', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('drug_id')->unsigned();
            $table->integer('count')->comment = 'Количество в упаковке (N) (тип упаковки) (Միավորների քանակը տուփում(N)) )';
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
        Schema::dropIfExists('drug_pack_counts');
    }
}
