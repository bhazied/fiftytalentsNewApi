<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSponsorshipsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!Schema::hasTable('sponsorships')) {
            Schema::create('sponsorships', function (Blueprint $table) {
                $table->increments('id');
                $table->string('email');
                $table->text('token');
                $table->enum('status', ['waiting', 'cancled', 'accepted'])->default('waiting');
                $table->integer('subscriber_id')->unsigned()->nullable();
                $table->timestamps();
                $table->foreign('subscriber_id')->references('id')->on('subscribers')->onDelete('set null');
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
                $table->dropForeign('sponsorships_subscriber_id_foreign');
            });
        }
        Schema::dropIfExists('sponsorships');
    }
}
