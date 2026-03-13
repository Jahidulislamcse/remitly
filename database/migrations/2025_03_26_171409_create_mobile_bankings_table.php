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
        Schema::create('mobile_bankings', function (Blueprint $table) {
            $table->id();
            $table->string('operator')->nullable();
            $table->string('transaction_id')->nullable();
            $table->string('type')->nullable();
            $table->double('amount')->nullable();
            $table->string('mobile')->nullable();
            $table->integer('user_id')->nullable();
            $table->integer('status')->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('mobile_bankings');
    }
};
