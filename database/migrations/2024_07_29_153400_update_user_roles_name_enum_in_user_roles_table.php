<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

class UpdateUserRolesNameEnumInUserRolesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('user_roles', function (Blueprint $table) {
            DB::statement("ALTER TABLE user_roles MODIFY COLUMN user_role_name ENUM('Super Admin', 'Tenant Owner', 'Tenant Manager', 'Client User', 'Home Buyer')");
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('user_roles', function (Blueprint $table) {
            DB::statement("ALTER TABLE user_roles MODIFY COLUMN user_role_name ENUM('Super Admin', 'Tenant Owner', 'Tenant Manager', 'Client User')");
            $table->dropSoftDeletes();
        });
    }
}
