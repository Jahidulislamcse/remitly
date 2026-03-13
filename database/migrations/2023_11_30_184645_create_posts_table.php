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
        Schema::create('posts', function (Blueprint $table) {
            $table->id();
            $table->string('title')->nullable();
            $table->string('slug')->nullable();
            $table->string('subtitle')->nullable();
            $table->tinyInteger('categories')->nullable();
            $table->tinyInteger('subcategories')->nullable();
            $table->text('content')->nullable();
            $table->text('main_image')->nullable();
            $table->string('meta_title')->nullable();
            $table->text('meta_content')->nullable();
            $table->text('meta_image')->nullable();
            $table->tinyInteger('featured')->nullable()->default(0);
            $table->tinyInteger('status')->default(1);
            $table->tinyInteger('created_by')->nullable();
            $table->tinyInteger('updated_by')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('posts');
    }
};
