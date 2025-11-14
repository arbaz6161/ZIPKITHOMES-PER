<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddFloorPlanAdditionalTextFieldToContractorFloorPlanTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('contractor_floor_plan', function (Blueprint $table) {
            $table->text("floor_plan_additional_text")->nullable()->after('floor_plan_price');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('contractor_floor_plan', function (Blueprint $table) {
            //
        });
    }
}
