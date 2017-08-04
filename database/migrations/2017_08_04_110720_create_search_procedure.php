<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSearchProcedure extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
//        DB::unprepared("CREATE PROCEDURE search( IN _name     VARCHAR(250) ) BEGIN
//                    SELECT * FROM (  SELECT
//                trade_name,
//                trade_name_ru,
//                trade_name_en,
//                drug_settings,
//                organizations.id,
//                organizations.name,
//                organizations.city || ' ' || organizations.street || ' ' || organizations.apartment as address,
//                organizations.phone,
//                sum(count) FROM (
//                SELECT
//                trade_name,
//                trade_name_ru,
//                trade_name_en,
//                storages.organization_id,
//                storages.drug_settings,
//                storages.count as count
//                FROM `drugs`
//                INNER JOIN storages
//                ON storages.drug_id = drugs.id
//                WHERE trade_name LIKE CONCAT('%', _name , '%')
//                OR trade_name_ru LIKE CONCAT('%', _name , '%')
//                OR trade_name_en LIKE CONCAT('%', _name , '%')
//                OR code LIKE CONCAT('%', _name , '%')
//                ORDER BY trade_name ASC
//                    ) as drugs
//                LEFT JOIN organizations
//                ON organizations.id = drugs.organization_id
//                WHERE organizations.status = 2 OR organizations.status = 3) as result
//                WHERE result.trade_name IS NOT NULL;
//                END");

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
//        $sql = "DROP PROCEDURE IF EXISTS search";
//        DB::connection()->getPdo()->exec($sql);
    }
}
