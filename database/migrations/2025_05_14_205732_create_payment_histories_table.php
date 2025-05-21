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
        Schema::create('payment_histories', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')
                ->constrained('users')
                ->onDelete('cascade');
            $table->foreignId('student_id')
                ->constrained('students')
                ->onDelete('cascade');
            $table->decimal('amount', 8, 2);
            $table->dateTime('paid_at')->nullable();
            $table->boolean('cash')->default(false);
            $table->string('payment_id')->nullable();
            $table->json('metadata')->nullable();
            $table->enum('status', ['pending', 'confirmed', 'rejected'])->default('pending');
            $table->timestamps();
            
            $table->index('payment_id');
            $table->index('user_id');
            $table->index('status');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('payment_histories');
    }
};
