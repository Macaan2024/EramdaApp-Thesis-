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
        Schema::create('injuries', function (Blueprint $table) {
            $table->id();
            $table->foreignId('submit_report_id')->constrained('submit_reports')->onDelete('cascade')->onUpdate('cascade');
            $table->foreignId('emergency_vehicle_id')->constrained('emergency_vehicles')->onUpdate('cascade')->onDelete('cascade');
            $table->enum('gender', ['m', 'f']);
            $table->string('lastname');
            $table->string('firstname');
            $table->string('middlename');
            $table->integer('age');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('injuries');
    }
};
