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
        // ১. Mobile Banking Table (বিকাশ, নগদ উইথড্র এর জন্য)
        if (Schema::hasTable('mobile_bankings')) {
            Schema::table('mobile_bankings', function (Blueprint $table) {
                if (!Schema::hasColumn('mobile_bankings', 'commission')) {
                    // amount এর পরে commission কলাম যোগ হবে, ডিফল্ট ০
                    $table->double('commission')->default(0)->after('amount');
                }
            });
        }

        // ২. Topups Table (অ্যাড ফান্ড এর জন্য)
        if (Schema::hasTable('topups')) {
            Schema::table('topups', function (Blueprint $table) {
                if (!Schema::hasColumn('topups', 'commission')) {
                    $table->double('commission')->default(0)->after('amount');
                }
            });
        }

        // ৩. Bank Pays Table (ব্যাংক উইথড্র এর জন্য)
        if (Schema::hasTable('bank_pays')) {
            Schema::table('bank_pays', function (Blueprint $table) {
                if (!Schema::hasColumn('bank_pays', 'commission')) {
                    $table->double('commission')->default(0)->after('amount');
                }
            });
        }

        // ৪. Mobile Recharges Table (রিচার্জ এর জন্য)
        if (Schema::hasTable('mobile_recharges')) {
            Schema::table('mobile_recharges', function (Blueprint $table) {
                if (!Schema::hasColumn('mobile_recharges', 'commission')) {
                    $table->double('commission')->default(0)->after('amount');
                }
            });
        }
        
        // ৫. Remittances Table (রেমিটেন্স এর জন্য)
        if (Schema::hasTable('remittances')) {
            Schema::table('remittances', function (Blueprint $table) {
                if (!Schema::hasColumn('remittances', 'commission')) {
                    $table->double('commission')->default(0)->after('amount');
                }
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // রোলব্যাক করলে কলামগুলো মুছে ফেলা হবে
        $tables = ['mobile_bankings', 'topups', 'bank_pays', 'mobile_recharges', 'remittances'];

        foreach ($tables as $tableName) {
            if (Schema::hasTable($tableName)) {
                Schema::table($tableName, function (Blueprint $table) {
                    if (Schema::hasColumn($table->getTable(), 'commission')) {
                        $table->dropColumn('commission');
                    }
                });
            }
        }
    }
};