<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ChangeCategoryNameToCategoryIdInFloorPlanTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        // Add a new big integer column
        Schema::table('floor_plans', function (Blueprint $table) {
            $table->bigInteger('category_id')->unsigned()->nullable();
        });

        // Update floor_plans with appropriate category_id
        DB::table('floor_plans')
            ->leftJoin('floor_plan_categories', 'floor_plans.category_name', '=', 'floor_plan_categories.category_name')
            ->update(['floor_plans.category_id' => DB::raw('IFNULL(floor_plan_categories.id, null)')]);

        // Drop the old column
        Schema::table('floor_plans', function (Blueprint $table) {
            $table->dropColumn('category_name');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        // Add the old column back as varchar(191)
        Schema::table('floor_plans', function (Blueprint $table) {
            $table->string('category_name', 191)->nullable();
        });

        // Update floor_plans with appropriate category_name
        DB::table('floor_plans')
            ->leftJoin('floor_plan_categories', 'floor_plans.category_id', '=', 'floor_plan_categories.id')
            ->update(['floor_plans.category_name' => DB::raw('IFNULL(floor_plan_categories.category_name, "")')]);

        // Drop the new column
        Schema::table('floor_plans', function (Blueprint $table) {
            $table->dropColumn('category_id');
        });
    }
}