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
        Schema::create('agency_report_actions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade')->onUpdate('cascade');
            $table->string('shortestpath_trigger_num');
            $table->string('nearest_agency_name');
            $table->float('agency_longitude');
            $table->float('agency_latitue');
            $table->string('vehicle_type_requested');
            $table->string('vehicle_num_requested');
            $table->string('agency_vehicle_num_can_provide');
            $table->string('agency_vehicle_type_can_provide');
            $table->string('report_action');
            $table->string('decline_reason');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('agency_report_actions');
    }
};
