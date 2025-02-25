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
        Schema::create('transaction', function (Blueprint $table) {
            $table->id();
            $table->foreignId('product_id')
                ->constrained('product')
                ->onDelete('cascade');
            $table->foreignId('subsdiy_id')
                ->constrained('subsdiy')
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
        Schema::dropIfExists('transaction');
    }
};
