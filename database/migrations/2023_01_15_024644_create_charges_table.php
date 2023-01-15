<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('charges', function (Blueprint $table) {
            $table->id();
            $table->string('type', 12);
            $table->string('name', 132)->nullable();
            $table->text('description')->nullable();
            $table->text('owner')->nullable();
            $table->dateTime('valid_from');
            $table->dateTime('valid_to')->nullable();
            $table->string('period_type')->nullable();
            $table->decimal('price',12,4)->nullable();
            $table->string('quantity')->nullable();
            $table->bigInteger('metering_point_id');
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
        Schema::dropIfExists('charges');
    }
};
