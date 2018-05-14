<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePackageTranslationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('package_translations', function (Blueprint $table) {
            $table->bigIncrements('translation_id')->unsigned();
            $table->bigInteger('package_id')->unsigned();
            $table->bigInteger('language_id')->unsigned();
            $table->string('name');
            $table->text('description')->nullable();
        });

        Schema::table('package_translations', function (Blueprint $table) {
            $table->foreign('currency_id')->references('id')->on('packages');
            $table->foreign('package_id')->references('id')->on('packages');
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
        Schema::dropIfExists('package_translations');
    }
}
