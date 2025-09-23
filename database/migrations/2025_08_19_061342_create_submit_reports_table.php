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
        Schema::create('submit_reports', function (Blueprint $table) {
            $table->id();
            $table->foreignId('agency_id')->constrained('agencies')->onDelete('cascade')->onUpdate('cascade');
            $table->foreignId('barangay_id')->constrained('barangays')->onDelete('cascade')->onUpdate('cascade');
            $table->foreignId('incident_types_id')->constrained('incident_types')->onDelete('cascade')->onUpdate('cascade');
            $table->float('incidentLatitude')->nullable();
            $table->float('incidentLongitude')->nullable();
            $table->integer('numberOfDeaths')->nullable();
            $table->integer('numberOfInjuries')->nullable();
            $table->string('time');
            $table->string('day');
            $table->string('month');
            $table->string('status')->nullable();
            $table->string('description');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('submit_reports');
    }
};
