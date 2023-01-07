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
            $table->string('GLN_Number', 16)->nullable();
            $table->string('ChargeType', 3);
            $table->string('ChargeTypeCode', 20);
            $table->string('Note', 99);
            $table->string('Description', 264); //Should only be 200 according to documentation, but can apparently be as large as 264
            $table->string('ValidFrom', 19);
            $table->string('ValidTo', 19)->nullable();
            $table->string('VATClass', 3);
            $table->float('Price1');
            $table->float('Price2')->nullable();
            $table->float('Price3')->nullable();
            $table->float('Price4')->nullable();
            $table->float('Price5')->nullable();
            $table->float('Price6')->nullable();
            $table->float('Price7')->nullable();
            $table->float('Price8')->nullable();
            $table->float('Price9')->nullable();
            $table->float('Price10')->nullable();
            $table->float('Price11')->nullable();
            $table->float('Price12')->nullable();
            $table->float('Price13')->nullable();
            $table->float('Price14')->nullable();
            $table->float('Price15')->nullable();
            $table->float('Price16')->nullable();
            $table->float('Price17')->nullable();
            $table->float('Price18')->nullable();
            $table->float('Price19')->nullable();
            $table->float('Price20')->nullable();
            $table->float('Price21')->nullable();
            $table->float('Price22')->nullable();
            $table->float('Price23')->nullable();
            $table->float('Price24')->nullable();
            $table->integer('TransparentInvoicing');
            $table->integer('TaxIndicator');
            $table->string('ResolutionDuration', 10);
            $table->timestamp('created_at')->nullable();
            $table->softDeletes();
            $table->primary(array('ChargeType', 'ChargeTypeCode', 'Note', 'ValidFrom'), 'primary_price');
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
