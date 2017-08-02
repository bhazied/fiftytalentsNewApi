<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UpdateSponsorship extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (Schema::hasTable('sponsorships')) {
            Schema::table('sponsorships', function (Blueprint $table) {
                $table->string('first_name')->after('email')->nullable();
                $table->string('last_name')->after('first_name')->nullable();
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
        if (Schema::hasTable('sponsorships')) {
            Schema::table('sponsorships', function (Blueprint $table) {
                $table->removeColumn('first_name');
                $table->removeColumn('last_name');
            });
        }
    }
}
