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
        Schema::create('instances_payroll', function (Blueprint $table) {
            $table->id();
            $table->integer('payroll_id');
            $table->string('name');
            $table->string('period_end_date');
            $table->string('start_effective_date');
            $table->string('end_effective_date');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('instances_payroll');
    }
};
