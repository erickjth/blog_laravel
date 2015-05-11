<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTwEntriesTable extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        Schema::create('twitter_entries', function (Blueprint $table) {
            $table->increments('id')->unsigned();
            $table->integer('tw_id');
            $table->string('tw_text', 200);
            $table->string('tw_name', 255);
            $table->string('tw_screen_name', 255);
            $table->bigInteger('tw_created_at', 255);
            $table->string('tw_profile_image_url', 255)->nullable()->default(null);;
            $table->integer('user_id');
            $table->boolean('is_hidden')->default(false);
            $table->bigInteger('time_hidden')->nullable()->default(null);
            $table->bigInteger('time_created');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down() {
        Schema::drop('twitter_entries');
    }

}
