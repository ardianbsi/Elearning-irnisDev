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
        Schema::create('students', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->unique()->constrained()->cascadeOnDelete();
            $table->foreignId('study_program_id')->nullable()->constrained()->nullOnDelete();
            $table->string('nim', 30)->unique();
            $table->string('cohort', 10)->nullable()->comment('Angkatan, contoh: 2024');
            $table->boolean('is_active')->default(true);
            $table->timestamps();

            $table->index('study_program_id');
        });

        Schema::create('lecturers', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->unique()->constrained()->cascadeOnDelete();
            $table->foreignId('faculty_id')->nullable()->constrained()->nullOnDelete();
            $table->string('nip', 30)->unique();
            $table->string('position')->nullable()->comment('Jabatan fungsional');
            $table->boolean('is_active')->default(true);
            $table->timestamps();

            $table->index('faculty_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('lecturers');
        Schema::dropIfExists('students');
    }
};
