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
        Schema::create('modul_student', function (Blueprint $table) {
            $table->id();
            $table->foreignId('groups_id')
                ->constrained('groups')
                ->onDelete('cascade');
            $table->foreignId('student_id')
                ->constrained('student')
                ->onDelete('cascade');
            $table->foreignId('moduls_id')
                ->constrained('moduls')
                ->onDelete('cascade');
            $table->integer('paid')->default(4);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('modul_student');
    }
};
