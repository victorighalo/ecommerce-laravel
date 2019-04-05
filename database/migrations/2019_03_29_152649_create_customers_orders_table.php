<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCustomersOrdersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('customers_orders', function (Blueprint $table) {
            $table->increments('id');
            $table->string('status');
            $table->integer('user_id')->nullable();
            $table->integer('is_shipping');
            $table->integer('shipping_cost')->nullable();
            $table->integer('delivery_id')->unsigned();
            $table->foreign('order_id')->references('id')->on('customers_orders')->onDelete('cascade');
            $table->integer('session_id')->nullable();
            $table->mediumText('notes')->nullable();
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
        Schema::dropIfExists('customers_orders');
    }
}
