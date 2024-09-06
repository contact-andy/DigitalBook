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
        Schema::create('employees', function (Blueprint $table) {
            $table->id();
            $table->string('employeeId');
            $table->string('firstName');
            $table->string('middleName')->nullable();
            $table->string('lastName')->nullable();
            $table->string('sex')->nullable();
            $table->string('dob');
            $table->string('placeOfBirth')->nullable();
            
            $table->string('city')->nullable();
            $table->string('subcity')->nullable();
            $table->string('wereda')->nullable();
            $table->string('houseNumber')->nullable();
            $table->string('housePhoneNumber')->nullable();
            $table->string('mobile');
            $table->string('email')->nullable();

            $table->string('maritalStatus')->nullable();
            $table->string('educationalRank')->nullable();
            $table->string('teachingExperience')->nullable();
            $table->string('otherExperience')->nullable();
            $table->string('fieldOfStudy')->nullable();
            $table->unsignedBigInteger('campusId')->unsigned();
            $table->text('photo')->nullable();
            $table->unsignedBigInteger('userId')->unsigned();
            $table->timestamps();
            $table->unique(['employeeId']);
            $table->softDeletes();
            
            // Foreign key constraints
            $table->foreign('campusId')->references('id')->on('campuses')->onDelete('cascade');
            $table->foreign('userId')->references('id')->on('users')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('employees');
    }
};
