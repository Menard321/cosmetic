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
        Schema::table('orders', function (Blueprint $table) {
            $table->foreignId('rider_id')->nullable()->constrained('users')->onDelete('set null');
            $table->string('delivery_status')->default('pending'); // pending, assigned, out_for_delivery, delivered
            $table->text('delivery_address')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('orders', function (Blueprint $table) {
            $table->dropForeign(['rider_id']);
            $table->dropColumn(['rider_id', 'delivery_status', 'delivery_address']);
        });
    }
};
