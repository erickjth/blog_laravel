<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateEntriesTable extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        Schema::create('entries', function (Blueprint $table) {
            $table->increments('id')->unsigned();
            $table->string('title', 255);
            $table->text('content');
            $table->text('tags')->nullable()->default(null);
            $table->integer('user_id');
            $table->bigInteger('time_created');
            $table->bigInteger('time_updated');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down() {
        Schema::drop('entries');
    }

}
