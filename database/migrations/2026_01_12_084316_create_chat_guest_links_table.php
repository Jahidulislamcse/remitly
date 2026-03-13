<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
{
    Schema::create('chat_guest_links', function (Blueprint $table) {
        $table->id();
        $table->string('name'); // গেস্টের নাম
        $table->string('avatar'); // আপলোড করা ছবির পাথ
        $table->string('virtual_number')->unique(); // লগিনের জন্য ফেক নাম্বার
        $table->string('token')->unique(); // লিংকের গোপন চাবি
        $table->timestamps();
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('chat_guest_links');
    }
};