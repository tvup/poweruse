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
        Schema::table('datahub_price_lists', function (Blueprint $table) {
            $table->date('ValidFrom')->change();
            $table->date('ValidTo')->nullable()->change();
            $table->dropPrimary();
            $table->primary(array('ChargeType', 'ChargeTypeCode', 'GLN_number', 'ValidFrom', 'Note'), 'primary_price');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('datahub_price_lists', function (Blueprint $table) {
            $table->string('ValidFrom', 19)->change();
            $table->string('ValidTo', 19)->nullable()->change();
            $table->dropPrimary();
            $table->primary(array('ChargeType', 'ChargeTypeCode', 'Note', 'ValidFrom'), 'primary_price');
        });
    }
};
