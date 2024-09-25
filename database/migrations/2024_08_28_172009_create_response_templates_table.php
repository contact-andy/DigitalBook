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
        Schema::create('response_templates', function (Blueprint $table) {
           
            $table->id();
            $table->string('content'); 
            $table->unsignedBigInteger('messageTemplateId');
            $table->unsignedBigInteger('campusId')->unsigned();
            $table->unsignedBigInteger('created_by');
            $table->unsignedBigInteger('updated_by')->nullable();
            $table->boolean('content_ok')->default(false); // Checkbox for content
            $table->boolean('grammar_ok')->default(false); // Checkbox for grammar
            $table->boolean('spelling_ok')->default(false); // Checkbox for spelling
            $table->text('comment')->nullable(); // Optional comments
            $table->unsignedBigInteger('approved_by')->nullable(); // Who approved the template            
            $table->timestamps();
            $table->softDeletes();

            // Foreign key constraints
            $table->foreign('campusId')->references('id')->on('campuses')->onDelete('cascade');
            $table->foreign('created_by')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('updated_by')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('messageTemplateId')->references('id')->on('message_templates')->onDelete('cascade');
            $table->foreign('approved_by')->references('id')->on('users')->onDelete('cascade');

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('response_templates');
    }
};
