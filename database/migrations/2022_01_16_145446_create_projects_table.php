<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProjectsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('projects', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');
            $table->unsignedBigInteger('category_id');
            $table->unsignedBigInteger('semester_id');
            $table->unsignedBigInteger('major_id');
            $table->unsignedBigInteger('lecture_id');
            $table->integer('status')->comment('0=nonaktif, 1=aktif');
            $table->string('lang')->default('id');
            $table->string('title');
            $table->text('desc');
            // $table->string('lecture');
            $table->string('github_link')->nullable();
            $table->string('demo_link')->nullable();
            $table->string('video_link')->nullable();
            $table->dateTime('approved_at')->nullable();
            $table->integer('is_migrated')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('projects');
    }
}
