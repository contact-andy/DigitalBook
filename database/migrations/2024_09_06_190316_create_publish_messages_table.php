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
        Schema::create('publish_messages', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('campusId')->unsigned();
            $table->unsignedBigInteger('gradeLevelId')->unsigned();
            $table->unsignedBigInteger('sectionId')->unsigned();
            $table->unsignedBigInteger('messageTemplateId')->unsigned();
            $table->boolean('status')->default(0); // 1: approved, 0: not approved
            $table->string('comment')->nullable();
            $table->unsignedBigInteger('approved_by')->nullable();
            $table->unsignedBigInteger('created_by');
            $table->unsignedBigInteger('updated_by')->nullable();
            $table->integer('academicYear');
            $table->timestamps();
            $table->softDeletes();
            
            // Foreign key constraints
            $table->foreign('campusId')->references('id')->on('campuses')->onDelete('cascade');
            $table->foreign('gradeLevelId')->references('id')->on('grade_levels')->onDelete('cascade');
            $table->foreign('sectionId')->references('id')->on('sections')->onDelete('cascade');
            $table->foreign('messageTemplateId')->references('id')->on('message_templates')->onDelete('cascade');
            $table->foreign('approved_by')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('created_by')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('updated_by')->references('id')->on('users')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('publish_messages');
    }
};
