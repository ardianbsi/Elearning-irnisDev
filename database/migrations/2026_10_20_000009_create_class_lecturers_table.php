<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('class_lecturers', function (Blueprint $table) {
            $table->id();
            $table->foreignId('course_class_id')->constrained()->cascadeOnDelete();
            $table->foreignId('lecturer_id')->constrained()->cascadeOnDelete();
            $table->timestamps();

            $table->unique(['course_class_id', 'lecturer_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('class_lecturers');
    }
};
