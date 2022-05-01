<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateHomePricesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('home_prices', function (Blueprint $table) {
            $table->increments('id');
            $table->uuid('uuid')->unique()->comment('Globally unique identifier for home prices');
            $table->timestamp('date')->nullable();
            $table->float('price', 5, 2)->nullable()->default(null)->index('price');
            $table->integer('bedrooms')->nullable()->default(null);
            $table->float('bathrooms', 5, 2)->nullable()->default(null);
            $table->integer('sqft_living')->nullable()->default(null)->index('sqft_living');
            $table->integer('sqft_lot')->nullable()->default(null);
            $table->float('floors', 5, 2)->nullable()->default(null);
            $table->tinyInteger('waterfront')->nullable()->default(null);
            $table->tinyInteger('view')->nullable()->default(null);
            $table->integer('condition')->nullable()->default(null);
            $table->integer('sqft_above')->nullable()->default(null);
            $table->integer('sqft_basement')->nullable()->default(null);
            $table->integer('year_built')->nullable()->default(null);
            $table->integer('year_renovated')->nullable()->default(null);
            $table->string('street')->nullable();
            $table->string('city')->nullable();
            $table->string('state_zip')->nullable();
            $table->string('country')->nullable();
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
        Schema::dropIfExists('home_prices');
    }
}
