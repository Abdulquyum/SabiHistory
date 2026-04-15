<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('ai_sessions', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');
            $table->string('query');
            $table->text('response');
            $table->string('query_type'); // research, summary, plagiarism, recommendation
            $table->json('related_material_ids')->nullable();
            $table->integer('tokens_used')->default(0);
            $table->timestamps();
            
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->index('user_id');
            $table->index('query_type');
        });
    }

    public function down()
    {
        Schema::dropIfExists('ai_sessions');
    }
};