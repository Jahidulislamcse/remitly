<?php


use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateGuidesTable extends Migration
{
    public function up()
    {
        Schema::create('guides', function (Blueprint $table) {
            $table->id();
            $table->longText('mobile_deposit')->nullable();
            $table->longText('mobile_menual_deposit')->nullable();
            $table->longText('bank_deposit')->nullable();
            $table->longText('loan')->nullable();
            $table->longText('remittance')->nullable();
            $table->longText('how_to_balance_add')->nullable();
            $table->longText('how_to_bank_transfer')->nullable();
            $table->longText('how_to_mobile_banking')->nullable();
            $table->longText('about_us')->nullable();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('guides');
    }
}

