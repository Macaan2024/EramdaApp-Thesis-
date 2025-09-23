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
        Schema::create('report_actions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('request_id')->constrained('requests')->onDelete('cascade')->onUpdate('cascade');
            $table->foreignId('submit_report_id')->constrained('submit_reports')->onDelete('cascade')->onUpdate('cascade');
            $table->foreignId('agency_id')->constrained('agencies')->onDelete('cascade')->onUpdate('cascade');
            $table->string('actionResponse');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('actions');
    }
};
