<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateEventsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('events', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->timestamp('event_start_at');
            $table->timestamp('event_end_at');
            $table->string('rsvp_link');
            $table->boolean('is_active')->default(false);
            $table->softDeletes();
            $table->timestamps();
        });

        Schema::create('event_translations', function (Blueprint $table) {
            $table->bigIncrements('translation_id')->unsigned();
            $table->bigInteger('event_id')->unsigned();
            $table->bigInteger('language_id')->unsigned();
            $table->string('name');
            $table->timestamps();
        });

        Schema::table('event_translations', function (Blueprint $table) {
            $table->foreign('event_id')->references('id')->on('events');
            $table->foreign('language_id')->references('id')->on('languages');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('event_translations');
        Schema::dropIfExists('events');
    }
}
