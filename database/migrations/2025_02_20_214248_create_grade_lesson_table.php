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
        Schema::create('grade_lesson', function (Blueprint $table) {
            $table->id();
            $table->foreignId('lesson_id')
                ->constrained('lesson')
                ->onDelete('cascade');
            $table->foreignId('student_id')
                ->constrained('student')
                ->onDelete('cascade');
            $table->foreignId('user_id')
                ->constrained('users')
                ->onDelete('cascade');
            $table->string('description');
            $table->integer('grade')->default('5');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('grade_lesson');
    }
};
