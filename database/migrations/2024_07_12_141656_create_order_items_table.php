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
        Schema::create('order_items', function (Blueprint $table) {
            $table->id();
            $table->integer('order_id');  
            $table->integer('product_id');  
            $table->integer('qty')->nullable();  
            $table->double('price')->nullable();   
            $table->double('subtotal')->nullable();  
            $table->string('currency')->default('usd')->nullable(); 
            $table->integer('duration')->default('30')->nullable(); 
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
        Schema::dropIfExists('order_items');
    }
};
