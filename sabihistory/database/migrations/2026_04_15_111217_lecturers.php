<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('lecturers', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('title')->nullable(); // Dr., Prof., Mr., Mrs.
            $table->string('email')->nullable();
            $table->string('phone')->nullable();
            $table->string('department')->default('History & Strategic Studies');
            $table->string('office_location')->nullable();
            $table->text('bio')->nullable();
            $table->string('profile_image')->nullable();
            $table->float('average_rating')->default(0);
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('lecturers');
    }
};