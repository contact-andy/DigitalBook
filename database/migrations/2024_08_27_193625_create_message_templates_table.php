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
        Schema::create('message_templates', function (Blueprint $table) {
            $table->id();
            $table->string('content');  
            /* 
            $table->text('content')->unique(); 
            it was challemnging to update the cntent [with the same content] with different attribute vlue
            It was due to the text datatype...
            */
            $table->string('type'); // Single User/ Multiple User
            $table->unsignedBigInteger('messageCategoryId');
            $table->unsignedBigInteger('campusId')->unsigned();
            $table->boolean('status')->default(0); // Approved:1 and 0 Not Approved
            $table->json('gradeLevels'); // Storing grade-levels as a JSON array
            $table->unsignedBigInteger('created_by');
            $table->unsignedBigInteger('updated_by')->nullable();
            $table->string('comment')->nullable();
            $table->timestamps();
            $table->softDeletes();

            // Foreign key constraints            
            $table->foreign('campusId')->references('id')->on('campuses')->onDelete('cascade');
            $table->foreign('created_by')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('updated_by')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('messageCategoryId')->references('id')->on('message_categories')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('message_templates');
    }
};
