<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class RemoveContractNameAndCategoryMappingInCategoryMappingTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('category_mapping', function (Blueprint $table) {
            $table->dropColumn("contractor_name");
            $table->dropColumn("category_mapping");
            $table->json('category_ids')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('category_mapping', function (Blueprint $table) {
            $table->string('contractor_name');
            $table->json('category_mapping')->nullable();
            $table->dropColumn('category_ids');
        });
    }
}
