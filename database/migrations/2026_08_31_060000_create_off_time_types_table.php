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
        Schema::create('off_time_types', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->unsignedInteger('max_off_times')->default(1);
            $table->string('interval_type')->default('Monthly'); // 'Monthly', 'Yearly'
            $table->boolean('superadmin_approval')->default(false);
            $table->string('status')->default('Active'); // 'Active', 'Inactive'
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('off_time_types');
    }
};
