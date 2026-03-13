<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('user_reviews', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id'); // reference to users table
            $table->string('title')->nullable();
            $table->string('video_path'); // store video file path
            $table->text('description')->nullable();
            $table->tinyInteger('status')->default(1); // 0 = pending, 1 = approved
            $table->timestamps();

            // Foreign key constraints
            $table->foreign('user_id')->references('id')->on('users');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('user_review_videos');
    }
};
