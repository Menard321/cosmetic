<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('performance_reviews', function (Blueprint $table) {
            $table->id();
            $table->foreignId('employee_id')->constrained()->cascadeOnDelete();
            $table->foreignId('reviewed_by')->nullable()->constrained('users')->nullOnDelete();
            $table->integer('month');
            $table->integer('year');
            $table->decimal('sales_score', 5, 2)->default(0);      // out of 100
            $table->decimal('attendance_score', 5, 2)->default(0);  // out of 100
            $table->decimal('task_completion', 5, 2)->default(0);   // out of 100
            $table->decimal('customer_rating', 5, 2)->default(0);   // out of 100
            $table->decimal('overall_score', 5, 2)->default(0);     // calculated average
            $table->enum('rating', ['poor', 'fair', 'good', 'excellent', 'outstanding'])->default('good');
            $table->text('feedback')->nullable();
            $table->text('areas_of_improvement')->nullable();
            $table->boolean('top_performer')->default(false);
            $table->timestamps();

            $table->unique(['employee_id', 'month', 'year']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('performance_reviews');
    }
};
