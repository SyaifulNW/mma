<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateInisiatifsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('inisiatifs', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('task_id');  // hubungkan ke task
            $table->string('teks');                 // teks inisiatif
            $table->string('dokumen')->nullable();  // dokumen terkait
            $table->timestamps();

            $table->foreign('task_id')->references('id')->on('tasks')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('inisiatifs');
    }
}
