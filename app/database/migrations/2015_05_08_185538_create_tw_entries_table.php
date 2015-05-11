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
            $table->bigInteger('tw_id');
            $table->string('content', 200);
            $table->integer('user_id');
            $table->bigInteger('is_hidden');
            $table->bigInteger('hidden_at');
            $table->bigInteger('created_at');
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
