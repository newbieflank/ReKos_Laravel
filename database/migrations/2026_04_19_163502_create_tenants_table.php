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
        Schema::create('tenants', function (Blueprint $table) {
            $table->id();
            $table->foreignId('tenant_id')->nullable()->constrained('users')->onDelete('set null');
            $table->foreignId('room_id')->nullable()->constrained('rooms')->onDelete('set null');
            $table->date('start_date')->default(now());
            $table->date('end_date')->nullable();
            $table->integer('duration')->nullable();
            $table->enum('rental_type', ['daily', 'weekly', 'monthly']);
            $table->unsignedInteger('total_price')->nullable();
            $table->enum('status', ['pending', 'active', 'complete', 'cancelled'])->default('pending');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tenants');
    }
};
