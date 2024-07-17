<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddColumnTypeAndCopyrightIdToProjectsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::statement('ALTER TABLE `projects` MODIFY `lecture_id` BIGINT UNSIGNED NULL;');
        Schema::table('projects', function (Blueprint $table) {
            $table->string('type')->nullable()->after('status');
            $table->string('copyright_id')->nullable()->after('type');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('projects', function (Blueprint $table) {
            $table->dropColumn('type');
            $table->dropColumn('copyright_id');
        });
    }
}
