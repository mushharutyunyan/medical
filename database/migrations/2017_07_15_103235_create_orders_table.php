<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateOrdersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('to')->unsigned();
            $table->integer('from')->unsigned();
            $table->string('file');
            $table->tinyInteger('status')->comment = '1 - Processing to, 2 - Processing from, 3 - Accepting to, 4 - Accepting from';
            $table->timestamps();
            $table->softDeletes();
            $table->foreign('to')->references('id')->on('admins');
            $table->foreign('from')->references('id')->on('admins');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('orders');
    }
}
