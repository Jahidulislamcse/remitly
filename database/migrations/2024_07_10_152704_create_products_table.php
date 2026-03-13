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
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->string('title')->nullable() ;
            $table->text('description')->nullable() ;
            $table->string('image')->nullable() ;
            $table->integer('categories')->nullable() ;
            $table->integer('subcategories')->nullable() ;

            $table->string('bdt')->nullable() ;
            $table->string('usd')->nullable() ;
            $table->double('one_month_bdt')->nullable() ;
            $table->double('one_month_usd')->nullable() ;
            $table->double('three_month_bdt')->nullable() ;
            $table->double('three_month_usd')->nullable() ;
            $table->double('six_month_bdt')->nullable() ;
            $table->double('six_month_usd')->nullable() ;
            $table->double('twelve_month_bdt')->nullable() ;
            $table->double('twelve_month_usd')->nullable() ;
            $table->integer('module_license_id')->nullable() ;

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
        Schema::dropIfExists('products');
    }
};
