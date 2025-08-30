<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProgressInisiatifsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('progress_inisiatifs', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('mentee_id');     // siapa pesertanya
            $table->unsignedBigInteger('inisiatif_id');  // inisiatif mana
            $table->boolean('is_checked')->default(false); // checklist (true/false)
            $table->date('start')->nullable();           // tanggal mulai
            $table->date('end')->nullable();             // tanggal selesai
            $table->enum('status', ['belum','proses','selesai'])->default('belum'); // status progress
            $table->integer('progress')->default(0);     // persen progress task ini
            $table->timestamps();

            // foreign key
            $table->foreign('mentee_id')->references('id')->on('mentees')->onDelete('cascade');
            $table->foreign('inisiatif_id')->references('id')->on('inisiatifs')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('progress_inisiatifs');
    }
}
