<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('past_questions', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('course_id');
            $table->integer('year');
            $table->string('exam_type')->default('first_term'); // first_term, second_term, resit
            $table->string('question_pdf_path');
            $table->string('solution_pdf_path')->nullable();
            $table->text('solution_text')->nullable(); // for AI-generated solutions
            $table->integer('downloads')->default(0);
            $table->unsignedBigInteger('uploaded_by');
            $table->timestamps();
            
            $table->foreign('course_id')->references('id')->on('courses')->onDelete('cascade');
            $table->foreign('uploaded_by')->references('id')->on('users')->onDelete('cascade');
            
            $table->unique(['course_id', 'year', 'exam_type']);
        });
    }

    public function down()
    {
        Schema::dropIfExists('past_questions');
    }
};