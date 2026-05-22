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
        Schema::table('users', function (Blueprint $table) {
            $table->integer('loyalty_points')->default(0)->after('email');
            $table->boolean('is_banned')->default(false)->after('loyalty_points');
            $table->string('customer_segment')->default('new')->after('is_banned'); // new, regular, VIP
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn(['loyalty_points', 'is_banned', 'customer_segment']);
        });
    }
};
