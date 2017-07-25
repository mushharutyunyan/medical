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
            $table->integer('delivery_status_id')->nullable();
            $table->tinyInteger('status');
            $table->string('file')->nullable();
            $table->timestamp('date')->nullable();
            $table->string('delivery_address')->nullable();
            $table->timestamps();
            $table->softDeletes();
            $table->foreign('to')->references('id')->on('organizations');
            $table->foreign('from')->references('id')->on('organizations');
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
