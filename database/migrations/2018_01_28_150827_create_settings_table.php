<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSettingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('settings', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('site_name');
            $table->string('logo');
            $table->string('enquiry_receiver');
            $table->boolean('smtp');
            $table->string('smtp_crypto', 3)->nullable();
            $table->string('smtp_host')->nullable();
            $table->smallInteger('smtp_port')->nullable();
            $table->string('smtp_email')->nullable();
            $table->string('smtp_password')->nullable();
            $table->string('default_meta_title');
            $table->text('default_meta_keywords')->nullable();
            $table->text('default_meta_description')->nullable();
            $table->text('embed_script_top')->nullable();
            $table->text('embed_script_bottom')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('settings');
    }
}
