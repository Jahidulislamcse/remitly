<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMenualPaymentsTable extends Migration
{

    public function up()
    {
        Schema::create('menual_payments', function (Blueprint $table) {
            $table->id();
            $table->string('gateway');
            $table->string('number')->nullable();
            $table->string('routing_number')->nullable();
            $table->string('account_number')->nullable(); 
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('menual_payments');
    }
}
