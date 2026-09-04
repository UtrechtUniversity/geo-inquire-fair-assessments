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
        Schema::table('fair_assessment_objects', function (Blueprint $table) {
            $table->dropColumn('fair_assessment_group_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('fair_assessment_objects', function (Blueprint $table) {
            $table->unsignedBigInteger('fair_assessment_group_id');
        });
    }
};
