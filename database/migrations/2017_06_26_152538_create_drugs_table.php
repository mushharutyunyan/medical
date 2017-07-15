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
            $table->string('group');
            $table->string('series');
            $table->string('country');
            $table->string('manufacturer');
            $table->string('unit')->comment = 'измерение (Չափման միավոր)';
            $table->string('release_packaging')->comment = 'Форма производства (тип упаковки) (Թողարկման ձևը (փաթեթավորումը) )';
            $table->integer('count')->comment = 'Количество в упаковке (N) (тип упаковки) (Միավորների քանակը տուփում(N)) )';
            $table->decimal('unit_price',19,4);
            $table->string('supplier')->comment = 'поставщик (Մատակարար)';
            $table->string('type_belonging')->comment = '(տեսակային պատկանելիություն)';
            $table->string('certificate_number')->comment = '(Հավաստագրի համարը)';
            $table->string('registration_date')->comment = '(գրանցման ժամկետը)';
            $table->string('expiration_date')->comment = '(Պիտանիության ժամկետը)';
            $table->string('release_order')->comment = '(բացթողնման կարգը)';
            $table->string('registration_certificate_holder')->comment = '(Գրանցման հավաստագրի իրավատերը)';
            $table->string('character');
            $table->string('picture');
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
