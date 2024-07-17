<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFormCustomsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('form_customs', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('semester_id');
            $table->string('label')->comment("Pertanyaan yang tampil di web");
            $table->string('type')->comment("Combobox, Text, Number, Date, Choose File");
            $table->string('name')->comment("Untuk name pada tag input");
            $table->string('placeholder')->comment("Untuk placeholder inputan");
            $table->integer('seq');
            $table->integer('status')->comment('1 = aktif, 0 = nonaktif');
            $table->string('caption')->nullable()->comment("Untuk memberi caption pada masing2 inputan");
            $table->text('validator')->nullable()->comment("Untuk validasi laravel, ex: required, dll");

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
        Schema::dropIfExists('form_customs');
    }
}
