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
            $table->string('gradeLevel2008')->nullable();
            $table->string('section2008')->nullable();
            $table->string('studentType2008')->nullable();
            $table->integer('campusId2008')->nullable();
            $table->string('status2008')->nullable();
            $table->integer('academicYear2008')->nullable();

            $table->string('gradeLevel2009')->nullable();
            $table->string('section2009')->nullable();
            $table->string('studentType2009')->nullable();
            $table->integer('campusId2009')->nullable();
            $table->string('status2009')->nullable();
            $table->integer('academicYear2009')->nullable();
            
            $table->string('gradeLevel2010')->nullable();
            $table->string('section2010')->nullable();
            $table->string('studentType2010')->nullable();
            $table->integer('campusId2010')->nullable();
            $table->string('status2010')->nullable();
            $table->integer('academicYear2010')->nullable();

            
            $table->string('gradeLevel2011')->nullable();
            $table->string('section2011')->nullable();
            $table->string('studentType2011')->nullable();
            $table->integer('campusId2011')->nullable();
            $table->string('status2011')->nullable();
            $table->integer('academicYear2011')->nullable();

            
            $table->string('gradeLevel2012')->nullable();
            $table->string('section2012')->nullable();
            $table->string('studentType2012')->nullable();
            $table->integer('campusId2012')->nullable();
            $table->string('status2012')->nullable();
            $table->integer('academicYear2012')->nullable();

            $table->string('gradeLevel2013')->nullable();
            $table->string('section2013')->nullable();
            $table->string('studentType2013')->nullable();
            $table->integer('campusId2013')->nullable();
            $table->string('status2013')->nullable();
            $table->integer('academicYear2013')->nullable();


            $table->string('gradeLevel2014')->nullable();
            $table->string('section2014')->nullable();
            $table->string('studentType2014')->nullable();
            $table->integer('campusId2014')->nullable();
            $table->string('status2014')->nullable();
            $table->integer('academicYear2014')->nullable();
            
            
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
