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
        Schema::create('ci_elements', function (Blueprint $table) {
            $table->id();
            $table->string("element_name_en");
            $table->string("element_name_ar");
            $table->integer("order");
            $table->boolean("disability");
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ci_elements');
    }
};
