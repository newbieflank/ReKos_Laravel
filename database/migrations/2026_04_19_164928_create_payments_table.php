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
        Schema::create('payments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('tenant_id')->nullable()->constrained('users')->onDelete('set null');
            $table->enum('payment_method', ['cash', 'payment_gateway'])->default('cash');
            $table->unsignedInteger('amount');
            $table->enum('status', ['waiting', 'successful', 'failed'])->default('waiting');
            $table->dateTime('payment_date')->default(now());
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('payments');
    }
};
