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
        Schema::create('loyalty_tiers', function (Blueprint $table) {
            $table->id();
            $table->string('name')->unique(); // Silver, Gold, Platinum, Diamond
            $table->integer('min_points');
            $table->decimal('discount_percentage', 5, 2)->default(0);
            $table->json('perks')->nullable(); // JSON list of exclusive benefits
            $table->string('color_hex')->nullable(); // For UI styling
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('loyalty_tiers');
    }
};
