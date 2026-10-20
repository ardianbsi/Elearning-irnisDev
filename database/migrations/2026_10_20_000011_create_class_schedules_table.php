<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('class_schedules', function (Blueprint $table) {
            $table->id();
            $table->foreignId('class_id')->constrained('course_classes')->cascadeOnDelete();
            $table->string('hari', 20);
            $table->time('start_time');
            $table->time('end_time');
            $table->foreignId('room_id')->nullable()->constrained()->nullOnDelete();
            $table->date('tanggal_mulai')->nullable();
            $table->date('tanggal_selesai')->nullable();
            $table->timestamps();

            $table->unique(['class_id', 'hari', 'tanggal_mulai', 'tanggal_selesai']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('class_schedules');
    }
};
