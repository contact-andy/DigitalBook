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
        Schema::create('student_families', function (Blueprint $table) {
            $table->id();
            $table->string('firstName');
            $table->string('middleName')->nullable();
            $table->string('lastName')->nullable();
            $table->string('sex')->nullable();
            $table->string('relationship')->nullable();
            $table->string('city')->nullable();
            $table->string('subcity')->nullable();
            $table->string('wereda')->nullable();
            $table->string('houseNumber')->nullable();
            $table->string('housePhoneNumber')->nullable();
            $table->string('mobile1');
            $table->string('mobile2')->nullable();
            $table->string('email')->nullable();
            $table->string('occupation')->nullable();
            $table->string('officePhone')->nullable();
            $table->string('workPlaceAddress')->nullable();
            $table->text('photo')->nullable();
            $table->unsignedBigInteger('userId')->unsigned();
            $table->timestamps();
            $table->softDeletes();
            
            // Foreign key constraints
            $table->foreign('userId')->references('id')->on('users')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('student_families');
    }
};
