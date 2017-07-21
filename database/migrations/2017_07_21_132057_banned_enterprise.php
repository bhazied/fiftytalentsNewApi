<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class BannedEnterprise extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if(Schema::hasTable('c_profiles')){
            Schema::table('c_profiles', function (Blueprint $table) {
                $table->text('banned_enterprise')->after('')->nullable();
            });
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        if(Schema::hasTable('c_profiles')){
            Schema::table('c_profiles', function (Blueprint $table) {
                //
            });
        }
    }
}
