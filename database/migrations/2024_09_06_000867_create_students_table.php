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
        Schema::create('students', function (Blueprint $table) {
            $table->id();
            $table->string('studentId');
            $table->string('firstName');
            $table->string('middleName');
            $table->string('lastName');
            $table->string('sex');
            $table->string('dob')->nullable();
            $table->string('city')->nullable();
            $table->string('subcity')->nullable();
            $table->string('wereda')->nullable();
            $table->string('houseNumber')->nullable();
            $table->string('housePhoneNumber')->nullable();
            $table->string('email')->nullable();
            $table->string('SMSMobile1');
            $table->string('SMSMobile2')->nullable();
            $table->text('photo')->nullable();
            $table->unsignedBigInteger('familyCode')->unsigned();
            $table->unsignedBigInteger('userId')->unsigned();
            $table->timestamps();
            $table->softDeletes();
            
            // Unique key constraints
            $table->unique(['studentId']);
            
            // Foreign key constraints
            $table->foreign('familyCode')->references('id')->on('student_families')->onDelete('cascade');
            $table->foreign('userId')->references('id')->on('users')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('students');
    }
};
