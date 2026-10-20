<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('course_classes', function (Blueprint $table) {
            $table->id();
            $table->foreignId('course_id')->constrained()->cascadeOnDelete();
            $table->foreignId('academic_year_id')->constrained()->cascadeOnDelete();
            $table->foreignId('semester_id')->constrained()->restrictOnDelete();
            $table->string('kelas');
            $table->unsignedTinyInteger('kapasitas')->default(30);
            $table->timestamps();

            $table->unique(['course_id', 'academic_year_id', 'semester_id', 'kelas']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('course_classes');
    }
};
