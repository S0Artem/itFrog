<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('progect_student', function (Blueprint $table) {
            $table->id();
            $table->foreignId('student_id')
                ->constrained('student')
                ->onDelete('cascade');
            $table->foreignId('moduls_id')
                ->constrained('moduls')
                ->onDelete('cascade');
            $table->string('progect');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('progect_student');
    }
};
