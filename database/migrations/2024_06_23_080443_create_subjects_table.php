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
        Schema::create('subjects', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('description')->nullable();
            $table->tinyInteger('maximum_marks');
            $table->tinyInteger('passing_marks');
            $table->tinyInteger('theory_marks');
            $table->tinyInteger('practical_marks')->nullable();
            $table->enum('status', ['active', 'inactive'])->default('active');
            // $table->string('banner')->nullable();
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('subjects');
    }
};
