<?php

use App\Models\CiElements;
use App\Models\CiInstances;
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
        Schema::create('instances_elements', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('priority');
            $table->string('type');
            $table->string('is_recurring');
            $table->integer('is_payroll_transferred');
            $table->integer('sequence');
            $table->integer('currency_id')->nullable();
            $table->foreignIdFor(CiInstances::class, 'instance_id');
            $table->foreignIdFor(CiElements::class, 'element_id');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('instances_elements');
    }
};