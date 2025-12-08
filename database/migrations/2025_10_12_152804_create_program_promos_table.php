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
        Schema::create('program_promos', function (Blueprint $table) {
            $table->id();
            $table->string('nama_promo', 200);
            $table->string('benefit_value', 200);
            $table->string('status', 200)->default('active');
            $table->string('deskripsi', 200)->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('program_promos');
    }
};
