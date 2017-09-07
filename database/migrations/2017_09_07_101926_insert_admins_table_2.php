<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class InsertAdminsTable2 extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if(!\App\Models\Admin::all()->count()){
            $admin = new \App\Models\Admin();
            $admin->firstname = 'admin';
            $admin->lastname = 'admin';
            $admin->email = 'admin';
            $admin->password = bcrypt('123456');
            $admin->role_id = 1;
            $admin->organization_id = 1;
            $admin->save();
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
}
