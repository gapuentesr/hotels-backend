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
        Schema::create('room_types', function (Blueprint $table) {
            $table->id();
            $table->enum('type', ['Estándar', 'Junior', 'Suite']);
            $table->enum('accommodation', ['Sencilla', 'Doble', 'Triple', 'Cuádruple']);
            $table->integer('quantity');
            $table->foreignId('hotel_id')->constrained()->onDelete('cascade');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('room__types');
    }
};
