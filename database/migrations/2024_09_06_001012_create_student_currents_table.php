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
       Schema::create('student_currents', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('studentId')->unsigned();           
            $table->string('gradeLevel2015')->nullable();
            $table->string('section2015')->nullable();
            $table->string('studentType2015')->nullable();
            $table->integer('campusId2015')->nullable();
            $table->string('status2015')->nullable();
            $table->integer('academicYear2015')->nullable();

            $table->string('gradeLevel2016')->nullable();
            $table->string('section2016')->nullable();
            $table->string('studentType2016')->nullable();
            $table->integer('campusId2016')->nullable();
            $table->string('status2016')->nullable();
            $table->integer('academicYear2016')->nullable();

            $table->string('gradeLevel2017')->nullable();
            $table->string('section2017')->nullable();
            $table->string('studentType2017')->nullable();
            $table->integer('campusId2017')->nullable();
            $table->string('status2017')->nullable();
            $table->integer('academicYear2017')->nullable();
            
            $table->timestamps();
            $table->softDeletes();

            // Foreign key constraints
            $table->foreign('studentId')->references('id')->on('students')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('student_currents');
    }
};
