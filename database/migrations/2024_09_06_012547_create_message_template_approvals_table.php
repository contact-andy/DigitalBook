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
        Schema::create('message_template_approvals', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('message_template_id'); // Reference to the message template
            $table->boolean('content_ok')->default(false); // Checkbox for content
            $table->boolean('grammar_ok')->default(false); // Checkbox for grammar
            $table->boolean('spelling_ok')->default(false); // Checkbox for spelling
            $table->text('comments')->nullable(); // Optional comments
            $table->unsignedBigInteger('approved_by'); // Who approved the template
            $table->timestamps();
            $table->softDeletes();
            // Add foreign keys if needed
            $table->foreign('message_template_id')->references('id')->on('message_templates')->onDelete('cascade');
            $table->foreign('approved_by')->references('id')->on('users')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('message_template_approvals');
    }
};
