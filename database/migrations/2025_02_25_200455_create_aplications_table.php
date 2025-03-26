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
        Schema::create('aplications', function (Blueprint $table) {
            $table->id();
            $table->string('number');
            $table->string('name');
            $table->string('email');
            $table->integer('age')->nullable();
            $table->foreignId('branche_id')
                ->nullable()
                ->constrained('branches')
                ->onDelete('cascade');
            $table->foreignId('student_id')
                ->nullable()
                ->constrained('students')
                ->onDelete('cascade');
            $table->foreignId('employee_id')
                ->nullable()
                ->constrained('employees')
                ->onDelete('cascade');
            $table->enum('status', ['Новая','В работе', 'Отказ', 'Обработана', 'Созданная'])->default('Новая');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('aplications');
    }
};
