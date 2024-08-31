<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    // public function up()
    // {
    //     Schema::create('surveys', function (Blueprint $table) {
    //         $table->id();
    //         $table->string('title');
    //         $table->text('description')->nullable();
    //         $table->json('options'); // Store the list of options as a JSON array
    //         $table->boolean('status')->default(1);
    //         $table->unsignedBigInteger('created_by');
    //         $table->unsignedBigInteger('updated_by')->nullable();
    //         $table->timestamps();
    //         $table->softDeletes();
    //     });
    // }
    public function up()
    {
        Schema::create('surveys', function (Blueprint $table) {
            $table->id();
            $table->string('title')->unique();
            $table->text('description')->nullable();
            $table->boolean('status')->default(1); // 1: Active, 0: Inactive
            $table->unsignedBigInteger('created_by');
            $table->unsignedBigInteger('updated_by')->nullable();
            $table->timestamps();
            $table->softDeletes();

            // Foreign key constraints
            $table->foreign('created_by')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('updated_by')->references('id')->on('users')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('surveys');
    }
};
