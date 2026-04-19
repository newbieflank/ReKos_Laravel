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
        Schema::create('boarding_house_reviews', function (Blueprint $table) {
            $table->id();
            $table->foreignId('tenant_id')->constrained('users')->onDelete('cascade');
            $table->foreignId('boarding_house_id')->constrained('boarding_houses')->onDelete('cascade');
            $table->decimal('rating')->default(0.0);
            $table->text('review')->nullable();
            $table->timestamps();

            $table->unique(['tenant_id', 'boarding_house_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('boarding_house_reviews');
    }
};
