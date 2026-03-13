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
        Schema::create('general_settings', function (Blueprint $table) {
            $table->id();
            $table->string('company_name')->nullable();
            $table->text('hq_address')->nullable();
            $table->string('logo')->nullable();
            $table->string('icon')->nullable();
            $table->string('phone')->nullable();
            $table->text('factory_address')->nullable();
            $table->string('email')->nullable();
            $table->string('website')->nullable();
            $table->string('social_link')->nullable();
            $table->integer('status')->default(1)->nullable();
            $table->string('created_by')->nullable();
            $table->string('updated_by')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('general_settings');
    }
};
