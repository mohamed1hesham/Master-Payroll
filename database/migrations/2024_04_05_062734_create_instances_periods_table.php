<?php

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
        Schema::create('instances_periods', function (Blueprint $table) {
            $table->id();
            $table->integer('period_id');
            $table->string('name');
            $table->string('from');
            $table->string('to');
            $table->integer('closed');
            $table->integer('soft_closed');
            $table->string('status');
            $table->foreignIdFor(CiInstances::class, 'instance_id');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('instances_periods');
    }
};