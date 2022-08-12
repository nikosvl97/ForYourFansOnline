<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

class V171 extends Migration
{
    /**
     * // Internally called as 1.8.0
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        Artisan::call('db:seed',['--force'=>true,'--class'=>'Database\Seeds\DataTypesTableSeeder']);
        Artisan::call('db:seed',['--force'=>true,'--class'=>'Database\Seeds\DataRowsTableSeeder']);
        Artisan::call('db:seed',['--force'=>true,'--class'=>'Database\Seeds\MenusTableSeeder']);
        Artisan::call('db:seed',['--force'=>true,'--class'=>'Database\Seeds\MenuItemsTableSeeder']);
        Artisan::call('db:seed',['--force'=>true,'--class'=>'Database\Seeds\RolesTableSeeder']);
        Artisan::call('db:seed',['--force'=>true,'--class'=>'Database\Seeds\PermissionsTableSeeder']);
        Artisan::call('db:seed',['--force'=>true,'--class'=>'Database\Seeds\PermissionRoleTableSeeder']);
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');
        Artisan::call('optimize:clear');

        if (Schema::hasTable('withdrawals')) {
            Schema::table('withdrawals', function (Blueprint $table) {
                $table->boolean('processed')->default(0);
            });
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
    }
}
