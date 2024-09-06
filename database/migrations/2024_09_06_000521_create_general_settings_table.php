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
        Schema::create('general_settings', function (Blueprint $table) {
            $table->id();
            $table->string('name')->nullable();
            $table->string('motto')->nullable();
            $table->string('level')->nullable();
            $table->string('yearsOfEsta')->nullable();
            $table->string('ownership')->nullable();
            $table->string('country')->nullable();
            $table->string('city')->nullable();
            $table->string('subcity')->nullable();
            $table->string('wereda')->nullable();
            $table->string('telephone')->nullable();
            $table->string('mobile')->nullable();
            $table->string('pobox')->nullable();
            $table->string('website')->nullable();
            $table->string('email')->nullable();
            $table->text('logo')->nullable();
            $table->text('facebook')->nullable();
            $table->text('telegram')->nullable();
            $table->text('twitter')->nullable();
            $table->string('schoolCode')->nullable();
            $table->string('issueDate')->nullable();
            $table->longText('aboutSchool');
            $table->longText('schoolVision');
            $table->longText('schoolMission');
            $table->longText('schoolGoal');
            $table->longText('galleryImages');
            $table->longText('certificateAwards');
            $table->integer('academicYear');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('general_settings');
    }
};
