<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePackagesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('packages', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('currency_id')->unsigned();

            $table->string('currency_code', 10)->index();
            $table->string('currency_symbol', 25);
            $table->string('currency_format', 50);
            $table->string('currency_exchange_rate');

            $table->string('package_type',50);
            $table->decimal('price', 10, 2)->default(0);
            $table->boolean('is_active')->default(false);
            $table->softDeletes();
            $table->timestamps();
        });

        Schema::table('packages', function (Blueprint $table) {
            $table->foreign('currency_id')->references('id')->on(config('currency.drivers.database.table'));
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('packages');
    }
}
