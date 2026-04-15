<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('materials', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->text('description')->nullable();
            $table->enum('type', ['pdf', 'docx', 'image', 'link', 'googledrive']);
            $table->string('file_path')->nullable(); // stored file path
            $table->string('external_url')->nullable(); // for links and Google Drive
            $table->string('thumbnail')->nullable();
            $table->unsignedBigInteger('course_id');
            $table->unsignedBigInteger('uploaded_by');
            $table->integer('level'); // 100-400
            $table->integer('downloads')->default(0);
            $table->integer('views')->default(0);
            $table->integer('upvotes')->default(0);
            $table->boolean('is_approved')->default(false); // admin approval needed
            $table->timestamps();
            
            $table->foreign('course_id')->references('id')->on('courses')->onDelete('cascade');
            $table->foreign('uploaded_by')->references('id')->on('users')->onDelete('cascade');
            
            // Add index for search performance
            $table->index(['course_id', 'level']);
            $table->index('type');
        });
    }

    public function down()
    {
        Schema::dropIfExists('materials');
    }
};