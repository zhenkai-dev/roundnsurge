<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateInvoicesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('invoices', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('member_id')->unsigned()->nullable();
            $table->string('prefix', 10)->nullable();
            $table->integer('invoice_no')->unsigned();
            $table->string('auth_key');
            $table->string('billing_name');
            $table->string('billing_email');
            $table->string('billing_contact')->nullable();
            $table->string('billing_address1')->nullable();
            $table->string('billing_address2')->nullable();
            $table->string('billing_postcode')->nullable();
            $table->string('billing_city')->nullable();
            $table->string('billing_state')->nullable();
            $table->bigInteger('billing_country_id')->unsigned()->nullable();
            $table->integer('currency_id')->unsigned();
            $table->string('currency_code', 10)->index();
            $table->string('currency_symbol', 25);
            $table->string('currency_format', 50);
            $table->string('currency_exchange_rate');
            $table->decimal('amount', 10, 2)->default(0);
            $table->string('payment_method');
            $table->boolean('paid')->default(false);
            $table->decimal('paid_amount', 10, 2)->default(0);
            $table->timestamp('paid_date')->nullable();
            $table->string('invoice_status');
            $table->timestamps();
        });

        Schema::table('invoices', function (Blueprint $table) {
            $table->foreign('member_id')->references('id')->on('members');
            $table->foreign('billing_country_id')->references('id')->on('countries');
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
        Schema::dropIfExists('invoices');
    }
}
