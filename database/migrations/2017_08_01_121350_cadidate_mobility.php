<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CadidateMobility extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (Schema::hasTable('c_profiles')) {
            Schema::table('c_profiles', function (Blueprint $table) {
                $table->text('mobility_by_state')->after('disponibility_date')->nullable();
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
        if (Schema::hasTable('c_profiles')) {
            Schema::table('c_profiles', function (Blueprint $table) {
                $table->removeColumn('mobility_by_state');
            });
        }
    }
}
