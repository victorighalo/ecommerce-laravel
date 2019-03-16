<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAppSettingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('app_settings', function (Blueprint $table) {
            $table->string('store_name');
            $table->string('store_description')->nullable();
            $table->string('store_about')->nullable();
            $table->string('store_address')->nullable();
            $table->string('store_email')->nullable();
            $table->string('store_facebook')->nullable();
            $table->string('store_twitter')->nullable();
            $table->string('store_instagram')->nullable();
            $table->string('store_linkedin')->nullable();
            $table->string('store_youtube')->nullable();
            $table->string('store_phone')->nullable();
            $table->increments('id');
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
        Schema::dropIfExists('app_settings');
    }
}
