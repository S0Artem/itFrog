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
        Schema::create('aplication', function (Blueprint $table) {
            $table->id();
            $table->string('number');
            $table->string('name');
            $table->integer('age');
            $table->foreignId('subsidiary_id')
                ->constrained('subsidiary')
                ->onDelete('cascade');
            $table->foreignId('student_id')
                ->constrained('student')
                ->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('aplication');
    }
};
