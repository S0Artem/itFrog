<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('applications', function (Blueprint $table) {
            $table->string('status')->default('Новая')->change();
        });

        DB::table('applications')
            ->where('status', 'Созданная')
            ->update(['status' => 'Пользователь создан']);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        DB::table('applications')
            ->where('status', 'Пользователь создан')
            ->update(['status' => 'Созданная']);
            
        DB::table('applications')
            ->where('status', 'Готовая')
            ->update(['status' => 'Обработана']);

        Schema::table('applications', function (Blueprint $table) {
            $table->string('status')->default('Новая')->change();
        });
    }
};
