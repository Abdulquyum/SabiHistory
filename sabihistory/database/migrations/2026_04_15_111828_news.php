<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('news', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->text('content');
            $table->string('image_url')->nullable();
            $table->string('source_url')->nullable();
            $table->enum('category', ['academic', 'department', 'university', 'general'])->default('general');
            $table->unsignedBigInteger('posted_by');
            $table->timestamp('published_at')->nullable();
            $table->timestamps();
            
            $table->foreign('posted_by')->references('id')->on('users')->onDelete('cascade');
            $table->index('published_at');
        });
    }

    public function down()
    {
        Schema::dropIfExists('news');
    }
};