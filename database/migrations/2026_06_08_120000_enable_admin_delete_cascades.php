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
        Schema::table('students', function (Blueprint $table) {
            $table->dropForeign(['user_id']);
            $table->foreign('user_id')->references('id')->on('users')->cascadeOnUpdate()->cascadeOnDelete();
        });

        Schema::table('evaluation_forms', function (Blueprint $table) {
            $table->dropForeign(['evaluation_period_id']);
            $table->foreign('evaluation_period_id')->references('id')->on('evaluation_periods')->cascadeOnUpdate()->cascadeOnDelete();
        });

        Schema::table('questions', function (Blueprint $table) {
            $table->dropForeign(['evaluation_form_id']);
            $table->dropForeign(['question_category_id']);

            $table->foreign('evaluation_form_id')->references('id')->on('evaluation_forms')->cascadeOnUpdate()->cascadeOnDelete();
            $table->foreign('question_category_id')->references('id')->on('question_categories')->cascadeOnUpdate()->cascadeOnDelete();
        });

        Schema::table('responses', function (Blueprint $table) {
            $table->dropForeign(['evaluation_form_id']);
            $table->dropForeign(['student_id']);

            $table->foreign('evaluation_form_id')->references('id')->on('evaluation_forms')->cascadeOnUpdate()->cascadeOnDelete();
            $table->foreign('student_id')->references('id')->on('students')->cascadeOnUpdate()->cascadeOnDelete();
        });

        Schema::table('response_answers', function (Blueprint $table) {
            $table->dropForeign(['question_id']);
            $table->foreign('question_id')->references('id')->on('questions')->cascadeOnUpdate()->cascadeOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('response_answers', function (Blueprint $table) {
            $table->dropForeign(['question_id']);
            $table->foreign('question_id')->references('id')->on('questions')->cascadeOnUpdate()->restrictOnDelete();
        });

        Schema::table('responses', function (Blueprint $table) {
            $table->dropForeign(['evaluation_form_id']);
            $table->dropForeign(['student_id']);

            $table->foreign('evaluation_form_id')->references('id')->on('evaluation_forms')->cascadeOnUpdate()->restrictOnDelete();
            $table->foreign('student_id')->references('id')->on('students')->cascadeOnUpdate()->restrictOnDelete();
        });

        Schema::table('questions', function (Blueprint $table) {
            $table->dropForeign(['evaluation_form_id']);
            $table->dropForeign(['question_category_id']);

            $table->foreign('evaluation_form_id')->references('id')->on('evaluation_forms')->cascadeOnUpdate()->restrictOnDelete();
            $table->foreign('question_category_id')->references('id')->on('question_categories')->cascadeOnUpdate()->restrictOnDelete();
        });

        Schema::table('evaluation_forms', function (Blueprint $table) {
            $table->dropForeign(['evaluation_period_id']);
            $table->foreign('evaluation_period_id')->references('id')->on('evaluation_periods')->cascadeOnUpdate()->restrictOnDelete();
        });

        Schema::table('students', function (Blueprint $table) {
            $table->dropForeign(['user_id']);
            $table->foreign('user_id')->references('id')->on('users')->cascadeOnUpdate()->restrictOnDelete();
        });
    }
};
