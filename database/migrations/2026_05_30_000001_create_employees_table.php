<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('employees', function (Blueprint $table) {
            $table->id();
            $table->string('employee_id')->unique(); // Auto-generated e.g. EMP-0001
            $table->foreignId('user_id')->nullable()->constrained()->nullOnDelete();
            $table->foreignId('branch_id')->nullable()->constrained()->nullOnDelete();

            // Personal Info
            $table->string('full_name');
            $table->string('photo')->nullable();
            $table->enum('gender', ['male', 'female']);
            $table->date('date_of_birth')->nullable();
            $table->string('national_id')->nullable();
            $table->string('phone');
            $table->string('email')->nullable();
            $table->text('address')->nullable();
            $table->string('emergency_contact_name')->nullable();
            $table->string('emergency_contact_phone')->nullable();

            // Employment Info
            $table->string('position');
            $table->string('department')->nullable();
            $table->enum('employment_type', ['full_time', 'part_time', 'contract', 'internship'])->default('full_time');
            $table->date('date_hired');
            $table->date('contract_start')->nullable();
            $table->date('contract_end')->nullable();
            $table->unsignedBigInteger('reporting_manager_id')->nullable();
            $table->foreign('reporting_manager_id')->references('id')->on('employees')->nullOnDelete();
            $table->enum('status', ['active', 'inactive', 'suspended', 'terminated', 'on_leave'])->default('active');

            // Payroll
            $table->decimal('basic_salary', 12, 2)->default(0);
            $table->string('payment_method')->default('cash'); // mobile_money, bank, cash
            $table->string('bank_name')->nullable();
            $table->string('account_name')->nullable();
            $table->string('account_number')->nullable();
            $table->string('mobile_money_name')->nullable(); // M-Pesa, Tigo Pesa, etc.
            $table->string('mobile_money_number')->nullable();

            $table->text('notes')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('employees');
    }
};
