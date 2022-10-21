<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class CreateGridOperatorNettariffPropertiesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('grid_operator_nettariff_properties', function (Blueprint $table) {
            $table->id();
            $table->string('GLN_number', 16);
            $table->string('charge_type', 3);
            $table->string('charge_type_code', 20);
            $table->string('note', 99);
            $table->string('valid_from', 19);
            $table->string('valid_to', 19);
            $table->timestamps();
        });

        DB::table('grid_operator_nettariff_properties')->insert([
            ['GLN_Number'=>'5790000705689','charge_type' => 'D03', 'charge_type_code' => 'DT_C_01', 'note' =>  'Nettarif C time' ,'valid_from' => '2022-10-01', 'valid_to' => '2022-10-02'],
            ['GLN_Number'=>'5790000705184','charge_type' => 'D03', 'charge_type_code' => '30TR_C_ET', 'note' =>  'Nettarif C time' ,'valid_from' => '2022-10-01', 'valid_to' => '2022-10-02'],
        ]);


    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('grid_operator_nettariff_properties');
    }
}
