<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddErrorCodesToRequestStatistics extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('request_statistics', function (Blueprint $table) {
            $table->integer('400')->after('count')->default(0);
            $table->integer('401')->after('400')->default(0);
            $table->integer('403')->after('401')->default(0);
            $table->integer('429')->after('403')->default(0);
            $table->integer('500')->after('429')->default(0);
            $table->integer('503')->after('500')->default(0);
            $table->integer('504')->after('503')->default(0);
        });

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('request_statistics', function (Blueprint $table) {
            $table->dropColumn('400');
            $table->dropColumn('401');
            $table->dropColumn('403');
            $table->dropColumn('429');
            $table->dropColumn('500');
            $table->dropColumn('503');
            $table->dropColumn('504');
        });
    }
}
