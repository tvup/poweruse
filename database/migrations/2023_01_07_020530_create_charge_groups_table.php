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
        Schema::create('charge_groups', function (Blueprint $table) {
            $table->id();
            $table->integer('year');
            $table->string('charge_group_1', 10);
            $table->string('charge_group_2', 10);
            $table->string('grid_operator_gln', 17);
            $table->string('grid_operator_name', 50);
            $table->integer('number_of_metering_points');
            $table->bigInteger('consumption_kwh');
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
        Schema::dropIfExists('charge_groups');
    }
};
