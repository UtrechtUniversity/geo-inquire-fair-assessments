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
            $table->json('datacite_metadata')->nullable();
            $table->string('datacite_publisher');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('fair_assessment_objects', function (Blueprint $table) {
            $table->dropColumn('datacite_metadata');
            $table->dropColumn('datacite_publisher');
        });
    }
};
