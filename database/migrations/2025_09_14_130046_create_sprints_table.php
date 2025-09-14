<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSprintsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sprints', function (Blueprint $table) {
            $table->id();
            // Relasi ke tabel tasks
            $table->unsignedBigInteger('task_id');
            $table->foreign('task_id')->references('id')->on('tasks')->onDelete('cascade');

            // Relasi ke tabel inisiatifs
            $table->unsignedBigInteger('inisiatif_id');
            $table->foreign('inisiatif_id')->references('id')->on('inisiatifs')->onDelete('cascade');

            $table->date('mulai')->nullable();
            $table->date('selesai')->nullable();
            $table->enum('status', ['pending', 'progress', 'done'])->default('pending');

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
        Schema::dropIfExists('sprints');
    }
}
