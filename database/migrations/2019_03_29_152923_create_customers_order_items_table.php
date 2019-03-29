<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCustomersOrderItemsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('customers_order_items', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('order_id')->unsigned();
            $table->foreign('order_id')->references('id')->on('customers_orders')->onDelete('cascade');
            $table->integer('product_id');
            $table->string('product_type');
            $table->integer('is_shipping');
            $table->integer('shipping_cost')->nullable();
            $table->string('product_name')->nullable();
            $table->integer('product_quantity');
            $table->decimal('product_price', 15,2);
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
        Schema::dropIfExists('customers_order_items');
    }
}
