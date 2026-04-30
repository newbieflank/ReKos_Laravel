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
            $table->string('order_id')->unique();
            $table->foreignId('payment_id')->nullable()->constrained('tenants')->onDelete('set null');
            $table->enum('payment_method', ['va', 'e-wallet'])->default('va');
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
