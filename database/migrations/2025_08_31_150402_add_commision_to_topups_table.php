<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddCommisionToTopupsTable extends Migration
{
    public function up(): void
    {
        Schema::table('topups', function (Blueprint $table) {
            $table->double('commision')->nullable()->after('amount');
        });
    }

    public function down(): void
    {
        Schema::table('topups', function (Blueprint $table) {
            $table->dropColumn('commision');
        });
    }
}
