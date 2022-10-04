<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class WithdrawalsFee extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (Schema::hasTable('settings')) {
            DB::table('settings')->insert(
                array(
                    array (
                        'key' => 'payments.withdrawal_default_fee_percentage',
                        'display_name' => 'Withdrawal fee percentage',
                        'value' => 0,
                        'details' => NULL,
                        'type' => 'text',
                        'order' => 96,
                        'group' => 'Payments',
                    ),
                    array (
                        'key' => 'payments.withdrawal_allow_fees',
                        'display_name' => 'Enable withdrawal fee',
                        'value' => 0,
                        'details' => '{
                        "true" : "On",
                        "false" : "Off",
                        "checked" : false,
                        "description": "Will enable admins to add a default fee percentage which will automatically apply to each withdrawal request."
                        }',
                        'type' => 'checkbox',
                        'order' => 94,
                        'group' => 'Payments',
                    )
                )
            );

            if (Schema::hasTable('withdrawals')) {
                Schema::table('withdrawals', function (Blueprint $table) {
                    $table->float('fee')->after('message')->default(0)->nullable();
                });
            }
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        DB::table('settings')
            ->whereIn('key', [
                'payments.withdrawal_default_fee_percentage',
                'payments.withdrawal_allow_fees',
            ])
            ->delete();

        Schema::table('withdrawals', function (Blueprint $table) {
            $table->dropColumn('fee');
        });
    }
}
