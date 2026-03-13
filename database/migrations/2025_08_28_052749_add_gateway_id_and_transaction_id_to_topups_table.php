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
        Schema::table('topups', function (Blueprint $table) {
            $table->unsignedBigInteger('gateway_id')->nullable()->after('type');
            $table->string('transaction_id')->nullable()->after('gateway_id');

            $table->foreign('gateway_id')->references('id')->on('accounts')->onDelete('set null');
        });
    }


    public function down(): void
    {
        Schema::table('topups', function (Blueprint $table) {
            $table->dropForeign(['gateway_id']);
            $table->dropColumn(['gateway_id', 'transaction_id']);
        });
    }
};
