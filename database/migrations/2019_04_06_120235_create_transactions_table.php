<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTransactionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('transactions', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('amount');
            $table->string('firstname');
            $table->string('lastname');
            $table->integer('state_id');
            $table->integer('city_id');
            $table->longText('address');
            $table->string('phone');
            $table->string('currency')->nullable();
            $table->string('status')->default('pending');
            $table->uuid('reference')->index();
            $table->uuid('additional_info')->nullable();
            $table->string('gateway_response')->nullable();
            $table->string('message')->nullable();
            $table->string('channel')->nullable();
            $table->string('ip_address')->nullable();
            $table->string('log')->nullable();
            $table->string('history')->nullable();
            $table->string('fees')->nullable();
            $table->string('authorization')->nullable();
            $table->string('customer')->nullable();
            $table->string('plan')->nullable();
            $table->integer('user_id')->nullable();
            $table->string('user_email');
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
        Schema::dropIfExists('transactions');
    }
}
