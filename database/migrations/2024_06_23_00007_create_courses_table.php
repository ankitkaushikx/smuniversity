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
        Schema::create('courses', function (Blueprint $table) {
             $table->id();
            $table->foreignId('program_id')->constrained();
            $table->string('name');
            $table->tinyInteger('eligibility');
            $table->tinyInteger('duration');
           
            $table->string('banner')->nullable();
            $table->string('description')->nullable();
            $table->string('comment')->nullable();
            $table->enum('status', ['active', 'inactive'])->default('active');
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('courses');
    }
};
