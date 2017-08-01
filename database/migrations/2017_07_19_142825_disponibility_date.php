<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class DisponibilityDate extends Migration
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
                $table->timestamp('disponibility_date')->after('favorite_salary')->nullable();
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
                $table->removeColumn('disponibility_date');
            });
        }
    }
}
