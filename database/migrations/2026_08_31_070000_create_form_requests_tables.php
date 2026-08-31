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
        Schema::create('off_time_requests', function (Blueprint $table) {
            $table->id();
            $table->foreignId('employee_id')->constrained('employees')->cascadeOnDelete();
            $table->foreignId('off_time_type_id')->nullable()->constrained('off_time_types')->nullOnDelete();
            $table->string('department')->nullable()->default('All Employees');
            $table->date('start_date');
            $table->date('end_date')->nullable();
            $table->dateTime('requested_at')->useCurrent();
            $table->text('reason')->nullable();
            $table->string('status')->default('In Review'); // 'In Review', 'Approved', 'Rejected'
            $table->timestamps();
        });

        Schema::create('attendance_requests', function (Blueprint $table) {
            $table->id();
            $table->foreignId('employee_id')->constrained('employees')->cascadeOnDelete();
            $table->date('request_date');
            $table->string('clock_in')->nullable();
            $table->string('clock_out')->nullable();
            $table->dateTime('requested_at')->useCurrent();
            $table->text('reason')->nullable();
            $table->string('status')->default('In Review'); // 'In Review', 'Approved', 'Rejected'
            $table->timestamps();
        });

        Schema::create('change_shift_requests', function (Blueprint $table) {
            $table->id();
            $table->foreignId('employee_id')->constrained('employees')->cascadeOnDelete();
            $table->foreignId('delegate_employee_id')->nullable()->constrained('employees')->nullOnDelete();
            $table->foreignId('shift_id')->nullable()->constrained('shifts')->nullOnDelete();
            $table->string('shift_to')->nullable();
            $table->date('request_date');
            $table->dateTime('requested_at')->useCurrent();
            $table->text('reason')->nullable();
            $table->string('status')->default('In Review'); // 'In Review', 'Approved', 'Rejected'
            $table->timestamps();
        });

        Schema::create('overtime_requests', function (Blueprint $table) {
            $table->id();
            $table->foreignId('employee_id')->constrained('employees')->cascadeOnDelete();
            $table->date('request_date');
            $table->string('overtime_time')->nullable(); // e.g. "18:00 - 21:00"
            $table->decimal('total_hours', 4, 1)->default(0);
            $table->dateTime('requested_at')->useCurrent();
            $table->text('reason')->nullable();
            $table->string('status')->default('In Review'); // 'In Review', 'Approved', 'Rejected'
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('overtime_requests');
        Schema::dropIfExists('change_shift_requests');
        Schema::dropIfExists('attendance_requests');
        Schema::dropIfExists('off_time_requests');
    }
};
