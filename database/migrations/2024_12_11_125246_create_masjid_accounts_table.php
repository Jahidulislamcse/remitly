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
        Schema::create('masjid_accounts', function (Blueprint $table) {
            $table->id();
            
            $table->integer('user_id')->nullable();
            $table->double('five_tk')->nullable();
            $table->double('ten_tk')->nullable();
            $table->double('twenty_tk')->nullable();
            $table->double('fifty_tk')->nullable();
            $table->double('hundred_tk')->nullable();
            $table->double('two_hundred_tk')->nullable();
            $table->double('five_hundred_tk')->nullable();
            $table->double('one_thousand_tk')->nullable();
            $table->double('five_tk_amount')->nullable();
            $table->double('ten_tk_amount')->nullable();
            $table->double('twenty_tk_amount')->nullable();
            $table->double('fifty_tk_amount')->nullable();
            $table->double('hundred_tk_amount')->nullable();
            $table->double('two_hundred_tk_amount')->nullable();
            $table->double('five_hundred_tk_amount')->nullable();
            $table->double('one_thousand_tk_amount')->nullable();
            $table->double('total_tk')->nullable();
            $table->integer('created_by')->nullable();
            $table->integer('updated_by')->nullable();
            $table->integer('status')->default(1);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('masjid_accounts');
    }
};
