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
        Schema::create('fair_asessment_group_object', function (Blueprint $table) {
            $table->unsignedBigInteger('fair_assessment_group_id');
            $table->unsignedBigInteger('fair_assessment_object_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('fair_asessment_group_object');
    }
};
