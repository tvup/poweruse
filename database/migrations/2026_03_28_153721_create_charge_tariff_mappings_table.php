<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('charge_tariff_mappings', function (Blueprint $table) {
            $table->id();
            $table->string('charge_name', 132);
            $table->string('charge_owner_gln', 16);
            $table->string('datahub_note', 99)->nullable();
            $table->string('datahub_gln', 16)->nullable();
            $table->string('datahub_charge_type', 3)->nullable();
            $table->string('datahub_description', 264)->nullable();
            $table->boolean('verified')->default(false);
            $table->timestamps();

            $table->unique(['charge_name', 'charge_owner_gln'], 'charge_tariff_mapping_unique');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('charge_tariff_mappings');
    }
};
