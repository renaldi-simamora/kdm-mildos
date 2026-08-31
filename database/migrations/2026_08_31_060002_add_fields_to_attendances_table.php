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
        Schema::table('attendances', function (Blueprint $table) {
            $table->string('location')->nullable()->after('employee_name');
            $table->string('shift')->nullable()->after('location');
            $table->dateTime('clock_in')->nullable()->after('shift');
            $table->dateTime('clock_out')->nullable()->after('clock_in');
            $table->unsignedInteger('overtime_hours')->default(0)->after('notes');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('attendances', function (Blueprint $table) {
            $table->dropColumn(['location', 'shift', 'clock_in', 'clock_out', 'overtime_hours']);
        });
    }
};
