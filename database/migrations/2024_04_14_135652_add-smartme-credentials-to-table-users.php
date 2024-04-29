<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->string('smartme_username')->nullable()->after('api_access_token');
            $table->string('smartme_password')->nullable()->after('smartme_username');
            $table->string('smartme_directory_id')->nullable()->after('smartme_password');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn('smartme_username');
            $table->dropColumn('smartme_password');
            $table->dropColumn('smartme_directory_id');
        });
    }
};
