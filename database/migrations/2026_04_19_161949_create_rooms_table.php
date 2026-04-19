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
        Schema::create('rooms', function (Blueprint $table) {
            $table->id();
            $table->foreignId('boarding_house_id')->constrained('boarding_houses')->onDelete('cascade');
            $table->string('room_name')->nullable();
            $table->string('room_type')->nullable();
            $table->string('room_size')->nullable();
            $table->json('facilities')->nullable();
            $table->unsignedInteger('daily_price')->nullable();
            $table->unsignedInteger('weekly_price')->nullable();
            $table->unsignedInteger('monthly_price')->nullable();
            $table->boolean('available')->default(1);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('rooms');
    }
};
