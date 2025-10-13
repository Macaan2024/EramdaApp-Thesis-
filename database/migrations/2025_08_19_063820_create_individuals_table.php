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
        Schema::create('individuals', function (Blueprint $table) {
            $table->id();
            $table->foreignId('incident_id')->constrained('incidents')->onUpdate('cascade')->onDelete('cascade');
            $table->string('individual_name');
            $table->string('individual_address');
            $table->string('individual_sex');
            $table->string('individual_contact_number');
            $table->string('injury_status');
            $table->string('brought_to_hospital');
            $table->string('position_or_location'); //seat position (for  passenger) or standing location (for pedestrian / witnesses)
            $table->string('action_taken'); // Addmitted, Release. Given First Aid
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('individuals');
    }
};
