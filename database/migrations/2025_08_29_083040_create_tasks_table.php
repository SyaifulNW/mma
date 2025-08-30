<?php

use App\Models\Tahapan;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTasksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tasks', function (Blueprint $table) {
            $table->id();

            $table->unsignedBigInteger('materi_id');   // hubungkan ke materi
            $table->unsignedBigInteger('tahapan_id');    // hubungkan ke tahapan
            $table->string('judul'); 
            $table->string('deskripsi');                 // nama task
            $table->timestamps();

            $table->foreign('materi_id')->references('id')->on('materi')->onDelete('cascade');
            $table->foreign('tahapan_id')->references('id')->on('tahapan')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('tasks');
        
    }
}
