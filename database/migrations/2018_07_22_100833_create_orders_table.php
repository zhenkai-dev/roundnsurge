<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateOrderTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('member_id')->unsigned()->nullable();
            $table->integer('currency_id')->unsigned();
            $table->string('order_no');
            $table->string('email');
            $table->string('username');
            $table->string('currency_code', 10)->index();
            $table->string('currency_symbol', 25);
            $table->string('currency_format', 50);
            $table->string('currency_exchange_rate');
            $table->decimal('amount', 10, 2)->default(0);
            $table->string('item_name');
            $table->string('order_type');
            $table->text('order_details');
            $table->timestamps();
        });

        Schema::table('orders', function (Blueprint $table) {
            $table->foreign('member_id')->references('id')->on('members');
            $table->foreign('currency_id')->references('id')->on('currencies');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('orders');
    }
}
