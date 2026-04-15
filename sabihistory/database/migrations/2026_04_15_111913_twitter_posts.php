<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('twitter_posts', function (Blueprint $table) {
            $table->id();
            $table->enum('type', ['today_history', 'did_you_know']);
            $table->text('content');
            $table->string('image_url')->nullable();
            $table->date('scheduled_date')->unique(); // one per day per type
            $table->timestamp('posted_at')->nullable();
            $table->string('twitter_post_id')->nullable(); // ID from X API after posting
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('twitter_posts');
    }
};