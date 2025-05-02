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
        Schema::create('groups', function (Blueprint $table) {
            $table->id();
        
            $table->foreignId('branch_id')
                ->constrained('branches')
                ->onDelete('cascade');
                
            $table->foreignId('modul_id')
                ->constrained('moduls')
                ->onDelete('cascade');
                
            $table->foreignId('time_id')
                ->constrained('lesson_times')
                ->onDelete('cascade');
                
            $table->tinyInteger('day')->unsigned()
                ->between(1, 7);
                
            $table->timestamps();
            

            $table->unique(['branch_id', 'modul_id', 'time_id', 'day'], 'group_schedule_unique');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('groups');
    }
};
