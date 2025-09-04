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
        Schema::create('attendances', function (Blueprint $table) {
            $table->id();
            $table->foreignId('personnel_responder_id')->constrained('personnel_responders')->onDelete('cascade')->onUpdate('cascade');
            $table->string('sign-in');
            $table->string('sign-out');
            $table->string('reason');
            $table->boolean('respondersLeave');
            $table->string('activeStatus');            
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('attendance');
    }
};
