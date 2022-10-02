<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateElspotpricesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('elspotprices', function (Blueprint $table) {
            $table->id();
            $table->timestamp('HourUTC')->nullable();
            $table->timestamp('HourDK')->nullable();
            $table->string('PriceArea')->nullable();
            $table->string('SpotPriceDKK')->nullable();
            $table->string('SpotPriceEUR')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('elspotprices');
    }
}
