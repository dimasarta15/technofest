<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Schema;

class AlterUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->unsignedBigInteger('major_id')->after('country_id')->nullable();
            $table->string('custom_major')->after('major_id')->nullable();
        });

        Artisan::call('major:fix');
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        /* Schema::table('projects', function (Blueprint $table) {
            $table->integer('major_id');
            $table->string('custom_major');
        }); */
        
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn('major_id');
            $table->dropColumn('custom_major');
        });
    }
}
