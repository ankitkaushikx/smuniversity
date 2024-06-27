<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use phpDocumentor\Reflection\Types\Nullable;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('students', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained();
            $table->foreignId('center_id')->constrained();
            // $table->string('name');
            $table->string('student_code')->unique();
            $table->string('father_name');
            $table->string('mother_name');
            $table->date('dob');
            $table->enum('gender', ['male', 'female']);
            $table->string('address');
            $table->string('comment')->nullable();
            $table->foreignId('course_id')->constrained();
            $table->string('session_start');
            $table->string('session_end');
            $table->string('photo');
            $table->string('id_proof');
            $table->string('tenth')->nullable();
            $table->string('twelfth')->nullable();
            $table->string('diploma')->nullable();
            $table->string('undergraduate')->nullable();
            $table->string('postgraduate')->nullable();
            // $table->enum('status', ['active', 'inactive', 'freeze'])->default('freeze');
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('students');
    }
};
