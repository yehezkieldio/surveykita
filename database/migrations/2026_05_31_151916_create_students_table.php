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
            $table->foreignId('user_id')->unique()->constrained()->cascadeOnUpdate()->restrictOnDelete();
            $table->string('nim', 7)->nullable()->unique();
            $table->string('name');
            $table->string('program_code', 2)->nullable()->index();
            $table->string('study_program')->nullable()->index();
            $table->unsignedSmallInteger('enrollment_year')->nullable()->index();
            $table->string('sequence_number', 3)->nullable();
            $table->string('class_name')->nullable()->index();
            $table->timestamps();

            $table->index(['program_code', 'enrollment_year']);
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
