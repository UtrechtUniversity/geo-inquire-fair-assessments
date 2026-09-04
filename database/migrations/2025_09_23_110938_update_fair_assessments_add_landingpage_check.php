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
            $table->boolean('landing_page_failed')->default(0);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('fair_assessments', function (Blueprint $table) {
            $table->dropColumn('landing_page_failed');
        });
    }
};
