<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCashInCashOutsTable extends Migration
{
    public function up()
    {
        Schema::create('cash_in_cash_out', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');
            $table->unsignedBigInteger('bank_account_id');
            $table->string('transaction_number')->unique();
            $table->string('sending_phone_number')->nullable();
             $table->enum('type', ['cash_in', 'cash_out']);
            $table->enum('status', ['pending', 'approved', 'declined'])->default('pending');
            $table->string('withdrawal_phone_number')->nullable();
            $table->decimal('amount', 15, 2);
            $table->timestamps();

            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('bank_account_id')->references('id')->on('menual_payments')->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('cash_in_cash_out');
    }
}
