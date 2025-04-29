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
        Schema::create('modul_students', function (Blueprint $table) {
            $table->id();
            $table->date('last_payment_date')->nullable();
            $table->foreignId('group_id')
                ->constrained('groups')
                ->onDelete('cascade');
            $table->foreignId('student_id')
                ->constrained('students')
                ->onDelete('cascade');
            $table->foreignId('modul_id')
                ->constrained('moduls')
                ->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('modul_students');
    }
};
