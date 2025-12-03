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
        Schema::create('global_ptkps', function (Blueprint $table) {
            $table->id();
            $table->string('code')->unique(); // TK/0, K/1, dll
            $table->decimal('amount', 15, 2); // Nilai PTKP Tahunan
            $table->enum('ter_category', ['A', 'B', 'C']); // Kategori TER 2024
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('global_ptkps');
    }
};
