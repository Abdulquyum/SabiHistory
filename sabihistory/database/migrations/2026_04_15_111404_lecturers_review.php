<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('lecturer_reviews', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('lecturer_id');
            $table->unsignedBigInteger('user_id');
            $table->integer('rating'); // 1-5
            $table->text('comment')->nullable();
            $table->string('course_code')->nullable(); // which course they took with lecturer
            $table->timestamps();
            
            $table->foreign('lecturer_id')->references('id')->on('lecturers')->onDelete('cascade');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            
            $table->unique(['lecturer_id', 'user_id']); // one review per user per lecturer
        });
    }

    public function down()
    {
        Schema::dropIfExists('lecturer_reviews');
    }
};