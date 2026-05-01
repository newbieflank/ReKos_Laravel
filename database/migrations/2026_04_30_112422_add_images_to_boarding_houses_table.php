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
        Schema::table('boarding_houses', function (Blueprint $table) {
            $table->string('main_image')->nullable();
            $table->json('other_images')->nullable();
        });

        Schema::table('rooms', function (Blueprint $table) {
            $table->string('main_image')->nullable();
            $table->json('other_images')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('boarding_houses', function (Blueprint $table) {
            $table->dropColumn(['main_image', 'other_images']);
        });

        Schema::table('rooms', function (Blueprint $table) {
            $table->dropColumn(['main_image', 'other_images']);
        });
    }
};
