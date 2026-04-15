<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('courses', function (Blueprint $table) {
            $table->id();
            $table->string('course_code')->unique();
            $table->string('course_title');
            $table->text('description')->nullable();
            $table->integer('level'); // 100, 200, 300, 400
            $table->string('semester'); // first or second
            $table->integer('credits')->default(2);
            $table->string('department')->default('History & Strategic Studies');
            $table->unsignedBigInteger('lecturer_id')->nullable();
            $table->timestamps();
            
            $table->foreign('lecturer_id')->references('id')->on('lecturers')->onDelete('set null');
        });
    }

    public function down()
    {
        Schema::dropIfExists('courses');
    }
};