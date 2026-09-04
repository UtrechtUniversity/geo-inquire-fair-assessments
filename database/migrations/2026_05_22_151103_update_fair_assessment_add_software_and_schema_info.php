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
        Schema::table('fair_assessments', function (Blueprint $table) {
            $table->string('software_version')->default('');
            $table->string('metric_specification')->default('');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('fair_assessments', function (Blueprint $table) {
            $table->dropColumn('software_version');
            $table->dropColumn('metric_specification');
        });
    }
};
