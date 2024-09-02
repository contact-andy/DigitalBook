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
        Schema::create('dcb_application_permissions', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('userId')->unsigned();
            $table->unsignedBigInteger('appId')->unsigned();
            $table->unsignedBigInteger('campusId')->unsigned();
            $table->unsignedBigInteger('created_by');
            $table->unsignedBigInteger('updated_by')->nullable();
            $table->timestamps();
            $table->softDeletes();

            
            // Foreign key constraints
            $table->foreign('created_by')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('updated_by')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('userId')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('appId')->references('id')->on('dcb_application_lists')->onDelete('cascade');
            $table->foreign('campusId')->references('id')->on('campuses')->onDelete('cascade');

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('dcb_application_permissions');
    }
};
