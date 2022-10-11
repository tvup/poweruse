<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDatahubPriceListsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('datahub_price_lists', function (Blueprint $table) {
            $table->string('ChargeOwner', 60);
            $table->string('GLN_Number', 16);
            $table->string('ChargeType', 3);
            $table->string('ChargeTypeCode', 20);
            $table->string('Note', 99);
            $table->string('Description', 200);
            $table->string('ValidFrom', 19);
            $table->string('ValidTo', 19);
            $table->string('VATClass', 3);
            $table->float('Price1');
            $table->float('Price2');
            $table->float('Price3');
            $table->float('Price4');
            $table->float('Price5');
            $table->float('Price6');
            $table->float('Price7');
            $table->float('Price8');
            $table->float('Price9');
            $table->float('Price10');
            $table->float('Price11');
            $table->float('Price12');
            $table->float('Price13');
            $table->float('Price14');
            $table->float('Price15');
            $table->float('Price16');
            $table->float('Price17');
            $table->float('Price18');
            $table->float('Price19');
            $table->float('Price20');
            $table->float('Price21');
            $table->float('Price22');
            $table->float('Price23');
            $table->float('Price24');
            $table->integer('TransparentInvoicing');
            $table->integer('TaxIndicator');
            $table->string('ResolutionDuration', 10);
            $table->timestamp('created_at')->nullable();
            $table->softDeletes();
            $table->primary(array('GLN_Number', 'ChargeType', 'ChargeTypeCode', 'Note', 'ValidFrom', 'ValidTo'), 'primary_price');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('datahub_price_lists');
    }
}
