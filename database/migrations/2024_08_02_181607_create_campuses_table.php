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
        Schema::create('campuses', function (Blueprint $table) {
            $table->id();
            $table->string("name");
            $table->string('code')->nullable();
            $table->string('yearsOfEsta')->nullable();
            $table->string('level')->nullable();
            $table->string('country')->nullable();
            $table->string('city')->nullable();
            $table->string('subcity')->nullable();
            $table->string('wereda')->nullable();
            $table->string('telephone')->nullable();
            $table->string('mobile')->nullable();
            $table->string('pobox')->nullable();
            $table->string('website')->nullable();
            $table->string('email')->nullable();
            $table->integer('status');
            // $table->integer('academicYear');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('campuses');
    }
};
