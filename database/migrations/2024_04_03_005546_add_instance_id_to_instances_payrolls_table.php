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
        Schema::table('instances_payrolls', function (Blueprint $table) {
            $table->foreignIdFor(CiInstances::class, 'instance_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('instances_payrolls', function (Blueprint $table) {
            //
        });
    }
};