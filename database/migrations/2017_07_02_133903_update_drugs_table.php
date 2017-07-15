<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UpdateDrugsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('drugs', function (Blueprint $table) {
            $table->string('trade_name_ru')->nullable()->after('trade_name');
            $table->string('trade_name_en')->nullable()->after('trade_name_ru');
            $table->string('trade_name')->nullable()->change();
            $table->string('generic_name')->nullable()->change();
            $table->string('dosage_form')->nullable()->change();
            $table->string('dosage_strength')->nullable()->change();
            $table->string('code')->nullable()->change();
            $table->dropColumn('group');
            $table->dropColumn('series');
            $table->dropColumn('country');
            $table->dropColumn('manufacturer');
            $table->dropColumn('unit');
            $table->dropColumn('release_packaging');
            $table->dropColumn('count');
            $table->dropColumn('unit_price');
            $table->dropColumn('supplier');
            $table->dropColumn('type_belonging');
            $table->dropColumn('certificate_number');
            $table->dropColumn('registration_date');
            $table->dropColumn('expiration_date');
            $table->dropColumn('release_order');
            $table->dropColumn('registration_certificate_holder');
            $table->dropColumn('character');
            $table->dropColumn('picture');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('drugs', function (Blueprint $table) {
            $table->dropColumn('trade_name_ru');
            $table->dropColumn('trade_name_eng');
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
        });
    }
}
