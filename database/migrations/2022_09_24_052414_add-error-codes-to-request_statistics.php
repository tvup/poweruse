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

        $defaultDatabaseConnectionName = config('database.default');
        $databaseName = config('database.connections.' . $defaultDatabaseConnectionName. ' . database');

        DB::unprepared('DROP PROCEDURE IF EXISTS insert_to_statistics; CREATE PROCEDURE insert_to_statistics (IN verb varchar(50),IN endpoint varchar(255),IN httpcode varchar(50))


BEGIN
  SET @sql = CONCAT(\'Update  ' . $databaseName . '.request_statistics set `\', httpcode, \'`=\', \'`\',httpcode,\'`\', \' +1 \', \' where `verb`=\\\'\',verb,\'\\\' and `endpoint`=\\\'\',endpoint,\'\\\'\');
  PREPARE stmt FROM @sql;
  EXECUTE stmt;
  DEALLOCATE PREPARE stmt;


END');
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        DB::unprepared('DROP PROCEDURE IF EXISTS insert_to_statistics; ');

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
