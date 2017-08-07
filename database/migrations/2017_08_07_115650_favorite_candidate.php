<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class FavoriteCandidate extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!Schema::hasTable('favorite_candidates')) {
            Schema::create('favorite_candidates', function (Blueprint $table) {
                $table->increments('id');
                $table->integer('c_profile_id')->unsigned()->nullable();
                $table->integer('e_profile_id')->unsigned()->nullable();
                $table->timestamps();
                $table->foreign('c_profile_id')->references('id')->on('c_profiles')->onDelete('set null');
                $table->foreign('e_profile_id')->references('id')->on('e_profiles')->onDelete('set null');
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
        if (Schema::hasTable('favorite_candidates')) {
            Schema::table('favorite_candidates', function (Blueprint $table) {
                $table->dropForeign('favorite_candidates_c_profile_id_foreign');
                $table->dropForeign('favorite_candidates_e_profile_id_foreign');
            });
            Schema::dropIfExists('favorite_candidates');
        }
    }
}
