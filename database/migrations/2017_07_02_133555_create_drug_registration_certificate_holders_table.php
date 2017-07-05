<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDrugRegistrationCertificateHoldersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('drug_registration_certificate_holders', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('drug_id')->unsigned();
            $table->string('name')->comment = '(Գրանցման հավաստագրի իրավատերը)';
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
        Schema::dropIfExists('drug_registration_certificate_holders');
    }
}
