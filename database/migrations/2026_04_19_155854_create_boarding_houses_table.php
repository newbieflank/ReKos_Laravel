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
        Schema::create('boarding_houses', function (Blueprint $table) {
            $table->id();
            $table->foreignId('owner_id')->constrained('users')->onDelete('cascade');
            $table->string('boarding_house_name');
            $table->text('alamat');
            $table->decimal('latitude', 11, 8);
            $table->decimal('longitude', 11, 8);
            $table->enum('boarding_house_type', ['male', 'female', 'mixed'])->default('mixed');
            $table->json('facilities')->nullable();
            $table->text('description')->nullable();
            $table->text('house_rule')->nullable();
            $table->decimal('rating')->default(0.0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('boarding_houses');
    }
};
